<?php

namespace App\Services\Reports\Generators;

use App\Models\Report;
use App\Services\Reports\ReportGeneratorInterface;
use App\Services\Reports\Traits\ChartGeneratorTrait;
use App\Services\Reports\Traits\MetricsCalculatorTrait;
use Carbon\Carbon;
use App\Services\Reports\ReportGeneratorFactory;
class EfficiencyReportGenerator implements ReportGeneratorInterface
{
    use ChartGeneratorTrait, MetricsCalculatorTrait;

    public function getType(): string
    {
        return 'efficiency';
    }

    public function getTemplateName(): string
    {
        return 'reports.templates.efficiency';
    }

    public function generate($report): array
    {
        $consumptionData = $this->getConsumptionData($report);

        $metrics = $this->calculateMetrics($consumptionData, [
            'period_start' => $report->period_start,
            'period_end' => $report->period_end
        ]);

        $charts = $this->generateCharts($metrics);

        return [
            'report_name' => $report->name,
            'period_start' => Carbon::parse($report->period_start)->format('d/m/Y'),
            'period_end' => Carbon::parse($report->period_end)->format('d/m/Y'),
            'metrics' => $metrics,
            'charts' => $charts,
            'consumption_data' => $this->formatConsumptionData($consumptionData),
            'generated_at' => now()->format('d/m/Y H:i'),
            'type' => 'efficiency'
        ];
    }

    public function calculateMetrics($devices, array $period): array
    {
        $metrics = [];

        foreach ($devices as $deviceName => $data) {
            // 1. kWh por hora de uso
            $kwhPerHour = $this->calculateKwhPerHour($data);

            // 2. Load Factor
            $loadFactor = $this->calculateLoadFactor($data);

            // 3. Horários de pico
            $peakHours = $this->identifyPeakHours($data);

            // 4. Score de eficiência
            $efficiencyScore = $this->calculateEfficiencyScore($data);

            // 5. Benchmark comparison
            $benchmarkComparison = $this->compareToBenchmark($data, $deviceName);

            $metrics[$deviceName] = [
                'kwh_per_hour' => $kwhPerHour,
                'load_factor' => $loadFactor,
                'peak_hours' => $peakHours,
                'efficiency_score' => $efficiencyScore,
                'benchmark_comparison' => $benchmarkComparison,
                'optimization_suggestions' => $this->generateSuggestions($data, $efficiencyScore)
            ];
        }

        // Ranking geral de eficiência
        $ranking = $this->createEfficiencyRanking($metrics);

        return [
            'devices' => $metrics,
            'ranking' => $ranking,
            'overall_efficiency' => $this->calculateOverallEfficiency($metrics)
        ];
    }

    public function generateCharts(array $data): array
    {
        $charts = [];

        // 1. Heatmap de consumo por hora/dia
        $charts['heatmap'] = $this->generateHeatmapChart($data);

        // 2. Radar Chart - Comparação de eficiência
        $charts['efficiency_radar'] = $this->generateRadarChart($data['devices']);

        // 3. Gauge Charts para cada dispositivo
        foreach ($data['devices'] as $deviceName => $metrics) {
            $charts['gauges'][$deviceName] = $this->generateGaugeChart(
                $metrics['efficiency_score'],
                "Score de Eficiência - {$deviceName}"
            );
        }

        // 4. Bar Chart - Ranking
        $charts['ranking'] = $this->generateRankingBarChart($data['ranking']);

        return $charts;
    }

    private function calculateKwhPerHour(array $data): float
    {
        if (count($data) === 0) return 0;

        $totalKwh = array_sum(array_column($data, 'consumption'));
        $totalHours = count($data) * 24;

        return $totalHours > 0 ? round($totalKwh / $totalHours, 4) : 0;
    }

    private function calculateLoadFactor(array $data): float
    {
        if (count($data) === 0) return 0;

        $totalEnergy = array_sum(array_column($data, 'consumption'));
        $consumptions = array_column($data, 'consumption');

        if (empty($consumptions)) return 0;

        $peakDemand = max($consumptions);
        $hours = count($data) * 24;

        if ($peakDemand == 0 || $hours == 0) return 0;

        $loadFactor = $totalEnergy / ($peakDemand * $hours);

        return round($loadFactor * 100, 2);
    }


