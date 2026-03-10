<x-app-layout>
    <div class="container py-4">
        <h2 class="mb-4">Resultado Evaluación RULA #{{ $rula->id }}</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card mb-4">
            <div class="card-body">
                <p><strong>Empresa:</strong> {{ $rula->evaluacion->empresa->nombre ?? 'N/A' }}</p>
                <p><strong>Sucursal:</strong> {{ $rula->evaluacion->sucursal->nombre ?? 'N/A' }}</p>
                <p><strong>Puesto:</strong> {{ $rula->evaluacion->puesto->nombre ?? 'N/A' }}</p>
                <p><strong>Trabajador:</strong> {{ $rula->evaluacion->trabajador->nombre ?? 'N/A' }}</p>
                <p><strong>Fecha:</strong> {{ $rula->evaluacion->fecha_evaluacion ?? 'N/A' }}</p>
                <p><strong>Evaluador:</strong> {{ $rula->evaluacion->usuario->name ?? 'N/A' }}</p>
            </div>
        </div>

        <div class="row mb-4 text-center">
            <div class="col-md-2"><div class="card"><div class="card-body"><strong>A</strong><br>{{ $rula->puntuacion_a }}</div></div></div>
            <div class="col-md-2"><div class="card"><div class="card-body"><strong>B</strong><br>{{ $rula->puntuacion_b }}</div></div></div>
            <div class="col-md-2"><div class="card"><div class="card-body"><strong>C</strong><br>{{ $rula->puntuacion_c }}</div></div></div>
            <div class="col-md-2"><div class="card"><div class="card-body"><strong>D</strong><br>{{ $rula->puntuacion_d }}</div></div></div>
            <div class="col-md-2"><div class="card"><div class="card-body"><strong>Final</strong><br>{{ $rula->puntuacion_final }}</div></div></div>
            <div class="col-md-2"><div class="card"><div class="card-body"><strong>Nivel</strong><br>{{ $rula->nivel_accion }}</div></div></div>
        </div>

        <div class="card mb-4">
            <div class="card-header"><strong>Detalle de la evaluación</strong></div>
            <div class="card-body">
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
            </div>
        </div>

        <a href="{{ route('rula.pdf', $rula->id) }}" class="btn btn-danger">Descargar PDF</a>
    </div>
</x-app-layout>