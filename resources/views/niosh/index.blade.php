<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-2xl font-bold text-blue-700">Evaluaciones NIOSH</h2>
                <p class="text-sm text-gray-500 mt-1">
                    Consulta las evaluaciones registradas del método NIOSH.
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
                            <th class="px-4 py-3 font-semibold">Empresa</th>
                            <th class="px-4 py-3 font-semibold">Fecha</th>
                            <th class="px-4 py-3 font-semibold">RWL</th>
                            <th class="px-4 py-3 font-semibold">Índice</th>
                            <th class="px-4 py-3 font-semibold">Riesgo</th>
                            <th class="px-4 py-3 font-semibold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($nioshEvaluaciones as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-800">{{ $item->id }}</td>
                                <td class="px-4 py-3">{{ $item->evaluacion->trabajador->nombre ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $item->evaluacion->empresa->nombre ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $item->evaluacion->fecha_evaluacion ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $item->rwl }} kg</td>
                                <td class="px-4 py-3">{{ $item->indice_levantamiento }}</td>
                                <td class="px-4 py-3">
                                    @if($item->nivel_riesgo === 'Bajo')
                                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                            {{ $item->nivel_riesgo }}
                                        </span>
                                    @elseif($item->nivel_riesgo === 'Medio')
                                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                                            {{ $item->nivel_riesgo }}
                                        </span>
                                    @else
                                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                            {{ $item->nivel_riesgo }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('niosh.show', $item->id) }}"
                                           class="bg-blue-700 hover:bg-blue-800 text-white text-xs font-semibold px-3 py-2 rounded-lg">
                                            Ver
                                        </a>
                                        <a href="{{ route('niosh.pdf', $item->id) }}"
                                           class="bg-red-600 hover:bg-red-700 text-white text-xs font-semibold px-3 py-2 rounded-lg">
                                            PDF
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-6 text-center text-gray-500">
                                    No hay evaluaciones NIOSH registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-4 border-t border-gray-100">
                {{ $nioshEvaluaciones->links() }}
            </div>
        </div>
    </div>
</x-app-layout>