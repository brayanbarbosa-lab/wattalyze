<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Environment;
use App\Models\Device;
use App\Services\InfluxDBService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Artisan;

class ApiEnvironmentController extends Controller
{
    private const CACHE_TTL = 300; // 5 minutos
    
    // Constante de tensão padrão (220V para Brasil)
    private const VOLTAGE = 220;

    /**
     * Get all environments with their consumption data
     */
    public function index(InfluxDBService $influxService): JsonResponse
    {
         Artisan::call('alerts:check');
        $userId = auth()->id();

        $environments = Environment::with('devices.deviceType')
            ->where('user_id', $userId)
            ->get();

        $environmentDailyConsumption = [];

        foreach ($environments as $environment) {
            $dailyTotals = $this->initializeDailyTotals();

            foreach ($environment->devices as $device) {
                $types = ['energy', 'temperature', 'humidity'];
                foreach ($types as $type) {
                    $measurementInfo = $this->getMeasurementInfoByType($device, $type);
                    if (!$measurementInfo) continue;

                    $data = $this->getDailyMeasurementData($influxService, $device, $measurementInfo);

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

            $this->calculateAverages($dailyTotals);
            $environmentDailyConsumption[$environment->id] = $this->formatDataForView($dailyTotals);
        }

        return response()->json([
            'environments' => $environments,
            'environment_daily_consumption' => $environmentDailyConsumption
        ]);
    }

    /**
     * Create a new environment
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
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

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        // If marked as default, unmark other environments as default
        if (isset($validated['is_default']) && $validated['is_default']) {
            Environment::where('user_id', auth()->id())
                ->update(['is_default' => false]);
        }

        $environment = Environment::create(array_merge(
            $validated,
            ['user_id' => auth()->id()]
        ));

        return response()->json([
            'message' => 'Ambiente criado com sucesso!',
            'environment' => $environment
        ], 201);
    }

    /**
     * Get a single environment
     */
    public function show(Environment $environment): JsonResponse
    {
        // Check authorization
        if ($environment->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json([
            'environment' => $environment->load('devices.deviceType')
        ]);
    }

    /**
     * Update an environment
     */
    public function update(Request $request, Environment $environment): JsonResponse
    {
        // Check authorization
        if ($environment->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
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

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        // If marked as default, unmark other environments as default
        if (isset($validated['is_default']) && $validated['is_default']) {
            Environment::where('user_id', auth()->id())
                ->where('id', '!=', $environment->id)
                ->update(['is_default' => false]);
        }

        $environment->update($validated);

        return response()->json([
            'message' => 'Ambiente atualizado com sucesso!',
            'environment' => $environment
        ]);
    }

    /**
     * Delete an environment
     */
    public function destroy(Environment $environment): JsonResponse
    {
        // Check authorization
        if ($environment->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $environment->delete();

        return response()->json(['message' => 'Ambiente excluído com sucesso!']);
    }

    /**
     * Get environment consumption data
     */
    public function consumption(Environment $environment, InfluxDBService $influxService): JsonResponse
    {
        // Check authorization
        if ($environment->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $dailyTotals = $this->initializeDailyTotals();

        foreach ($environment->devices as $device) {
            $types = ['energy', 'temperature', 'humidity'];
            foreach ($types as $type) {
                $measurementInfo = $this->getMeasurementInfoByType($device, $type);
                if (!$measurementInfo) continue;

                $data = $this->getDailyMeasurementData($influxService, $device, $measurementInfo);

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

        $this->calculateAverages($dailyTotals);
        $consumptionData = $this->formatDataForView($dailyTotals);

        return response()->json([
            'environment' => $environment,
            'consumption_data' => $consumptionData
        ]);
    }

    // Private helper methods - USANDO A MESMA LÓGICA DO EnvironmentController

    private function initializeDailyTotals(): array
    {
        $dailyTotals = [];
        foreach ($this->getLast7Days() as $date) {
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
            foreach (['energy','temperature','humidity'] as $type) {
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
        $timezone = config('app.timezone', 'America/Sao_Paulo');
        $start = Carbon::now($timezone)->subDays(7)->startOfDay()->setTimezone('UTC')->toIso8601String();
        $stop = Carbon::now($timezone)->endOfDay()->setTimezone('UTC')->toIso8601String();
        $mac = $device->mac_address;

        // Para sensores usa média, para energia calcula consumo baseado em tempo real
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
            // Para energia, buscar TODOS os registros de corrente do período para calcular tempo real
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
                // Processamento normal para sensores
                foreach ($results as $row) {
                    if (!isset($row['value']) || $row['value'] === null) continue;

                    $date = Carbon::parse($row['time'])->setTimezone($timezone)->format('Y-m-d');
                    $value = floatval($row['value']);
                    $valuesPerDay[$date] = $value;
                }
            } else {
                // Processamento para energia com cálculo de tempo real
                $consumptionPerDay = $this->calculateRealTimeConsumption($results, $timezone, $device);
                $valuesPerDay = $consumptionPerDay;
            }

            $formatted = [];
            foreach ($this->getLast7Days() as $date) {
                $formatted[] = [
                    'date' => $date,
                    'value' => round($valuesPerDay[$date] ?? 0, $measurementInfo['measurement'] === 'energy' ? 3 : 2)
                ];
            }

            return $formatted;
        } catch (\Exception $e) {
            Log::error("Erro ao consultar dados diários para device {$device->id}: " . $e->getMessage());
            return array_map(fn($d) => ['date' => $d, 'value' => 0], $this->getLast7Days());
        }
    }

    /**
     * Calcula consumo real baseado no tempo de operação efetivo
     * Verifica pausas (gaps sem dados) e calcula somente o tempo ligado
     */
    private function calculateRealTimeConsumption(array $results, string $timezone, Device $device): array
    {
        $consumptionPerDay = [];
        $dataByDay = [];

        // Agrupar dados por dia
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

        // Calcular consumo por dia
        foreach ($dataByDay as $date => $dayData) {
            if (count($dayData) < 2) {
                // Se houver apenas 1 registro, não é possível calcular tempo real
                $consumptionPerDay[$date] = 0;
                continue;
            }

            // Ordenar por timestamp
            usort($dayData, fn($a, $b) => $a['timestamp'] - $b['timestamp']);

            // Calcular tempo de operação efetivo (desconsiderando pausas)
            $operationHours = $this->calculateOperationHours($dayData);
            
            // Calcular corrente média
            $avgCurrent = array_sum(array_column($dayData, 'current')) / count($dayData);

            // Calcular consumo: P = I × V, E = P × horas / 1000
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

    /**
     * Calcula horas de operação efetiva, detectando pausas/gaps
     * Gap padrão: 30 minutos sem dados = pausa
     */
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

            // Se a diferença for menor que o threshold, é tempo de operação
            if ($timeDiff < $GAP_THRESHOLD) {
                $operationSeconds += $timeDiff;
            } else {
                // Se for maior, há uma pausa - não conta
                Log::debug("Pausa detectada: {$timeDiff}s (>{$GAP_THRESHOLD}s)");
            }

            $lastTime = $data['timestamp'];
        }

        // Converter para horas
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
                'field' => 'current', // Campo de corrente em Amperes
                'unit' => 'kWh',
            ] : null,
            default => null,
        };
    }
}