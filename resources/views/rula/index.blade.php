<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 space-y-5">
        <div>
            <h2 class="text-2xl font-bold text-blue-700">Evaluaciones RULA</h2>
            <p class="text-sm text-gray-500 mt-1">
                Consulta las evaluaciones registradas del método RULA.
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
                            <th class="px-4 py-3 font-semibold">Resultado final</th>
                            <th class="px-4 py-3 font-semibold">Nivel acción</th>
                            <th class="px-4 py-3 font-semibold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($rulas as $rula)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-800">{{ $rula->id }}</td>
                                <td class="px-4 py-3">{{ $rula->evaluacion->trabajador->nombre ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $rula->evaluacion->empresa->nombre ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $rula->puntuacion_final }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                                        {{ $rula->nivel_accion }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('rula.show', $rula->id) }}"
                                           class="bg-blue-700 hover:bg-blue-800 text-white text-xs font-semibold px-3 py-2 rounded-lg">
                                            Ver
                                        </a>
                                        <a href="{{ route('rula.pdf', $rula->id) }}"
                                           class="bg-red-600 hover:bg-red-700 text-white text-xs font-semibold px-3 py-2 rounded-lg">
                                            PDF
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                    No hay evaluaciones RULA registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-4 border-t border-gray-100">
                {{ $rulas->links() }}
            </div>
        </div>
    </div>
</x-app-layout>