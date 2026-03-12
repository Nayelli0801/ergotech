<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte NOM-036</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #222;
            margin: 25px;
        }

        h1, h2, h3 {
            margin: 0;
        }

        .titulo {
            text-align: center;
            margin-bottom: 20px;
        }

        .titulo h1 {
            font-size: 20px;
            color: #1d4ed8;
        }

        .titulo p {
            margin-top: 6px;
            font-size: 11px;
            color: #555;
        }

        .bloque {
            margin-bottom: 18px;
        }

        .bloque h3 {
            background: #eaf2ff;
            color: #1d4ed8;
            padding: 8px 10px;
            border: 1px solid #cfe0ff;
            font-size: 13px;
        }

        .contenido {
            border: 1px solid #d9d9d9;
            border-top: none;
            padding: 10px;
        }

        .grid {
            width: 100%;
            border-collapse: collapse;
        }

        .grid td {
            padding: 6px 8px;
            vertical-align: top;
        }

        .etiqueta {
            font-weight: bold;
            width: 180px;
        }

        table.detalle {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        table.detalle th,
        table.detalle td {
            border: 1px solid #cfcfcf;
            padding: 8px;
            font-size: 11px;
        }

        table.detalle th {
            background: #f3f4f6;
            text-align: left;
        }

        .riesgo {
            font-weight: bold;
            color: #b91c1c;
        }

        .footer {
            margin-top: 25px;
            font-size: 10px;
            text-align: right;
            color: #666;
        }
    </style>
</head>
<body>

    <div class="titulo">
        <h1>Reporte de Evaluación NOM-036</h1>
        <p>Factores de riesgo ergonómico por manejo manual de cargas</p>
    </div>

    <div class="bloque">
        <h3>Datos generales</h3>
        <div class="contenido">
            <table class="grid">
                <tr>
                    <td class="etiqueta">Empresa:</td>
                    <td>{{ $nom036->evaluacion->empresa->nombre ?? 'N/A' }}</td>
                    <td class="etiqueta">Sucursal:</td>
                    <td>{{ $nom036->evaluacion->sucursal->nombre ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="etiqueta">Puesto:</td>
                    <td>{{ $nom036->evaluacion->puesto->nombre ?? 'N/A' }}</td>
                    <td class="etiqueta">Trabajador:</td>
                    <td>{{ $nom036->evaluacion->trabajador->nombre ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="etiqueta">Fecha:</td>
                    <td>{{ $nom036->evaluacion->fecha_evaluacion ?? 'N/A' }}</td>
                    <td class="etiqueta">Tipo de actividad:</td>
                    <td>{{ $nom036->tipo_actividad ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="etiqueta">Nivel de riesgo:</td>
                    <td class="riesgo">{{ $nom036->nivel_riesgo ?? 'N/A' }}</td>
                    <td class="etiqueta">Resultado final:</td>
                    <td>{{ $nom036->evaluacion->resultado_final ?? 'N/A' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="bloque">
        <h3>Observaciones</h3>
        <div class="contenido">
            {{ $nom036->observaciones ?? 'Sin observaciones.' }}
        </div>
    </div>

    <div class="bloque">
        <h3>Detalle de factores evaluados</h3>
        <div class="contenido">
            <table class="detalle">
                <thead>
                    <tr>
                        <th>Sección</th>
                        <th>Concepto</th>
                        <th>Valor</th>
                        <th>Resultado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($nom036->detalles as $detalle)
                        <tr>
                            <td>{{ $detalle->seccion }}</td>
                            <td>{{ $detalle->concepto }}</td>
                            <td>{{ $detalle->valor }}</td>
                            <td>{{ $detalle->resultado }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No hay detalles registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="footer">
        Reporte generado por Ergotech
    </div>

</body>
</html>