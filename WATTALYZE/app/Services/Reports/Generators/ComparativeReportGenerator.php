<?php

namespace App\Services\Reports\Generators;

use App\Models\Report;
use App\Services\Reports\ReportGeneratorInterface;
use App\Services\Reports\ReportGeneratorFactory;
use App\Services\Reports\Traits\ChartGeneratorTrait;
use App\Services\Reports\Traits\MetricsCalculatorTrait;
use Carbon\Carbon;

class ComparativeReportGenerator implements ReportGeneratorInterface
{
    use ChartGeneratorTrait, MetricsCalculatorTrait;

    public function getType(): string
    {
        return 'comparative';
    }

    public function getTemplateName(): string
    {
        return 'reports.templates.comparative';
    }

    public function generate($report): array
    {
       $consumptionData = $this->getConsumptionData($report);
        // Obter dados do período anterior para comparação
        $previousPeriodData = $this->getPreviousPeriodData($report);

        $metrics = $this->calculateMetrics([
            'current' => $consumptionData,
            'previous' => $previousPeriodData
        ], [
            'period_start' => $report->period_start,
            'period_end' => $report->period_end
        ]);

        $charts = $this->generateCharts($metrics);

        return [
            'report_name' => $report->name,
            'period_start' => Carbon::parse($report->period_start)->format('d/m/Y'),
            'period_end' => Carbon::parse($report->period_end)->format('d/m/Y'),
            'consumption_data' => $this->formatConsumptionData($consumptionData),
            'metrics' => $metrics,
            'charts' => $charts,
            'generated_at' => now()->format('d/m/Y H:i'),
            'type' => 'comparative'
        ];
    }

    public function calculateMetrics($devices, array $period): array
    {
        $current = is_array($devices['current']) ? $devices['current'] : [];
        $previous = is_array($devices['previous']) ? $devices['previous'] : [];

        $comparison = [];

        // Pre-calc ranking once for efficiency
        $ranking = $this->calculateRanking($current);

        // total consumption of current period across all devices (safe)
        $totalConsumption = array_reduce($current, function ($carry, $d) {
            if (!is_array($d) || empty($d)) return $carry;
            $sum = array_sum(array_column($d, 'consumption'));
            return $carry + $sum;
        }, 0.0);

        foreach ($current as $deviceName => $currentData) {
            $previousData = $previous[$deviceName] ?? [];

            // Ensure arrays
            $currentData = is_array($currentData) ? $currentData : [];
            $previousData = is_array($previousData) ? $previousData : [];

            // Comparação de consumo
            $currentTotal = $this->safeArraySumColumn($currentData, 'consumption');
            $previousTotal = $this->safeArraySumColumn($previousData, 'consumption');

            $variation = $previousTotal > 0
                ? (($currentTotal - $previousTotal) / $previousTotal) * 100
                : 0;

            // Taxa de crescimento
            $growthRate = $this->calculateGrowthRate($currentData, $previousData);

            // Ranking (precomputed)
            $rankingPosition = $ranking[$deviceName] ?? 0;

            // Contribuição percentual (proteção contra divisão por zero)
            $contributionPercentage = $totalConsumption > 0
                ? ($currentTotal / $totalConsumption) * 100
                : 0;

            $comparison[$deviceName] = [
                'current_total' => round($currentTotal, 2),
                'previous_total' => round($previousTotal, 2),
                'variation' => round($variation, 2),
                'growth_rate' => $growthRate,
                'ranking_position' => $rankingPosition,
                'contribution_percentage' => round($contributionPercentage, 2),
                'trend' => $this->analyzeTrend($currentData)
            ];
        }

        return [
            'devices' => $comparison,
            'summary' => $this->createSummary($comparison)
        ];
    }

    public function generateCharts(array $data): array
    {
        $charts = [];

        // 1. Grouped Bar Chart - Comparação lado a lado
        $charts['grouped_comparison'] = $this->generateGroupedBarChart($data['devices'] ?? []);

        // 2. Line Chart - Tendências múltiplas
        $charts['trends'] = $this->generateMultiLineTrendChart($data['devices'] ?? []);

        // 3. Stacked Area Chart - Contribuição
        $charts['contribution'] = $this->generateStackedAreaChart($data['devices'] ?? []);

        // 4. Bullet Chart - Atual vs Meta
        $charts['targets'] = $this->generateBulletCharts($data['devices'] ?? []);

        return $charts;
    }

