<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\TwoFactorCode;

class AuthenticatedSessionController extends Controller
{
    /**
     * Mostrar formulario de login
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Procesar login + generar código 2FA demo
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = auth()->user();

        // Generar código 2FA
        $code = rand(100000, 999999);

        // Guardar código en BD
        TwoFactorCode::updateOrCreate(
            ['user_id' => $user->id],
            [
                'code' => $code,
                'expires_at' => now()->addMinutes(10),
            ]
        );

        // Guardar usuario en sesión temporal
        session(['2fa_user_id' => $user->id]);

        // Cerrar sesión temporal hasta validar código
        Auth::logout();

        // Redirigir a la pantalla 2FA mostrando el código demo
        return redirect()->route('2fa.index')
            ->with('codigo_demo', $code);
    }

    /**
     * Cerrar sesión
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}