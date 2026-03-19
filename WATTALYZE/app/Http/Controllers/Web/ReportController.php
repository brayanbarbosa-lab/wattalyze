<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Device;
use App\Models\Environment;
use App\Services\Reports\Generators\ReportGeneratorFactory;
use Illuminate\Http\Request;
use App\Jobs\GenerateReportJob;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

class ReportController extends Controller
{
    public function index()
    {
         Artisan::call('alerts:check');
        $reports = Report::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('reports.index', compact('reports'));
    }

    public function generateForm()
    {
        $devices = Device::where('user_id', auth()->id())->get();
        $environments = Environment::where('user_id', auth()->id())->get();

        return view('reports.generate', compact('devices', 'environments'));
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:consumption,cost,efficiency,comparative,custom',
            'period_type' => 'required|in:daily,weekly,monthly,yearly,custom',
            'period_start' => 'required|date',
            'period_end' => 'required|date|after:period_start',
            'format' => 'required|in:pdf,excel,csv',
            'devices' => 'nullable|array',
            'environments' => 'nullable|array',
        ]);

        $report = Report::create([
            'user_id' => auth()->id(),
            'status' => 'pending',
            'filters' => [
                'devices' => $request->devices,
                'environments' => $request->environments,
            ],
            ...$validated,
        ]);

        // Executa o job **sincronamente** (sem fila)
        $job = new GenerateReportJob($report);
        $job->handle();

        return redirect()->route('reports.index')
            ->with('success', 'Relatório gerado com sucesso!');
    }

    // Adicionar método para preview
public function preview(Request $request)
{
    $validated = $request->validate([
        'type' => 'required|in:consumption,cost,efficiency,comparative,custom',
        'devices' => 'nullable|array',
        'period_start' => 'required|date',
        'period_end' => 'required|date|after:period_start'
    ]);

    // Criar relatório temporário para preview
    $tempReport = new Report([
        'user_id' => auth()->id(),
        'type' => $validated['type'],
        'period_start' => $validated['period_start'],
        'period_end' => $validated['period_end'],
        'filters' => ['devices' => $request->devices]
    ]);

    $generator = ReportGeneratorFactory::make($validated['type']);
    $reportData = $generator->generate($tempReport);

    return view($generator->getTemplateName(), ['reportData' => $reportData]);
}

   public function destroy(Report $report)
    {

        // Apagar o arquivo do storage se existir
        if ($report->file_path && Storage::exists($report->file_path)) {
            Storage::delete($report->file_path);
        }

        $report->delete();

        return redirect()->route('reports.index')
            ->with('success', 'Relatório excluído com sucesso!');
    }
    public function download(Report $report)
    {
        $this->authorize('view', $report);

        if (!$report->file_path || $report->status !== 'completed') {
            return back()->with('error', 'Relatório não disponível para download');
        }

        return response()->download(storage_path('app/' . $report->file_path));
    }
}
