<x-app-layout>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1">Resultado de evaluación OWAS #{{ $owas->id }}</h2>
                <p class="text-muted mb-0">Resumen de la evaluación ergonómica realizada con el método OWAS.</p>
            </div>
            <div>
                <a href="{{ route('owas.pdf', $owas->id) }}" class="btn btn-danger">Descargar PDF</a>
                <a href="{{ route('owas.index') }}" class="btn btn-secondary">Volver</a>
            </div>
        </div>

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

            function badgeColor($cat) {
                return match((int)$cat) {
                    1 => 'success',
                    2 => 'warning',
                    3 => 'danger',
                    4 => 'dark',
                    default => 'secondary'
                };
            }
        @endphp

        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-info text-white border-0">
                        <h5 class="mb-0">Información de la evaluación</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm mb-0">
                            <tr><th>Fecha</th><td>{{ $owas->evaluacion->fecha_evaluacion ?? 'N/A' }}</td></tr>
                            <tr><th>Empresa</th><td>{{ $owas->evaluacion->empresa->nombre ?? 'N/A' }}</td></tr>
                            <tr><th>Sucursal</th><td>{{ $owas->evaluacion->sucursal->nombre ?? 'N/A' }}</td></tr>
                            <tr><th>Puesto</th><td>{{ $owas->evaluacion->puesto->nombre ?? 'N/A' }}</td></tr>
                            <tr><th>Trabajador</th><td>{{ $owas->evaluacion->trabajador->nombre ?? 'N/A' }}</td></tr>
                            <tr><th>Evaluador</th><td>{{ $owas->evaluacion->usuario->name ?? 'N/A' }}</td></tr>
                            <tr><th>Área</th><td>{{ $owas->evaluacion->area_evaluada ?? 'N/A' }}</td></tr>
                            <tr><th>Actividad</th><td>{{ $owas->evaluacion->actividad ?? 'N/A' }}</td></tr>
                            <tr><th>Observaciones</th><td>{{ $owas->evaluacion->observaciones ?? 'Sin observaciones' }}</td></tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-primary text-white border-0">
                        <h5 class="mb-0">Resultado de la evaluación</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Código de postura crítica:</strong> {{ $owas->codigo_postura }}</p>
                        <p><strong>Nivel de riesgo global:</strong> {{ $nivelFinal }}</p>
                        <p><strong>Categoría final:</strong>
                            <span class="badge bg-{{ badgeColor($categoriaFinal) }}">
                                {{ $categoriaFinal }}
                            </span>
                        </p>
                        <div class="alert alert-{{ badgeColor($categoriaFinal) === 'dark' ? 'danger' : badgeColor($categoriaFinal) }}">
                            <strong>Acción correctiva:</strong> {{ $owas->accion_correctiva }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-info text-white border-0">
                <h5 class="mb-0">Análisis por parte del cuerpo</h5>
            </div>
            <div class="card-body">
                @foreach($partes as $nombreParte => $grupoParte)
                    <h6 class="mt-2 mb-3 text-uppercase">{{ $nombreParte }}</h6>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
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
                                        <td>
                                            <span class="badge bg-{{ badgeColor($categoria) }}">
                                                {{ $categoria }}
                                            </span>
                                        </td>
                                        <td>{{ $nivel }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-info text-white border-0">
                <h5 class="mb-0">Análisis por posturas</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
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
                                    <td><span class="badge bg-{{ badgeColor($categoria) }}">{{ $categoria }}</span></td>
                                    <td>{{ $nivel }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>