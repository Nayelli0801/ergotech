<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 space-y-5">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">
            <div>
                <h2 class="text-2xl font-bold text-blue-700">Resultado evaluación REBA</h2>
                <p class="text-sm text-gray-500 mt-1">
                    Resumen y detalle de la evaluación ergonómica registrada con el método REBA.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('reba.pdf', $reba->id) }}"
                   class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg shadow-sm">
                    Descargar PDF
                </a>

                <a href="{{ route('reba.index') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-4 py-2 rounded-lg">
                    Volver
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Empresa</label>
                <div class="text-sm text-gray-700">{{ $reba->evaluacion->empresa->nombre ?? 'N/A' }}</div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Sucursal</label>
                <div class="text-sm text-gray-700">{{ $reba->evaluacion->sucursal->nombre ?? 'N/A' }}</div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Puesto</label>
                <div class="text-sm text-gray-700">{{ $reba->evaluacion->puesto->nombre ?? 'N/A' }}</div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Trabajador</label>
                <div class="text-sm text-gray-700">{{ $reba->evaluacion->trabajador->nombre ?? 'N/A' }}</div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Fecha</label>
                <div class="text-sm text-gray-700">{{ $reba->evaluacion->fecha_evaluacion ?? 'N/A' }}</div>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-slate-50 border rounded-xl p-4">
                <p class="text-xs uppercase tracking-wide text-gray-500">Puntuación A</p>
                <p class="text-2xl font-bold text-slate-700 mt-1">{{ $reba->puntuacion_a }}</p>
            </div>

            <div class="bg-green-50 border rounded-xl p-4">
                <p class="text-xs uppercase tracking-wide text-gray-500">Puntuación B</p>
                <p class="text-2xl font-bold text-green-700 mt-1">{{ $reba->puntuacion_b }}</p>
            </div>

            <div class="bg-yellow-50 border rounded-xl p-4">
                <p class="text-xs uppercase tracking-wide text-gray-500">Puntuación C</p>
                <p class="text-2xl font-bold text-yellow-700 mt-1">{{ $reba->puntuacion_c }}</p>
            </div>

            <div class="bg-purple-50 border rounded-xl p-4">
                <p class="text-xs uppercase tracking-wide text-gray-500">Puntuación final</p>
                <p class="text-2xl font-bold text-purple-700 mt-1">{{ $reba->puntuacion_final }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <div class="rounded-xl border border-amber-200 bg-amber-50 p-4">
                <p class="text-sm text-gray-800">
                    <span class="font-semibold">Nivel de riesgo:</span>
                    {{ $reba->nivel_riesgo }}
                </p>
            </div>

            <div class="rounded-xl border border-red-200 bg-red-50 p-4">
                <p class="text-sm text-gray-800">
                    <span class="font-semibold">Acción requerida:</span>
                    {{ $reba->accion_requerida }}
                </p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="text-lg font-bold text-blue-700">Detalle de la evaluación</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-700">
                        <tr>
                            <th class="px-4 py-3 font-semibold">Sección</th>
                            <th class="px-4 py-3 font-semibold">Concepto</th>
                            <th class="px-4 py-3 font-semibold">Valor</th>
                            <th class="px-4 py-3 font-semibold">Puntaje</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($reba->detalles as $detalle)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $detalle->seccion }}</td>
                                <td class="px-4 py-3">{{ ucfirst(str_replace('_', ' ', $detalle->concepto)) }}</td>
                                <td class="px-4 py-3">{{ $detalle->valor }}</td>
                                <td class="px-4 py-3 font-medium text-gray-800">{{ $detalle->puntaje }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                                    No hay detalles registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>