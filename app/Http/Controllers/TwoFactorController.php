<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TwoFactorCode;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TwoFactorController extends Controller
{
    public function index()
    {
        return view('auth.two-factor');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ]);

        $userId = session('2fa_user_id');

        if (!$userId) {
            return redirect()->route('login');
        }

        $twoFactor = TwoFactorCode::where('user_id', $userId)
            ->where('code', $request->code)
            ->where('expires_at', '>=', now())
            ->first();

        if (!$twoFactor) {
            return back()->withErrors(['code' => 'Código inválido o expirado']);
        }

        $user = User::find($userId);

        Auth::login($user);

        $twoFactor->delete();
        session()->forget('2fa_user_id');

        return redirect()->route('dashboard');
    }
}