<?php

namespace App\Services\Reportes;

use App\Models\RulaEvaluacion;

class RulaReportService
{
    public function findOrFail(int $id): RulaEvaluacion
    {
        return RulaEvaluacion::with([
            'evaluacion.empresa',
            'evaluacion.sucursal',
            'evaluacion.puesto',
            'evaluacion.trabajador',
            'evaluacion.usuario',
            'detalles',
        ])->findOrFail($id);
    }

    public function build(RulaEvaluacion $rula): array
    {
        $trabajador = trim(
            ($rula->evaluacion->trabajador->nombre ?? '') . ' ' .
            ($rula->evaluacion->trabajador->apellido_paterno ?? '') . ' ' .
            ($rula->evaluacion->trabajador->apellido_materno ?? '')
        );

        $general = [
            'empresa' => $rula->evaluacion->empresa->nombre ?? 'N/A',
            'sucursal' => $rula->evaluacion->sucursal->nombre ?? 'N/A',
            'puesto' => $rula->evaluacion->puesto->nombre ?? 'N/A',
            'trabajador' => $trabajador ?: 'N/A',
            'fecha' => $rula->evaluacion->fecha_evaluacion ?? 'N/A',
            'evaluador' => $rula->evaluacion->usuario->name ?? 'N/A',
            'area_evaluada' => $rula->evaluacion->area_evaluada ?? 'N/A',
            'actividad' => $rula->evaluacion->actividad ?? 'N/A',
            'observaciones' => $rula->evaluacion->observaciones ?? 'Sin observaciones',
        ];

        $scores = [
            ['label' => 'Puntuación A', 'value' => (int) ($rula->puntuacion_a ?? 0)],
            ['label' => 'Puntuación B', 'value' => (int) ($rula->puntuacion_b ?? 0)],
            ['label' => 'Puntuación C', 'value' => (int) ($rula->puntuacion_c ?? 0)],
            ['label' => 'Puntuación D', 'value' => (int) ($rula->puntuacion_d ?? 0)],
            ['label' => 'Puntuación Final', 'value' => (int) ($rula->puntuacion_final ?? 0)],
        ];

        $detalles = $rula->detalles->map(function ($detalle) {
            return [
                'seccion' => $detalle->seccion,
                'concepto' => ucfirst(str_replace('_', ' ', $detalle->concepto)),
                'valor' => $detalle->valor,
                'puntaje' => $detalle->puntaje,
            ];
        })->values()->toArray();

        return [
            'id' => $rula->id,
            'general' => $general,
            'scores' => $scores,
            'nivel_riesgo' => $rula->nivel_riesgo ?? 'N/A',
            'accion_requerida' => $rula->accion_requerida ?? 'N/A',
            'detalles' => $detalles,
        ];
    }
}