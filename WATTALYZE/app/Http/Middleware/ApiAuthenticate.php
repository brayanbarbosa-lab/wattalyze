<?php
// app/Http/Middleware/ApiAuthenticate.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ApiAuthenticate
{
    /**
     * Handle an incoming request specifically for API routes
     */
    public function handle(Request $request, Closure $next)
    {
        // Log da tentativa de autenticação
        $token = $request->bearerToken();
        Log::info('API Auth Attempt:', [
            'has_token' => !empty($token),
            'route' => $request->route()?->getName(),
            'method' => $request->method()
        ]);

        // Verificar autenticação com Sanctum
        if (!Auth::guard('sanctum')->check()) {
            Log::warning('API Auth Failed:', [
                'token_present' => !empty($token),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Token de autenticação inválido ou expirado',
                'error' => 'Unauthenticated',
                'debug' => app()->environment('local') ? [
                    'has_bearer_token' => !empty($token),
                    'guard' => 'sanctum',
                    'route' => $request->route()?->getName()
                ] : null
            ], 401);
        }

        // Definir o guard padrão para esta requisição
        Auth::shouldUse('sanctum');

        Log::info('API Auth Success:', [
            'user_id' => Auth::id(),
            'route' => $request->route()?->getName()
        ]);

        return $next($request);
    }
}