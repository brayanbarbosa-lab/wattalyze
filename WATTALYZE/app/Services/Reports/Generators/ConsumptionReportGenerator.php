<?php

namespace App\Services\Reports\Generators;

use App\Services\Reports\Traits\MetricsCalculatorTrait;
use App\Services\Reports\Traits\ChartGeneratorTrait;
use Carbon\Carbon;
use App\Services\Reports\ReportGeneratorInterface;

/**
 * ✅ CORRIGIDO: Gerador de Relatório de Consumo
 * Agora extrai corretamente consumption e cost dos dados normalizados
 */
class ConsumptionReportGenerator implements ReportGeneratorInterface
{
    use MetricsCalculatorTrait, ChartGeneratorTrait;

    public function generate($report): array
    {
        // Obter dados (normalizados)
        $consumptionData = $this->getConsumptionData($report);
        // Calcular métricas COM DADOS CORRETOS
        $metrics = $this->calculateMetrics($consumptionData, [
            'period_start' => $report->period_start,
            'period_end' => $report->period_end
        ]);

        // Gerar gráficos
        $charts = $this->generateCharts($metrics);

        return [
            'report_name' => $report->name,
            'period_start' => Carbon::parse($report->period_start)->format('d/m/Y'),
            'period_end' => Carbon::parse($report->period_end)->format('d/m/Y'),
            'consumption_data' => $this->formatConsumptionData($consumptionData),
            'metrics' => $metrics,
            'charts' => $charts,
            'generated_at' => now()->format('d/m/Y H:i'),
            'type' => 'consumption'
        ];
    }

    /**
     * ✅ CORRIGIDO: Usar métodos seguros para extrair dados
     */
    public function calculateMetrics($devices, array $period): array
    {
        $metrics = [];

        foreach ($devices as $deviceName => $data) {
            // ✅ Usar extract methods que tratam normalização
            $consumptions = $this->extractConsumptionValues($data);
            $costs = $this->extractCostValues($data);

            $count = count($consumptions);

            $metrics[$deviceName] = [
                'total_consumption' => $this->safeSum($consumptions),
                'average_consumption' => $this->safeAverage($consumptions),
                'max_consumption' => $this->safeMax($consumptions),
                'min_consumption' => $this->safeMin($consumptions),
                'total_cost' => $this->safeSum($costs),
                'average_cost' => $this->safeAverage($costs)
            ];
        }

        return ['devices' => $metrics];
    }
    public function getType(): string
    {
        return 'consumption';
    }
    public function generateCharts(array $data): array
    {
        return [];
    }

    public function getTemplateName(): string
    {
        return 'reports.templates.consumption';
    }
}
