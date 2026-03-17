<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte OWAS</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #1f2937;
            margin: 24px;
        }

        .header {
            border-bottom: 3px solid #1d4ed8;
            padding-bottom: 10px;
            margin-bottom: 18px;
        }

        .header h1 {
            margin: 0;
            color: #1d4ed8;
            font-size: 21px;
        }

        .header p {
            margin: 5px 0 0 0;
            color: #6b7280;
            font-size: 11px;
        }

        .section-title {
            background: #eff6ff;
            color: #1d4ed8;
            padding: 8px 10px;
            font-weight: bold;
            border: 1px solid #bfdbfe;
            margin: 16px 0 8px 0;
            font-size: 13px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        th, td {
            border: 1px solid #d1d5db;
            padding: 6px;
            vertical-align: top;
            text-align: left;
        }

        th {
            background: #f3f4f6;
        }

        .badge {
            display: inline-block;
            padding: 3px 7px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 10px;
        }

        .success { background: #dcfce7; color: #166534; }
        .warning { background: #fef3c7; color: #92400e; }
        .danger  { background: #fee2e2; color: #991b1b; }
        .dark    { background: #1f2937; color: #ffffff; }

        .summary-box {
            border: 1px solid #dbeafe;
            background: #f8fbff;
            padding: 10px;
            margin-top: 8px;
        }

        .summary-box p {
            margin: 4px 0;
        }
    </style>
</head>
<body>
    @php
        $detalles = $owas->detalles;

        $posturas = $detalles->filter(fn($d) => str_starts_with($d->seccion, 'POSTURA_'))
            ->groupBy('seccion')
            ->sortKeys();

        $partes = [
            'espalda' => $detalles->where('seccion', 'PARTE_ESPALDA')->groupBy(function ($item) {
                return explode('_', $item->concepto)[1] ?? null;
            }),
            'brazos' => $detalles->where('seccion', 'PARTE_BRAZOS')->groupBy(function ($item) {
                return explode('_', $item->concepto)[1] ?? null;
            }),
            'piernas' => $detalles->where('seccion', 'PARTE_PIERNAS')->groupBy(function ($item) {
                return explode('_', $item->concepto)[1] ?? null;
            }),
        ];

        $categoriaFinal = optional($detalles->firstWhere('concepto', 'categoria_final'))->puntaje ?? 1;
        $nivelFinal = optional($detalles->firstWhere('concepto', 'categoria_final'))->valor ?? 'No definido';

        function badgeColorPdf($cat) {
            return match((int)$cat) {
                1 => 'success',
                2 => 'warning',
                3 => 'danger',
                4 => 'dark',
                default => 'success'
            };
        }
    @endphp

    <div class="header">
        <h1>Reporte de Evaluación OWAS</h1>
        <p>Resultado ergonómico generado por ErgoTech</p>
    </div>

    <div class="section-title">Información de la evaluación</div>
    <table>
        <tr><th>ID</th><td>{{ $owas->id }}</td><th>Fecha</th><td>{{ $owas->evaluacion->fecha_evaluacion ?? 'N/A' }}</td></tr>
        <tr><th>Empresa</th><td>{{ $owas->evaluacion->empresa->nombre ?? 'N/A' }}</td><th>Sucursal</th><td>{{ $owas->evaluacion->sucursal->nombre ?? 'N/A' }}</td></tr>
        <tr><th>Puesto</th><td>{{ $owas->evaluacion->puesto->nombre ?? 'N/A' }}</td><th>Trabajador</th><td>{{ $owas->evaluacion->trabajador->nombre ?? 'N/A' }}</td></tr>
        <tr><th>Evaluador</th><td>{{ $owas->evaluacion->usuario->name ?? 'N/A' }}</td><th>Área</th><td>{{ $owas->evaluacion->area_evaluada ?? 'N/A' }}</td></tr>
        <tr><th>Actividad</th><td>{{ $owas->evaluacion->actividad ?? 'N/A' }}</td><th>Observaciones</th><td>{{ $owas->evaluacion->observaciones ?? 'Sin observaciones' }}</td></tr>
    </table>

    <div class="section-title">Resultado de la evaluación</div>
    <div class="summary-box">
        <p><strong>Código de postura crítica:</strong> {{ $owas->codigo_postura }}</p>
        <p><strong>Categoría final:</strong> <span class="badge {{ badgeColorPdf($categoriaFinal) }}">{{ $categoriaFinal }}</span></p>
        <p><strong>Nivel de riesgo:</strong> {{ $nivelFinal }}</p>
        <p><strong>Acción correctiva:</strong> {{ $owas->accion_correctiva }}</p>
    </div>

    <div class="section-title">Análisis por parte del cuerpo</div>
    @foreach($partes as $nombreParte => $grupoParte)
        <table>
            <thead>
                <tr>
                    <th colspan="6">{{ strtoupper($nombreParte) }}</th>
                </tr>
                <tr>
                    <th>Código</th>
                    <th>Descripción</th>
                    <th>Frecuencia</th>
                    <th>Porcentaje</th>
                    <th>Categoría</th>
                    <th>Nivel</th>
                </tr>
            </thead>
            <tbody>
                @foreach($grupoParte as $codigo => $items)
                    @php
                        $descripcion = optional($items->firstWhere('concepto', 'codigo_'.$codigo.'_descripcion'))->valor;
                        $frecuencia = optional($items->firstWhere('concepto', 'codigo_'.$codigo.'_frecuencia'))->puntaje;
                        $porcentaje = optional($items->firstWhere('concepto', 'codigo_'.$codigo.'_porcentaje'))->puntaje;
                        $categoria = optional($items->firstWhere('concepto', 'codigo_'.$codigo.'_categoria'))->puntaje;
                        $nivel = optional($items->firstWhere('concepto', 'codigo_'.$codigo.'_categoria'))->valor;
                    @endphp
                    <tr>
                        <td>{{ $codigo }}</td>
                        <td>{{ $descripcion }}</td>
                        <td>{{ $frecuencia }}</td>
                        <td>{{ $porcentaje }}%</td>
                        <td>{{ $categoria }}</td>
                        <td>{{ $nivel }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

    <div class="section-title">Análisis por posturas</div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Espalda</th>
                <th>Brazos</th>
                <th>Piernas</th>
                <th>Carga</th>
                <th>Frecuencia</th>
                <th>%</th>
                <th>Código</th>
                <th>Categoría</th>
                <th>Nivel</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posturas as $seccion => $grupo)
                @php
                    $espalda = optional($grupo->firstWhere('concepto', 'espalda'))->valor;
                    $brazos = optional($grupo->firstWhere('concepto', 'brazos'))->valor;
                    $piernas = optional($grupo->firstWhere('concepto', 'piernas'))->valor;
                    $carga = optional($grupo->firstWhere('concepto', 'carga'))->valor;
                    $frecuencia = optional($grupo->firstWhere('concepto', 'frecuencia'))->puntaje;
                    $porcentaje = optional($grupo->firstWhere('concepto', 'porcentaje'))->puntaje;
                    $codigo = optional($grupo->firstWhere('concepto', 'codigo_postura'))->valor;
                    $categoria = optional($grupo->firstWhere('concepto', 'categoria_riesgo'))->puntaje;
                    $nivel = optional($grupo->firstWhere('concepto', 'categoria_riesgo'))->valor;
                @endphp
                <tr>
                    <td>{{ str_replace('POSTURA_', '', $seccion) }}</td>
                    <td>{{ $espalda }}</td>
                    <td>{{ $brazos }}</td>
                    <td>{{ $piernas }}</td>
                    <td>{{ $carga }}</td>
                    <td>{{ $frecuencia }}</td>
                    <td>{{ $porcentaje }}%</td>
                    <td>{{ $codigo }}</td>
                    <td>{{ $categoria }}</td>
                    <td>{{ $nivel }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>