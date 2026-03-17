<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 space-y-5">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">
            <div>
                <h2 class="text-2xl font-bold text-blue-700">Resultado evaluación NIOSH</h2>
                <p class="text-sm text-gray-500 mt-1">
                    Revisión del cálculo realizado para la evaluación #{{ $niosh->id }}.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('niosh.pdf', $niosh->id) }}"
                   class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg shadow-sm">
                    Descargar PDF
                </a>

                <a href="{{ route('niosh.index') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-4 py-2 rounded-lg">
                    Volver
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Empresa</label>
                <div class="text-sm text-gray-700">{{ $niosh->evaluacion->empresa->nombre ?? 'N/A' }}</div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Sucursal</label>
                <div class="text-sm text-gray-700">{{ $niosh->evaluacion->sucursal->nombre ?? 'N/A' }}</div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Puesto</label>
                <div class="text-sm text-gray-700">{{ $niosh->evaluacion->puesto->nombre ?? 'N/A' }}</div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Trabajador</label>
                <div class="text-sm text-gray-700">{{ $niosh->evaluacion->trabajador->nombre ?? 'N/A' }}</div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Fecha</label>
                <div class="text-sm text-gray-700">{{ $niosh->evaluacion->fecha_evaluacion ?? 'N/A' }}</div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Actividad</label>
                <div class="text-sm text-gray-700">{{ $niosh->evaluacion->actividad ?? 'No especificada' }}</div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <h3 class="text-lg font-bold text-blue-700 mb-4">Resumen de resultados</h3>

            <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-4">
                <div class="bg-slate-50 border rounded-xl p-4">
                    <p class="text-xs uppercase tracking-wide text-gray-500">LC</p>
                    <p class="text-xl font-bold text-slate-700 mt-1">{{ $niosh->constante_carga }}</p>
                </div>

                <div class="bg-slate-50 border rounded-xl p-4">
                    <p class="text-xs uppercase tracking-wide text-gray-500">HM</p>
                    <p class="text-xl font-bold text-slate-700 mt-1">{{ $niosh->hm }}</p>
                </div>

                <div class="bg-slate-50 border rounded-xl p-4">
                    <p class="text-xs uppercase tracking-wide text-gray-500">VM</p>
                    <p class="text-xl font-bold text-slate-700 mt-1">{{ $niosh->vm }}</p>
                </div>

                <div class="bg-slate-50 border rounded-xl p-4">
                    <p class="text-xs uppercase tracking-wide text-gray-500">DM</p>
                    <p class="text-xl font-bold text-slate-700 mt-1">{{ $niosh->dm }}</p>
                </div>

                <div class="bg-slate-50 border rounded-xl p-4">
                    <p class="text-xs uppercase tracking-wide text-gray-500">AM</p>
                    <p class="text-xl font-bold text-slate-700 mt-1">{{ $niosh->am }}</p>
                </div>

                <div class="bg-green-50 border rounded-xl p-4">
                    <p class="text-xs uppercase tracking-wide text-gray-500">FM</p>
                    <p class="text-xl font-bold text-green-700 mt-1">{{ $niosh->fm }}</p>
                </div>

                <div class="bg-green-50 border rounded-xl p-4">
                    <p class="text-xs uppercase tracking-wide text-gray-500">CM</p>
                    <p class="text-xl font-bold text-green-700 mt-1">{{ $niosh->cm }}</p>
                </div>

                <div class="bg-yellow-50 border rounded-xl p-4">
                    <p class="text-xs uppercase tracking-wide text-gray-500">RWL</p>
                    <p class="text-xl font-bold text-yellow-700 mt-1">{{ $niosh->rwl }} kg</p>
                </div>

                <div class="bg-purple-50 border rounded-xl p-4">
                    <p class="text-xs uppercase tracking-wide text-gray-500">Índice de levantamiento</p>
                    <p class="text-xl font-bold text-purple-700 mt-1">{{ $niosh->indice_levantamiento }}</p>
                </div>

                <div class="border rounded-xl p-4
                    @if($niosh->nivel_riesgo === 'Bajo') bg-green-50
                    @elseif($niosh->nivel_riesgo === 'Medio') bg-yellow-50
                    @else bg-red-50 @endif">
                    <p class="text-xs uppercase tracking-wide text-gray-500">Nivel de riesgo</p>
                    <p class="text-xl font-bold mt-1
                        @if($niosh->nivel_riesgo === 'Bajo') text-green-700
                        @elseif($niosh->nivel_riesgo === 'Medio') text-yellow-700
                        @else text-red-700 @endif">
                        {{ $niosh->nivel_riesgo }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="text-lg font-bold text-blue-700">Detalle del cálculo</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-700">
                        <tr>
                            <th class="px-4 py-3 font-semibold">Sección</th>
                            <th class="px-4 py-3 font-semibold">Concepto</th>
                            <th class="px-4 py-3 font-semibold">Valor</th>
                            <th class="px-4 py-3 font-semibold">Resultado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($niosh->detalles as $detalle)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $detalle->seccion }}</td>
                                <td class="px-4 py-3">{{ $detalle->concepto }}</td>
                                <td class="px-4 py-3">{{ $detalle->valor }}</td>
                                <td class="px-4 py-3 font-medium text-gray-800">{{ $detalle->resultado }}</td>
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