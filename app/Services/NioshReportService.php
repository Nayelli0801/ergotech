<?php

namespace App\Services\Reportes;

use App\Models\NioshEvaluacion;

class NioshReportService
{
    public function findOrFail(int $id): NioshEvaluacion
    {
        return NioshEvaluacion::with([
            'evaluacion.empresa',
            'evaluacion.sucursal',
            'evaluacion.puesto',
            'evaluacion.trabajador',
            'evaluacion.usuario',
            'detalles',
        ])->findOrFail($id);
    }

    public function build(NioshEvaluacion $niosh): array
    {
        $trabajador = trim(
            ($niosh->evaluacion->trabajador->nombre ?? '') . ' ' .
            ($niosh->evaluacion->trabajador->apellido_paterno ?? '') . ' ' .
            ($niosh->evaluacion->trabajador->apellido_materno ?? '')
        );

        $general = [
            'empresa' => $niosh->evaluacion->empresa->nombre ?? 'N/A',
            'sucursal' => $niosh->evaluacion->sucursal->nombre ?? 'N/A',
            'puesto' => $niosh->evaluacion->puesto->nombre ?? 'N/A',
            'trabajador' => $trabajador ?: 'N/A',
            'fecha' => $niosh->evaluacion->fecha_evaluacion ?? 'N/A',
            'evaluador' => $niosh->evaluacion->usuario->name ?? 'N/A',
            'area_evaluada' => $niosh->evaluacion->area_evaluada ?? 'N/A',
            'actividad' => $niosh->evaluacion->actividad ?? 'N/A',
            'observaciones' => $niosh->evaluacion->observaciones ?? 'Sin observaciones',
        ];

        $scores = [
            ['label' => 'HM', 'value' => (string) ($niosh->hm ?? 'N/A')],
            ['label' => 'VM', 'value' => (string) ($niosh->vm ?? 'N/A')],
            ['label' => 'DM', 'value' => (string) ($niosh->dm ?? 'N/A')],
            ['label' => 'AM', 'value' => (string) ($niosh->am ?? 'N/A')],
            ['label' => 'FM', 'value' => (string) ($niosh->fm ?? 'N/A')],
            ['label' => 'CM', 'value' => (string) ($niosh->cm ?? 'N/A')],
            ['label' => 'RWL', 'value' => (string) ($niosh->rwl ?? 'N/A')],
            ['label' => 'Índice de levantamiento', 'value' => (string) ($niosh->indice_levantamiento ?? 'N/A')],
        ];

        $detalles = $niosh->detalles->map(function ($detalle) {
            return [
                'seccion' => $detalle->seccion,
                'concepto' => ucfirst(str_replace('_', ' ', $detalle->concepto)),
                'valor' => $detalle->valor,
                'puntaje' => $detalle->resultado ?? '',
            ];
        })->values()->toArray();

        return [
            'id' => $niosh->id,
            'general' => $general,
            'scores' => $scores,
            'nivel_riesgo' => $niosh->nivel_riesgo ?? 'N/A',
            'accion_requerida' => 'Índice de levantamiento: ' . ($niosh->indice_levantamiento ?? 'N/A'),
            'detalles' => $detalles,
        ];
    }
}