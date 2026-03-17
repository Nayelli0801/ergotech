<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte REBA</title>
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
        .cards { width: 100%; border-collapse: separate; border-spacing: 8px 8px; margin-top: 6px; }
        .card { border: 1px solid #dbeafe; background: #f8fbff; padding: 10px; text-align: center; }
        .card .title { font-size: 10px; color: #6b7280; text-transform: uppercase; margin-bottom: 4px; }
        .card .value { font-size: 18px; font-weight: bold; color: #1d4ed8; }
        .summary-box { border: 1px solid #d1d5db; background: #f8fafc; padding: 12px; margin-top: 10px; }
        .summary-box p { margin: 4px 0; }
        .footer { margin-top: 20px; font-size: 10px; color: #6b7280; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Evaluación REBA</h1>
        <p>Resultado ergonómico generado por ErgoTech</p>
    </div>

    <div class="section">
        <div class="section-title">Datos generales</div>
        <table class="grid">
            <tr>
                <th>Empresa</th>
                <td>{{ $reba->evaluacion->empresa->nombre ?? 'N/A' }}</td>
                <th>Sucursal</th>
                <td>{{ $reba->evaluacion->sucursal->nombre ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Puesto</th>
                <td>{{ $reba->evaluacion->puesto->nombre ?? 'N/A' }}</td>
                <th>Trabajador</th>
                <td>{{ trim(($reba->evaluacion->trabajador->nombre ?? '') . ' ' . ($reba->evaluacion->trabajador->apellido_paterno ?? '') . ' ' . ($reba->evaluacion->trabajador->apellido_materno ?? '')) ?: 'N/A' }}</td>
            </tr>
            <tr>
                <th>Fecha</th>
                <td>{{ $reba->evaluacion->fecha_evaluacion ?? 'N/A' }}</td>
                <th>Evaluador</th>
                <td>{{ $reba->evaluacion->usuario->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Área evaluada</th>
                <td>{{ $reba->evaluacion->area_evaluada ?? 'N/A' }}</td>
                <th>Actividad general</th>
                <td>{{ $reba->evaluacion->actividad ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Observaciones</th>
                <td colspan="3">{{ $reba->evaluacion->observaciones ?? 'Sin observaciones' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Resultados</div>

        <table class="cards">
            <tr>
                <td class="card"><div class="title">Puntuación A</div><div class="value">{{ $reba->puntuacion_a }}</div></td>
                <td class="card"><div class="title">Puntuación B</div><div class="value">{{ $reba->puntuacion_b }}</div></td>
                <td class="card"><div class="title">Puntuación C</div><div class="value">{{ $reba->puntuacion_c }}</div></td>
                <td class="card"><div class="title">Puntuación final</div><div class="value">{{ $reba->puntuacion_final }}</div></td>
            </tr>
        </table>

        <div class="summary-box">
            <p><strong>Nivel de riesgo:</strong> {{ $reba->nivel_riesgo }}</p>
            <p><strong>Acción requerida:</strong> {{ $reba->accion_requerida }}</p>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Detalle de la evaluación</div>
        <table class="detail">
            <thead>
                <tr>
                    <th>Sección</th>
                    <th>Concepto</th>
                    <th>Valor</th>
                    <th>Puntaje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reba->detalles as $detalle)
                    <tr>
                        <td>{{ $detalle->seccion }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $detalle->concepto)) }}</td>
                        <td>{{ $detalle->valor }}</td>
                        <td>{{ $detalle->puntaje }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">Reporte generado por ErgoTech</div>
</body>
</html>