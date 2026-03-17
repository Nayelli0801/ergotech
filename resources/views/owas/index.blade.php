<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 space-y-5">
        <div>
            <h2 class="text-2xl font-bold text-blue-700">Evaluaciones OWAS</h2>
            <p class="text-sm text-gray-500 mt-1">
                Consulta las evaluaciones registradas del método OWAS.
            </p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-700">
                        <tr>
                            <th class="px-4 py-3 font-semibold">ID</th>
                            <th class="px-4 py-3 font-semibold">Trabajador</th>
                            <th class="px-4 py-3 font-semibold">Empresa</th>
                            <th class="px-4 py-3 font-semibold">Fecha</th>
                            <th class="px-4 py-3 font-semibold">Categoría</th>
                            <th class="px-4 py-3 font-semibold">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($owas as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium text-blue-700">
                                    <a href="{{ route('owas.show', $item->id) }}" class="hover:underline">
                                        {{ $item->id }}
                                    </a>
                                </td>
                                <td class="px-4 py-3">{{ $item->evaluacion->trabajador->nombre ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $item->evaluacion->empresa->nombre ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $item->evaluacion->fecha_evaluacion ?? 'N/A' }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700">
                                        {{ $item->categoria_riesgo }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">{{ $item->accion_correctiva }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                    No hay evaluaciones OWAS registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-4 border-t border-gray-100">
                {{ $owas->links() }}
            </div>
        </div>
    </div>
</x-app-layout>