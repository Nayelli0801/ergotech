<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Empresa;
use App\Models\Evaluacion;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user || !$user->rol) {
            return redirect()->route('login')
                ->with('error', 'Tu usuario no tiene un rol asignado.');
        }

        // ADMIN
        if ($user->rol->nombre === 'admin') {
            $totalUsuarios = User::count();
            $totalEmpresas = Empresa::count();
            $totalEvaluaciones = Evaluacion::count();

            $ultimasEvaluaciones = Evaluacion::with('empresa')
                ->latest()
                ->take(5)
                ->get();

            return view('dashboard.admin', compact(
                'totalUsuarios',
                'totalEmpresas',
                'totalEvaluaciones',
                'ultimasEvaluaciones'
            ));
        }

        // EVALUADOR
        if ($user->rol->nombre === 'evaluador') {
            return view('dashboard.evaluador');
        }

        // VISITANTE
        if ($user->rol->nombre === 'visitante') {
            return view('dashboard.visitante');
        }

        return redirect()->route('login')
            ->with('error', 'El rol asignado no es válido.');
    }
}