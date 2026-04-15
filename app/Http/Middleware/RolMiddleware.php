<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RolMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Obtener rol del usuario
        $userRole = trim(strtolower(Auth::user()->rol?->nombre ?? ''));

        // Normalizar roles recibidos
        $roles = collect($roles)
            ->flatMap(fn($r) => explode(',', $r))
            ->map(fn($r) => strtolower(trim($r)))
            ->toArray();

        // Validación
        if (!$userRole || !in_array($userRole, $roles)) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        return $next($request);
    }
}