<?php

namespace App\Services\Reports\Generators;

use App\Services\Reports\Traits\MetricsCalculatorTrait;
use App\Services\Reports\Traits\ChartGeneratorTrait;
use Carbon\Carbon;
use App\Services\Reports\ReportGeneratorInterface;

/**
 * ✅ CORRIGIDO: Gerador de Relatório de Custo
 * Agora extrai corretamente os dados de custo
 */
class CostReportGenerator implements ReportGeneratorInterface
{
    use MetricsCalculatorTrait, ChartGeneratorTrait;

    public function generate($report): array
    {
        $user = $report->user;
        $tariff = $user->activeEnergyTariff;

        // Obter dados normalizados
        $consumptionData = $this->getConsumptionData($report);

        // Calcular métricas específicas de custo
        $metrics = $this->calculateMetrics($consumptionData, [
            'tariff' => $tariff,
            'period_start' => $report->period_start,
            'period_end' => $report->period_end
        ]);

        // Gerar gráficos
        $charts = $this->generateCharts($metrics);

        return [
            'report_name' => $report->name,
            'period_start' => Carbon::parse($report->period_start)->format('d/m/Y'),
            'period_end' => Carbon::parse($report->period_end)->format('d/m/Y'),
            'metrics' => $metrics,
            'consumption_data' => $this->formatConsumptionData($consumptionData),
            'charts' => $charts,
            'generated_at' => now()->format('d/m/Y H:i'),
            'type' => 'cost'
        ];
    }

    /**
     * ✅ CORRIGIDO: Calcular métricas de custo com dados normalizados
     */
    public function calculateMetrics($devices, array $period): array
    {
        $tariff = $period['tariff'];
        $metricsDevices = [];

        foreach ($devices as $deviceName => $data) {
            // ✅ Usar métodos seguros
            $costs = $this->extractCostValues($data);
            $consumptions = $this->extractConsumptionValues($data);

            // Calcular distribuição de custos por faixa tarifária
            $bracketDistribution = $this->calculateBracketDistribution($data, $tariff);

            // Calcular economia potencial
            $savingsPotential = $this->calculateSavingsPotential($data, $tariff);

            // Projeções
            $totalCost = $this->safeSum($costs);
            $avgDailyCost = $this->safeAverage($costs);

            $projections = [
                'monthly' => round($avgDailyCost * 30, 2),
                'quarterly' => round($avgDailyCost * 90, 2),
                'yearly' => round($avgDailyCost * 365, 2)
            ];

            // Score de eficiência de custo (0-100)
            $costEfficiencyScore = $this->calculateCostEfficiencyScore($data, $tariff);

            $metricsDevices[$deviceName] = [
                'bracket_distribution' => $bracketDistribution,
                'savings_potential' => $savingsPotential,
                'projections' => $projections,
                'cost_efficiency_score' => $costEfficiencyScore,
                'total_cost' => $totalCost,
                'average_daily_cost' => $avgDailyCost
            ];
        }

        // Calcular resumo
        $totalCosts = array_column($metricsDevices, 'total_cost');
        $avgDailyCosts = array_column($metricsDevices, 'average_daily_cost');

        return [
            'devices' => $metricsDevices,
            'summary' => [
                'total_cost' => $this->safeSum($totalCosts),
                'average_cost' => $this->safeAverage($avgDailyCosts)
            ]
        ];
    }
    public function getType(): string
    {
        return 'cost';
    }
    public function generateCharts(array $data): array
    {
        $charts = [];
        $devices = $data['devices'] ?? [];

        foreach ($devices as $deviceName => $metrics) {
            // 1. Gráfico de Pizza - Distribuição por faixa
            $charts[$deviceName]['bracket_pie'] = $this->generatePieChart(
                array_keys($metrics['bracket_distribution']),
                array_values($metrics['bracket_distribution']),
                'Distribuição de Custos por Faixa Tarifária',
                ['#2E8B57', '#3498db', '#e67e22']
            );

            // 2. Gauge Chart - Score de eficiência
            $charts[$deviceName]['efficiency_gauge'] = $this->generateGaugeChart(
                $metrics['cost_efficiency_score'],
                'Score de Eficiência de Custo'
            );

            // 3. Line Chart - Projeções
            $charts[$deviceName]['projections'] = $this->generateLineChart(
                ['Mensal', 'Trimestral', 'Anual'],
                [
                    $metrics['projections']['monthly'],
                    $metrics['projections']['quarterly'],
                    $metrics['projections']['yearly']
                ],
                'Projeção de Custos',
                '#DC143C'
            );
        }

        return $charts;
    }

