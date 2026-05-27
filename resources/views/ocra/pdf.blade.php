<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte OCRA</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #1f2937;
            margin: 25px;
        }

        .header {
            background: #0284c7;
            color: white;
            padding: 18px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
        }

        .header p {
            margin: 4px 0 0;
            font-size: 12px;
        }

        .section {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            margin-bottom: 16px;
            padding: 12px;
        }

        .section-title {
            font-size: 15px;
            font-weight: bold;
            color: #0369a1;
            margin-bottom: 8px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        th {
            background: #f3f4f6;
            text-align: left;
            padding: 7px;
            border: 1px solid #d1d5db;
        }

        td {
            padding: 7px;
            border: 1px solid #d1d5db;
        }

        .resultado {
            background: #f0f9ff;
            border: 1px solid #7dd3fc;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 16px;
        }

        .resultado-numero {
            font-size: 28px;
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
        <h1>Reporte de Evaluación OCRA</h1>
        <p>Evaluación del riesgo por movimientos repetitivos de extremidades superiores</p>
    </div>

    <div class="section">
        <div class="section-title">Datos generales</div>

        <table>
            <tr>
                <th>Empresa</th>
                <td>{{ $ocra->evaluacion->empresa->nombre ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Sucursal</th>
                <td>{{ $ocra->evaluacion->sucursal->nombre ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Puesto</th>
                <td>{{ $ocra->evaluacion->puesto->nombre ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Trabajador</th>
                <td>{{ $ocra->evaluacion->trabajador->nombre ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Fecha</th>
                <td>{{ $ocra->evaluacion->fecha_evaluacion }}</td>
            </tr>
            <tr>
                <th>Lado evaluado</th>
                <td>{{ $ocra->lado_evaluado }}</td>
            </tr>
        </table>
    </div>

    <div class="resultado">
        <div>Índice OCRA</div>
        <div class="resultado-numero">{{ $ocra->indice_ocra }}</div>
        <div>Nivel de riesgo: <span class="riesgo">{{ $ocra->nivel_riesgo }}</span></div>
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