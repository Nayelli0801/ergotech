<?php

namespace App\Services\Reportes;

use App\Models\Nom036Evaluacion;

class Nom036ReportService
{
    public function findOrFail(int $id): Nom036Evaluacion
    {
        return Nom036Evaluacion::with([
            'evaluacion.empresa',
            'evaluacion.sucursal',
            'evaluacion.puesto',
            'evaluacion.trabajador',
            'evaluacion.usuario',
            'detalles',
        ])->findOrFail($id);
    }

    public function build(Nom036Evaluacion $nom036): array
    {
        $trabajador = trim(
            ($nom036->evaluacion->trabajador->nombre ?? '') . ' ' .
            ($nom036->evaluacion->trabajador->apellido_paterno ?? '') . ' ' .
            ($nom036->evaluacion->trabajador->apellido_materno ?? '')
        );

        $general = [
            'empresa' => $nom036->evaluacion->empresa->nombre ?? 'N/A',
            'sucursal' => $nom036->evaluacion->sucursal->nombre ?? 'N/A',
            'puesto' => $nom036->evaluacion->puesto->nombre ?? 'N/A',
            'trabajador' => $trabajador ?: 'N/A',
            'fecha' => $nom036->evaluacion->fecha_evaluacion ?? 'N/A',
            'evaluador' => $nom036->evaluacion->usuario->name ?? 'N/A',
            'area_evaluada' => $nom036->evaluacion->area_evaluada ?? 'N/A',
            'actividad' => $nom036->evaluacion->actividad ?? 'N/A',
            'observaciones' => $nom036->evaluacion->observaciones ?? 'Sin observaciones',
        ];

        $scores = [
            ['label' => 'Puntuación final', 'value' => (string) ($nom036->puntuacion_final ?? $nom036->resultado_final ?? 'N/A')],
            ['label' => 'Nivel de riesgo', 'value' => (string) ($nom036->nivel_riesgo ?? 'N/A')],
        ];

        $detalles = $nom036->detalles->map(function ($detalle) {
            return [
                'seccion' => $detalle->seccion,
                'concepto' => ucfirst(str_replace('_', ' ', $detalle->concepto)),
                'valor' => $detalle->valor,
                'puntaje' => $detalle->puntaje ?? $detalle->resultado ?? '',
            ];
        })->values()->toArray();

        return [
            'id' => $nom036->id,
            'general' => $general,
            'scores' => $scores,
            'nivel_riesgo' => $nom036->nivel_riesgo ?? 'N/A',
            'accion_requerida' => $nom036->accion_requerida ?? 'N/A',
            'detalles' => $detalles,
        ];
    }
}