    /**
     * ✅ CORRIGIDO: Calcular distribuição por faixa com dados normalizados
     */
    private function calculateBracketDistribution(array $data, $tariff): array
    {
        $distribution = [
            'Faixa 1' => 0,
            'Faixa 2' => 0,
            'Faixa 3' => 0
        ];

        if (!$tariff) {
            return $distribution;
        }

        // Dados já normalizados (flat array)
        foreach ($data as $entry) {
            if (!is_array($entry) || !isset($entry['consumption'])) {
                continue;
            }

            $consumption = $entry['consumption'];

            // Calcular quanto foi consumido em cada faixa
            if ($consumption <= ($tariff->bracket1_max ?? 0)) {
                $distribution['Faixa 1'] += $consumption * ($tariff->bracket1_rate ?? 0);
            } elseif ($consumption <= ($tariff->bracket2_max ?? 0)) {
                $bracket1Cost = ($tariff->bracket1_max ?? 0) * ($tariff->bracket1_rate ?? 0);
                $bracket2Cost = ($consumption - ($tariff->bracket1_max ?? 0)) * ($tariff->bracket2_rate ?? 0);
                $distribution['Faixa 1'] += $bracket1Cost;
                $distribution['Faixa 2'] += $bracket2Cost;
            } else {
                $bracket1Cost = ($tariff->bracket1_max ?? 0) * ($tariff->bracket1_rate ?? 0);
                $bracket2Cost = (($tariff->bracket2_max ?? 0) - ($tariff->bracket1_max ?? 0)) * ($tariff->bracket2_rate ?? 0);
                $bracket3Cost = ($consumption - ($tariff->bracket2_max ?? 0)) * ($tariff->bracket3_rate ?? 0);
                $distribution['Faixa 1'] += $bracket1Cost;
                $distribution['Faixa 2'] += $bracket2Cost;
                $distribution['Faixa 3'] += $bracket3Cost;
            }
        }

        // Arredondar valores
        return array_map(fn($v) => round($v, 2), $distribution);
    }

    private function calculateSavingsPotential(array $data, $tariff): float
    {
        if (!$tariff) return 0;

        $costs = $this->extractCostValues($data);
        $currentCost = $this->safeSum($costs);

        $consumptions = $this->extractConsumptionValues($data);
        $totalConsumption = $this->safeSum($consumptions);

        // Custo se todo consumo fosse na faixa mais barata
        $optimizedCost = $totalConsumption * ($tariff->bracket1_rate ?? 0);

        // Percentual de economia
        $savingsPercentage = $currentCost > 0 ? (($currentCost - $optimizedCost) / $currentCost) * 100 : 0;

        return max(0, round($savingsPercentage, 2));
    }

    private function calculateCostEfficiencyScore(array $data, $tariff): int
    {
        if (!$tariff) return 50;

        $consumptions = $this->extractConsumptionValues($data);
        if (empty($consumptions)) return 50;

        $consumption = $this->safeSum($consumptions);
        if ($consumption == 0) return 50;

        // Percentual de consumo na faixa 1 (mais barata)
        $bracket1Consumption = 0;
        foreach ($data as $entry) {
            if (is_array($entry) && isset($entry['consumption'])) {
                $c = $entry['consumption'];
                $bracket1Consumption += min($c, $tariff->bracket1_max ?? 0);
            }
        }

        $bracket1Percentage = ($bracket1Consumption / $consumption) * 100;

        // Calcular variação
        $mean = array_sum($consumptions) / count($consumptions);
        $variance = array_sum(array_map(fn($x) => pow($x - $mean, 2), $consumptions)) / count($consumptions);
        $stdDev = sqrt($variance);
        $cv = ($stdDev / $mean) * 100;

        // Score: 70% baseado em uso da faixa 1, 30% baseado em consistência
        $score = ($bracket1Percentage * 0.7) + ((100 - min($cv, 100)) * 0.3);

        return (int) round(min($score, 100));
    }

    public function getTemplateName(): string
    {
        return 'reports.templates.cost';
    }
}
