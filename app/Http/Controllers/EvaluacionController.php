<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\User;
use App\Models\Evaluacion;
use Illuminate\Http\Request;
use App\Services\RebaService;
use App\Models\Metodo;

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
        $evaluaciones = Evaluacion::with('empresa', 'evaluador', 'reba', 'metodoRelacion')
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

        // ✅ Ahora vienen desde la BD
        $metodos = Metodo::orderBy('nombre')->get();

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

            // ✅ nuevo
            'metodo_id' => 'required|exists:metodos,id',

            'fecha' => 'required|date',
            'observaciones' => 'nullable|string',

            // REBA (validación condicional por método_id) — la validamos abajo en runtime
            'tronco' => 'nullable|integer|min:1|max:5',
            'cuello' => 'nullable|integer|min:1|max:3',
            'piernas' => 'nullable|integer|min:1|max:4',
            'brazo' => 'nullable|integer|min:1|max:6',
            'antebrazo' => 'nullable|integer|min:1|max:2',
            'muneca' => 'nullable|integer|min:1|max:3',

            'carga' => 'nullable|integer|min:0|max:3',
            'actividad' => 'nullable|integer|min:0|max:3',
            'agarre' => 'nullable|integer|min:0|max:3',

            'tronco_ajuste' => 'nullable|boolean',
            'cuello_ajuste' => 'nullable|boolean',
            'muneca_ajuste' => 'nullable|boolean',
        ]);

        // ✅ Obtenemos el método seleccionado
        $metodo = Metodo::findOrFail($request->metodo_id);
        $metodoNombre = strtoupper($metodo->nombre);

        // ✅ Validación estricta SOLO si es REBA
        if ($metodoNombre === 'REBA') {
            $request->validate([
                'tronco' => 'required|integer|min:1|max:5',
                'cuello' => 'required|integer|min:1|max:3',
                'piernas' => 'required|integer|min:1|max:4',
                'brazo' => 'required|integer|min:1|max:6',
                'antebrazo' => 'required|integer|min:1|max:2',
                'muneca' => 'required|integer|min:1|max:3',
            ]);
        }

        $puntajeFinal = null;
        $nivel = null;
        $grupoA = null;
        $grupoB = null;

        if ($metodoNombre === 'REBA') {
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

        $evaluacion = Evaluacion::create([
            'empresa_id' => $request->empresa_id,
            'user_id' => $request->user_id,

            // ✅ nuevo
            'metodo_id' => $request->metodo_id,

            // ✅ compatibilidad (para que tus vistas actuales no se rompan)
            'metodo' => $metodoNombre,

            'fecha' => $request->fecha,
            'observaciones' => $request->observaciones,
            'puntaje_total' => $puntajeFinal,
            'nivel_riesgo' => $nivel
        ]);

        if ($metodoNombre === 'REBA') {
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
        $evaluacion->load('empresa', 'evaluador', 'reba', 'metodoRelacion');
        return view('evaluaciones.show', compact('evaluacion'));
    }

    // =========================
    // EDITAR
    // =========================
    public function edit(Evaluacion $evaluacion)
    {
        $evaluacion->load('reba', 'metodoRelacion');

        $empresas = Empresa::all();

        $evaluadores = User::whereHas('rol', function ($q) {
            $q->where('nombre', 'evaluador');
        })->get();

        // ✅ Ahora vienen desde la BD
        $metodos = Metodo::orderBy('nombre')->get();

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

            // ✅ nuevo
            'metodo_id' => 'required|exists:metodos,id',

            'fecha' => 'required|date',
            'observaciones' => 'nullable|string',

            // REBA (primero nullable; validamos “required” más abajo si aplica)
            'tronco' => 'nullable|integer|min:1|max:5',
            'cuello' => 'nullable|integer|min:1|max:3',
            'piernas' => 'nullable|integer|min:1|max:4',
            'brazo' => 'nullable|integer|min:1|max:6',
            'antebrazo' => 'nullable|integer|min:1|max:2',
            'muneca' => 'nullable|integer|min:1|max:3',

            'carga' => 'nullable|integer|min:0|max:3',
            'actividad' => 'nullable|integer|min:0|max:3',
            'agarre' => 'nullable|integer|min:0|max:3',

            'tronco_ajuste' => 'nullable|boolean',
            'cuello_ajuste' => 'nullable|boolean',
            'muneca_ajuste' => 'nullable|boolean',
        ]);

        // ✅ Método seleccionado
        $metodo = Metodo::findOrFail($request->metodo_id);
        $metodoNombre = strtoupper($metodo->nombre);

        // ✅ Validación estricta SOLO si es REBA
        if ($metodoNombre === 'REBA') {
            $request->validate([
                'tronco' => 'required|integer|min:1|max:5',
                'cuello' => 'required|integer|min:1|max:3',
                'piernas' => 'required|integer|min:1|max:4',
                'brazo' => 'required|integer|min:1|max:6',
                'antebrazo' => 'required|integer|min:1|max:2',
                'muneca' => 'required|integer|min:1|max:3',
            ]);
        }

        $puntajeFinal = null;
        $nivel = null;
        $grupoA = null;
        $grupoB = null;

        if ($metodoNombre === 'REBA') {
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

            // ✅ nuevo
            'metodo_id' => $request->metodo_id,

            // ✅ compatibilidad
            'metodo' => $metodoNombre,

            'fecha' => $request->fecha,
            'observaciones' => $request->observaciones,
            'puntaje_total' => $puntajeFinal,
            'nivel_riesgo' => $nivel
        ]);

        if ($metodoNombre === 'REBA') {
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