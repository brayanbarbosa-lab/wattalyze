<?php

namespace App\Services\Reports\Traits;

use App\Models\Device;
use App\Services\InfluxDBService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

/**
 * ✅ CORRIGIDO: Trait que calcula métricas energéticas com dados do InfluxDB
 */
trait MetricsCalculatorTrait
{
    /**
     * ✅ CORRIGIDO: Obter dados de consumo de todos os dispositivos do relatório
     * Retorna: ['device_name' => [['consumption' => X, 'cost' => Y, 'timestamp' => Z], ...]]
     */
    protected function getConsumptionData($report): array
    {
        $filters = $report->filters ?? [];

        // Obter dispositivos selecionados ou todos do usuário
        if (!empty($filters['devices'])) {
            $devices = Device::whereIn('id', $filters['devices'])
                ->where('user_id', $report->user_id)
                ->with('deviceType')
                ->get();
        } else {
            $devices = Device::where('user_id', $report->user_id)
                ->with('deviceType')
                ->get();
        }

        if ($devices->isEmpty()) {
            Log::warning("Nenhum dispositivo encontrado para o relatório {$report->id}");
            return [];
        }

        $consumptionData = [];
        $influxService = app(InfluxDBService::class);

        foreach ($devices as $device) {
            $data = $this->fetchDeviceConsumptionFromInflux(
                $influxService,
                $device,
                $report->period_start,
                $report->period_end
            );
            
            // ✅ Só adiciona se houver dados
            if (!empty($data)) {
                $consumptionData[$device->name] = $data;
            }
        }

        Log::info("Dados de consumo obtidos", [
            'report_id' => $report->id,
            'devices_with_data' => count($consumptionData),
            'total_devices' => $devices->count()
        ]);

        return $consumptionData;
    }

