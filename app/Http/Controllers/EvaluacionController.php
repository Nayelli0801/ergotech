<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\User;
use App\Models\Evaluacion;
use Illuminate\Http\Request;
use App\Services\RebaService;

class EvaluacionController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            if (!auth()->user()->isAdmin() && !auth()->user()->isEvaluador()) {
                abort(403, 'No tienes permiso para acceder aquí.');
            }

            return $next($request);
        });
    }

    // =========================
    // LISTADO
    // =========================
    public function index()
    {
        $evaluaciones = Evaluacion::with('empresa', 'evaluador')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('evaluaciones.index', compact('evaluaciones'));
    }

    // =========================
    // FORMULARIO CREAR
    // =========================
    public function create()
    {
        $empresas = Empresa::all();

        $evaluadores = User::whereHas('rol', function ($q) {
            $q->where('nombre', 'evaluador');
        })->get();

        $metodos = ['REBA', 'RULA', 'NIOSH'];

        return view('evaluaciones.create', compact('empresas', 'evaluadores', 'metodos'));
    }

    // =========================
    // GUARDAR
    // =========================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'user_id' => 'required|exists:users,id',
            'metodo' => 'required|string|max:255',
            'fecha' => 'required|date',
            'observaciones' => 'nullable|string',

            // Campos REBA
            'tronco' => 'nullable|integer|min:1|max:5',
            'cuello' => 'nullable|integer|min:1|max:3',
            'piernas' => 'nullable|integer|min:1|max:4',
            'brazo' => 'nullable|integer|min:1|max:6',
            'antebrazo' => 'nullable|integer|min:1|max:2',
            'muneca' => 'nullable|integer|min:1|max:3',
            'actividad' => 'nullable|integer|min:0|max:3',
        ]);

        $puntajeFinal = null;
        $nivel = null;

        if ($request->metodo === 'REBA') {

            $reba = new RebaService();

            $grupoA = $reba->calcularGrupoA(
                $request->tronco,
                $request->cuello,
                $request->piernas
            );

            $grupoB = $reba->calcularGrupoB(
                $request->brazo,
                $request->antebrazo,
                $request->muneca
            );

            $grupoC = $reba->calcularGrupoC($grupoA, $grupoB);

            $puntajeFinal = $reba->calcularFinal(
                $grupoC,
                $request->actividad ?? 0
            );

            $nivel = $reba->nivelRiesgo($puntajeFinal);
        }

        Evaluacion::create([
            'empresa_id' => $request->empresa_id,
            'user_id' => $request->user_id,
            'metodo' => $request->metodo,
            'fecha' => $request->fecha,
            'observaciones' => $request->observaciones,
            'puntaje_total' => $puntajeFinal,
            'nivel_riesgo' => $nivel
        ]);

        return redirect()->route('evaluaciones.index')
            ->with('success', 'Evaluación creada correctamente');
    }

    // =========================
    // EDITAR
    // =========================
    public function edit($id)
    {
        $evaluacion = Evaluacion::findOrFail($id);

        $empresas = Empresa::all();

        $evaluadores = User::whereHas('rol', function ($q) {
            $q->where('nombre', 'evaluador');
        })->get();

        $metodos = ['REBA', 'RULA', 'NIOSH'];

        return view('evaluaciones.edit', compact('evaluacion', 'empresas', 'evaluadores', 'metodos'));
    }

    // =========================
    // ACTUALIZAR
    // =========================
    public function update(Request $request, $id)
    {
        $evaluacion = Evaluacion::findOrFail($id);

        $validated = $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'user_id' => 'required|exists:users,id',
            'metodo' => 'required|string|max:255',
            'fecha' => 'required|date',
            'observaciones' => 'nullable|string',

            // Campos REBA
            'tronco' => 'nullable|integer|min:1|max:5',
            'cuello' => 'nullable|integer|min:1|max:3',
            'piernas' => 'nullable|integer|min:1|max:4',
            'brazo' => 'nullable|integer|min:1|max:6',
            'antebrazo' => 'nullable|integer|min:1|max:2',
            'muneca' => 'nullable|integer|min:1|max:3',
            'actividad' => 'nullable|integer|min:0|max:3',
        ]);

        $puntajeFinal = null;
        $nivel = null;

        if ($request->metodo === 'REBA') {

            $reba = new RebaService();

            $grupoA = $reba->calcularGrupoA(
                $request->tronco,
                $request->cuello,
                $request->piernas
            );

            $grupoB = $reba->calcularGrupoB(
                $request->brazo,
                $request->antebrazo,
                $request->muneca
            );

            $grupoC = $reba->calcularGrupoC($grupoA, $grupoB);

            $puntajeFinal = $reba->calcularFinal(
                $grupoC,
                $request->actividad ?? 0
            );

            $nivel = $reba->nivelRiesgo($puntajeFinal);
        }

        $evaluacion->update([
            'empresa_id' => $request->empresa_id,
            'user_id' => $request->user_id,
            'metodo' => $request->metodo,
            'fecha' => $request->fecha,
            'observaciones' => $request->observaciones,
            'puntaje_total' => $puntajeFinal,
            'nivel_riesgo' => $nivel
        ]);

        return redirect()->route('evaluaciones.index')
            ->with('success', 'Evaluación actualizada correctamente');
    }

    // =========================
    // ELIMINAR
    // =========================
    public function destroy($id)
    {
        $evaluacion = Evaluacion::findOrFail($id);
        $evaluacion->delete();

        return redirect()->route('evaluaciones.index')
            ->with('success', 'Evaluación eliminada correctamente');
    }

    // =========================
    // HISTORIAL PERSONAL
    // =========================
    public function historial()
    {
        $evaluaciones = Evaluacion::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('evaluaciones.historial', compact('evaluaciones'));
    }
}