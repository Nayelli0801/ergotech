<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte REBA</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #222;
            margin: 30px;
        }

        h1, h2, h3 {
            margin: 0;
        }

        .header {
            border-bottom: 2px solid #1d4ed8;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            color: #1d4ed8;
            font-size: 22px;
        }

        .sub {
            color: #555;
            font-size: 12px;
            margin-top: 4px;
        }

        .section {
            margin-bottom: 18px;
        }

        .section-title {
            background: #eff6ff;
            color: #1d4ed8;
            padding: 8px 10px;
            font-weight: bold;
            border: 1px solid #bfdbfe;
            margin-bottom: 10px;
        }

        .grid {
            width: 100%;
            border-collapse: collapse;
        }

        .grid td {
            padding: 6px 8px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
        }

        .label {
            font-weight: bold;
            width: 180px;
            background: #f9fafb;
        }

        .cards {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px 0;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .card {
            border: 1px solid #dbeafe;
            background: #f8fbff;
            padding: 12px;
            text-align: center;
        }

        .card .title {
            font-size: 11px;
            color: #555;
            text-transform: uppercase;
        }

        .card .value {
            font-size: 22px;
            font-weight: bold;
            color: #1d4ed8;
            margin-top: 4px;
        }

        .risk {
            padding: 12px;
            border: 1px solid #fde68a;
            background: #fffbeb;
            margin-top: 10px;
        }

        table.detalle {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.detalle th,
        table.detalle td {
            border: 1px solid #d1d5db;
            padding: 8px;
            text-align: left;
            font-size: 11px;
        }

        table.detalle th {
            background: #f3f4f6;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Reporte de Evaluación REBA</h1>
        <div class="sub">Resultado ergonómico generado por el sistema</div>
    </div>

    <div class="section">
        <div class="section-title">Datos generales</div>
        <table class="grid">
            <tr>
                <td class="label">Empresa</td>
                <td>{{ $reba->evaluacion->empresa->nombre ?? 'N/A' }}</td>
                <td class="label">Sucursal</td>
                <td>{{ $reba->evaluacion->sucursal->nombre ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Puesto</td>
                <td>{{ $reba->evaluacion->puesto->nombre ?? 'N/A' }}</td>
                <td class="label">Trabajador</td>
                <td>
                    {{ trim(($reba->evaluacion->trabajador->nombre ?? '') . ' ' . ($reba->evaluacion->trabajador->apellido_paterno ?? '') . ' ' . ($reba->evaluacion->trabajador->apellido_materno ?? '')) ?: 'N/A' }}
                </td>
            </tr>
            <tr>
                <td class="label">Fecha</td>
                <td>{{ $reba->evaluacion->fecha_evaluacion ?? 'N/A' }}</td>
                <td class="label">Evaluador</td>
                <td>{{ $reba->evaluacion->usuario->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Área evaluada</td>
                <td>{{ $reba->evaluacion->area_evaluada ?? 'N/A' }}</td>
                <td class="label">Actividad general</td>
                <td>{{ $reba->evaluacion->actividad ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Observaciones</td>
                <td colspan="3">{{ $reba->evaluacion->observaciones ?? 'Sin observaciones' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Resultados</div>

        <table class="cards">
            <tr>
                <td class="card">
                    <div class="title">Puntuación A</div>
                    <div class="value">{{ $reba->puntuacion_a }}</div>
                </td>
                <td class="card">
                    <div class="title">Puntuación B</div>
                    <div class="value">{{ $reba->puntuacion_b }}</div>
                </td>
                <td class="card">
                    <div class="title">Puntuación C</div>
                    <div class="value">{{ $reba->puntuacion_c }}</div>
                </td>
                <td class="card">
                    <div class="title">Puntuación Final</div>
                    <div class="value">{{ $reba->puntuacion_final }}</div>
                </td>
            </tr>
        </table>

        <div class="risk">
            <strong>Nivel de riesgo:</strong> {{ $reba->nivel_riesgo }}<br>
            <strong>Acción requerida:</strong> {{ $reba->accion_requerida }}
        </div>
    </div>

    <div class="section">
        <div class="section-title">Detalle de la evaluación</div>

        <table class="detalle">
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

</body>
</html>