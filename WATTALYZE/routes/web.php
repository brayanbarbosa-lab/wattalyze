<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\SupportController;
use App\Http\Controllers\Web\DeviceController;
use App\Http\Controllers\Web\EnvironmentController;
use App\Http\Controllers\Web\AlertController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\ReportController;
use App\Http\Controllers\Web\SettingsController;
use App\Http\Controllers\Web\EnergyTariffController;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/produtos', function () {
    return view('infos.produtos');
})->name('produtos');
Route::get('/suporte', function () {
    return view('infos.suporte');
})->name('suporte');

Route::get('/contato', function () {
    return view('infos.contato');
})->name('contato');

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/sair-agora', function () {
    Auth::guard('web')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/')->with('status', 'Logout via GET funcionou!');
})->middleware('auth')->name('sair.agora');



// routes/web.php
Route::get('/devices/{device}/influx-data', [DeviceController::class, 'influxData'])
    ->name('devices.influxData');

Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Registro
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Esqueceu a senha
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');

    // Reset de senha
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    // Aviso de verificação
    Route::get('/email/verify', [AuthController::class, 'showVerificationNotice'])->name('verification.notice');

    // Reenviar email de verificação
    Route::post('/email/verification-notification', [AuthController::class, 'resendVerificationEmail'])->name('verification.send');
});

Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

// Authenticated Routes
Route::middleware('auth', 'verified')->group(
    function () {

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        // Dashboard
        Route::get('/home', [HomeController::class, 'dashboard'])->name('dashboard.home');


        // Profile Management
        Route::patch('/profile', [AuthController::class, 'update'])->name('profile.update');

        // Environments Routes
        Route::prefix('environments')->name('environments.')->group(function () {
            Route::get('/', [EnvironmentController::class, 'index'])->name('index');
            Route::get('/create', [EnvironmentController::class, 'create'])->name('create');
            Route::post('/', [EnvironmentController::class, 'store'])->name('store');
            Route::get('/{environment}', [EnvironmentController::class, 'show'])->name('show');
            Route::get('/{environment}/edit', [EnvironmentController::class, 'edit'])->name('edit');
            Route::patch('/{environment}', [EnvironmentController::class, 'update'])->name('update');
            Route::delete('/{environment}', [EnvironmentController::class, 'destroy'])->name('destroy');
            Route::get('/hierarchy/view', [EnvironmentController::class, 'hierarchy'])->name('hierarchy');
        });

        // Devices Routes
        Route::prefix('devices')->name('devices.')->group(function () {
            Route::get('/', [DeviceController::class, 'index'])->name('index');
            Route::get('/create', [DeviceController::class, 'create'])->name('create');
            Route::post('/', [DeviceController::class, 'store'])->name('store');
            Route::get('/{device}', [DeviceController::class, 'show'])->name('show');
            Route::get('/{device}/edit', [DeviceController::class, 'edit'])->name('edit');
            Route::patch('/{device}', [DeviceController::class, 'update'])->name('update');
            Route::delete('/{device}', [DeviceController::class, 'destroy'])->name('destroy');
            Route::get('/{device}/diagnostics', [DeviceController::class, 'diagnostics'])->name('diagnostics');
            Route::post('/{device}/restart', [DeviceController::class, 'restart'])->name('restart');
        });

        // Alerts Routes
        Route::prefix('alerts')->name('alerts.')->group(function () {
            // Alert Rules
            Route::get('/rules', [AlertController::class, 'rules'])->name('rules');
            Route::post('/rules', [AlertController::class, 'storeRule'])->name('rules.store');
            Route::get('/rules/{rule}/edit', [AlertController::class, 'editRule'])->name('rules.edit');
            Route::patch('/rules/{rule}', [AlertController::class, 'updateRule'])->name('rules.update');
            Route::delete('/rules/{rule}', [AlertController::class, 'destroyRule'])->name('rules.destroy');
            Route::post('/rules/{rule}/toggle', [AlertController::class, 'toggleRule'])->name('rules.toggle');

            // Active Alerts
            Route::get('/active', [AlertController::class, 'active'])->name('active');
            Route::post('/{alert}/resolve', [AlertController::class, 'markResolved'])->name('resolve');
            Route::post('/{alert}/acknowledge', [AlertController::class, 'acknowledge'])->name('acknowledge');
            Route::post('/bulk-resolve', [AlertController::class, 'bulkResolve'])->name('bulk-resolve');

            // Alert History
            Route::get('/history', [AlertController::class, 'history'])->name('history');

            // Notification Settings
            Route::get('/notifications', [AlertController::class, 'notificationSettings'])->name('notifications');
            Route::post('/notifications', [AlertController::class, 'saveNotificationSettings'])->name('notifications.save');
        });
        Route::prefix('tariffs')->name('tariffs.')->group(function () {
            Route::get('/', [EnergyTariffController::class, 'index'])->name('index');
            Route::get('/create', [EnergyTariffController::class, 'create'])->name('create');
            Route::post('/', [EnergyTariffController::class, 'store'])->name('store');
            Route::get('/{tariff}/edit', [EnergyTariffController::class, 'edit'])->name('edit');
            Route::put('/{tariff}', [EnergyTariffController::class, 'update'])->name('update');
            Route::delete('/{tariff}', [EnergyTariffController::class, 'destroy'])->name('destroy');
        });
        // Reports Routes
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

        // Formulário de criação
        Route::get('/reports/generate', [ReportController::class, 'generateForm'])->name('reports.generate');

        // Gerar relatório (POST)
        Route::post('/reports/generate', [ReportController::class, 'generate'])->name('reports.store');

        // Download do relatório
        Route::get('/reports/{report}/download', [ReportController::class, 'download'])->name('reports.download');
        Route::delete('/reports/{report}', [ReportController::class, 'destroy'])->name('reports.destroy');


        // Settings Routes
        Route::prefix('settings')->name('settings.')->group(function () {
            // Profile Settings
            Route::get('/profile', [SettingsController::class, 'profile'])->name('profile');
            Route::patch('/profile', [SettingsController::class, 'updateProfile'])->name('profile.update');

            // Security Settings (Senhas)
            Route::get('/security', [SettingsController::class, 'security'])->name('security');
            Route::post('/security/password', [SettingsController::class, 'updatePassword'])->name('security.password.update');

            // Resto das suas rotas...
            Route::get('/notifications', [SettingsController::class, 'notifications'])->name('notifications');
            Route::get('/api', [SettingsController::class, 'api'])->name('api');
            Route::get('/preferences', [SettingsController::class, 'preferences'])->name('preferences');
            Route::get('/data', [SettingsController::class, 'dataManagement'])->name('data');
        });

        Route::middleware('auth')->group(function () {});

        // Support Routes
        Route::prefix('support')->name('support.')->group(function () {
            Route::get('/', [SupportController::class, 'index'])->name('index');
            Route::post('/ticket', [SupportController::class, 'submit'])->name('ticket.submit');
            Route::get('/faq', [SupportController::class, 'faq'])->name('faq');
            Route::get('/documentation', [SupportController::class, 'documentation'])->name('documentation');
            Route::get('/contact', [SupportController::class, 'contact'])->name('contact');
            Route::post('/contact', [SupportController::class, 'sendMessage'])->name('contact.send');
        });
    }

);
