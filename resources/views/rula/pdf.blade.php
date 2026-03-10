<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte RULA</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; }
        .titulo { background: #2e86c1; color: #fff; padding: 12px; font-size: 18px; }
        .subtitulo { margin-top: 20px; margin-bottom: 8px; font-size: 15px; color: #2e86c1; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
        table, th, td { border: 1px solid #ccc; }
        th, td { padding: 8px; }
        th { background: #f2f6fa; }
    </style>
</head>
<body>
    <div class="titulo">REPORTE DE EVALUACIÓN ERGONÓMICA - RULA</div>

    <div class="subtitulo">Información general</div>
    <table>
        <tr><th>ID</th><td>{{ $rula->id }}</td></tr>
        <tr><th>Empresa</th><td>{{ $rula->evaluacion->empresa->nombre ?? 'N/A' }}</td></tr>
        <tr><th>Sucursal</th><td>{{ $rula->evaluacion->sucursal->nombre ?? 'N/A' }}</td></tr>
        <tr><th>Puesto</th><td>{{ $rula->evaluacion->puesto->nombre ?? 'N/A' }}</td></tr>
        <tr><th>Trabajador</th><td>{{ $rula->evaluacion->trabajador->nombre ?? 'N/A' }}</td></tr>
        <tr><th>Fecha</th><td>{{ $rula->evaluacion->fecha_evaluacion ?? 'N/A' }}</td></tr>
        <tr><th>Evaluador</th><td>{{ $rula->evaluacion->usuario->name ?? 'N/A' }}</td></tr>
        <tr><th>Área evaluada</th><td>{{ $rula->evaluacion->area_evaluada ?? 'N/A' }}</td></tr>
        <tr><th>Actividad</th><td>{{ $rula->evaluacion->actividad ?? 'N/A' }}</td></tr>
        <tr><th>Observaciones</th><td>{{ $rula->evaluacion->observaciones ?? 'N/A' }}</td></tr>
    </table>

    <div class="subtitulo">Resultado</div>
    <table>
        <tr><th>Puntuación A</th><td>{{ $rula->puntuacion_a }}</td></tr>
        <tr><th>Puntuación B</th><td>{{ $rula->puntuacion_b }}</td></tr>
        <tr><th>Puntuación C</th><td>{{ $rula->puntuacion_c }}</td></tr>
        <tr><th>Puntuación D</th><td>{{ $rula->puntuacion_d }}</td></tr>
        <tr><th>Puntuación Final</th><td>{{ $rula->puntuacion_final }}</td></tr>
        <tr><th>Nivel de acción</th><td>{{ $rula->nivel_accion }}</td></tr>
        <tr><th>Nivel de riesgo</th><td>{{ $rula->evaluacion->nivel_riesgo }}</td></tr>
        <tr><th>Recomendaciones</th><td>{{ $rula->evaluacion->recomendaciones }}</td></tr>
    </table>

    <div class="subtitulo">Detalle</div>
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
</body>
</html>