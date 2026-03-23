<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RolMiddleware
{
    public function handle(Request $request, Closure $next, $roles): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $rolesArray = explode(',', $roles);
        $rolesArray = array_map('trim', $rolesArray);
        $rolesArray = array_map('strtolower', $rolesArray);

        $userRole = strtolower(Auth::user()->rol?->nombre ?? '');

        if (!$userRole || !in_array($userRole, $rolesArray)) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        return $next($request);
    }
}