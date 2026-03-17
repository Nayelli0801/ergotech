<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte RULA</title>
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
        .grid th { width: 170px; }
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
        <h1>Reporte de Evaluación RULA</h1>
        <p>Resultado ergonómico generado por ErgoTech</p>
    </div>

    <div class="section">
        <div class="section-title">Información general</div>
        <table class="grid">
            <tr>
                <th>ID</th>
                <td>{{ $rula->id }}</td>
                <th>Empresa</th>
                <td>{{ $rula->evaluacion->empresa->nombre ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Sucursal</th>
                <td>{{ $rula->evaluacion->sucursal->nombre ?? 'N/A' }}</td>
                <th>Puesto</th>
                <td>{{ $rula->evaluacion->puesto->nombre ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Trabajador</th>
                <td>{{ $rula->evaluacion->trabajador->nombre ?? 'N/A' }}</td>
                <th>Fecha</th>
                <td>{{ $rula->evaluacion->fecha_evaluacion ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Evaluador</th>
                <td>{{ $rula->evaluacion->usuario->name ?? 'N/A' }}</td>
                <th>Área evaluada</th>
                <td>{{ $rula->evaluacion->area_evaluada ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Actividad</th>
                <td>{{ $rula->evaluacion->actividad ?? 'N/A' }}</td>
                <th>Observaciones</th>
                <td>{{ $rula->evaluacion->observaciones ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Resultado</div>

        <table class="cards">
            <tr>
                <td class="card"><div class="title">A</div><div class="value">{{ $rula->puntuacion_a }}</div></td>
                <td class="card"><div class="title">B</div><div class="value">{{ $rula->puntuacion_b }}</div></td>
                <td class="card"><div class="title">C</div><div class="value">{{ $rula->puntuacion_c }}</div></td>
                <td class="card"><div class="title">D</div><div class="value">{{ $rula->puntuacion_d }}</div></td>
                <td class="card"><div class="title">Final</div><div class="value">{{ $rula->puntuacion_final }}</div></td>
            </tr>
        </table>

        <div class="summary-box">
            <p><strong>Nivel de acción:</strong> {{ $rula->nivel_accion }}</p>
            <p><strong>Nivel de riesgo:</strong> {{ $rula->evaluacion->nivel_riesgo ?? 'N/A' }}</p>
            <p><strong>Recomendaciones:</strong> {{ $rula->evaluacion->recomendaciones ?? 'Sin recomendaciones' }}</p>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Detalle</div>
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
                @foreach($rula->detalles as $detalle)
                    <tr>
                        <td>{{ $detalle->seccion }}</td>
                        <td>{{ $detalle->concepto }}</td>
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