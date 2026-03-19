<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Alert;
use App\Services\InfluxDBService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;

class ApiHomeController extends Controller
{
    const CACHE_TTL_DEVICES = 300;
    const CACHE_TTL_ALERTS = 300;
    const CACHE_TTL_DAILY_DATA = 600;
    const CACHE_TTL_SESSION_DATA = 300;
    const VOLTAGE = 220;

    /**
     * Get dashboard data with all metrics
     */
    public function index(InfluxDBService $influxService): JsonResponse
    {
         Artisan::call('alerts:check');
        $user = auth()->user();
        $sessionId = session()->getId();
        $userId = $user->id;
        $cacheKeyBase = "dashboard_data_{$userId}_{$sessionId}";

        $devices = $this->getCachedDevices($userId);
        $alerts = $this->getCachedAlerts($userId);
        $dailyConsumption = $this->getCachedDailyConsumption($influxService, $devices, $cacheKeyBase);
        $totalConsumptionValue = $this->getCachedTotalConsumption($dailyConsumption, $cacheKeyBase);

        return response()->json([
            'devices' => $devices,
            'alerts' => $alerts,
            'daily_consumption' => $dailyConsumption,
            'total_consumption' => $totalConsumptionValue
        ]);
    }

    /**
     * Get dashboard (alias)
     */
    public function dashboard(InfluxDBService $influxService): JsonResponse
    {
        return $this->index($influxService);
    }

    private function getCachedDevices(int $userId)
    {
        $cacheKey = "user_devices_{$userId}";
        return Cache::remember($cacheKey, self::CACHE_TTL_DEVICES, function () use ($userId) {
            return Device::where('user_id', $userId)
                ->with('deviceType')
                ->latest()
                ->limit(5)
                ->get();
        });
    }

    private function getCachedAlerts(int $userId)
    {
        $cacheKey = "user_alerts_{$userId}";
        return Cache::remember($cacheKey, self::CACHE_TTL_ALERTS, function () use ($userId) {
            return Alert::where('user_id', $userId)
                ->where('is_resolved', false)
                ->with('device')
                ->latest()
                ->limit(5)
                ->get();
        });
    }

    private function getCachedDailyConsumption(InfluxDBService $influxService, $devices, string $cacheKeyBase): array
    {
        $cacheKey = "{$cacheKeyBase}_daily_consumption";
        return Cache::remember($cacheKey, self::CACHE_TTL_DAILY_DATA, function () use ($influxService, $devices) {
            $dailyConsumption = [];
            foreach ($devices as $device) {
                $deviceId = $device->id;
                $types = ['energy', 'temperature', 'humidity'];
                $deviceData = [];

                foreach ($types as $type) {
                    $measurementInfo = $this->getMeasurementInfoByType($device, $type);
                    if ($measurementInfo === null) continue;

                    $cacheMinute = intdiv(Carbon::now()->timestamp, 300) * 300;
                    $deviceTypeCacheKey = "device_data_{$deviceId}_{$type}_{$cacheMinute}";

                    $data = Cache::remember($deviceTypeCacheKey, self::CACHE_TTL_DAILY_DATA, function () use ($influxService, $device, $measurementInfo) {
                        return $this->getDailyMeasurementData($influxService, $device, $measurementInfo);
                    });

                    $deviceData[$type] = $data;
                }

                $dailyConsumption[$deviceId] = $deviceData;
            }

            return $dailyConsumption;
        });
    }

    private function getCachedTotalConsumption(array $dailyConsumption, string $cacheKeyBase): float
    {
        $cacheKey = "{$cacheKeyBase}_total_consumption";
        return Cache::remember($cacheKey, self::CACHE_TTL_SESSION_DATA, function () use ($dailyConsumption) {
            $totalConsumptionValue = 0;
            foreach ($dailyConsumption as $deviceData) {
                if (isset($deviceData['energy'])) {
                    foreach ($deviceData['energy'] as $day) {
                        $totalConsumptionValue += $day['value'];
                    }
                }
            }
            return round($totalConsumptionValue, 3);
        });
    }

