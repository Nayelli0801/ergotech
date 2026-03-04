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
        $evaluaciones = Evaluacion::with('empresa', 'evaluador', 'reba')
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

            // REBA
            'tronco' => 'required_if:metodo,REBA|integer|min:1|max:5',
            'cuello' => 'required_if:metodo,REBA|integer|min:1|max:3',
            'piernas' => 'required_if:metodo,REBA|integer|min:1|max:4',
            'brazo' => 'required_if:metodo,REBA|integer|min:1|max:6',
            'antebrazo' => 'required_if:metodo,REBA|integer|min:1|max:2',
            'muneca' => 'required_if:metodo,REBA|integer|min:1|max:3',

            'carga' => 'nullable|integer|min:0|max:3',
            'actividad' => 'nullable|integer|min:0|max:3',
            'agarre' => 'nullable|integer|min:0|max:3',

            'tronco_ajuste' => 'nullable|boolean',
            'cuello_ajuste' => 'nullable|boolean',
            'muneca_ajuste' => 'nullable|boolean',
        ]);

        $puntajeFinal = null;
        $nivel = null;
        $grupoA = null;
        $grupoB = null;

        if ($request->metodo === 'REBA') {
            $reba = new RebaService();

            // ✅ Si tienes versión PRO úsala, si no tienes, cambia por calcularGrupoA/B normales
            if (method_exists($reba, 'calcularGrupoAPro')) {
                $grupoA = $reba->calcularGrupoAPro(
                    (int)$request->tronco,
                    (int)$request->cuello,
                    (int)$request->piernas,
                    (bool)($request->tronco_ajuste ?? false),
                    (bool)($request->cuello_ajuste ?? false),
                    (int)($request->carga ?? 0)
                );

                $grupoB = $reba->calcularGrupoBPro(
                    (int)$request->brazo,
                    (int)$request->antebrazo,
                    (int)$request->muneca,
                    (bool)($request->muneca_ajuste ?? false),
                    (int)($request->agarre ?? 0)
                );
            } else {
                $grupoA = $reba->calcularGrupoA($request->tronco, $request->cuello, $request->piernas);
                $grupoB = $reba->calcularGrupoB($request->brazo, $request->antebrazo, $request->muneca);
            }

            $grupoC = $reba->calcularGrupoC($grupoA, $grupoB);
            $puntajeFinal = $reba->calcularFinal($grupoC, (int)($request->actividad ?? 0));
            $nivel = $reba->nivelRiesgo($puntajeFinal);
        }

        $evaluacion = Evaluacion::create([
            'empresa_id' => $request->empresa_id,
            'user_id' => $request->user_id,
            'metodo' => $request->metodo,
            'fecha' => $request->fecha,
            'observaciones' => $request->observaciones,
            'puntaje_total' => $puntajeFinal,
            'nivel_riesgo' => $nivel
        ]);

        if ($request->metodo === 'REBA') {
            $evaluacion->reba()->create([
                'cuello' => (int)$request->cuello,
                'tronco' => (int)$request->tronco,
                'piernas' => (int)$request->piernas,
                'carga' => (int)($request->carga ?? 0),
                'brazo' => (int)$request->brazo,
                'antebrazo' => (int)$request->antebrazo,
                'muneca' => (int)$request->muneca,
                'actividad' => (int)($request->actividad ?? 0),
                'puntaje_a' => (int)$grupoA,
                'puntaje_b' => (int)$grupoB,
                'puntaje_final' => (int)$puntajeFinal
            ]);
        }

        return redirect()->route('evaluaciones.index')
            ->with('success', 'Evaluación creada correctamente');
    }

    // =========================
    // VER (para 👁️)
    // =========================
    public function show(Evaluacion $evaluacion)
    {
        $evaluacion->load('empresa', 'evaluador', 'reba');
        return view('evaluaciones.show', compact('evaluacion'));
    }

    // =========================
    // EDITAR (el que te falta)
    // =========================
    public function edit(Evaluacion $evaluacion)
    {
        $evaluacion->load('reba');

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
    public function update(Request $request, Evaluacion $evaluacion)
    {
        $evaluacion->load('reba');

        $validated = $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'user_id' => 'required|exists:users,id',
            'metodo' => 'required|string|max:255',
            'fecha' => 'required|date',
            'observaciones' => 'nullable|string',

            // REBA
            'tronco' => 'required_if:metodo,REBA|integer|min:1|max:5',
            'cuello' => 'required_if:metodo,REBA|integer|min:1|max:3',
            'piernas' => 'required_if:metodo,REBA|integer|min:1|max:4',
            'brazo' => 'required_if:metodo,REBA|integer|min:1|max:6',
            'antebrazo' => 'required_if:metodo,REBA|integer|min:1|max:2',
            'muneca' => 'required_if:metodo,REBA|integer|min:1|max:3',

            'carga' => 'nullable|integer|min:0|max:3',
            'actividad' => 'nullable|integer|min:0|max:3',
            'agarre' => 'nullable|integer|min:0|max:3',

            'tronco_ajuste' => 'nullable|boolean',
            'cuello_ajuste' => 'nullable|boolean',
            'muneca_ajuste' => 'nullable|boolean',
        ]);

        $puntajeFinal = null;
        $nivel = null;
        $grupoA = null;
        $grupoB = null;

        if ($request->metodo === 'REBA') {
            $reba = new RebaService();

            if (method_exists($reba, 'calcularGrupoAPro')) {
                $grupoA = $reba->calcularGrupoAPro(
                    (int)$request->tronco,
                    (int)$request->cuello,
                    (int)$request->piernas,
                    (bool)($request->tronco_ajuste ?? false),
                    (bool)($request->cuello_ajuste ?? false),
                    (int)($request->carga ?? 0)
                );

                $grupoB = $reba->calcularGrupoBPro(
                    (int)$request->brazo,
                    (int)$request->antebrazo,
                    (int)$request->muneca,
                    (bool)($request->muneca_ajuste ?? false),
                    (int)($request->agarre ?? 0)
                );
            } else {
                $grupoA = $reba->calcularGrupoA($request->tronco, $request->cuello, $request->piernas);
                $grupoB = $reba->calcularGrupoB($request->brazo, $request->antebrazo, $request->muneca);
            }

            $grupoC = $reba->calcularGrupoC($grupoA, $grupoB);
            $puntajeFinal = $reba->calcularFinal($grupoC, (int)($request->actividad ?? 0));
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

        if ($request->metodo === 'REBA') {
            // si no existe detalle, lo crea
            if (!$evaluacion->reba) {
                $evaluacion->reba()->create([
                    'cuello' => (int)$request->cuello,
                    'tronco' => (int)$request->tronco,
                    'piernas' => (int)$request->piernas,
                    'carga' => (int)($request->carga ?? 0),
                    'brazo' => (int)$request->brazo,
                    'antebrazo' => (int)$request->antebrazo,
                    'muneca' => (int)$request->muneca,
                    'actividad' => (int)($request->actividad ?? 0),
                    'puntaje_a' => (int)$grupoA,
                    'puntaje_b' => (int)$grupoB,
                    'puntaje_final' => (int)$puntajeFinal
                ]);
            } else {
                $evaluacion->reba->update([
                    'cuello' => (int)$request->cuello,
                    'tronco' => (int)$request->tronco,
                    'piernas' => (int)$request->piernas,
                    'carga' => (int)($request->carga ?? 0),
                    'brazo' => (int)$request->brazo,
                    'antebrazo' => (int)$request->antebrazo,
                    'muneca' => (int)$request->muneca,
                    'actividad' => (int)($request->actividad ?? 0),
                    'puntaje_a' => (int)$grupoA,
                    'puntaje_b' => (int)$grupoB,
                    'puntaje_final' => (int)$puntajeFinal
                ]);
            }
        }

        return redirect()->route('evaluaciones.index')
            ->with('success', 'Evaluación actualizada correctamente');
    }

    // =========================
    // ELIMINAR
    // =========================
    public function destroy(Evaluacion $evaluacion)
    {
        $evaluacion->delete();

        return redirect()->route('evaluaciones.index')
            ->with('success', 'Evaluación eliminada correctamente');
    }
}