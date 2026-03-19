<?php

namespace App\Jobs;

use App\Models\Report;
use App\Models\Device;
use App\Services\InfluxDBService;
use App\Services\Reports\ReportGeneratorFactory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\Middleware\ThrottlesExceptions;

class GenerateReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $report;

    public function __construct(Report $report)
    {
        $this->report = $report;
    }

    public function handle()
    {
        try {
            $report = $this->report;

            // Usar o novo sistema de geradores
            $generator = ReportGeneratorFactory::make($report->type);
            $reportData = $generator->generate($report);

            // Renderizar template
            $html = view($generator->getTemplateName(), [
                'reportData' => $reportData
            ])->render();

            // Gerar PDF
            $pdf = Pdf::loadHTML($html)->setPaper('a4', 'portrait');
            $fileName = "reports/{$report->id}_" . now()->format('YmdHis') . ".pdf";

            Storage::put($fileName, $pdf->output());

            $report->update([
                'data' => $reportData,
                'status' => 'completed',
                'file_path' => $fileName,
            ]);

            Log::info("Relatório {$report->id} gerado com sucesso");

        } catch (\Exception $e) {
            Log::error("Erro ao gerar relatório {$this->report->id}: " . $e->getMessage());

            $this->report->update([
                'status' => 'failed',
                'error_message' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    public function middleware(): array
    {
        return [
            new WithoutOverlapping($this->report->id),
        ];
    }

    /**
     * Calcula o custo baseado em faixas progressivas
     * (Mantido para compatibilidade retroativa)
     */
    private function calculateCost(float $consumption, $tariff): float
    {
        if (empty($tariff->bracket1_rate)) {
            return round($consumption * ($tariff->default_rate ?? 0), 4);
        }

        $cost = 0;
        $remaining = $consumption;

        $brackets = [
            [
                'limit' => $tariff->bracket1_max ?? INF,
                'rate' => $tariff->bracket1_rate
            ],
            [
                'limit' => $tariff->bracket2_max ?? INF,
                'rate' => $tariff->bracket2_rate
            ],
            [
                'limit' => $tariff->bracket3_max ?? INF,
                'rate' => $tariff->bracket3_rate
            ],
        ];

        foreach ($brackets as $index => $bracket) {
            if ($remaining <= 0) break;

            $prevLimit = $index > 0 ? $brackets[$index - 1]['limit'] : 0;
            $currentLimit = min($bracket['limit'], $prevLimit + ($bracket['limit'] ?? INF)) - $prevLimit;
            $bracketConsumption = min($remaining, $currentLimit);

            $cost += $bracketConsumption * $bracket['rate'];
            $remaining -= $bracketConsumption;
        }

        if (!empty($tariff->tax_rate)) {
            $cost += $cost * ($tariff->tax_rate / 100);
        }

        return round($cost, 4);
    }
}