    private function getDailyMeasurementData(InfluxDBService $influxService, Device $device, array $measurementInfo): array
    {
        $timezone = config('app.timezone', 'America/Sao_Paulo');
        $start = Carbon::now($timezone)->subDays(7)->startOfDay()->setTimezone('UTC')->toIso8601String();
        $stop = Carbon::now($timezone)->endOfDay()->setTimezone('UTC')->toIso8601String();
        $mac = $device->mac_address;

        if (in_array($measurementInfo['measurement'], ['temperature', 'humidity'])) {
            $query = <<<FLUX
from(bucket: "{$influxService->getBucket()}")
|> range(start: $start, stop: $stop)
|> filter(fn: (r) => r._measurement == "{$measurementInfo['measurement']}")
|> filter(fn: (r) => r.mac == "$mac")
|> filter(fn: (r) => r._field == "{$measurementInfo['field']}")
|> aggregateWindow(every: 1d, fn: mean, createEmpty: false)
|> yield()
FLUX;
        } else {
            $query = <<<FLUX
from(bucket: "{$influxService->getBucket()}")
|> range(start: $start, stop: $stop)
|> filter(fn: (r) => r._measurement == "{$measurementInfo['measurement']}")
|> filter(fn: (r) => r.mac == "$mac")
|> filter(fn: (r) => r._field == "{$measurementInfo['field']}")
|> sort(columns: ["_time"])
|> yield()
FLUX;
        }

        try {
            $results = $influxService->queryEnergyData($query);
            $valuesPerDay = [];

            if (in_array($measurementInfo['measurement'], ['temperature', 'humidity'])) {
                foreach ($results as $row) {
                    if (isset($row['value']) && $row['value'] !== null && $row['value'] !== '') {
                        $localDate = Carbon::parse($row['time'])->setTimezone($timezone)->format('Y-m-d');
                        $value = floatval($row['value']);
                        $valuesPerDay[$localDate] = $value;
                    }
                }
            } else {
                $valuesPerDay = $this->calculateRealTimeConsumption($results, $timezone, $device);
            }

            $last7Days = $this->getLast7Days();
            $formattedData = [];

            foreach ($last7Days as $date) {
                $value = $valuesPerDay[$date] ?? 0;
                $precision = $measurementInfo['measurement'] === 'energy' ? 3 : 2;
                $formattedData[] = [
                    'date' => $date,
                    'value' => round($value, $precision)
                ];
            }

            return $formattedData;
        } catch (\Exception $e) {
            Log::error("Erro ao consultar dados diários para device {$device->id}: " . $e->getMessage());
            return $this->getFallbackData();
        }
    }

    private function calculateRealTimeConsumption(array $results, string $timezone, Device $device): array
    {
        $consumptionPerDay = [];
        $dataByDay = [];

        foreach ($results as $row) {
            if (!isset($row['value']) || $row['value'] === null) continue;

            try {
                $time = Carbon::parse($row['time'])->setTimezone($timezone);
                $date = $time->format('Y-m-d');
                $value = floatval($row['value']);

                if (!isset($dataByDay[$date])) {
                    $dataByDay[$date] = [];
                }

                $dataByDay[$date][] = [
                    'time' => $time,
                    'current' => $value,
                    'timestamp' => $time->timestamp
                ];
            } catch (\Exception $e) {
                Log::warning("Erro ao parsear timestamp para device {$device->id}: " . $e->getMessage());
                continue;
            }
        }

        foreach ($dataByDay as $date => $dayData) {
            if (count($dayData) < 2) {
                $consumptionPerDay[$date] = 0;
                continue;
            }

            usort($dayData, fn($a, $b) => $a['timestamp'] - $b['timestamp']);

            $operationHours = $this->calculateOperationHours($dayData);
            $avgCurrent = array_sum(array_column($dayData, 'current')) / count($dayData);
            $powerW = self::VOLTAGE * $avgCurrent;
            $energyKwh = ($powerW * $operationHours) / 1000;
            $consumptionPerDay[$date] = $energyKwh;

            Log::debug("Consumo calculado para device {$device->id} em {$date}", [
                'records' => count($dayData),
                'operation_hours' => round($operationHours, 6),
                'avg_current_A' => round($avgCurrent, 6),
                'power_W' => round($powerW, 2),
                'energy_kwh' => round($energyKwh, 6)
            ]);
        }

        return $consumptionPerDay;
    }

