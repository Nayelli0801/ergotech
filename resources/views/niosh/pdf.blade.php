<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte NIOSH</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #222;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .title {
            font-size: 20px;
            font-weight: bold;
            color: #1d4ed8;
        }
        .subtitle {
            font-size: 12px;
            color: #555;
            margin-top: 4px;
        }
        .section {
            margin-bottom: 18px;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #1d4ed8;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #d1d5db;
            padding: 7px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background: #f3f4f6;
        }
        .result-box {
            width: 18%;
            display: inline-block;
            border: 1px solid #d1d5db;
            padding: 10px;
            margin: 0 1% 10px 0;
            box-sizing: border-box;
        }
        .label {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
        }
        .value {
            font-size: 16px;
            font-weight: bold;
            margin-top: 4px;
        }
        .risk-low {
            background: #dcfce7;
        }
        .risk-medium {
            background: #fef3c7;
        }
        .risk-high {
            background: #fee2e2;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Reporte de Evaluación NIOSH</div>
        <div class="subtitle">Evaluación #{{ $niosh->id }}</div>
    </div>

    <div class="section">
        <div class="section-title">Datos generales</div>
        <table>
            <tr>
                <th>Empresa</th>
                <td>{{ $niosh->evaluacion->empresa->nombre ?? 'N/A' }}</td>
                <th>Sucursal</th>
                <td>{{ $niosh->evaluacion->sucursal->nombre ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Puesto</th>
                <td>{{ $niosh->evaluacion->puesto->nombre ?? 'N/A' }}</td>
                <th>Trabajador</th>
                <td>{{ $niosh->evaluacion->trabajador->nombre ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Fecha</th>
                <td>{{ $niosh->evaluacion->fecha_evaluacion ?? 'N/A' }}</td>
                <th>Actividad</th>
                <td>{{ $niosh->evaluacion->actividad ?? 'No especificada' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Resumen de resultados</div>

        <div class="result-box">
            <div class="label">LC</div>
            <div class="value">{{ $niosh->constante_carga }}</div>
        </div>

        <div class="result-box">
            <div class="label">HM</div>
            <div class="value">{{ $niosh->hm }}</div>
        </div>

        <div class="result-box">
            <div class="label">VM</div>
            <div class="value">{{ $niosh->vm }}</div>
        </div>

        <div class="result-box">
            <div class="label">DM</div>
            <div class="value">{{ $niosh->dm }}</div>
        </div>

        <div class="result-box">
            <div class="label">AM</div>
            <div class="value">{{ $niosh->am }}</div>
        </div>

        <div class="result-box">
            <div class="label">FM</div>
            <div class="value">{{ $niosh->fm }}</div>
        </div>

        <div class="result-box">
            <div class="label">CM</div>
            <div class="value">{{ $niosh->cm }}</div>
        </div>

        <div class="result-box">
            <div class="label">RWL</div>
            <div class="value">{{ $niosh->rwl }} kg</div>
        </div>

        <div class="result-box">
            <div class="label">Índice</div>
            <div class="value">{{ $niosh->indice_levantamiento }}</div>
        </div>

        <div class="result-box
            @if($niosh->nivel_riesgo === 'Bajo') risk-low
            @elseif($niosh->nivel_riesgo === 'Medio') risk-medium
            @else risk-high
            @endif">
            <div class="label">Riesgo</div>
            <div class="value">{{ $niosh->nivel_riesgo }}</div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Detalle del cálculo</div>
        <table>
            <thead>
                <tr>
                    <th>Sección</th>
                    <th>Concepto</th>
                    <th>Valor</th>
                    <th>Resultado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($niosh->detalles as $detalle)
                    <tr>
                        <td>{{ $detalle->seccion }}</td>
                        <td>{{ $detalle->concepto }}</td>
                        <td>{{ $detalle->valor }}</td>
                        <td>{{ $detalle->resultado }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>