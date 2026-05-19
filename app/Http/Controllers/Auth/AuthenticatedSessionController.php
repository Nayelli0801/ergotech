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
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = auth()->user();

        $code = rand(100000, 999999);

        TwoFactorCode::updateOrCreate(
            ['user_id' => $user->id],
            [
                'code' => $code,
                'expires_at' => now()->addMinutes(10),
            ]
        );

        session(['2fa_user_id' => $user->id]);

        return redirect()->route('2fa.index');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}