    private function calculateOperationHours(array $dayData): float
    {
        if (count($dayData) < 2) {
            return 0;
        }

        $GAP_THRESHOLD = 5 * 60;
        $operationSeconds = 0;
        $lastTime = null;

        foreach ($dayData as $data) {
            if ($lastTime === null) {
                $lastTime = $data['timestamp'];
                continue;
            }

            $timeDiff = $data['timestamp'] - $lastTime;

            if ($timeDiff < $GAP_THRESHOLD) {
                $operationSeconds += $timeDiff;
            } else {
                Log::debug("Pausa detectada: {$timeDiff}s (>{$GAP_THRESHOLD}s)");
            }

            $lastTime = $data['timestamp'];
        }

        return $operationSeconds / 3600;
    }

    private function getLast7Days(): array
    {
        return Cache::remember('last_7_days_' . Carbon::now()->format('Y-m-d'), 86400, function () {
            $timezone = config('app.timezone', 'America/Sao_Paulo');
            $now = Carbon::now($timezone);
            $days = [];

            for ($i = 6; $i >= 0; $i--) {
                $days[] = $now->copy()->subDays($i)->format('Y-m-d');
            }

            return $days;
        });
    }

    private function getFallbackData(): array
    {
        $last7Days = $this->getLast7Days();
        $fallbackData = [];

        foreach ($last7Days as $date) {
            $fallbackData[] = ['date' => $date, 'value' => 0];
        }

        return $fallbackData;
    }

    private function getMeasurementInfoByType(Device $device, string $type): ?array
    {
        $cacheKey = "measurement_info_{$device->id}_{$type}";
        return Cache::remember($cacheKey, 3600, function () use ($device, $type) {
            $typeName = strtolower($device->deviceType->name ?? '');
            return match ($type) {
                'temperature' => str_contains($typeName, 'temperature sensor') ? [
                    'measurement' => 'temperature',
                    'field' => 'temperature',
                    'unit' => '°C',
                ] : null,
                'humidity' => str_contains($typeName, 'humidity sensor') ? [
                    'measurement' => 'humidity',
                    'field' => 'humidity',
                    'unit' => '%',
                ] : null,
                'energy' => !str_contains($typeName, 'temperature sensor') && !str_contains($typeName, 'humidity sensor') ? [
                    'measurement' => 'energy',
                    'field' => 'current',
                    'unit' => 'kWh',
                ] : null,
                default => null,
            };
        });
    }

    public function clearUserCache(int $userId): void
    {
        Cache::forget("user_devices_{$userId}");
        Cache::forget("user_alerts_{$userId}");
        Cache::forget("dashboard_data_{$userId}_*");
        Cache::forget("device_data_*");
        Cache::forget("influx_data_*");
    }

    public function warmUpCache(InfluxDBService $influxService): void
    {
        $user = auth()->user();
        $sessionId = session()->getId();
        $cacheKeyBase = "dashboard_data_{$user->id}_{$sessionId}";

        $this->getCachedDevices($user->id);
        $this->getCachedAlerts($user->id);
        $devices = $this->getCachedDevices($user->id);
        $this->getCachedDailyConsumption($influxService, $devices, $cacheKeyBase);
    }
}