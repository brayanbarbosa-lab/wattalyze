<?php

namespace App\Services\Reports\Generators;

use App\Models\Report;
use App\Services\Reports\ReportGeneratorInterface;
use App\Services\Reports\Traits\ChartGeneratorTrait;
use App\Services\Reports\Traits\MetricsCalculatorTrait;
use Carbon\Carbon;
use App\Services\Reports\ReportGeneratorFactory;
class CustomReportGenerator implements ReportGeneratorInterface
{
    use ChartGeneratorTrait, MetricsCalculatorTrait;

    public function getType(): string
    {
        return 'custom';
    }

    public function getTemplateName(): string
    {
        return 'reports.templates.custom';
    }

    public function generate($report): array
    {
        $consumptionData = $this->getConsumptionData($report);

        // Obter configuração de métricas customizadas do filtro
        $customMetrics = $report->filters['custom_metrics'] ?? [];
        $filterByHour = $report->filters['filter_hour'] ?? null;
        $filterByDayOfWeek = $report->filters['filter_day_of_week'] ?? null;

        // Aplicar filtros
        if ($filterByHour !== null) {
            $consumptionData = $this->filterByHour($consumptionData, $filterByHour);
        }

        if ($filterByDayOfWeek !== null) {
            $consumptionData = $this->filterByDayOfWeek($consumptionData, $filterByDayOfWeek);
        }

        $metrics = $this->calculateMetrics($consumptionData, [
            'custom_metrics' => $customMetrics,
            'period_start' => $report->period_start,
            'period_end' => $report->period_end
        ]);

        // ✅ Passar dados + métricas juntos
        $chartData = array_merge($metrics, ['custom_metrics' => $customMetrics]);
        $charts = $this->generateCharts($chartData);

        // Preparar dados brutos para exportação
        $rawData = $this->prepareRawDataExport($consumptionData);

        return [
            'report_name' => $report->name,
            'period_start' => Carbon::parse($report->period_start)->format('d/m/Y'),
            'period_end' => Carbon::parse($report->period_end)->format('d/m/Y'),
            'metrics' => $metrics,
            'charts' => $charts,
            'raw_data' => $rawData,
            'generated_at' => now()->format('d/m/Y H:i'),
            'type' => 'custom'
        ];
    }

    /**
     * ✅ Assinatura compatível com interface
     */
    public function calculateMetrics($devices, array $period): array
    {
        $customMetrics = $period['custom_metrics'] ?? [];
        $metrics = [];

        foreach ($devices as $deviceName => $data) {
            $deviceMetrics = [];

            // Calcular métricas solicitadas
            foreach ($customMetrics as $metric) {
                $deviceMetrics[$metric] = $this->calculateMetric($metric, $data);
            }

            $metrics[$deviceName] = $deviceMetrics;
        }

        return [
            'devices' => $metrics,
            'custom_metrics' => $customMetrics
        ];
    }

    /**
     * ✅ Assinatura compatível com interface
     * Extrai custom_metrics dos dados passados
     */
    public function generateCharts(array $data): array
    {
        // ✅ Extrair custom_metrics do $data
        $customMetrics = $data['custom_metrics'] ?? [];
        $deviceMetrics = $data['devices'] ?? $data;

        // Gerar gráficos baseado nas métricas selecionadas
        $charts = [];

        // Exemplo: Se linha for selecionada
        if (in_array('line_trend', $customMetrics)) {
            $charts['trend'] = $this->generateMultiLineTrendChart($deviceMetrics);
        }

        // Se comparação for selecionada
        if (in_array('comparison', $customMetrics)) {
            $charts['comparison'] = $this->generateGroupedBarChart($deviceMetrics);
        }

        // Se distribuição for selecionada
        if (in_array('distribution', $customMetrics)) {
            $charts['distribution'] = $this->generatePieChart(
                array_keys($deviceMetrics),
                array_column($deviceMetrics, 'total') ?? array_fill(0, count($deviceMetrics), 0),
                'Distribuição de Consumo',
                ['#2E8B57', '#3498db', '#e67e22', '#9b59b6', '#e74c3c']
            );
        }

        return $charts;
    }

    private function calculateMetric(string $metric, array $data): mixed
    {
        $values = [];

        // Extrair valores de consumo
        foreach ($data as $entry) {
            if (is_array($entry)) {
                foreach ($entry as $hourData) {
                    if (is_array($hourData) && isset($hourData['consumption'])) {
                        $values[] = $hourData['consumption'];
                    }
                }
            }
        }

        if (empty($values)) {
            return match($metric) {
                'total', 'average', 'maximum', 'minimum', 'std_dev', 'variance', 'median', 'q1', 'q3' => 0,
                default => null
            };
        }

        return match($metric) {
            'total' => round(array_sum($values), 2),
            'average' => round(array_sum($values) / count($values), 2),
            'maximum' => round(max($values), 2),
            'minimum' => round(min($values), 2),
            'std_dev' => round($this->calculateStdDev($values), 2),
            'variance' => round($this->calculateVariance($values), 2),
            'median' => round($this->calculateMedian($values), 2),
            'q1' => round($this->calculateQuartile($values, 0.25), 2),
            'q3' => round($this->calculateQuartile($values, 0.75), 2),
            default => null
        };
    }

    private function filterByHour(array $data, int $hour): array
    {
        $filtered = [];

        foreach ($data as $date => $entries) {
            if (isset($entries[$hour])) {
                $filtered[$date] = [$hour => $entries[$hour]];
            }
        }

        return $filtered;
    }

    private function filterByDayOfWeek(array $data, array $daysOfWeek): array
    {
        $filtered = [];

        foreach ($data as $date => $entries) {
            $dayOfWeek = Carbon::parse($date)->dayOfWeek;

            if (in_array($dayOfWeek, $daysOfWeek)) {
                $filtered[$date] = $entries;
            }
        }

        return $filtered;
    }

    private function prepareRawDataExport(array $data): array
    {
        $rawData = [];

        foreach ($data as $date => $entries) {
            foreach ($entries as $hour => $consumption) {
                $rawData[] = [
                    'date' => $date,
                    'hour' => sprintf('%02d:00', $hour),
                    'consumption_kwh' => $consumption
                ];
            }
        }

        return $rawData;
    }

    private function calculateStdDev(array $values): float
    {
        if (count($values) < 2) return 0;

        $mean = array_sum($values) / count($values);
        $variance = array_sum(array_map(fn($x) => pow($x - $mean, 2), $values)) / count($values);
        return sqrt($variance);
    }

    private function calculateVariance(array $values): float
    {
        if (count($values) < 2) return 0;

        $mean = array_sum($values) / count($values);
        return array_sum(array_map(fn($x) => pow($x - $mean, 2), $values)) / count($values);
    }

    private function calculateMedian(array $values): float
    {
        sort($values);
        $count = count($values);
        $middle = intdiv($count, 2);

        if ($count % 2 === 0) {
            return ($values[$middle - 1] + $values[$middle]) / 2;
        }

        return $values[$middle];
    }

    private function calculateQuartile(array $values, float $percentile): float
    {
        sort($values);
        $position = $percentile * (count($values) - 1);

        if ($position == intval($position)) {
            return $values[intval($position)];
        }

        $lower = $values[floor($position)];
        $upper = $values[ceil($position)];
        $weight = $position - floor($position);

        return $lower + ($upper - $lower) * $weight;
    }
}