<x-app-layout>
    <div class="container py-4">
        <h2 class="mb-4">Evaluaciones RULA</h2>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Trabajador</th>
                            <th>Empresa</th>
                            <th>Resultado final</th>
                            <th>Nivel acción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rulas as $rula)
                            <tr>
                                <td>{{ $rula->id }}</td>
                                <td>{{ $rula->evaluacion->trabajador->nombre ?? 'N/A' }}</td>
                                <td>{{ $rula->evaluacion->empresa->nombre ?? 'N/A' }}</td>
                                <td>{{ $rula->puntuacion_final }}</td>
                                <td>{{ $rula->nivel_accion }}</td>
                                <td>
                                    <a href="{{ route('rula.show', $rula->id) }}" class="btn btn-sm btn-primary">Ver</a>
                                    <a href="{{ route('rula.pdf', $rula->id) }}" class="btn btn-sm btn-danger">PDF</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">No hay evaluaciones RULA registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{ $rulas->links() }}
            </div>
        </div>
    </div>
</x-app-layout>