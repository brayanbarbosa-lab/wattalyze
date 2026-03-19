<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api;
use App\Http\Controllers\Api\ApiAlertController;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ApiDeviceController;
use App\Http\Controllers\Api\ApiEnergyTariffController;
use App\Http\Controllers\Api\ApiEnvironmentController;
use App\Http\Controllers\Api\ApiHomeController;
use App\Http\Controllers\Api\ApiReportController;
use App\Http\Controllers\Api\ApiSettingsController;
use App\Http\Controllers\Api\ApiSupportController;

/*
|--------------------------------------------------------------------------
| API Routes 
|--------------------------------------------------------------------------
*/

Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/login', [ApiAuthController::class, 'login']);
Route::post('/password/email', [ApiAuthController::class, 'sendResetLinkEmail']);
Route::post('/password/reset', [ApiAuthController::class, 'resetPassword']);

// Rota para verificação de email (pode ser acessada sem autenticação)
// Rotas protegidas por autenticação
Route::middleware(['auth:sanctum'])->group(function () {
    // Usuário autenticado
    Route::get('/user', [ApiAuthController::class, 'user']);
    Route::put('/user', [ApiAuthController::class, 'update']);
    
    // Logout
    Route::post('/logout', [ApiAuthController::class, 'logout']);
    
    // Refresh token
    Route::post('/refresh', [ApiAuthController::class, 'refresh']);
    
    // Verificação de email
    Route::post('/email/verification-notification', [ApiAuthController::class, 'resendVerificationEmail'])
        ->name('verification.send');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', [ApiHomeController::class, 'dashboard']);
    Route::get('/health', [ApiHomeController::class, 'health']);

});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/devices', [ApiDeviceController::class, 'index']);
    Route::get('/devices/create', [ApiDeviceController::class, 'create']);
    Route::post('/devices', [ApiDeviceController::class, 'store']);
    Route::get('/devices/{device}', [ApiDeviceController::class, 'show']);
    Route::get('/devices/{device}/edit', [ApiDeviceController::class, 'edit']);
    Route::put('/devices/{device}', [ApiDeviceController::class, 'update']);
    Route::delete('/devices/{device}', [ApiDeviceController::class, 'destroy']);
    Route::get('/devices/{device}/diagnostics', [ApiDeviceController::class, 'diagnostics']);
    Route::get('/devices/{device}/debug', [ApiDeviceController::class, 'debug']);
});

Route::middleware('auth:sanctum')->group(function () {
    // Listar relatórios
    Route::get('/report', [ApiReportController::class, 'index']);

    // Dados para formulário de geração
    Route::get('/report/generate-form', [ApiReportController::class, 'generateForm']);

    // Gerar novo relatório
    Route::post('/report/generate', [ApiReportController::class, 'generate']);

    // Preview do relatório
    Route::post('/report/preview', [ApiReportController::class, 'preview']);

    // Buscar relatório específico
    Route::get('/report/{id}', [ApiReportController::class, 'show']);

    // Download do relatório
    Route::get('/report/{id}/download', [ApiReportController::class, 'download']);

    // Deletar relatório
    Route::delete('/report/{id}', [ApiReportController::class, 'destroy']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/energy-tariffs', [ApiEnergyTariffController::class, 'index']);
    Route::post('/energy-tariffs', [ApiEnergyTariffController::class, 'store']);
    Route::get('/energy-tariffs/{tariff}', [ApiEnergyTariffController::class, 'show']);
    Route::put('/energy-tariffs/{tariff}', [ApiEnergyTariffController::class, 'update']);
    Route::delete('/energy-tariffs/{tariff}', [ApiEnergyTariffController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/environments', [ApiEnvironmentController::class, 'index']);
    Route::post('/environments', [ApiEnvironmentController::class, 'store']);
    Route::get('/environments/{environment}', [ApiEnvironmentController::class, 'show']);
    Route::put('/environments/{environment}', [ApiEnvironmentController::class, 'update']);
    Route::delete('/environments/{environment}', [ApiEnvironmentController::class, 'destroy']);
    Route::get('/environments/{environment}/consumption', [ApiEnvironmentController::class, 'consumption']);
});



Route::middleware('auth:sanctum')->group(function () {
    Route::get('/settings/profile', [ApiSettingsController::class, 'profile']);
    Route::put('/settings/profile', [ApiSettingsController::class, 'updateProfile']);
    Route::put('/settings/password', [ApiSettingsController::class, 'updatePassword']);
    Route::get('/settings/notifications', [ApiSettingsController::class, 'notifications']);
    Route::get('/settings/notification-preferences', [ApiSettingsController::class, 'notificationPreferences']);
    Route::put('/settings/notification-preferences', [ApiSettingsController::class, 'updateNotificationPreferences']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/support', [ApiSupportController::class, 'submit']);
    Route::get('/support/contact-info', [ApiSupportController::class, 'contactInfo']);
});


Route::get('/test', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'API funcionando',
        'timestamp' => now()->toIsoString()
    ]);
});



Route::middleware('auth:sanctum')->group(function () {
    
    // Regras de alerta
    Route::get('/alert-rules', [ApiAlertController::class, 'rules']);
    Route::post('/alert-rules', [ApiAlertController::class, 'storeRule']);
    Route::get('/alert-rules/{rule}', [ApiAlertController::class, 'editRule']);
    Route::put('/alert-rules/{rule}', [ApiAlertController::class, 'updateRule']);
    Route::delete('/alert-rules/{rule}', [ApiAlertController::class, 'destroyRule']);
    Route::patch('/alert-rules/{rule}/toggle', [ApiAlertController::class, 'toggleRule']);

    // Alertas
    Route::get('/alerts/active', [ApiAlertController::class, 'active']);
    Route::get('/alerts/history', [ApiAlertController::class, 'history']);
    Route::patch('/alerts/{alert}/resolve', [ApiAlertController::class, 'markResolved']);
    Route::patch('/alerts/{alert}/acknowledge', [ApiAlertController::class, 'acknowledge']);
    Route::post('/alerts/bulk-resolve', [ApiAlertController::class, 'bulkResolve']);
});
