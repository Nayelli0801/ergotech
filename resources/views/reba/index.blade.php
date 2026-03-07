<x-app-layout>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Evaluaciones REBA</h2>
            <a href="{{ route('reba.create') }}" class="btn btn-primary">Nueva evaluación</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Trabajador</th>
                        <th>Puesto</th>
                        <th>Fecha</th>
                        <th>Puntaje final</th>
                        <th>Nivel de riesgo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rebas as $reba)
                        <tr>
                            <td>{{ $reba->id }}</td>
                            <td>{{ $reba->evaluacion->trabajador->nombre ?? 'N/A' }}</td>
                            <td>{{ $reba->evaluacion->puesto->nombre ?? 'N/A' }}</td>
                            <td>{{ $reba->evaluacion->fecha_evaluacion ?? 'N/A' }}</td>
                            <td>{{ $reba->puntuacion_final }}</td>
                            <td>{{ $reba->nivel_riesgo }}</td>
                            <td>
                                <a href="{{ route('reba.show', $reba->id) }}" class="btn btn-sm btn-info">Ver</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No hay evaluaciones registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $rebas->links() }}
    </div>
</x-app-layout>