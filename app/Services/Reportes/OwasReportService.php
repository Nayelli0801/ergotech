<?php

namespace App\Services\Reportes;

use App\Models\OwasEvaluacion;

class OwasReportService
{
    public function findOrFail(int $id): OwasEvaluacion
    {
        return OwasEvaluacion::with([
            'evaluacion.empresa',
            'evaluacion.sucursal',
            'evaluacion.puesto',
            'evaluacion.trabajador',
            'evaluacion.usuario',
            'detalles',
        ])->findOrFail($id);
    }

    public function build(OwasEvaluacion $owas): array
    {
        $trabajador = trim(
            ($owas->evaluacion->trabajador->nombre ?? '') . ' ' .
            ($owas->evaluacion->trabajador->apellido_paterno ?? '') . ' ' .
            ($owas->evaluacion->trabajador->apellido_materno ?? '')
        );

        $general = [
            'empresa' => $owas->evaluacion->empresa->nombre ?? 'N/A',
            'sucursal' => $owas->evaluacion->sucursal->nombre ?? 'N/A',
            'puesto' => $owas->evaluacion->puesto->nombre ?? 'N/A',
            'trabajador' => $trabajador ?: 'N/A',
            'fecha' => $owas->evaluacion->fecha_evaluacion ?? 'N/A',
            'evaluador' => $owas->evaluacion->usuario->name ?? 'N/A',
            'area_evaluada' => $owas->evaluacion->area_evaluada ?? 'N/A',
            'actividad' => $owas->evaluacion->actividad ?? 'N/A',
            'observaciones' => $owas->evaluacion->observaciones ?? 'Sin observaciones',
        ];

        $scores = [
            ['label' => 'Código de postura', 'value' => (string) ($owas->codigo_postura ?? 'N/A')],
            ['label' => 'Categoría de riesgo', 'value' => (string) ($owas->categoria_riesgo ?? 'N/A')],
            ['label' => 'Puntuación final', 'value' => (string) ($owas->puntuacion_final ?? 'N/A')],
        ];

        $detalles = $owas->detalles->map(function ($detalle) {
            return [
                'seccion' => $detalle->seccion,
                'concepto' => ucfirst(str_replace('_', ' ', $detalle->concepto)),
                'valor' => $detalle->valor,
                'puntaje' => $detalle->puntaje ?? '',
            ];
        })->values()->toArray();

        return [
            'id' => $owas->id,
            'general' => $general,
            'scores' => $scores,
            'nivel_riesgo' => $owas->nivel_riesgo ?? ($owas->categoria_riesgo ?? 'N/A'),
            'accion_requerida' => $owas->accion_requerida ?? 'N/A',
            'detalles' => $detalles,
        ];
    }
}