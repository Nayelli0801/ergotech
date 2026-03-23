<?php

namespace App\Services\Reportes;

use App\Models\RebaEvaluacion;

class RebaReportService
{
    public function findOrFail(int $id): RebaEvaluacion
    {
        return RebaEvaluacion::with([
            'evaluacion.empresa',
            'evaluacion.sucursal',
            'evaluacion.puesto',
            'evaluacion.trabajador',
            'evaluacion.usuario',
            'detalles',
        ])->findOrFail($id);
    }

    public function build(RebaEvaluacion $reba): array
    {
        $trabajador = trim(
            ($reba->evaluacion->trabajador->nombre ?? '') . ' ' .
            ($reba->evaluacion->trabajador->apellido_paterno ?? '') . ' ' .
            ($reba->evaluacion->trabajador->apellido_materno ?? '')
        );

        $general = [
            'empresa' => $reba->evaluacion->empresa->nombre ?? 'N/A',
            'sucursal' => $reba->evaluacion->sucursal->nombre ?? 'N/A',
            'puesto' => $reba->evaluacion->puesto->nombre ?? 'N/A',
            'trabajador' => $trabajador ?: 'N/A',
            'fecha' => $reba->evaluacion->fecha_evaluacion ?? 'N/A',
            'evaluador' => $reba->evaluacion->usuario->name ?? 'N/A',
            'area_evaluada' => $reba->evaluacion->area_evaluada ?? 'N/A',
            'actividad' => $reba->evaluacion->actividad ?? 'N/A',
            'observaciones' => $reba->evaluacion->observaciones ?? 'Sin observaciones',
        ];

        $scores = [
            ['label' => 'Puntuación A', 'value' => (int) $reba->puntuacion_a],
            ['label' => 'Puntuación B', 'value' => (int) $reba->puntuacion_b],
            ['label' => 'Puntuación C', 'value' => (int) $reba->puntuacion_c],
            ['label' => 'Puntuación Final', 'value' => (int) $reba->puntuacion_final],
        ];

        $detalles = $reba->detalles
            ->map(function ($detalle) {
                return [
                    'seccion' => $detalle->seccion,
                    'concepto' => ucfirst(str_replace('_', ' ', $detalle->concepto)),
                    'valor' => $detalle->valor,
                    'puntaje' => $detalle->puntaje,
                ];
            })
            ->values()
            ->toArray();

        return [
            'id' => $reba->id,
            'general' => $general,
            'scores' => $scores,
            'nivel_riesgo' => $reba->nivel_riesgo ?? 'N/A',
            'accion_requerida' => $reba->accion_requerida ?? 'N/A',
            'detalles' => $detalles,
        ];
    }
}