<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RolMiddleware
{
    public function handle(Request $request, Closure $next, $rol)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        if (!Auth::user()->rol || Auth::user()->rol->nombre !== $rol) {

            abort(403, 'No tienes permiso para acceder');
        }

        return $next($request);
    }
}
