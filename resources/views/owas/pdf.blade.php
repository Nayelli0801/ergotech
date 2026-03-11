<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte OWAS</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #222; }
        .titulo { background: #29a3e1; color: #fff; padding: 8px 10px; font-size: 16px; font-weight: bold; margin-bottom: 12px; }
        .subtitulo { color: #29a3e1; font-size: 14px; font-weight: bold; margin: 16px 0 8px 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
        th, td { border: 1px solid #cfcfcf; padding: 6px; vertical-align: top; }
        th { background: #29a3e1; color: white; text-align: left; }
        .badge { display: inline-block; padding: 2px 6px; border-radius: 3px; color: white; font-weight: bold; font-size: 10px; }
        .success { background: #16a34a; }
        .warning { background: #ca8a04; }
        .danger { background: #dc2626; }
        .dark { background: #111827; }
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

    <div class="titulo">REPORTE DE EVALUACIÓN ERGONÓMICA - OWAS</div>

    <div class="subtitulo">Información de la evaluación</div>
    <table>
        <tr><td><strong>ID</strong></td><td>{{ $owas->id }}</td></tr>
        <tr><td><strong>Fecha</strong></td><td>{{ $owas->evaluacion->fecha_evaluacion ?? 'N/A' }}</td></tr>
        <tr><td><strong>Empresa</strong></td><td>{{ $owas->evaluacion->empresa->nombre ?? 'N/A' }}</td></tr>
        <tr><td><strong>Sucursal</strong></td><td>{{ $owas->evaluacion->sucursal->nombre ?? 'N/A' }}</td></tr>
        <tr><td><strong>Puesto</strong></td><td>{{ $owas->evaluacion->puesto->nombre ?? 'N/A' }}</td></tr>
        <tr><td><strong>Trabajador</strong></td><td>{{ $owas->evaluacion->trabajador->nombre ?? 'N/A' }}</td></tr>
        <tr><td><strong>Evaluador</strong></td><td>{{ $owas->evaluacion->usuario->name ?? 'N/A' }}</td></tr>
        <tr><td><strong>Área</strong></td><td>{{ $owas->evaluacion->area_evaluada ?? 'N/A' }}</td></tr>
        <tr><td><strong>Actividad</strong></td><td>{{ $owas->evaluacion->actividad ?? 'N/A' }}</td></tr>
        <tr><td><strong>Observaciones</strong></td><td>{{ $owas->evaluacion->observaciones ?? 'Sin observaciones' }}</td></tr>
    </table>

    <div class="subtitulo">Resultado de la evaluación</div>
    <table>
        <tr><td><strong>Código de postura crítica</strong></td><td>{{ $owas->codigo_postura }}</td></tr>
        <tr><td><strong>Categoría final</strong></td><td><span class="badge {{ badgeColorPdf($categoriaFinal) }}">{{ $categoriaFinal }}</span></td></tr>
        <tr><td><strong>Nivel de riesgo</strong></td><td>{{ $nivelFinal }}</td></tr>
        <tr><td><strong>Acción correctiva</strong></td><td>{{ $owas->accion_correctiva }}</td></tr>
    </table>

    <div class="subtitulo">Análisis por parte del cuerpo</div>
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

    <div class="subtitulo">Análisis por posturas</div>
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