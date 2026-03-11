<x-app-layout>
    <div class="container py-4">
        <h2 class="mb-4">Evaluaciones OWAS</h2>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Trabajador</th>
                        <th>Empresa</th>
                        <th>Fecha</th>
                        <th>Categoría</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($owas as $item)
                        <tr>
                            <td>
                                <a href="{{ route('owas.show', $item->id) }}">{{ $item->id }}</a>
                            </td>
                            <td>{{ $item->evaluacion->trabajador->nombre ?? 'N/A' }}</td>
                            <td>{{ $item->evaluacion->empresa->nombre ?? 'N/A' }}</td>
                            <td>{{ $item->evaluacion->fecha_evaluacion ?? 'N/A' }}</td>
                            <td>{{ $item->categoria_riesgo }}</td>
                            <td>{{ $item->accion_correctiva }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No hay evaluaciones OWAS registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $owas->links() }}
    </div>
</x-app-layout>