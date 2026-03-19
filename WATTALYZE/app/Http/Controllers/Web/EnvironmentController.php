<?php

namespace App\Http\Controllers\Web;

use App\Models\Environment;
use App\Models\Device;
use App\Services\InfluxDBService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class EnvironmentController extends Controller
{
   
    const CACHE_TTL_ENVIRONMENTS = 300;
    const CACHE_TTL_DAILY_DATA = 600;
    const CACHE_TTL_PROCESSED_DATA = 900;
    const CACHE_TTL_STATIC = 3600;
    const VOLTAGE = 220;

    public function index(InfluxDBService $influxService)
    {
        Artisan::call('alerts:check');
        $userId = auth()->id();
        $sessionId = session()->getId();
        $cacheKey = "environments_dashboard_{$userId}_{$sessionId}";

        $data = Cache::remember($cacheKey, self::CACHE_TTL_PROCESSED_DATA, function () use ($userId, $influxService) {
            $environments = $this->getCachedEnvironments($userId);
            $environmentDailyConsumption = $this->getCachedEnvironmentConsumption($influxService, $environments, $userId);
            return compact('environments', 'environmentDailyConsumption');
        });

        return view('environments.index', $data);
    }

    private function getCachedEnvironments(int $userId)
    {
        $cacheKey = "user_environments_{$userId}";
        return Cache::remember($cacheKey, self::CACHE_TTL_ENVIRONMENTS, function () use ($userId) {
            return Environment::with('devices.deviceType')
                ->where('user_id', $userId)
                ->get();
        });
    }

    private function getCachedEnvironmentConsumption(InfluxDBService $influxService, $environments, int $userId): array
    {
        $cacheKey = "environment_consumption_{$userId}_" . Carbon::now()->format('Y-m-d-H');
        return Cache::remember($cacheKey, self::CACHE_TTL_DAILY_DATA, function () use ($influxService, $environments) {
            $environmentDailyConsumption = [];
            foreach ($environments as $environment) {
                $environmentDailyConsumption[$environment->id] = $this->getCachedEnvironmentData(
                    $influxService,
                    $environment
                );
            }
            return $environmentDailyConsumption;
        });
    }

    private function getCachedEnvironmentData(InfluxDBService $influxService, Environment $environment): array
    {
        $cacheKey = "environment_data_{$environment->id}_" . Carbon::now()->format('Y-m-d-H');
        return Cache::remember($cacheKey, self::CACHE_TTL_DAILY_DATA, function () use ($influxService, $environment) {
            $dailyTotals = $this->initializeDailyTotals();
            foreach ($environment->devices as $device) {
                $deviceData = $this->getCachedDeviceData($influxService, $device);
                $this->aggregateDeviceData($dailyTotals, $deviceData);
            }

            $this->calculateAverages($dailyTotals);
            return $this->formatDataForView($dailyTotals);
        });
    }

    private function getCachedDeviceData(InfluxDBService $influxService, Device $device): array
    {
        $cacheKey = "device_environment_data_{$device->id}_" . Carbon::now()->format('Y-m-d-H');
        return Cache::remember($cacheKey, self::CACHE_TTL_DAILY_DATA, function () use ($influxService, $device) {
            $types = ['energy', 'temperature', 'humidity'];
            $deviceData = [];
            foreach ($types as $type) {
                $measurementInfo = $this->getCachedMeasurementInfo($device, $type);
                if (!$measurementInfo) continue;
                $deviceData[$type] = $this->getDailyMeasurementData($influxService, $device, $measurementInfo);
            }

            return $deviceData;
        });
    }

    private function getCachedMeasurementInfo(Device $device, string $type): ?array
    {
        $cacheKey = "measurement_info_{$device->id}_{$type}";
        return Cache::remember($cacheKey, self::CACHE_TTL_STATIC, function () use ($device, $type) {
            return $this->getMeasurementInfoByType($device, $type);
        });
    }

    private function aggregateDeviceData(array &$dailyTotals, array $deviceData): void
    {
        foreach ($deviceData as $type => $data) {
            foreach ($data as $day) {
                $date = $day['date'];
                $value = $day['value'];
                switch ($type) {
                    case 'energy':
                        $dailyTotals[$date]['energy'] += $value;
                        break;
                    case 'temperature':
                        $dailyTotals[$date]['temperature'] += $value;
                        $dailyTotals[$date]['temp_count']++;
                        break;
                    case 'humidity':
                        $dailyTotals[$date]['humidity'] += $value;
                        $dailyTotals[$date]['humidity_count']++;
                        break;
                }
            }
        }
    }

    private function initializeDailyTotals(): array
    {
        $dailyTotals = [];
        foreach ($this->getCachedLast7Days() as $date) {
            $dailyTotals[$date] = [
                'energy' => 0,
                'temperature' => 0,
                'humidity' => 0,
                'temp_count' => 0,
                'humidity_count' => 0,
            ];
        }

        return $dailyTotals;
    }

    private function getCachedLast7Days(): array
    {
        $cacheKey = 'last_7_days_' . Carbon::now()->format('Y-m-d');
        return Cache::remember($cacheKey, 86400, function () {
            return $this->getLast7Days();
        });
    }

    private function calculateAverages(array &$dailyTotals): void
    {
        foreach ($dailyTotals as $date => &$values) {
            $values['temperature'] = $values['temp_count'] > 0
                ? round($values['temperature'] / $values['temp_count'], 2)
                : 0;
            $values['humidity'] = $values['humidity_count'] > 0
                ? round($values['humidity'] / $values['humidity_count'], 2)
                : 0;
            unset($values['temp_count'], $values['humidity_count']);
        }
    }

    private function formatDataForView(array $dailyTotals): array
    {
        $formatted = ['energy' => [], 'temperature' => [], 'humidity' => []];
        foreach ($dailyTotals as $date => $values) {
            foreach (['energy', 'temperature', 'humidity'] as $type) {
                $formatted[$type][] = ['date' => $date, 'value' => $values[$type]];
            }
        }

        return $formatted;
    }

    private function getLast7Days(): array
    {
        $timezone = config('app.timezone', 'America/Sao_Paulo');
        $now = Carbon::now($timezone);
        $days = [];
        for ($i = 6; $i >= 0; $i--) {
            $days[] = $now->copy()->subDays($i)->format('Y-m-d');
        }

        return $days;
    }

    private function getDailyMeasurementData(InfluxDBService $influxService, Device $device, array $measurementInfo): array
    {
        $influxCacheKey = "influx_environment_data_{$device->id}_{$measurementInfo['measurement']}_" . Carbon::now()->format('Y-m-d-H');
        return Cache::remember($influxCacheKey, self::CACHE_TTL_DAILY_DATA, function () use ($influxService, $device, $measurementInfo) {
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
                        if (!isset($row['value']) || $row['value'] === null) continue;
                        $date = Carbon::parse($row['time'])->setTimezone($timezone)->format('Y-m-d');
                        $value = floatval($row['value']);
                        $valuesPerDay[$date] = $value;
                    }
                } else {
                    $consumptionPerDay = $this->calculateRealTimeConsumption($results, $timezone, $device);
                    $valuesPerDay = $consumptionPerDay;
                }

                $formatted = [];
                foreach ($this->getCachedLast7Days() as $date) {
                    $formatted[] = [
                        'date' => $date,
                        'value' => round($valuesPerDay[$date] ?? 0, $measurementInfo['measurement'] === 'energy' ? 3 : 2)
                    ];
                }

                return $formatted;
            } catch (\Exception $e) {
                Log::error("Erro ao consultar dados diários para device {$device->id}: " . $e->getMessage());
                return array_map(fn($d) => ['date' => $d, 'value' => 0], $this->getCachedLast7Days());
            }
        });
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
                'operation_hours' => round($operationHours, 2),
                'avg_current_A' => round($avgCurrent, 3),
                'power_W' => round($powerW, 2),
                'energy_kwh' => round($energyKwh, 3)
            ]);
        }

        return $consumptionPerDay;
    }

    private function calculateOperationHours(array $dayData): float
    {
        if (count($dayData) < 2) {
            return 0;
        }

        $GAP_THRESHOLD = 30 * 60; // 30 minutos em segundos = pausa
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

    private function getMeasurementInfoByType(Device $device, string $type): ?array
    {
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
    }

 
    public function create()
    {
        return view('environments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:residential,commercial,industrial,public',
            'description' => 'nullable|string|max:1000',
            'size_sqm' => 'nullable|numeric|min:0',
            'occupancy' => 'nullable|integer|min:0',
            'voltage_standard' => 'nullable|string|max:50',
            'tariff_type' => 'nullable|string|max:50',
            'energy_provider' => 'nullable|string|max:255',
            'installation_date' => 'nullable|date',
            'is_default' => 'nullable|boolean',
        ]);

        if (isset($validated['is_default']) && $validated['is_default']) {
            Environment::where('user_id', auth()->id())
                ->update(['is_default' => false]);
        }

        $environment = Environment::create(array_merge(
            $validated,
            ['user_id' => auth()->id()]
        ));

        $this->clearUserEnvironmentCache(auth()->id());

        return redirect()->route('environments.index', $environment->id)
            ->with('success', 'Ambiente criado com sucesso!');
    }

    public function edit(Environment $environment)
    {
        return view('environments.edit', compact('environment'));
    }

    public function update(Request $request, Environment $environment)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:residential,commercial,industrial,public',
            'description' => 'nullable|string|max:1000',
            'size_sqm' => 'nullable|numeric|min:0',
            'occupancy' => 'nullable|integer|min:0',
            'voltage_standard' => 'nullable|string|max:50',
            'tariff_type' => 'nullable|string|max:50',
            'energy_provider' => 'nullable|string|max:255',
            'installation_date' => 'nullable|date',
            'is_default' => 'nullable|boolean',
        ]);

        if (isset($validated['is_default']) && $validated['is_default']) {
            Environment::where('user_id', auth()->id())
                ->where('id', '!=', $environment->id)
                ->update(['is_default' => false]);
        }

        $environment->update($validated);

        $this->clearUserEnvironmentCache(auth()->id());
        $this->clearEnvironmentSpecificCache($environment->id);

        return redirect()->route('environments.index', $environment->id)
            ->with('success', 'Ambiente atualizado com sucesso!');
    }

    public function destroy(Environment $environment)
    {
        $userId = auth()->id();
        $environmentId = $environment->id;

        $environment->delete();

        $this->clearUserEnvironmentCache($userId);
        $this->clearEnvironmentSpecificCache($environmentId);

        return redirect()->route('environments.index')
            ->with('success', 'Ambiente excluÃ­do com sucesso!');
    }
    private function clearUserEnvironmentCache(int $userId): void
    {
        $sessionId = session()->getId();
        Cache::forget("user_environments_{$userId}");
        Cache::forget("environments_dashboard_{$userId}_{$sessionId}");
        Cache::forget("environment_consumption_{$userId}_" . Carbon::now()->format('Y-m-d-H'));
        Cache::forget("environment_consumption_{$userId}_" . Carbon::now()->subHour()->format('Y-m-d-H'));
    }

    private function clearEnvironmentSpecificCache(int $environmentId): void
    {
        $currentHour = Carbon::now()->format('Y-m-d-H');
        $previousHour = Carbon::now()->subHour()->format('Y-m-d-H');
        Cache::forget("environment_data_{$environmentId}_{$currentHour}");
        Cache::forget("environment_data_{$environmentId}_{$previousHour}");
    }
}