<?php

namespace App\Http\Controllers;

use App\Models\Evaluacion;
use App\Models\Nom036Detalle;
use App\Models\Nom036Evaluacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class Nom036Controller extends Controller
{
    public function create($evaluacionId)
    {
        $evaluacion = Evaluacion::with([
            'empresa',
            'sucursal',
            'puesto',
            'trabajador',
            'metodo'
        ])->findOrFail($evaluacionId);

        return view('nom036.create', compact('evaluacion'));
    }

    public function store(Request $request, $evaluacionId)
    {
        $evaluacion = Evaluacion::findOrFail($evaluacionId);

        $request->validate([
            'tipo_actividad' => 'required|string|max:255',
            'objeto_manipulado' => 'nullable|string|max:255',
            'peso_carga' => 'nullable|numeric|min:0',
            'frecuencia' => 'nullable|numeric|min:0',
            'duracion' => 'nullable|numeric|min:0',
            'distancia_recorrida' => 'nullable|numeric|min:0',
            'altura_inicial' => 'nullable|numeric|min:0',
            'altura_final' => 'nullable|numeric|min:0',
            'postura_tronco' => 'nullable|string|max:255',
            'postura_brazos' => 'nullable|string|max:255',
            'postura_piernas' => 'nullable|string|max:255',
            'agarre' => 'nullable|string|max:255',
            'condiciones_ambientales' => 'nullable|string|max:255',
            'superficie_trabajo' => 'nullable|string|max:255',
            'espacio_trabajo' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $asimetria = $request->has('asimetria') ? 1 : 0;
            $movimientosRepetitivos = $request->has('movimientos_repetitivos') ? 1 : 0;
            $fuerzaBrusca = $request->has('fuerza_brusca') ? 1 : 0;

            $puntaje = 0;

            if (($request->peso_carga ?? 0) >= 25) {
                $puntaje += 3;
            } elseif (($request->peso_carga ?? 0) >= 15) {
                $puntaje += 2;
            } elseif (($request->peso_carga ?? 0) >= 5) {
                $puntaje += 1;
            }

            if (($request->frecuencia ?? 0) >= 10) {
                $puntaje += 3;
            } elseif (($request->frecuencia ?? 0) >= 5) {
                $puntaje += 2;
            } elseif (($request->frecuencia ?? 0) > 0) {
                $puntaje += 1;
            }

            if (($request->duracion ?? 0) >= 4) {
                $puntaje += 3;
            } elseif (($request->duracion ?? 0) >= 2) {
                $puntaje += 2;
            } elseif (($request->duracion ?? 0) > 0) {
                $puntaje += 1;
            }

            if ($asimetria) $puntaje += 1;
            if ($movimientosRepetitivos) $puntaje += 1;
            if ($fuerzaBrusca) $puntaje += 1;

            if (($request->postura_tronco ?? '') === 'forzada') $puntaje += 2;
            if (($request->postura_brazos ?? '') === 'forzada') $puntaje += 1;
            if (($request->postura_piernas ?? '') === 'forzada') $puntaje += 1;

            if (($request->agarre ?? '') === 'malo') $puntaje += 1;
            if (($request->superficie_trabajo ?? '') === 'irregular') $puntaje += 1;
            if (($request->espacio_trabajo ?? '') === 'reducido') $puntaje += 1;
            if (($request->condiciones_ambientales ?? '') === 'desfavorables') $puntaje += 1;

            if ($puntaje <= 3) {
                $nivelRiesgo = 'Bajo';
                $recomendacion = 'Mantener seguimiento y condiciones actuales.';
            } elseif ($puntaje <= 6) {
                $nivelRiesgo = 'Medio';
                $recomendacion = 'Revisar condiciones de trabajo y proponer mejoras.';
            } elseif ($puntaje <= 9) {
                $nivelRiesgo = 'Alto';
                $recomendacion = 'Se requiere intervención pronta.';
            } else {
                $nivelRiesgo = 'Muy alto';
                $recomendacion = 'Se requiere intervención inmediata.';
            }

            $nom036 = Nom036Evaluacion::create([
                'evaluacion_id' => $evaluacion->id,
                'tipo_actividad' => $request->tipo_actividad,
                'objeto_manipulado' => $request->objeto_manipulado,
                'peso_carga' => $request->peso_carga,
                'frecuencia' => $request->frecuencia,
                'duracion' => $request->duracion,
                'distancia_recorrida' => $request->distancia_recorrida,
                'altura_inicial' => $request->altura_inicial,
                'altura_final' => $request->altura_final,
                'postura_tronco' => $request->postura_tronco,
                'postura_brazos' => $request->postura_brazos,
                'postura_piernas' => $request->postura_piernas,
                'agarre' => $request->agarre,
                'asimetria' => $asimetria,
                'movimientos_repetitivos' => $movimientosRepetitivos,
                'fuerza_brusca' => $fuerzaBrusca,
                'condiciones_ambientales' => $request->condiciones_ambientales,
                'superficie_trabajo' => $request->superficie_trabajo,
                'espacio_trabajo' => $request->espacio_trabajo,
                'nivel_riesgo' => $nivelRiesgo,
                'observaciones' => $request->observaciones,
            ]);

            $evaluacion->update([
                'resultado_final' => $puntaje,
                'nivel_riesgo' => $nivelRiesgo,
                'recomendaciones' => $recomendacion,
            ]);

            $detalles = [
                ['seccion' => 'Carga', 'concepto' => 'Tipo de actividad', 'valor' => $request->tipo_actividad, 'resultado' => null],
                ['seccion' => 'Carga', 'concepto' => 'Objeto manipulado', 'valor' => $request->objeto_manipulado, 'resultado' => null],
                ['seccion' => 'Carga', 'concepto' => 'Peso de la carga', 'valor' => $request->peso_carga, 'resultado' => null],
                ['seccion' => 'Tiempo', 'concepto' => 'Frecuencia', 'valor' => $request->frecuencia, 'resultado' => null],
                ['seccion' => 'Tiempo', 'concepto' => 'Duración', 'valor' => $request->duracion, 'resultado' => null],
                ['seccion' => 'Distancias', 'concepto' => 'Distancia recorrida', 'valor' => $request->distancia_recorrida, 'resultado' => null],
                ['seccion' => 'Distancias', 'concepto' => 'Altura inicial', 'valor' => $request->altura_inicial, 'resultado' => null],
                ['seccion' => 'Distancias', 'concepto' => 'Altura final', 'valor' => $request->altura_final, 'resultado' => null],
                ['seccion' => 'Posturas', 'concepto' => 'Postura del tronco', 'valor' => $request->postura_tronco, 'resultado' => null],
                ['seccion' => 'Posturas', 'concepto' => 'Postura de brazos', 'valor' => $request->postura_brazos, 'resultado' => null],
                ['seccion' => 'Posturas', 'concepto' => 'Postura de piernas', 'valor' => $request->postura_piernas, 'resultado' => null],
                ['seccion' => 'Condiciones', 'concepto' => 'Agarre', 'valor' => $request->agarre, 'resultado' => null],
                ['seccion' => 'Condiciones', 'concepto' => 'Asimetría', 'valor' => $asimetria ? 'Sí' : 'No', 'resultado' => null],
                ['seccion' => 'Condiciones', 'concepto' => 'Movimientos repetitivos', 'valor' => $movimientosRepetitivos ? 'Sí' : 'No', 'resultado' => null],
                ['seccion' => 'Condiciones', 'concepto' => 'Fuerza brusca', 'valor' => $fuerzaBrusca ? 'Sí' : 'No', 'resultado' => null],
                ['seccion' => 'Ambiente', 'concepto' => 'Condiciones ambientales', 'valor' => $request->condiciones_ambientales, 'resultado' => null],
                ['seccion' => 'Ambiente', 'concepto' => 'Superficie de trabajo', 'valor' => $request->superficie_trabajo, 'resultado' => null],
                ['seccion' => 'Ambiente', 'concepto' => 'Espacio de trabajo', 'valor' => $request->espacio_trabajo, 'resultado' => null],
                ['seccion' => 'Resultado', 'concepto' => 'Puntaje total', 'valor' => $puntaje, 'resultado' => 'Calculado automáticamente'],
                ['seccion' => 'Resultado', 'concepto' => 'Nivel de riesgo', 'valor' => $nivelRiesgo, 'resultado' => 'Calculado automáticamente'],
            ];

            foreach ($detalles as $detalle) {
                Nom036Detalle::create([
                    'nom036_evaluacion_id' => $nom036->id,
                    'seccion' => $detalle['seccion'],
                    'concepto' => $detalle['concepto'],
                    'valor' => $detalle['valor'],
                    'resultado' => $detalle['resultado'],
                ]);
            }

            DB::commit();

            return redirect()->route('nom036.show', $nom036->id)
                ->with('success', 'Evaluación NOM-036 guardada correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error al guardar: ' . $e->getMessage());
        }
    }

    public function pdf($id)
     {
    $nom036 = Nom036Evaluacion::with([
        'evaluacion.empresa',
        'evaluacion.sucursal',
        'evaluacion.puesto',
        'evaluacion.trabajador',
        'evaluacion.usuario',
        'detalles'
    ])->findOrFail($id);

    $pdf = Pdf::loadView('nom036.pdf', compact('nom036'))
        ->setPaper('a4', 'portrait');

    $nombreArchivo = 'nom036_' . $nom036->id . '.pdf';

    return $pdf->download($nombreArchivo);
     }




    public function show($id)
    {
        $nom036 = Nom036Evaluacion::with([
            'evaluacion.empresa',
            'evaluacion.sucursal',
            'evaluacion.puesto',
            'evaluacion.trabajador',
            'detalles'
        ])->findOrFail($id);

        return view('nom036.show', compact('nom036'));
    }
}