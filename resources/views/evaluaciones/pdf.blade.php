<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Evaluación #{{ $evaluacion->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111; }
        .header { margin-bottom: 16px; }
        .title { font-size: 18px; font-weight: bold; }
        .subtitle { font-size: 12px; color: #555; }
        .box { border: 1px solid #ddd; padding: 10px; margin-bottom: 12px; border-radius: 6px; }
        .row { display: flex; width: 100%; }
        .col { width: 50%; padding-right: 10px; box-sizing: border-box; }
        .label { font-weight: bold; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f4f6f8; }
        .badge { padding: 4px 8px; border-radius: 6px; color: #fff; font-weight: bold; display: inline-block; }
        .gray { background:#6b7280; }
        .green { background:#22c55e; }
        .yellow { background:#eab308; }
        .orange { background:#f97316; }
        .red { background:#dc2626; }
        .footer { margin-top: 20px; color: #777; font-size: 10px; }
        .mono { font-family: monospace; }
    </style>
</head>
<body>

<div class="header">
    <div class="title">Reporte de Evaluación Ergonómica</div>
    <div class="subtitle">ErgoTech — Evaluación #{{ $evaluacion->id }}</div>
</div>

<div class="box">
    <div class="row">
        <div class="col">
            <div><span class="label">Empresa:</span> {{ $evaluacion->empresa->nombre ?? '-' }}</div>
            <div><span class="label">Método:</span> {{ $evaluacion->metodo }}</div>
            <div><span class="label">Fecha:</span> {{ optional($evaluacion->fecha)->format('d/m/Y') ?? $evaluacion->created_at->format('d/m/Y') }}</div>
        </div>
        <div class="col">
            <div><span class="label">Evaluador:</span> {{ $evaluacion->evaluador->name ?? '-' }}</div>
            <div><span class="label">Registro:</span> {{ $evaluacion->created_at->format('d/m/Y H:i') }}</div>
            <div><span class="label">ID:</span> <span class="mono">#{{ $evaluacion->id }}</span></div>
        </div>
    </div>
</div>

<div class="box">
    <div class="row">
        <div class="col">
            <div class="label">Resultado</div>
            <div style="margin-top:6px;">
                <span class="label">Puntaje total:</span> {{ $evaluacion->puntaje_total ?? '-' }}
            </div>
            <div style="margin-top:6px;">
                <span class="label">Nivel:</span>
                @php($nivel = $evaluacion->nivel_riesgo)
                @if($nivel === 'Riesgo inapreciable')
                    <span class="badge gray">Inapreciable</span>
                @elseif($nivel === 'Riesgo bajo')
                    <span class="badge green">Bajo</span>
                @elseif($nivel === 'Riesgo medio')
                    <span class="badge yellow">Medio</span>
                @elseif($nivel === 'Riesgo alto')
                    <span class="badge orange">Alto</span>
                @elseif($nivel === 'Riesgo muy alto')
                    <span class="badge red">Muy Alto</span>
                @else
                    -
                @endif
            </div>
        </div>

        <div class="col">
            <div class="label">Observaciones</div>
            <div style="margin-top:6px;">
                {{ $evaluacion->observaciones ?? 'Sin observaciones.' }}
            </div>
        </div>
    </div>
</div>

@if($evaluacion->metodo === 'REBA' && $evaluacion->reba)
<div class="box">
    <div class="label">Detalle REBA</div>

    <table>
        <thead>
            <tr>
                <th colspan="2">Grupo A</th>
                <th colspan="2">Grupo B</th>
                <th>Actividad</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Cuello</strong></td>
                <td>{{ $evaluacion->reba->cuello }}</td>
                <td><strong>Brazo</strong></td>
                <td>{{ $evaluacion->reba->brazo }}</td>
                <td rowspan="4">{{ $evaluacion->reba->actividad ?? 0 }}</td>
            </tr>
            <tr>
                <td><strong>Tronco</strong></td>
                <td>{{ $evaluacion->reba->tronco }}</td>
                <td><strong>Antebrazo</strong></td>
                <td>{{ $evaluacion->reba->antebrazo }}</td>
            </tr>
            <tr>
                <td><strong>Piernas</strong></td>
                <td>{{ $evaluacion->reba->piernas }}</td>
                <td><strong>Muñeca</strong></td>
                <td>{{ $evaluacion->reba->muneca }}</td>
            </tr>
            <tr>
                <td><strong>Carga</strong></td>
                <td>{{ $evaluacion->reba->carga ?? 0 }}</td>
                <td><strong>Puntaje B</strong></td>
                <td>{{ $evaluacion->reba->puntaje_b }}</td>
            </tr>
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <th>Puntaje A</th>
                <th>Puntaje B</th>
                <th>Puntaje Final</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $evaluacion->reba->puntaje_a }}</td>
                <td>{{ $evaluacion->reba->puntaje_b }}</td>
                <td>{{ $evaluacion->reba->puntaje_final }}</td>
            </tr>
        </tbody>
    </table>
</div>
@endif

<div class="footer">
    Documento generado automáticamente por ErgoTech el {{ now()->format('d/m/Y H:i') }}.
</div>

</body>
</html>