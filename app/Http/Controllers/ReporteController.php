<?php

namespace App\Http\Controllers;

use App\Models\Evaluacion;
use App\Models\Empresa;
use App\Models\Puesto;

class ReporteController extends Controller
{
    public function index()
    {
        // Obtener evaluaciones con relaciones
        $evaluaciones = Evaluacion::with(['empresa', 'puesto', 'trabajador'])->get();

        // Mapear a un formato simple para la vista (array asociativo)
        $evaluacionesData = $evaluaciones->map(function ($eval) {
            return [
                'id'                 => $eval->id,
                'empresa_nombre'     => $eval->empresa->nombre ?? 'N/A',
                'puesto_nombre'      => $eval->puesto->nombre ?? 'N/A',
                'trabajador_nombre'  => $eval->trabajador->nombre ?? 'N/A',
                'fecha'              => $eval->fecha,
                'area'               => $eval->area,
                'resultado'          => $eval->resultado,
                'observaciones'      => $eval->observaciones,
                // Agrega aquí más campos si los necesitas (ej. evaluador, método)
            ];
        })->values(); // Reindexa la colección

        // Obtener listados para los filtros
        $empresas = Empresa::all();
        $puestos  = Puesto::all();

        return view('reportes.index', compact('evaluacionesData', 'empresas', 'puestos'));
    }
}