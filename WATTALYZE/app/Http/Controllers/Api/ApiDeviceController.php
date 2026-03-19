<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Environment;
use App\Models\DeviceType;
use App\Services\InfluxDBService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;

class ApiDeviceController extends Controller
{
    const CACHE_TTL = 300;
    const POWER_CACHE_TTL = 60;
    const CACHE_TTL_DAILY_DATA = 600;
    const VOLTAGE = 220;

    /**
     * Get all devices for authenticated user
     */
    public function index(InfluxDBService $influxService): JsonResponse
    {
         Artisan::call('alerts:check');
        $userId = auth()->id();
        $cacheKey = "user_devices_data_{$userId}";

        $cachedData = Cache::remember($cacheKey, self::CACHE_TTL, function () use ($userId) {
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

        return response()->json([
            'devices' => $cachedData['devices'],
            'environments' => $cachedData['environments'],
            'device_types' => $cachedData['deviceTypes'],
            'influx_data' => $influxData,
            'daily_consumption' => $dailyConsumption
        ]);
    }

    /**
     * Get form data for creating a new device
     */
    public function create(): JsonResponse
    {
        $userId = auth()->id();
        $environments = Environment::where('user_id', $userId)->select(['id', 'name'])->get();

        $formData = Cache::remember("form_data_{$userId}", 1800, function () {
            return [
                'device_types' => DeviceType::select(['id', 'name'])->get()
            ];
        });

        return response()->json([
            'environments' => $environments,
            'device_types' => $formData['device_types'],
        ]);
    }

    /**
     * Store a new device
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
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

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();
        $validated['user_id'] = auth()->id();

        DB::transaction(function () use ($validated) {
            Device::create($validated);
        });

        $this->clearUserCache(auth()->id());

        return response()->json([
            'message' => 'Dispositivo cadastrado com sucesso!'
        ], 201);
    }

    /**
     * Get a single device
     */
    public function show(Device $device): JsonResponse
    {
        if ($device->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $cacheKey = "device_consumption_{$device->id}";
        $consumption = Cache::remember($cacheKey, 300, function () use ($device) {
            return $device->energyConsumptions()
                ->select(['timestamp', 'current', 'instantaneous_power'])
                ->orderBy('timestamp', 'desc')
                ->limit(100)
                ->get();
        });

        return response()->json([
            'device' => $device->load(['deviceType', 'environment']),
            'consumption' => $consumption
        ]);
    }

    /**
     * Get device data for editing
     */
    public function edit(Device $device): JsonResponse
    {
        if ($device->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $userId = auth()->id();
        $formData = Cache::remember("form_data_{$userId}", 1800, function () use ($userId) {
            return [
                'environments' => Environment::where('user_id', $userId)
                    ->select(['id', 'name'])
                    ->get(),
                'device_types' => DeviceType::select(['id', 'name'])->get()
            ];
        });

        return response()->json(array_merge([
            'device' => $device
        ], $formData));
    }

    /**
     * Update a device
     */
    public function update(Request $request, Device $device): JsonResponse
    {
        if ($device->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
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

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        DB::transaction(function () use ($device, $validated) {
            $device->update($validated);
        });

        $this->clearDeviceCache($device->id);
        $this->clearUserCache($device->user_id);

        return response()->json([
            'message' => 'Dispositivo atualizado com sucesso!',
            'device' => $device->fresh()
        ]);
    }

    /**
     * Get device diagnostics
     */
    public function diagnostics(Device $device): JsonResponse
    {
        if ($device->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $cacheKey = "device_diagnostics_{$device->id}";
        $diagnosticsData = Cache::remember($cacheKey, 120, function () use ($device) {
            return [
                'last_seen' => $device->last_seen_at,
                'status' => $device->status,
                'consumption_data' => $device->energyConsumptions()
                    ->select(['timestamp', 'current', 'instantaneous_power', 'voltage', 'current'])
                    ->orderBy('timestamp', 'desc')
                    ->limit(50)
                    ->get()
            ];
        });

        return response()->json(array_merge(
            ['device' => $device],
            $diagnosticsData
        ));
    }

    /**
     * Debug device data
     */
    public function debug(Device $device, InfluxDBService $influxService): JsonResponse
    {
        if ($device->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $this->clearDeviceCache($device->id);
        $this->clearUserCache($device->user_id);

        $measurementInfo = $this->getMeasurementInfo($device);
        $mac = $device->mac_address;

        $debugQuery = <<<FLUX
from(bucket: "{$influxService->getBucket()}")
|> range(start: -7d)
|> filter(fn: (r) => r._measurement == "{$measurementInfo['measurement']}")
|> filter(fn: (r) => r.mac == "$mac")
|> filter(fn: (r) => r._field == "{$measurementInfo['field']}")
|> limit(n: 20)
FLUX;

        try {
            $rawData = $influxService->queryEnergyData($debugQuery);

            Log::info("DEBUG - Raw data for device {$device->id}:", [
                'measurement_info' => $measurementInfo,
                'mac_address' => $mac,
                'raw_data_count' => count($rawData),
                'sample_data' => array_slice($rawData, 0, 5)
            ]);

            return response()->json([
                'device_id' => $device->id,
                'measurement_info' => $measurementInfo,
                'raw_data_count' => count($rawData),
                'sample_data' => array_slice($rawData, 0, 10)
            ]);
        } catch (\Exception $e) {
            Log::error("Erro no debug do device {$device->id}: " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Delete a device
     */
    public function destroy(Device $device): JsonResponse
    {
        if ($device->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $this->clearDeviceCache($device->id);
        $this->clearUserCache($device->user_id);

        $device->delete();

        return response()->json([
            'message' => 'Dispositivo excluído com sucesso!'
        ]);
    }

    // ===== PRIVATE HELPER METHODS =====

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

            $influxData[$deviceId] = Cache::remember($cacheKey, self::POWER_CACHE_TTL, function () use ($influxService, $device, $measurementInfo) {
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

            if ($rawValue === null || $rawValue === '') {
                $normalizedValue = $measurementInfo['measurement'] === 'energy' ? null : 0.0;
            } else {
                $raw = str_replace(',', '.', trim((string)$rawValue));
                $normalizedValue = is_numeric($raw) ? (float)round((float)$raw, $measurementInfo['measurement'] === 'energy' ? 3 : 2) : ($measurementInfo['measurement'] === 'energy' ? null : 0.0);
            }

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
                self::CACHE_TTL,
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
        Cache::forget("user_devices_data_{$userId}");
        Cache::forget("form_data_{$userId}");
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