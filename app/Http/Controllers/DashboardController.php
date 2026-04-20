<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Empresa;
use App\Models\Evaluacion;
use App\Models\RebaEvaluacion;
use App\Models\RulaEvaluacion;
use App\Models\OwasEvaluacion;
use App\Models\Nom036Evaluacion;
use App\Models\NioshEvaluacion;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // =========================
        // MÉTRICAS GENERALES
        // =========================
        $totalUsuarios = User::count();
        $totalEmpresas = Empresa::count();
        $totalEvaluaciones = Evaluacion::count();

        $totalReba = RebaEvaluacion::count();
        $totalRula = RulaEvaluacion::count();
        $totalOwas = OwasEvaluacion::count();
        $totalNom036 = Nom036Evaluacion::count();
        $totalNiosh = NioshEvaluacion::count();

        // =========================
        // MÉTODOS
        // =========================
        $metodos = [
            'REBA' => $totalReba,
            'RULA' => $totalRula,
            'OWAS' => $totalOwas,
            'NOM-036' => $totalNom036,
            'NIOSH' => $totalNiosh,
        ];

        // =========================
        // RIESGOS
        // =========================
        $riesgos = [
            'Bajo' => 0,
            'Medio' => 0,
            'Alto' => 0,
            'Muy alto' => 0,
            'Inapreciable' => 0,
        ];

        $evaluaciones = Evaluacion::select('nivel_riesgo')->get();

        foreach ($evaluaciones as $evaluacion) {
            $nivel = trim((string) $evaluacion->nivel_riesgo);

            if (array_key_exists($nivel, $riesgos)) {
                $riesgos[$nivel]++;
            }
        }

        $totalRiesgos = array_sum($riesgos);

        $riesgoPorcentaje = [
            'Bajo' => $totalRiesgos ? round(($riesgos['Bajo'] / $totalRiesgos) * 100, 1) : 0,
            'Medio' => $totalRiesgos ? round(($riesgos['Medio'] / $totalRiesgos) * 100, 1) : 0,
            'Alto' => $totalRiesgos ? round(($riesgos['Alto'] / $totalRiesgos) * 100, 1) : 0,
            'Muy alto' => $totalRiesgos ? round(($riesgos['Muy alto'] / $totalRiesgos) * 100, 1) : 0,
            'Inapreciable' => $totalRiesgos ? round(($riesgos['Inapreciable'] / $totalRiesgos) * 100, 1) : 0,
        ];

        // =========================
        // ÚLTIMAS EVALUACIONES
        // =========================
        $ultimasEvaluaciones = Evaluacion::with(['empresa', 'metodo'])
            ->latest()
            ->take(5)
            ->get();

        // =========================
        // DATA
        // =========================
        $data = compact(
            'totalUsuarios',
            'totalEmpresas',
            'totalEvaluaciones',
            'totalReba',
            'totalRula',
            'totalOwas',
            'totalNom036',
            'totalNiosh',
            'metodos',
            'riesgos',
            'riesgoPorcentaje',
            'ultimasEvaluaciones'
        );

        // =========================
        // ROLES
        // =========================
        if ($user && $user->isAdmin()) {
            return view('dashboard.admin', $data);
        }

        if ($user && $user->isEvaluador()) {
            return view('dashboard.evaluador', $data);
        }

        // 🔥 FIX: ahora sí pasas los datos al visitante
        return view('dashboard.visitante', $data);
    }
}