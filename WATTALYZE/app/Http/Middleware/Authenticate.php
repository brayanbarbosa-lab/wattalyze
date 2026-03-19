<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        // Se não especificou guards, usar web para requests normais e sanctum para API
        if (empty($guards)) {
            $guards = $request->is('api/*') ? ['sanctum'] : ['web'];
        }

        // Para rotas de API, garantir que use sanctum
        if ($request->is('api/*') && !in_array('sanctum', $guards)) {
            $guards[] = 'sanctum';
        }

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                Auth::shouldUse($guard); // Define o guard padrão
                return $next($request);
            }
        }

        // Se chegou aqui, não está autenticado
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => false,
                'message' => 'Token de autenticação inválido ou expirado',
                'error' => 'Unauthenticated',
                'debug' => app()->environment('local') ? [
                    'guards_checked' => $guards,
                    'route' => $request->route()?->getName(),
                    'is_api' => $request->is('api/*')
                ] : null
            ], 401);
        }

        return redirect()->guest(route('login'));
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson() && !$request->is('api/*')) {
            return route('login');
        }

        return null; // Para API, retorna null (será tratado no handle)
    }
}