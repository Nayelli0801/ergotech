<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\TwoFactorCode;
use Illuminate\Support\Facades\Mail;

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
     * Procesar login + enviar código 2FA
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = auth()->user();

        // 🔹 Generar código 2FA
        $code = rand(100000, 999999);

        // 🔹 Guardar código en BD
        TwoFactorCode::updateOrCreate(
            ['user_id' => $user->id],
            [
                'code' => $code,
                'expires_at' => now()->addMinutes(10)
            ]
        );

        // 🔹 Enviar código por correo
        Mail::raw("Tu código de acceso es: $code", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Código de verificación - Ergotech');
        });

        // 🔹 Guardar usuario en sesión temporal
        session(['2fa_user_id' => $user->id]);

        // 🔹 cerrar sesión temporal hasta validar código
        Auth::logout();

        return redirect()->route('2fa.index');
    }

    /**
     * Cerrar sesión (LOGOUT)
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