    /**
     * ✅ NOVO: Buscar dados de consumo do InfluxDB com horas reais de operação
     */
    private function fetchDeviceConsumptionFromInflux(
        InfluxDBService $influxService, 
        Device $device, 
        $startDate, 
        $endDate
    ): array {
        try {
            $timezone = config('app.timezone', 'America/Sao_Paulo');
            $start = Carbon::parse($startDate, $timezone)->startOfDay()->setTimezone('UTC')->toIso8601String();
            $stop = Carbon::parse($endDate, $timezone)->endOfDay()->setTimezone('UTC')->toIso8601String();
            $mac = $device->mac_address;

            // ✅ Determinar tipo de medição baseado no tipo de dispositivo
            $measurementInfo = $this->getMeasurementInfo($device);

            // ✅ Query para buscar dados BRUTOS (sem agregação) para calcular horas reais
            $query = <<<FLUX
from(bucket: "{$influxService->getBucket()}")
|> range(start: $start, stop: $stop)
|> filter(fn: (r) => r._measurement == "{$measurementInfo['measurement']}")
|> filter(fn: (r) => r.mac == "$mac")
|> filter(fn: (r) => r._field == "{$measurementInfo['field']}")
|> sort(columns: ["_time"])
|> yield()
FLUX;

            Log::debug("Query InfluxDB para device {$device->id}", [
                'device' => $device->name,
                'measurement' => $measurementInfo['measurement'],
                'period' => "$startDate to $endDate"
            ]);

            $results = $influxService->queryEnergyData($query);

            if (empty($results)) {
                Log::warning("Nenhum dado encontrado no InfluxDB para device {$device->id} no período");
                return [];
            }

            // ✅ Obter tarifa do usuário
            $tariff = $device->user->activeEnergyTariff;

            // ✅ Processar resultados agrupados por data/hora com cálculo real de tempo
            $data = $this->processRawDataWithRealHours($results, $timezone, $measurementInfo, $tariff);

            Log::info("Device {$device->name}: " . count($results) . " registros brutos processados, " . count($data) . " horas válidas");
            return $data;

        } catch (\Exception $e) {
            Log::error("Erro ao buscar dados do InfluxDB para device {$device->id}", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return [];
        }
    }

    /**
     * ✅ NOVO: Processar dados brutos calculando horas reais de operação
     */
    private function processRawDataWithRealHours(
        array $results, 
        string $timezone, 
        array $measurementInfo,
        $tariff
    ): array {
         $VOLTAGE = 220; // Volts
        $GAP_THRESHOLD = 5 * 60; // 5 minutos em segundos (considera como pausa)

        // ✅ Agrupar dados por data e hora
        $dataByDateHour = [];

        foreach ($results as $row) {
            if (!isset($row['value']) || $row['value'] === null || $row['value'] === '') {
                continue;
            }

            try {
                $timestamp = Carbon::parse($row['time'])->setTimezone($timezone);
                $dateKey = $timestamp->format('Y-m-d');
                $hourKey = $timestamp->hour;
                $value = (float) $row['value'];

                if (!isset($dataByDateHour[$dateKey])) {
                    $dataByDateHour[$dateKey] = [];
                }

                if (!isset($dataByDateHour[$dateKey][$hourKey])) {
                    $dataByDateHour[$dateKey][$hourKey] = [
                        'records' => [],
                        'sum_values' => 0,
                        'count' => 0
                    ];
                }

                $dataByDateHour[$dateKey][$hourKey]['records'][] = [
                    'timestamp' => $timestamp->timestamp,
                    'value' => $value
                ];
                $dataByDateHour[$dateKey][$hourKey]['sum_values'] += $value;
                $dataByDateHour[$dateKey][$hourKey]['count']++;

            } catch (\Exception $e) {
                Log::warning("Erro ao processar timestamp", ['error' => $e->getMessage()]);
                continue;
            }
        }

        // ✅ Calcular consumo real para cada hora com tempo de operação correto
        $processedData = [];

        foreach ($dataByDateHour as $date => $hours) {
            foreach ($hours as $hour => $data) {
                $records = $data['records'];
                
                if (count($records) < 2) {
                    // Se houver apenas 1 registro, assumir consumo zero ou mínimo
                    $avgValue = $data['sum_values'] / $data['count'];
                    $operationHours = 0;
                    
                    Log::debug("Hora com poucos registros", [
                        'date' => $date,
                        'hour' => $hour,
                        'records' => count($records)
                    ]);
                } else {
                    // ✅ Calcular horas reais de operação considerando gaps
                    $operationHours = $this->calculateOperationHours($records, $GAP_THRESHOLD);
                    $avgValue = $data['sum_values'] / $data['count'];
                }

                // ✅ Calcular consumo baseado em horas REAIS de operação
                $consumption = $this->calculateConsumptionWithRealHours(
                    $avgValue, 
                    $operationHours, 
                    $measurementInfo
                );

                $processedData[] = [
                    'date' => $date,
                    'hour' => $hour,
                    'consumption' => $consumption,
                    'cost' => $this->calculateCost($consumption, $tariff),
                    'operation_hours' => round($operationHours, 4),
                    'records_count' => count($records),
                    'avg_value' => round($avgValue, 4),
                    'timestamp' => Carbon::parse("$date $hour:00:00", config('app.timezone', 'America/Sao_Paulo'))
                ];

                if ($consumption > 0) {
                    Log::debug("Consumo calculado", [
                        'date' => $date,
                        'hour' => $hour,
                        'records' => count($records),
                        'operation_hours' => round($operationHours, 4),
                        'avg_value' => round($avgValue, 4),
                        'consumption_kwh' => round($consumption, 6)
                    ]);
                }
            }
        }

        return $processedData;
    }

    /**
     * ✅ NOVO: Calcular horas reais de operação detectando pausas
     */
    private function calculateOperationHours(array $records, int $gapThreshold): float
    {
        if (count($records) < 2) {
            return 0;
        }

        // Ordenar por timestamp
        usort($records, fn($a, $b) => $a['timestamp'] - $b['timestamp']);

        $operationSeconds = 0;
        $lastTimestamp = null;

        foreach ($records as $record) {
            if ($lastTimestamp === null) {
                $lastTimestamp = $record['timestamp'];
                continue;
            }

            $timeDiff = $record['timestamp'] - $lastTimestamp;

            // ✅ Se a diferença for menor que o threshold, conta como operação contínua
            if ($timeDiff < $gapThreshold) {
                $operationSeconds += $timeDiff;
            } else {
                // Pausa detectada - não conta esse intervalo
                Log::debug("Pausa detectada", [
                    'gap_seconds' => $timeDiff,
                    'threshold' => $gapThreshold
                ]);
            }

            $lastTimestamp = $record['timestamp'];
        }

        // Converter segundos para horas
        return $operationSeconds / 3600;
    }

    /**
     * ✅ NOVO: Calcular consumo usando horas REAIS de operação
     */
    private function calculateConsumptionWithRealHours(
        float $value, 
        float $operationHours, 
        array $measurementInfo
    ): float {
        // Se for temperatura ou umidade, retornar o valor direto
        if (in_array($measurementInfo['measurement'], ['temperature', 'humidity'])) {
            return $value;
        }

        // ✅ Se não houver tempo de operação, retornar zero
        if ($operationHours <= 0) {
            return 0;
        }

        // ✅ Calcular energia usando horas REAIS: E = P × t / 1000
        // Onde P = V × I (Potência em Watts)
        $VOLTAGE = 220;
        
        $powerW = $VOLTAGE * $value; // Potência em Watts
        $energyKwh = ($powerW * $operationHours) / 1000; // Energia em kWh
        
        return round($energyKwh, 6);
    }



    /**
     * ✅ Determinar tipo de medição do dispositivo
     */
    private function getMeasurementInfo(Device $device): array
    {
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
    }

    /**
     * ✅ CORRIGIDO: Calcular custo com base em tarifa progressiva
     */
    protected function calculateCost(float $consumption, $tariff): float
    {
        if (!$tariff) {
            return 0.0;
        }

        // Se não há faixas, usar taxa padrão
        if (empty($tariff->bracket1_rate)) {
            return round($consumption * ($tariff->default_rate ?? 0), 4);
        }

        $cost = 0;
        $remaining = $consumption;

        // Faixa 1
        if ($remaining > 0 && isset($tariff->bracket1_max) && $tariff->bracket1_max > 0) {
            $bracketConsumption = min($remaining, $tariff->bracket1_max);
            $cost += $bracketConsumption * $tariff->bracket1_rate;
            $remaining -= $bracketConsumption;
        }

        // Faixa 2
        if ($remaining > 0 && isset($tariff->bracket2_max) && $tariff->bracket2_max > 0) {
            $bracketLimit = $tariff->bracket2_max - ($tariff->bracket1_max ?? 0);
            $bracketConsumption = min($remaining, $bracketLimit);
            $cost += $bracketConsumption * ($tariff->bracket2_rate ?? 0);
            $remaining -= $bracketConsumption;
        }

        // Faixa 3 (todo o restante)
        if ($remaining > 0 && isset($tariff->bracket3_rate)) {
            $cost += $remaining * $tariff->bracket3_rate;
        }

        // Aplicar imposto se houver
        if (isset($tariff->tax_rate) && $tariff->tax_rate > 0) {
            $cost += $cost * ($tariff->tax_rate / 100);
        }

        return round($cost, 4);
    }

    /**
     * ✅ Extrair valores de consumo de forma segura
     */
    protected function extractConsumptionValues(array $data): array
    {
        $values = [];
        
        foreach ($data as $entry) {
            if (is_array($entry) && isset($entry['consumption'])) {
                $values[] = (float) $entry['consumption'];
            }
        }
        
        return $values;
    }

    /**
     * ✅ Extrair valores de custo de forma segura
     */
    protected function extractCostValues(array $data): array
    {
        $values = [];
        
        foreach ($data as $entry) {
            if (is_array($entry) && isset($entry['cost'])) {
                $values[] = (float) $entry['cost'];
            }
        }
        
        return $values;
    }

    /**
     * ✅ Soma segura de valores
     */
    protected function safeSum(array $values): float
    {
        if (empty($values)) {
            return 0.0;
        }

        $sum = 0.0;
        foreach ($values as $value) {
            if (is_numeric($value)) {
                $sum += (float) $value;
            }
        }

        return round($sum, 2);
    }

    /**
     * ✅ Média segura
     */
    protected function safeAverage(array $values): float
    {
        if (empty($values)) {
            return 0.0;
        }

        $numeric = array_filter($values, 'is_numeric');
        $count = count($numeric);
        
        if ($count === 0) {
            return 0.0;
        }

        $sum = array_sum($numeric);
        return round($sum / $count, 2);
    }

    /**
     * ✅ Máximo seguro
     */
    protected function safeMax(array $values): float
    {
        if (empty($values)) {
            return 0.0;
        }

        $numeric = array_filter($values, 'is_numeric');
        return !empty($numeric) ? round(max($numeric), 2) : 0.0;
    }

    /**
     * ✅ Mínimo seguro
     */
    protected function safeMin(array $values): float
    {
        if (empty($values)) {
            return 0.0;
        }

        $numeric = array_filter($values, 'is_numeric');
        return !empty($numeric) ? round(min($numeric), 2) : 0.0;
    }

    /**
     * ✅ Formata dados de consumo para exibição
     */
    protected function formatConsumptionData(array $rawData): array
    {
        $formatted = [
            'summary' => [],
            'details' => []
        ];

        foreach ($rawData as $deviceName => $entries) {
            if (!is_array($entries) || empty($entries)) {
                continue;
            }

            $consumptions = $this->extractConsumptionValues($entries);
            $costs = $this->extractCostValues($entries);

            $formatted['summary'][$deviceName] = [
                'total_consumption' => $this->safeSum($consumptions),
                'total_cost' => $this->safeSum($costs),
                'avg_consumption' => $this->safeAverage($consumptions),
                'records_count' => count($entries)
            ];

            $formatted['details'][$deviceName] = array_map(function ($entry) {
                return [
                    'date' => $entry['date'] ?? 'N/A',
                    'time' => sprintf('%02d:00', $entry['hour'] ?? 0),
                    'consumption_kwh' => round($entry['consumption'] ?? 0, 3),
                    'cost_currency' => round($entry['cost'] ?? 0, 4),
                    'timestamp' => isset($entry['timestamp'])
                        ? $entry['timestamp']->format('Y-m-d H:i:s')
                        : null
                ];
            }, $entries);
        }

        return $formatted;
    }
}