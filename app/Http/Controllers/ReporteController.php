<?php

namespace App\Http\Controllers;

use App\Models\Evaluacion;
use App\Models\Empresa;
use App\Models\Puesto;

class ReporteController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $soloLectura = ($user->rol->nombre ?? '') === 'visitante';

        $evaluaciones = Evaluacion::with([
            'empresa',
            'puesto',
            'trabajador',
            'metodo',
            'rebaEvaluacion',
            'rulaEvaluacion',
            'owasEvaluacion',
            'nioshEvaluacion',
            'nom036'
        ])->get();

        $evaluacionesData = $evaluaciones->map(function ($eval) {
            $metodo = strtoupper($eval->metodo->nombre ?? '');
            $resultado = $eval->resultado_final ?? null;

            if (!$resultado) {
                switch ($metodo) {
                    case 'REBA':
                        $resultado = $eval->rebaEvaluacion->puntuacion_final ?? 'N/A';
                        break;

                    case 'RULA':
                        $resultado = $eval->rulaEvaluacion->puntuacion_final ?? 'N/A';
                        break;

                    case 'OWAS':
                        $resultado = $eval->owasEvaluacion->resultado_final ?? 'N/A';
                        break;

                    case 'NIOSH':
                        $resultado = $eval->nioshEvaluacion->indice_levantamiento ?? 'N/A';
                        break;

                    case 'NOM-036':
                    case 'NOM036':
                    case 'NOM 036':
                        $resultado = $eval->nom036->resultado_final ?? 'N/A';
                        break;

                    default:
                        $resultado = 'N/A';
                        break;
                }
            }

            return [
                'id' => $eval->id,
                'empresa_nombre' => $eval->empresa->nombre ?? 'N/A',
                'puesto_nombre' => $eval->puesto->nombre ?? 'N/A',
                'trabajador_nombre' => trim(
                    ($eval->trabajador->nombre ?? '') . ' ' .
                    ($eval->trabajador->apellido_paterno ?? '') . ' ' .
                    ($eval->trabajador->apellido_materno ?? '')
                ) ?: 'N/A',
                'fecha' => $eval->fecha_evaluacion ?? 'N/A',
                'area' => $eval->area_evaluada ?? 'N/A',
                'resultado' => $resultado ?? 'N/A',
                'observaciones' => $eval->observaciones ?? '',
                'metodo' => $eval->metodo->nombre ?? 'N/A',
            ];
        })->values();

        $empresas = Empresa::all();
        $puestos = Puesto::all();

        return view('reportes.index', compact(
            'evaluacionesData',
            'empresas',
            'puestos',
            'soloLectura'
        ));
    }
}