    /**
     * Calcula o período anterior com mesma duração (inclui ambos os extremos)
     */
    private function getPreviousPeriodData(Report $report): array
    {
        $periodStart = Carbon::parse($report->period_start);
        $periodEnd = Carbon::parse($report->period_end);

        // duração em dias INCLUSIVA
        $duration = $periodStart->diffInDays($periodEnd) + 1;
        if ($duration <= 0) {
            // fallback: comparar com período anterior de 1 dia
            $duration = 1;
        }

        // Período anterior: imediatamente antes do período atual, com mesma duração
        $previousEnd = $periodStart->copy()->subDay();
        $previousStart = $previousEnd->copy()->subDays($duration - 1);

        // Criar relatório temporário para buscar dados (assegurando strings/dates)
        $tempReport = new Report([
            'user_id' => $report->user_id,
            'period_start' => $previousStart->toDateString(),
            'period_end' => $previousEnd->toDateString(),
            'filters' => $report->filters
        ]);

        return $this->getConsumptionData($tempReport);
    }

    private function calculateGrowthRate(array $current, array $previous): float
    {
        // Se não houver dados suficientes em qualquer lado, retorna 0
        $currentValues = is_array($current) ? array_column($current, 'consumption') : [];
        $previousValues = is_array($previous) ? array_column($previous, 'consumption') : [];

        $currentCount = count($currentValues);
        $previousCount = count($previousValues);

        $currentAvg = $currentCount > 0 ? (array_sum($currentValues) / $currentCount) : 0;
        $previousAvg = $previousCount > 0 ? (array_sum($previousValues) / $previousCount) : 0;

        if ($previousAvg <= 0) {
            return 0.0;
        }

        return round((($currentAvg - $previousAvg) / $previousAvg) * 100, 2);
    }

    private function calculateRanking(array $allDevices): array
    {
        $totals = [];
        foreach ($allDevices as $device => $data) {
            $totals[$device] = $this->safeArraySumColumn($data, 'consumption');
        }

        arsort($totals);

        $ranking = [];
        $position = 1;
        foreach (array_keys($totals) as $device) {
            $ranking[$device] = $position++;
        }

        return $ranking;
    }

    private function analyzeTrend(array $data): string
    {
        $values = is_array($data) ? array_column($data, 'consumption') : [];

        if (count($values) < 2) return 'stable';

        $half = (int) floor(count($values) / 2);
        if ($half < 1) return 'stable';

        $firstHalf = array_slice($values, 0, $half);
        $secondHalf = array_slice($values, $half);

        if (count($firstHalf) === 0 || count($secondHalf) === 0) return 'stable';

        $firstAvg = array_sum($firstHalf) / count($firstHalf);
        $secondAvg = array_sum($secondHalf) / count($secondHalf);

        // Proteção: se a média inicial for zero, não dividir por zero — considera 'stable'
        if ($firstAvg == 0) return 'stable';

        $change = (($secondAvg - $firstAvg) / $firstAvg) * 100;

        if ($change > 10) return 'increasing';
        if ($change < -10) return 'decreasing';
        return 'stable';
    }

    private function createSummary(array $comparison): array
    {
        $deviceCount = count($comparison);
        if ($deviceCount === 0) {
            return [
                'average_variation' => 0.0,
                'devices_increasing' => 0,
                'devices_decreasing' => 0,
                'devices_stable' => 0
            ];
        }

        // Somar variações apenas quando existirem e forem numéricas
        $variations = array_map(function ($d) {
            return isset($d['variation']) && is_numeric($d['variation']) ? (float)$d['variation'] : 0.0;
        }, $comparison);

        $totalVariationSum = array_sum($variations);
        $totalVariation = $deviceCount > 0 ? ($totalVariationSum / $deviceCount) : 0.0;

        $increasing = array_filter($comparison, fn($d) => isset($d['trend']) && $d['trend'] === 'increasing');
        $decreasing = array_filter($comparison, fn($d) => isset($d['trend']) && $d['trend'] === 'decreasing');

        $increasingCount = count($increasing);
        $decreasingCount = count($decreasing);
        $stableCount = $deviceCount - $increasingCount - $decreasingCount;

        return [
            'average_variation' => round($totalVariation, 2),
            'devices_increasing' => $increasingCount,
            'devices_decreasing' => $decreasingCount,
            'devices_stable' => $stableCount
        ];
    }

    /**
     * Helper para somar de forma segura uma coluna 'consumption' mesmo que o dado esteja vazio
     */
    private function safeArraySumColumn($data, string $column): float
    {
        if (!is_array($data) || empty($data)) return 0.0;

        $values = array_column($data, $column);
        if (empty($values)) return 0.0;

        // Garantir que apenas valores numéricos sejam somados
        $sum = 0.0;
        foreach ($values as $v) {
            if (is_numeric($v)) $sum += (float)$v;
        }
        return $sum;
    }
}
