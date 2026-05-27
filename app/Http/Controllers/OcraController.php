<?php

namespace App\Http\Controllers;

use App\Models\Evaluacion;
use App\Models\OcraEvaluacion;
use App\Models\OcraDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class OcraController extends Controller
{
    public function create($evaluacionId)
    {
        $evaluacion = Evaluacion::with([
            'empresa',
            'sucursal',
            'puesto',
            'trabajador',
            'metodo',
            'usuario',
        ])->findOrFail($evaluacionId);

        return view('ocra.create', compact('evaluacion'));
    }

    public function store(Request $request, $evaluacionId)
    {
        $evaluacion = Evaluacion::findOrFail($evaluacionId);

        $request->validate([
            'lado_evaluado' => 'required|string|max:50',
            'duracion_tarea' => 'required|numeric|min:0',
            'acciones_tecnicas' => 'required|integer|min:0',
            'frecuencia_acciones' => 'required|integer|min:0',
            'fuerza' => 'required|integer|min:0|max:10',
            'postura_hombro' => 'required|integer|min:0|max:10',
            'postura_codo' => 'required|integer|min:0|max:10',
            'postura_muneca' => 'required|integer|min:0|max:10',
            'postura_mano' => 'required|integer|min:0|max:10',
            'repetitividad' => 'required|integer|min:0|max:10',
            'factores_adicionales' => 'required|integer|min:0|max:10',
            'recuperacion' => 'required|integer|min:0|max:10',
            'observaciones' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $indice = $this->calcularIndice($request);
            [$nivel, $recomendaciones] = $this->clasificarRiesgo($indice);

            $ocra = OcraEvaluacion::create([
                'evaluacion_id' => $evaluacion->id,
                'lado_evaluado' => $request->lado_evaluado,
                'duracion_tarea' => $request->duracion_tarea,
                'acciones_tecnicas' => $request->acciones_tecnicas,
                'frecuencia_acciones' => $request->frecuencia_acciones,
                'fuerza' => $request->fuerza,
                'postura_hombro' => $request->postura_hombro,
                'postura_codo' => $request->postura_codo,
                'postura_muneca' => $request->postura_muneca,
                'postura_mano' => $request->postura_mano,
                'repetitividad' => $request->repetitividad,
                'factores_adicionales' => $request->factores_adicionales,
                'recuperacion' => $request->recuperacion,
                'indice_ocra' => $indice,
                'nivel_riesgo' => $nivel,
                'recomendaciones' => $recomendaciones,
                'observaciones' => $request->observaciones,
            ]);

            $this->guardarDetalles($ocra, $request, $indice);

            $evaluacion->update([
                'resultado_final' => $indice,
                'nivel_riesgo' => $nivel,
                'recomendaciones' => $recomendaciones,
                'observaciones' => $request->observaciones,
            ]);

            DB::commit();

            return redirect()
                ->route('ocra.show', $ocra->id)
                ->with('success', 'Evaluación OCRA registrada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Error al guardar OCRA: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $ocra = OcraEvaluacion::with([
            'evaluacion.empresa',
            'evaluacion.sucursal',
            'evaluacion.puesto',
            'evaluacion.trabajador',
            'evaluacion.metodo',
            'evaluacion.usuario',
            'detalles',
        ])->findOrFail($id);

        return view('ocra.show', compact('ocra'));
    }

    public function pdf($id)
    {
        $ocra = OcraEvaluacion::with([
            'evaluacion.empresa',
            'evaluacion.sucursal',
            'evaluacion.puesto',
            'evaluacion.trabajador',
            'evaluacion.metodo',
            'evaluacion.usuario',
            'detalles',
        ])->findOrFail($id);

        $pdf = Pdf::loadView('ocra.pdf', compact('ocra'))
            ->setPaper('letter', 'portrait');

        return $pdf->download('reporte_ocra_' . $ocra->id . '.pdf');
    }

    private function calcularIndice(Request $request): float
    {
        $postura = (
            $request->postura_hombro +
            $request->postura_codo +
            $request->postura_muneca +
            $request->postura_mano
        ) / 4;

        $indice = 
            ($request->frecuencia_acciones * 0.25) +
            ($request->fuerza * 1.5) +
            ($postura * 1.2) +
            ($request->repetitividad * 1.1) +
            ($request->factores_adicionales * 0.8) -
            ($request->recuperacion * 0.7);

        return max(round($indice, 2), 0);
    }

    private function clasificarRiesgo(float $indice): array
    {
        if ($indice <= 7.5) {
            return ['Bajo', 'Mantener condiciones actuales y continuar con vigilancia ergonómica.'];
        }

        if ($indice <= 11) {
            return ['Medio', 'Revisar pausas, recuperación, ritmo de trabajo y posturas forzadas.'];
        }

        if ($indice <= 22.5) {
            return ['Alto', 'Rediseñar la tarea, reducir repetitividad, mejorar pausas y capacitar al trabajador.'];
        }

        return ['Muy alto', 'Intervenir de forma prioritaria. Reducir exposición, fuerza aplicada y frecuencia de acciones técnicas.'];
    }

    private function guardarDetalles(OcraEvaluacion $ocra, Request $request, float $indice): void
    {
        $detalles = [
            ['General', 'Lado evaluado', $request->lado_evaluado, null],
            ['General', 'Duración de la tarea', $request->duracion_tarea . ' horas', null],
            ['Acciones', 'Acciones técnicas', $request->acciones_tecnicas, $request->acciones_tecnicas],
            ['Acciones', 'Frecuencia de acciones', $request->frecuencia_acciones, $request->frecuencia_acciones],
            ['Factores de riesgo', 'Fuerza', $request->fuerza, $request->fuerza],
            ['Postura', 'Hombro', $request->postura_hombro, $request->postura_hombro],
            ['Postura', 'Codo', $request->postura_codo, $request->postura_codo],
            ['Postura', 'Muñeca', $request->postura_muneca, $request->postura_muneca],
            ['Postura', 'Mano', $request->postura_mano, $request->postura_mano],
            ['Factores de riesgo', 'Repetitividad', $request->repetitividad, $request->repetitividad],
            ['Factores adicionales', 'Factores adicionales', $request->factores_adicionales, $request->factores_adicionales],
            ['Recuperación', 'Recuperación', $request->recuperacion, $request->recuperacion],
            ['Resultado', 'Índice OCRA', $indice, $indice],
        ];

        foreach ($detalles as $detalle) {
            OcraDetalle::create([
                'ocra_evaluacion_id' => $ocra->id,
                'seccion' => $detalle[0],
                'concepto' => $detalle[1],
                'valor' => $detalle[2],
                'puntaje' => $detalle[3],
            ]);
        }
    }
}