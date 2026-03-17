<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-6">
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-200">
            <div class="bg-blue-700 text-white px-6 py-4 flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold">Evaluaciones</h2>
                    <p class="text-sm text-blue-100 mt-1">Listado general de evaluaciones registradas.</p>
                </div>

                <a href="{{ route('evaluaciones.create') }}"
                   class="bg-white text-blue-700 hover:bg-blue-50 font-semibold px-4 py-2 rounded-lg shadow">
                    Nueva evaluación
                </a>
            </div>

            <div class="p-6">
                @if(session('success'))
                    <div class="mb-4 rounded-lg bg-green-100 border border-green-300 text-green-700 px-4 py-3">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 rounded-lg bg-red-100 border border-red-300 text-red-700 px-4 py-3">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">ID</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Empresa</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Sucursal</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Puesto</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Trabajador</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Método</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Fecha</th>
                                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($evaluaciones as $evaluacion)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $evaluacion->id }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $evaluacion->empresa->nombre ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $evaluacion->sucursal->nombre ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $evaluacion->puesto->nombre ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">
                                        {{ trim(($evaluacion->trabajador->nombre ?? '') . ' ' . ($evaluacion->trabajador->apellido_paterno ?? '') . ' ' . ($evaluacion->trabajador->apellido_materno ?? '')) ?: 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $evaluacion->metodo->nombre ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $evaluacion->fecha_evaluacion ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-center">
                                        @php
                                            $metodo = strtoupper($evaluacion->metodo->nombre ?? '');
                                        @endphp

                                        @if($metodo === 'REBA' && $evaluacion->rebaEvaluacion)
                                            <a href="{{ route('reba.show', $evaluacion->rebaEvaluacion->id) }}"
                                               class="inline-block bg-cyan-500 hover:bg-cyan-600 text-white text-sm font-semibold px-3 py-2 rounded-lg">
                                                Ver REBA
                                            </a>

                                        @elseif($metodo === 'RULA' && $evaluacion->rulaEvaluacion)
                                            <a href="{{ route('rula.show', $evaluacion->rulaEvaluacion->id) }}"
                                               class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-3 py-2 rounded-lg">
                                                Ver RULA
                                            </a>

                                        @elseif($metodo === 'OWAS' && $evaluacion->owasEvaluacion)
                                            <a href="{{ route('owas.show', $evaluacion->owasEvaluacion->id) }}"
                                               class="inline-block bg-purple-600 hover:bg-purple-700 text-white text-sm font-semibold px-3 py-2 rounded-lg">
                                                Ver OWAS
                                            </a>

                                        @elseif($metodo === 'NIOSH' && $evaluacion->nioshEvaluacion)
                                            <a href="{{ route('niosh.show', $evaluacion->nioshEvaluacion->id) }}"
                                               class="inline-block bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold px-3 py-2 rounded-lg">
                                                Ver NIOSH
                                            </a>

                                        @elseif(($metodo === 'NOM-036' || $metodo === 'NOM036' || $metodo === 'NOM 036') && $evaluacion->nom036)
                                            <a href="{{ route('nom036.show', $evaluacion->nom036->id) }}"
                                               class="inline-block bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold px-3 py-2 rounded-lg">
                                                Ver NOM-036
                                            </a>

                                        @else
                                            <span class="text-gray-400 text-sm">Sin detalle</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-6 text-center text-gray-500">
                                        No hay evaluaciones registradas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>