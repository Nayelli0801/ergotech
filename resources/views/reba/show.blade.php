<x-app-layout>
    <div class="container py-4">
        <h2 class="mb-4">Resultado Evaluación REBA #{{ $reba->id }}</h2>

        <div class="card mb-4">
            <div class="card-body">
                <p><strong>Empresa:</strong> {{ $reba->evaluacion->empresa->nombre ?? 'N/A' }}</p>
                <p><strong>Sucursal:</strong> {{ $reba->evaluacion->sucursal->nombre ?? 'N/A' }}</p>
                <p><strong>Puesto:</strong> {{ $reba->evaluacion->puesto->nombre ?? 'N/A' }}</p>
                <p><strong>Trabajador:</strong> {{ $reba->evaluacion->trabajador->nombre ?? 'N/A' }}</p>
                <p><strong>Fecha:</strong> {{ $reba->evaluacion->fecha_evaluacion ?? 'N/A' }}</p>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <strong>Puntuación A:</strong> {{ $reba->puntuacion_a }}
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <strong>Puntuación B:</strong> {{ $reba->puntuacion_b }}
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <strong>Puntuación C:</strong> {{ $reba->puntuacion_c }}
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <strong>Puntuación Final:</strong> {{ $reba->puntuacion_final }}
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-warning">
            <strong>Nivel de riesgo:</strong> {{ $reba->nivel_riesgo }} <br>
            <strong>Acción requerida:</strong> {{ $reba->accion_requerida }}
        </div>

        <h4>Detalle</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sección</th>
                    <th>Concepto</th>
                    <th>Valor</th>
                    <th>Puntaje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reba->detalles as $detalle)
                    <tr>
                        <td>{{ $detalle->seccion }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $detalle->concepto)) }}</td>
                        <td>{{ $detalle->valor }}</td>
                        <td>{{ $detalle->puntaje }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4 d-flex gap-2">
            <a href="{{ route('reba.pdf', $reba->id) }}" class="btn btn-danger">
                Descargar PDF
            </a>

            <a href="{{ route('reba.index') }}" class="btn btn-secondary">
                Volver
            </a>
        </div>
    </div>
</x-app-layout>