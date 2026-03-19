<?php

namespace App\Http\Controllers\Web;

use App\Models\Device;
use App\Models\Environment;
use App\Models\DeviceType;
use App\Services\InfluxDBService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class DeviceController extends Controller
{
    const CACHE_TTL_DEVICES = 300;
    const CACHE_TTL_DAILY_DATA = 600;
    const CACHE_TTL_POWER_DATA = 60;
    const VOLTAGE = 220;
    private const CACHE_TTL_FORM_DATA = 600; // 10 minutos


    public function index(InfluxDBService $influxService)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        Artisan::call('alerts:check');

        $userId = auth()->id();
        $sessionId = session()->getId();
        $cacheKeyBase = "user_devices_data_{$userId}_{$sessionId}";

        $cachedData = Cache::remember("{$cacheKeyBase}_basic", self::CACHE_TTL_DEVICES, function () use ($userId) {
            return [
                'devices' => Device::where('user_id', $userId)
                    ->with(['deviceType:id,name', 'environment:id,name'])
                    ->select(['id', 'name', 'mac_address', 'status', 'device_type_id', 'environment_id', 'user_id'])
                    ->get(),
                'environments' => Environment::where('user_id', $userId)
                    ->select(['id', 'name'])
                    ->get(),
                'deviceTypes' => DeviceType::select(['id', 'name'])->get()
            ];
        });

        $deviceIds = $cachedData['devices']->pluck('id')->toArray();
        $influxData = $this->getCachedInfluxData($influxService, $deviceIds);
        $dailyConsumption = $this->getCachedDailyConsumption($influxService, $deviceIds);

        return view('devices.index', [
            'devices' => $cachedData['devices'],
            'environments' => $cachedData['environments'],
            'deviceTypes' => $cachedData['deviceTypes'],
            'influxData' => $influxData,
            'dailyConsumption' => $dailyConsumption
        ]);
    }
    public function create()
    {
        $userId = auth()->id();
        $cacheKey = "form_data_{$userId}";

        $formData = Cache::remember($cacheKey, self::CACHE_TTL_FORM_DATA, function () use ($userId) {
            return [
                'environments' => Environment::where('user_id', $userId)->select(['id', 'name'])->get(),
                'deviceTypes' => DeviceType::select(['id', 'name'])->get()
            ];
        });

        return view('devices.create', $formData);
    }
    public function destroy(Device $device)
    {
        try {
            // Verifica permissÃ£o
            if ($device->user_id !== auth()->id()) {
                return redirect()->route('devices.index')
                    ->with('error', 'Sem permissÃ£o para excluir este dispositivo');
            }

            $deviceId = $device->id;
            $userId = $device->user_id;

            // Excluir em transaÃ§Ã£o
            DB::transaction(function () use ($device) {
                $device->delete();
            });

            // Limpar cache
            $this->clearDeviceCache($deviceId);
            $this->clearUserCache($userId);

            return redirect()->route('devices.index')
                ->with('success', 'Dispositivo excluído com sucesso!');

        } catch (\Exception $e) {
            Log::error("Erro ao excluir dispositivo: " . $e->getMessage());
            return redirect()->route('devices.index')
                ->with('error', 'Erro ao excluir dispositivo');
        }
    }

    /**
     * Salvar novo dispositivo
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mac_address' => 'required|string|size:17|unique:devices,mac_address',
            'serial_number' => 'nullable|string|max:255|unique:devices,serial_number',
            'model' => 'nullable|string|max:255',
            'manufacturer' => 'nullable|string|max:255',
            'firmware_version' => 'nullable|string|max:255',
            'status' => 'required|string|in:online,offline,maintenance',
            'location' => 'nullable|string|max:255',
            'installation_date' => 'nullable|date',
            'rated_power' => 'nullable|numeric|min:0',
            'rated_voltage' => 'nullable|numeric|min:0',
            'device_type_id' => 'nullable|exists:device_types,id',
            'environment_id' => 'nullable|exists:environments,id',
        ]);

        $validated['user_id'] = auth()->id();

        DB::transaction(function () use ($validated) {
            Device::create($validated);
        });

        $this->clearUserCache(auth()->id());

        return redirect()->route('devices.index')
            ->with('success', 'Dispositivo cadastrado com sucesso!');
    }

    /**
     * Editar dispositivo
     */
    public function edit(Device $device)
    {
        $userId = auth()->id();
        $cacheKey = "form_data_{$userId}";

        $formData = Cache::remember($cacheKey, self::CACHE_TTL_FORM_DATA, function () use ($userId) {
            return [
                'environments' => Environment::where('user_id', $userId)
                    ->select(['id', 'name'])
                    ->get(),
                'deviceTypes' => DeviceType::select(['id', 'name'])->get()
            ];
        });

        return view('devices.edit', array_merge(['device' => $device], $formData));
    }

    /**
     * Atualizar dispositivo
     */
    public function update(Request $request, Device $device)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mac_address' => 'required|string|size:17|unique:devices,mac_address,' . $device->id,
            'serial_number' => 'nullable|string|max:255|unique:devices,serial_number,' . $device->id,
            'model' => 'nullable|string|max:255',
            'manufacturer' => 'nullable|string|max:255',
            'firmware_version' => 'nullable|string|max:255',
            'status' => 'required|string|in:online,offline,maintenance',
            'location' => 'nullable|string|max:255',
            'installation_date' => 'nullable|date',
            'rated_power' => 'nullable|numeric|min:0',
            'rated_voltage' => 'nullable|numeric|min:0',
            'device_type_id' => 'nullable|exists:device_types,id',
            'environment_id' => 'nullable|exists:environments,id',
        ]);

        DB::transaction(function () use ($device, $validated) {
            $device->update($validated);
        });

        $this->clearDeviceCache($device->id);
        $this->clearUserCache($device->user_id);

        return redirect()->route('devices.index', $device->id)
            ->with('success', 'Dispositivo atualizado com sucesso!');
    }
    private function getCachedInfluxData(InfluxDBService $influxService, array $deviceIds): array
    {
        $influxData = [];
        foreach ($deviceIds as $deviceId) {
            $device = Device::find($deviceId);
            if (!$device) {
                $influxData[$deviceId] = [
                    'value' => null,
                    'unit' => null,
                    'time' => null
                ];
                continue;
            }

            $measurementInfo = $this->getMeasurementInfo($device);
            $cacheKey = "device_measurement_{$deviceId}_" . Carbon::now()->format('Y-m-d-H-i');

            $influxData[$deviceId] = Cache::remember($cacheKey, self::CACHE_TTL_POWER_DATA, function () use ($influxService, $device, $measurementInfo) {
                return $this->getRealTimeMeasurementData($influxService, $device, $measurementInfo);
            });
        }

        return $influxData;
    }

    private function getRealTimeMeasurementData(InfluxDBService $influxService, Device $device, array $measurementInfo): array
    {
        $mac = $device->mac_address;
        $timeRange = $measurementInfo['measurement'] === 'energy' ? '-30m' : '-24h';

        $lastQuery = <<<FLUX
from(bucket: "{$influxService->getBucket()}")
|> range(start: $timeRange)
|> filter(fn: (r) => r._measurement == "{$measurementInfo['measurement']}")
|> filter(fn: (r) => r.mac == "$mac")
|> filter(fn: (r) => r._field == "{$measurementInfo['field']}")
|> sort(columns: ["_time"], desc: true)
|> limit(n:1)
|> yield()
FLUX;

        try {
            $lastData = $influxService->queryEnergyData($lastQuery);

            Log::debug("LAST QUERY result for device {$device->id}", [
                'measurement' => $measurementInfo['measurement'],
                'field' => $measurementInfo['field'],
                'mac' => $mac,
                'timeRange' => $timeRange,
                'row_count' => count($lastData),
                'sample' => $lastData[0] ?? null
            ]);

            $row = $lastData[0] ?? null;
            $rawValue = null;
            $rawTime = null;

            if (is_array($row)) {
                if (array_key_exists('_value', $row)) {
                    $rawValue = $row['_value'];
                } elseif (array_key_exists('value', $row)) {
                    $rawValue = $row['value'];
                } elseif (array_key_exists('Value', $row)) {
                    $rawValue = $row['Value'];
                }

                $rawTime = $row['_time'] ?? ($row['time'] ?? null);
            }

            // Normalizar valor
            if ($rawValue === null || $rawValue === '') {
                $normalizedValue = $measurementInfo['measurement'] === 'energy' ? null : 0.0;
            } else {
                $raw = str_replace(',', '.', trim((string)$rawValue));
                $normalizedValue = is_numeric($raw) ? (float)round((float)$raw, $measurementInfo['measurement'] === 'energy' ? 3 : 2) : ($measurementInfo['measurement'] === 'energy' ? null : 0.0);
            }

            // Normalizar tempo
            $normalizedTime = null;
            if ($rawTime) {
                try {
                    $dt = Carbon::parse($rawTime);
                    $dt->setTimezone(config('app.timezone', 'America/Sao_Paulo'));
                    $normalizedTime = $dt->toDateTimeString();
                } catch (\Exception $ex) {
                    Log::debug("Não foi possível parsear rawTime do Influx", [
                        'device' => $device->id,
                        'rawTime' => $rawTime,
                        'err' => $ex->getMessage()
                    ]);
                    $normalizedTime = (string)$rawTime;
                }
            }

            return [
                'value' => $normalizedValue,
                'unit' => $measurementInfo['unit'] ?? null,
                'time' => $normalizedTime
            ];
        } catch (\Exception $e) {
            Log::error("Erro ao consultar dados em tempo real para device {$device->id}: " . $e->getMessage());
            return [
                'value' => $measurementInfo['measurement'] === 'energy' ? null : 0.0,
                'unit' => $measurementInfo['unit'] ?? null,
                'time' => null
            ];
        }
    }

    private function getCachedDailyConsumption(InfluxDBService $influxService, array $deviceIds): array
    {
        $dailyConsumption = [];
        foreach ($deviceIds as $deviceId) {
            $device = Device::find($deviceId);
            if (!$device) {
                $dailyConsumption[$deviceId] = [];
                continue;
            }

            $measurementInfo = $this->getMeasurementInfo($device);
            $cacheKey = "device_daily_consumption_{$deviceId}_" . Carbon::now()->format('Y-m-d');

            $dailyConsumption[$deviceId] = Cache::remember(
                $cacheKey,
                self::CACHE_TTL_DAILY_DATA,
                function () use ($influxService, $device, $measurementInfo) {
                    return $this->getDailyMeasurementData($influxService, $device, $measurementInfo);
                }
            );
        }

        return $dailyConsumption;
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

        $GAP_THRESHOLD = 5 * 60; // 5 minutos em segundos
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

    private function getMeasurementInfo(Device $device): array
    {
        $cacheKey = "measurement_info_{$device->id}";
        return Cache::remember($cacheKey, 3600, function () use ($device) {
            $typeName = strtolower($device->deviceType->name ?? '');
            return match (true) {
                str_contains($typeName, 'temperature sensor') => [
                    'measurement' => 'temperature',
                    'field' => 'temperature',
                    'unit' => '°C'
                ],
                str_contains($typeName, 'humidity sensor') => [
                    'measurement' => 'humidity',
                    'field' => 'humidity',
                    'unit' => '%'
                ],
                default => [
                    'measurement' => 'energy',
                    'field' => 'current',
                    'unit' => 'kWh'
                ]
            };
        });
    }

    private function clearUserCache(int $userId): void
    {
        Cache::flush();
    }

    private function clearDeviceCache(int $deviceId): void
    {
        Cache::forget("device_measurement_{$deviceId}");
        Cache::forget("device_consumption_{$deviceId}");
        Cache::forget("device_diagnostics_{$deviceId}");

        for ($i = -10; $i <= 3; $i++) {
            $date = Carbon::now()->addDays($i)->format('Y-m-d');
            Cache::forget("device_daily_consumption_{$deviceId}_{$date}");
        }
    }
}
