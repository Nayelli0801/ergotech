<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte NOM-036</title>
    <style>
        @page { margin: 24px 24px 34px 24px; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #1f2937; }
        .header { border-bottom: 3px solid #1d4ed8; padding-bottom: 10px; margin-bottom: 18px; }
        .header h1 { margin: 0; color: #1d4ed8; font-size: 22px; }
        .header p { margin: 4px 0 0 0; color: #6b7280; font-size: 11px; }
        .section { margin-bottom: 18px; }
        .section-title { background: #eff6ff; color: #1d4ed8; padding: 8px 10px; font-weight: bold; border: 1px solid #bfdbfe; margin-bottom: 10px; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; }
        .grid th, .grid td, .detail th, .detail td { border: 1px solid #d1d5db; padding: 7px 8px; vertical-align: top; }
        .grid th, .detail th { background: #f3f4f6; text-align: left; }
        .risk { color: #b91c1c; font-weight: bold; }
        .footer { margin-top: 20px; font-size: 10px; color: #6b7280; text-align: right; }
    </style>
</head>
<body>
    @php
        $detallesGenerales = $nom036->detalles->where('seccion', 'General');
        $tareasSeleccionadas = optional($detallesGenerales->firstWhere('concepto', 'Tareas seleccionadas'))->valor ?? 'No especificadas';
        $tareaObservada = optional($detallesGenerales->firstWhere('concepto', 'Tarea observada'))->valor ?? 'No especificada';
        $medioAyuda = optional($detallesGenerales->firstWhere('concepto', 'Medio de ayuda utilizado'))->valor ?? 'No especificado';
        $descripcionApoyo = optional($detallesGenerales->firstWhere('concepto', 'Descripción del apoyo o equipo utilizado'))->valor ?? 'No especificada';

        $secciones = $nom036->detalles
            ->whereNotIn('seccion', ['General', 'Resultado'])
            ->groupBy('seccion');

        $resultados = $nom036->detalles->where('seccion', 'Resultado');
    @endphp

    <div class="header">
        <h1>Reporte de Evaluación NOM-036</h1>
        <p>Factores de riesgo ergonómico en el trabajo - Manejo manual de cargas</p>
    </div>

    <div class="section">
        <div class="section-title">Datos generales</div>
        <table class="grid">
            <tr>
                <th>Empresa</th>
                <td>{{ $nom036->evaluacion->empresa->nombre ?? 'N/A' }}</td>
                <th>Sucursal</th>
                <td>{{ $nom036->evaluacion->sucursal->nombre ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Puesto</th>
                <td>{{ $nom036->evaluacion->puesto->nombre ?? 'N/A' }}</td>
                <th>Trabajador</th>
                <td>{{ $nom036->evaluacion->trabajador->nombre ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Fecha</th>
                <td>{{ $nom036->evaluacion->fecha_evaluacion ?? 'N/A' }}</td>
                <th>Resultado final</th>
                <td>{{ $nom036->evaluacion->resultado_final ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Nivel de riesgo</th>
                <td class="risk">{{ $nom036->nivel_riesgo ?? 'N/A' }}</td>
                <th>Recomendación</th>
                <td>{{ $nom036->evaluacion->recomendaciones ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Datos de la actividad</div>
        <table class="grid">
            <tr><th>Tareas seleccionadas</th><td>{{ $tareasSeleccionadas }}</td></tr>
            <tr><th>Tarea observada</th><td>{{ $tareaObservada }}</td></tr>
            <tr><th>Medio de ayuda utilizado</th><td>{{ $medioAyuda }}</td></tr>
            <tr><th>Descripción del apoyo o equipo</th><td>{{ $descripcionApoyo }}</td></tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Observaciones</div>
        <table class="grid">
            <tr><td>{{ $nom036->observaciones ?? 'Sin observaciones.' }}</td></tr>
        </table>
    </div>

    @foreach($secciones as $nombreSeccion => $items)
        <div class="section">
            <div class="section-title">{{ $nombreSeccion }}</div>
            <table class="detail">
                <thead>
                    <tr>
                        <th>Concepto</th>
                        <th>Valor seleccionado</th>
                        <th>Resultado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $detalle)
                        <tr>
                            <td>{{ $detalle->concepto }}</td>
                            <td>{{ $detalle->valor }}</td>
                            <td>{{ $detalle->resultado ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach

    <div class="section">
        <div class="section-title">Resultado final</div>
        <table class="detail">
            <thead>
                <tr>
                    <th>Concepto</th>
                    <th>Valor</th>
                    <th>Resultado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($resultados as $detalle)
                    <tr>
                        <td>{{ $detalle->concepto }}</td>
                        <td>{{ $detalle->valor }}</td>
                        <td>{{ $detalle->resultado ?? '—' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">Reporte generado por ErgoTech</div>
</body>
</html>