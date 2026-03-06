<x-app-layout>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-xl font-bold">Evaluaciones</h2>
            <a href="{{ route('evaluaciones.create') }}" class="btn btn-primary">
                Nueva evaluación
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success mb-3">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger mb-3">
                {{ session('error') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Empresa</th>
                        <th>Sucursal</th>
                        <th>Puesto</th>
                        <th>Trabajador</th>
                        <th>Método</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($evaluaciones as $evaluacion)
                        <tr>
                            <td>{{ $evaluacion->id }}</td>
                            <td>{{ $evaluacion->empresa->nombre ?? 'N/A' }}</td>
                            <td>{{ $evaluacion->sucursal->nombre ?? 'N/A' }}</td>
                            <td>{{ $evaluacion->puesto->nombre ?? 'N/A' }}</td>
                            <td>{{ $evaluacion->trabajador->nombre ?? 'N/A' }}</td>
                            <td>{{ $evaluacion->metodo->nombre ?? 'N/A' }}</td>
                            <td>{{ $evaluacion->fecha ?? 'N/A' }}</td>
                            <td>
                                @if(strtoupper($evaluacion->metodo->nombre ?? '') === 'REBA' && $evaluacion->rebaEvaluacion)
                                    <a href="{{ route('reba.show', $evaluacion->rebaEvaluacion->id) }}" class="btn btn-sm btn-info">
                                        Ver REBA
                                    </a>
                                @else
                                    <span class="text-muted">Sin detalle</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No hay evaluaciones registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>