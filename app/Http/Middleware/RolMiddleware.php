<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RolMiddleware
{
public function handle(Request $request, Closure $next, $roles)
{
    if (!Auth::check()) {
        return redirect('/login');
    }

    // Depuración: guardamos en log y mostramos en pantalla
    $rolesArray = explode(',', $roles);
    $rolesArray = array_map('trim', $rolesArray);
    $userRole = Auth::user()->rol?->nombre;

    // Mostramos en pantalla (solo para depurar)
    dump([
        'roles_recibido' => $roles,
        'roles_array' => $rolesArray,
        'usuario_rol' => $userRole,
        'permiso' => in_array($userRole, $rolesArray)
    ]);

    // También escribimos en el log
    \Log::info('RolMiddleware', [
        'roles' => $roles,
        'user_role' => $userRole,
        'allowed' => $rolesArray,
        'result' => in_array($userRole, $rolesArray)
    ]);

    if (!$userRole || !in_array($userRole, $rolesArray)) {
        abort(403, 'No tienes permiso para acceder a esta sección.');
    }

    return $next($request);
}
}
