<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte NIOSH</title>
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
        .card { width: 25%; border: 1px solid #dbeafe; background: #f8fbff; padding: 10px; text-align: center; }
        .card .title { font-size: 10px; color: #6b7280; text-transform: uppercase; margin-bottom: 4px; }
        .card .value { font-size: 18px; font-weight: bold; color: #1d4ed8; }
        .summary { border: 1px solid #d1d5db; background: #f8fafc; padding: 12px; margin-top: 10px; }
        .summary p { margin: 4px 0; }
        .risk-low { background: #dcfce7; border: 1px solid #86efac; }
        .risk-medium { background: #fef3c7; border: 1px solid #fcd34d; }
        .risk-high { background: #fee2e2; border: 1px solid #fca5a5; }
        .muted { color: #6b7280; }
        .footer { margin-top: 20px; font-size: 10px; color: #6b7280; text-align: right; }
    </style>
</head>
<body>
    @php
        $riesgoClase = match(strtolower($niosh->nivel_riesgo ?? '')) {
            'bajo' => 'risk-low',
            'medio' => 'risk-medium',
            'alto' => 'risk-high',
            default => ''
        };
    @endphp

    <div class="header">
        <h1>Reporte de Evaluación NIOSH</h1>
        <p>Resultado ergonómico generado por ErgoTech</p>
    </div>

    <div class="section">
        <div class="section-title">Datos generales</div>
        <table class="grid">
            <tr>
                <th>ID</th>
                <td>{{ $niosh->id }}</td>
                <th>Fecha</th>
                <td>{{ $niosh->evaluacion->fecha_evaluacion ?? 'N/A' }}</td>
            </tr>
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
                <td>{{ trim(($niosh->evaluacion->trabajador->nombre ?? '') . ' ' . ($niosh->evaluacion->trabajador->apellido_paterno ?? '') . ' ' . ($niosh->evaluacion->trabajador->apellido_materno ?? '')) ?: 'N/A' }}</td>
            </tr>
            <tr>
                <th>Evaluador</th>
                <td>{{ $niosh->evaluacion->usuario->name ?? 'N/A' }}</td>
                <th>Área evaluada</th>
                <td>{{ $niosh->evaluacion->area_evaluada ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Actividad</th>
                <td>{{ $niosh->evaluacion->actividad ?? 'Sin actividad registrada' }}</td>
                <th>Observaciones</th>
                <td>{{ $niosh->evaluacion->observaciones ?? 'Sin observaciones' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Parámetros de entrada</div>
        <table class="grid">
            <tr>
                <th>Distancia horizontal</th>
                <td>{{ $niosh->distancia_horizontal }} cm</td>
                <th>Altura inicial</th>
                <td>{{ $niosh->altura_inicial }} cm</td>
            </tr>
            <tr>
                <th>Desplazamiento vertical</th>
                <td>{{ $niosh->desplazamiento_vertical }} cm</td>
                <th>Ángulo de asimetría</th>
                <td>{{ $niosh->angulo_asimetria }}°</td>
            </tr>
            <tr>
                <th>Frecuencia de levantamiento</th>
                <td>{{ $niosh->frecuencia_levantamiento }}</td>
                <th>Duración</th>
                <td>{{ $niosh->duracion }}</td>
            </tr>
            <tr>
                <th>Calidad de agarre</th>
                <td>{{ $niosh->calidad_agarre }}</td>
                <th>Peso del objeto</th>
                <td>{{ $niosh->peso_objeto }} kg</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Resultados del cálculo</div>

        <table class="cards">
            <tr>
                <td class="card"><div class="title">LC</div><div class="value">{{ $niosh->constante_carga }}</div></td>
                <td class="card"><div class="title">HM</div><div class="value">{{ $niosh->hm }}</div></td>
                <td class="card"><div class="title">VM</div><div class="value">{{ $niosh->vm }}</div></td>
                <td class="card"><div class="title">DM</div><div class="value">{{ $niosh->dm }}</div></td>
            </tr>
            <tr>
                <td class="card"><div class="title">AM</div><div class="value">{{ $niosh->am }}</div></td>
                <td class="card"><div class="title">FM</div><div class="value">{{ $niosh->fm }}</div></td>
                <td class="card"><div class="title">CM</div><div class="value">{{ $niosh->cm }}</div></td>
                <td class="card"><div class="title">RWL</div><div class="value">{{ $niosh->rwl }} kg</div></td>
            </tr>
        </table>

        <div class="summary {{ $riesgoClase }}">
            <p><strong>Índice de levantamiento:</strong> {{ $niosh->indice_levantamiento }}</p>
            <p><strong>Nivel de riesgo:</strong> {{ $niosh->nivel_riesgo }}</p>
            <p><strong>Interpretación:</strong>
                @if(($niosh->indice_levantamiento ?? 0) <= 1)
                    La tarea evaluada se encuentra dentro del límite recomendado.
                @elseif(($niosh->indice_levantamiento ?? 0) <= 3)
                    La tarea presenta riesgo ergonómico moderado y requiere revisión.
                @else
                    La tarea presenta riesgo ergonómico alto y requiere intervención inmediata.
                @endif
            </p>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Detalle del cálculo</div>
        <table class="detail">
            <thead>
                <tr>
                    <th>Sección</th>
                    <th>Concepto</th>
                    <th>Valor</th>
                    <th>Resultado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($niosh->detalles as $detalle)
                    <tr>
                        <td>{{ $detalle->seccion }}</td>
                        <td>{{ $detalle->concepto }}</td>
                        <td>{{ $detalle->valor }}</td>
                        <td>{{ $detalle->resultado ?? '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="muted">No se registraron detalles para esta evaluación.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="footer">Reporte generado por ErgoTech</div>
</body>
</html>