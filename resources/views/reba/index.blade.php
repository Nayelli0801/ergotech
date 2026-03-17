<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-2xl font-bold text-blue-700">Evaluaciones REBA</h2>
                <p class="text-sm text-gray-500 mt-1">
                    Consulta los resultados registrados del método REBA.
                </p>
            </div>
        </div>

        @if(session('success'))
            <div class="rounded-lg bg-green-50 border border-green-200 text-green-700 px-4 py-3 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-700">
                        <tr>
                            <th class="px-4 py-3 font-semibold">ID</th>
                            <th class="px-4 py-3 font-semibold">Trabajador</th>
                            <th class="px-4 py-3 font-semibold">Puesto</th>
                            <th class="px-4 py-3 font-semibold">Fecha</th>
                            <th class="px-4 py-3 font-semibold">Puntaje final</th>
                            <th class="px-4 py-3 font-semibold">Nivel de riesgo</th>
                            <th class="px-4 py-3 font-semibold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($rebas as $reba)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-800">{{ $reba->id }}</td>
                                <td class="px-4 py-3">{{ $reba->evaluacion->trabajador->nombre ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $reba->evaluacion->puesto->nombre ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $reba->evaluacion->fecha_evaluacion ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $reba->puntuacion_final }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                        {{ $reba->nivel_riesgo }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('reba.show', $reba->id) }}"
                                       class="bg-blue-700 hover:bg-blue-800 text-white text-xs font-semibold px-3 py-2 rounded-lg">
                                        Ver
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                                    No hay evaluaciones registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-4 border-t border-gray-100">
                {{ $rebas->links() }}
            </div>
        </div>
    </div>
</x-app-layout>