<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Check List OCRA</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #1f2937;
            margin: 25px;
        }

        .header {
            background: #0284c7;
            color: white;
            padding: 18px;
            border-radius: 8px;
            margin-bottom: 18px;
        }

        .header h1 {
            margin: 0;
            font-size: 21px;
        }

        .header p {
            margin: 4px 0 0;
        }

        .section {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            margin-bottom: 14px;
            padding: 10px;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #0369a1;
            margin-bottom: 8px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }

        th {
            background: #f3f4f6;
            text-align: left;
            padding: 6px;
            border: 1px solid #d1d5db;
        }

        td {
            padding: 6px;
            border: 1px solid #d1d5db;
        }

        .resultado {
            background: #f0f9ff;
            border: 1px solid #7dd3fc;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 14px;
        }

        .resultado-numero {
            font-size: 26px;
            font-weight: bold;
            color: #0369a1;
        }

        .riesgo {
            font-weight: bold;
            color: #dc2626;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Reporte Check List OCRA</h1>
        <p>Evaluación del riesgo por movimientos repetitivos de extremidades superiores</p>
    </div>

    <div class="section">
        <div class="section-title">Datos generales</div>

        <table>
            <tr>
                <th>Empresa</th>
                <td>{{ $ocra->evaluacion->empresa->nombre ?? 'N/A' }}</td>
                <th>Sucursal</th>
                <td>{{ $ocra->evaluacion->sucursal->nombre ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Puesto</th>
                <td>{{ $ocra->evaluacion->puesto->nombre ?? 'N/A' }}</td>
                <th>Trabajador</th>
                <td>
                    {{ trim(($ocra->evaluacion->trabajador->nombre ?? '') . ' ' . ($ocra->evaluacion->trabajador->apellido_paterno ?? '') . ' ' . ($ocra->evaluacion->trabajador->apellido_materno ?? '')) ?: 'N/A' }}
                </td>
            </tr>
            <tr>
                <th>Fecha</th>
                <td>{{ $ocra->evaluacion->fecha_evaluacion }}</td>
                <th>Lado evaluado</th>
                <td>{{ $ocra->lado_evaluado }}</td>
            </tr>
        </table>
    </div>

    <div class="resultado">
        <div>Índice Check List OCRA</div>
        <div class="resultado-numero">{{ $ocra->ickl }}</div>
        <div>Nivel de riesgo: <span class="riesgo">{{ $ocra->nivel_riesgo }}</span></div>
        <div>Acción recomendada: {{ $ocra->accion_recomendada }}</div>
    </div>

    <div class="section">
        <div class="section-title">Resumen de cálculo</div>

        <table>
            <tr>
                <th>TNTR</th>
                <td>{{ $ocra->tntr }} min</td>
                <th>TNC</th>
                <td>{{ $ocra->tnc }} seg</td>
            </tr>
            <tr>
                <th>FR</th>
                <td>{{ $ocra->fr }}</td>
                <th>FF</th>
                <td>{{ $ocra->ff }}</td>
            </tr>
            <tr>
                <th>FFz</th>
                <td>{{ $ocra->ffz }}</td>
                <th>FP</th>
                <td>{{ $ocra->fp }}</td>
            </tr>
            <tr>
                <th>FC</th>
                <td>{{ $ocra->fc }}</td>
                <th>MD</th>
                <td>{{ $ocra->md }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Detalle de factores evaluados</div>

        <table>
            <thead>
                <tr>
                    <th>Sección</th>
                    <th>Concepto</th>
                    <th>Valor</th>
                    <th>Puntaje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ocra->detalles as $detalle)
                    <tr>
                        <td>{{ $detalle->seccion }}</td>
                        <td>{{ $detalle->concepto }}</td>
                        <td>{{ $detalle->valor }}</td>
                        <td>{{ $detalle->puntaje ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Recomendaciones</div>
        <p>{{ $ocra->recomendaciones }}</p>
    </div>

    @if($ocra->observaciones)
        <div class="section">
            <div class="section-title">Observaciones</div>
            <p>{{ $ocra->observaciones }}</p>
        </div>
    @endif

</body>
</html>