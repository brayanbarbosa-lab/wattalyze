<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Device;
use App\Models\Environment;
use App\Jobs\GenerateReportJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Artisan;

class ApiReportController extends Controller
{
    /**
     * Listar relatórios do usuário autenticado
     * GET /api/reports
     */
    public function index()
    {
         Artisan::call('alerts:check');
        try {
            $reports = Report::where('user_id', auth()->id())
                ->latest()
                ->paginate(10);

            return response()->json($reports, 200);
        } catch (\Exception $e) {
            Log::error('Erro ao listar relatórios', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'message' => 'Erro ao listar relatórios',
                'error' => config('app.debug') ? $e->getMessage() : 'Erro interno do servidor',
            ], 500);
        }
    }

    /**
     * Buscar dispositivos e ambientes para o formulário
     * GET /api/reports/generate-form
     */
    public function generateForm()
    {
        try {
            $devices = Device::where('user_id', auth()->id())
                ->select('id', 'name')
                ->get();

            $environments = Environment::where('user_id', auth()->id())
                ->select('id', 'name')
                ->get();

            return response()->json([
                'devices' => $devices,
                'environments' => $environments,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Erro ao carregar formulário', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'message' => 'Erro ao carregar dados do formulário',
                'error' => config('app.debug') ? $e->getMessage() : 'Erro interno do servidor',
            ], 500);
        }
    }

    /**
     * Gerar novo relatório
     * POST /api/reports/generate
     */
    public function generate(Request $request)
    {
        try {
            // Validação
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'type' => 'required|in:consumption,cost,efficiency,comparative,custom',
                'period_type' => 'required|in:daily,weekly,monthly,yearly,custom',
                'period_start' => 'required|date',
                'period_end' => 'required|date|after_or_equal:period_start',
                'format' => 'required|in:pdf,excel,csv',
                'devices' => 'nullable|array',
                'devices.*' => 'integer|exists:devices,id',
                'environments' => 'nullable|array',
                'environments.*' => 'integer|exists:environments,id',
            ]);

            Log::info('Iniciando geração de relatório', [
                'user_id' => auth()->id(),
                'data' => $validated
            ]);

            // Validar que os devices/environments pertencem ao usuário
            if (!empty($validated['devices'])) {
                $userDevices = Device::where('user_id', auth()->id())
                    ->whereIn('id', $validated['devices'])
                    ->pluck('id')
                    ->toArray();
                
                if (count($userDevices) !== count($validated['devices'])) {
                    return response()->json([
                        'message' => 'Um ou mais dispositivos não pertencem a você',
                    ], 403);
                }
            }

            if (!empty($validated['environments'])) {
                $userEnvironments = Environment::where('user_id', auth()->id())
                    ->whereIn('id', $validated['environments'])
                    ->pluck('id')
                    ->toArray();
                
                if (count($userEnvironments) !== count($validated['environments'])) {
                    return response()->json([
                        'message' => 'Um ou mais ambientes não pertencem a você',
                    ], 403);
                }
            }

            // Criar o registro do relatório
            $report = Report::create([
                'user_id' => auth()->id(),
                'name' => $validated['name'],
                'type' => $validated['type'],
                'period_type' => $validated['period_type'],
                'period_start' => $validated['period_start'],
                'period_end' => $validated['period_end'],
                'format' => $validated['format'],
                'status' => 'pending',
                'filters' => json_encode([
                    'devices' => $validated['devices'] ?? [],
                    'environments' => $validated['environments'] ?? [],
                ]),
            ]);

            Log::info('Relatório criado', ['report_id' => $report->id]);

            // OPÇÃO 1: Processar de forma assíncrona (RECOMENDADO)
            // Despachar para fila
            // GenerateReportJob::dispatch($report);

            // OPÇÃO 2: Processar de forma síncrona (para testes/debug)
            // Executar o Job imediatamente
            try {
                $job = new GenerateReportJob($report);
                $job->handle();

                Log::info('Job executado com sucesso', ['report_id' => $report->id]);
            } catch (\Exception $jobError) {
                Log::error('Erro no Job de geração', [
                    'report_id' => $report->id,
                    'error' => $jobError->getMessage(),
                    'trace' => $jobError->getTraceAsString()
                ]);

                // Atualizar status para erro
                $report->update([
                    'status' => 'failed',
                    'error_message' => $jobError->getMessage()
                ]);

                return response()->json([
                    'message' => 'Erro ao processar relatório',
                    'error' => config('app.debug') ? $jobError->getMessage() : 'Erro ao gerar arquivo',
                    'report' => $report->fresh(),
                ], 500);
            }

            // Recarregar para pegar status atualizado
            $report->refresh();

            Log::info('Relatório finalizado', [
                'report_id' => $report->id,
                'status' => $report->status
            ]);

            return response()->json([
                'message' => 'Relatório gerado com sucesso!',
                'report' => $report,
            ], 201);

        } catch (ValidationException $e) {
            Log::warning('Erro de validação', [
                'errors' => $e->errors(),
                'user_id' => auth()->id()
            ]);
            
            return response()->json([
                'message' => 'Dados inválidos',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            Log::error('Erro ao gerar relatório', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'message' => 'Erro ao gerar relatório',
                'error' => config('app.debug') ? $e->getMessage() : 'Erro interno do servidor',
            ], 500);
        }
    }

    /**
     * Preview do relatório (sem gerar arquivo)
     * POST /api/reports/preview
     */
    public function preview(Request $request)
    {
        try {
            $validated = $request->validate([
                'type' => 'required|in:consumption,cost,efficiency,comparative,custom',
                'devices' => 'nullable|array',
                'devices.*' => 'integer|exists:devices,id',
                'period_start' => 'required|date',
                'period_end' => 'required|date|after_or_equal:period_start',
            ]);

            // Validar que os devices pertencem ao usuário
            if (!empty($validated['devices'])) {
                $userDevices = Device::where('user_id', auth()->id())
                    ->whereIn('id', $validated['devices'])
                    ->pluck('id')
                    ->toArray();
                
                if (count($userDevices) !== count($validated['devices'])) {
                    return response()->json([
                        'message' => 'Um ou mais dispositivos não pertencem a você',
                    ], 403);
                }
            }

            // Dados de exemplo para preview
            $reportData = [
                'title' => 'Preview - ' . $validated['type'],
                'period' => $validated['period_start'] . ' a ' . $validated['period_end'],
                'devices_count' => count($validated['devices'] ?? []),
                'data' => [],
            ];

            return response()->json([
                'success' => true,
                'data' => $reportData,
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Dados inválidos',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            Log::error('Erro ao gerar preview', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'message' => 'Erro ao gerar preview',
                'error' => config('app.debug') ? $e->getMessage() : 'Erro interno do servidor',
            ], 500);
        }
    }

    /**
     * Buscar um relatório específico
     * GET /api/reports/{id}
     */
    public function show($id)
    {
        try {
            $report = Report::where('id', $id)
                ->where('user_id', auth()->id())
                ->firstOrFail();

            return response()->json([
                'report' => $report,
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Relatório não encontrado',
            ], 404);

        } catch (\Exception $e) {
            Log::error('Erro ao buscar relatório', [
                'report_id' => $id,
                'user_id' => auth()->id(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'message' => 'Erro ao buscar relatório',
                'error' => config('app.debug') ? $e->getMessage() : 'Erro interno do servidor',
            ], 500);
        }
    }

    /**
     * Deletar relatório
     * DELETE /api/reports/{id}
     */
    public function destroy($id)
    {
        try {
            $report = Report::where('id', $id)
                ->where('user_id', auth()->id())
                ->firstOrFail();

            // Apagar o arquivo do storage se existir
            if ($report->file_path && Storage::exists($report->file_path)) {
                Storage::delete($report->file_path);
            }

            $report->delete();

            return response()->json([
                'message' => 'Relatório excluído com sucesso!',
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Relatório não encontrado',
            ], 404);

        } catch (\Exception $e) {
            Log::error('Erro ao deletar relatório', [
                'report_id' => $id,
                'user_id' => auth()->id(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'message' => 'Erro ao excluir relatório',
                'error' => config('app.debug') ? $e->getMessage() : 'Erro interno do servidor',
            ], 500);
        }
    }

    /**
     * Download do relatório
     * GET /api/reports/{id}/download
     */
    public function download($id)
    {
        try {
            $report = Report::where('id', $id)
                ->where('user_id', auth()->id())
                ->firstOrFail();

            // Validar se o relatório está pronto
            if ($report->status !== 'completed') {
                return response()->json([
                    'message' => 'Relatório ainda não está pronto',
                    'status' => $report->status,
                ], 400);
            }

            if (!$report->file_path) {
                return response()->json([
                    'message' => 'Arquivo do relatório não encontrado',
                ], 404);
            }

            $filePath = storage_path('app/' . $report->file_path);

            // Validar se o arquivo existe
            if (!file_exists($filePath)) {
                Log::error('Arquivo de relatório não existe no sistema', [
                    'report_id' => $report->id,
                    'file_path' => $report->file_path,
                    'full_path' => $filePath
                ]);

                return response()->json([
                    'message' => 'Arquivo não encontrado no servidor',
                ], 404);
            }

            return response()->download($filePath);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Relatório não encontrado',
            ], 404);

        } catch (\Exception $e) {
            Log::error('Erro ao fazer download', [
                'report_id' => $id,
                'user_id' => auth()->id(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'message' => 'Erro ao fazer download do relatório',
                'error' => config('app.debug') ? $e->getMessage() : 'Erro interno do servidor',
            ], 500);
        }
    }
}