    private function identifyPeakHours(array $data): array
    {
        // Agrupar por hora do dia e calcular média
        $hourlyConsumption = array_fill(0, 24, []);

        foreach ($data as $date => $entry) {
            // Simular distribuição horária (em implementação real, usar dados reais)
            for ($hour = 0; $hour < 24; $hour++) {
                $hourlyConsumption[$hour][] = $entry['consumption'] / 24;
            }
        }

        $hourlyAverage = [];
        foreach ($hourlyConsumption as $hour => $values) {
            $hourlyAverage[$hour] = count($values) > 0
                ? array_sum($values) / count($values)
                : 0;
        }

        // Identificar top 5 horas de pico
        arsort($hourlyAverage);
        $topPeakHours = array_slice($hourlyAverage, 0, 5, true);

        return array_map(function ($hour, $consumption) {
            return [
                'hour' => sprintf('%02d:00', $hour),
                'avg_consumption' => round($consumption, 2)
            ];
        }, array_keys($topPeakHours), $topPeakHours);
    }

    private function calculateEfficiencyScore(array $data): int
    {
        // Score baseado em múltiplos fatores:
        // - Load Factor (40%)
        // - Consistência de consumo (30%)
        // - Uso em horários otimizados (30%)

        $loadFactor = $this->calculateLoadFactor($data);

        // Coeficiente de variação
        $consumptions = array_column($data, 'consumption');
        $count = count($consumptions);

        if ($count === 0) {
            return 0;
        }

        $mean = array_sum($consumptions) / $count;

        if ($mean == 0) return 0;

        $variance = array_sum(array_map(fn($x) => pow($x - $mean, 2), $consumptions)) / $count;
        $cv = (sqrt($variance) / $mean) * 100;
        $consistencyScore = 100 - min($cv, 100);
        
        // Score de horário otimizado (simulado)
        $timingScore = 70; // Em implementação real, calcular baseado em tarifas

        $totalScore = ($loadFactor * 0.4) + ($consistencyScore * 0.3) + ($timingScore * 0.3);

        return (int) round($totalScore);
    }

    private function compareToBenchmark(array $data, string $deviceName): array
    {
        // Benchmarks ideais por tipo de dispositivo (valores exemplo)
        $benchmarks = [
            'default' => ['kwh_per_hour' => 0.5, 'load_factor' => 60]
        ];

        $benchmark = $benchmarks['default'];
        $actual = [
            'kwh_per_hour' => $this->calculateKwhPerHour($data),
            'load_factor' => $this->calculateLoadFactor($data)
        ];

        return [
            'benchmark' => $benchmark,
            'actual' => $actual,
            'variance' => [
                'kwh_per_hour' => round((($actual['kwh_per_hour'] - $benchmark['kwh_per_hour']) / $benchmark['kwh_per_hour']) * 100, 2),
                'load_factor' => round($actual['load_factor'] - $benchmark['load_factor'], 2)
            ]
        ];
    }

    private function generateSuggestions(array $data, int $score): array
    {
        $suggestions = [];

        if ($score < 50) {
            $suggestions[] = "⚠️ Eficiência crítica. Considere revisar o equipamento.";
        }

        $loadFactor = $this->calculateLoadFactor($data);
        if ($loadFactor < 50) {
            $suggestions[] = "💡 Load Factor baixo. Distribua melhor o uso ao longo do dia.";
        }

        $peakHours = $this->identifyPeakHours($data);
        if (!empty($peakHours)) {
            $suggestions[] = "⏰ Concentre o uso fora dos horários: " . implode(', ', array_column($peakHours, 'hour'));
        }

        return $suggestions;
    }

    private function createEfficiencyRanking(array $metrics): array
    {
        $ranking = [];

        foreach ($metrics as $device => $data) {
            $ranking[$device] = $data['efficiency_score'];
        }

        arsort($ranking);

        return $ranking;
    }

    private function calculateOverallEfficiency(array $metrics): int
    {



        $scores = array_column($metrics, 'efficiency_score');

        if (array_sum($scores) === 0 || count($scores) === 0) {
            return 0;
        } else {
            return (int) round(array_sum($scores) / count($scores));
        }
    }
}
