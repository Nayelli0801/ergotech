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
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $evaluacion->fecha ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-center">
                                        @if(strtoupper($evaluacion->metodo->nombre ?? '') === 'REBA' && $evaluacion->rebaEvaluacion)
                                            <a href="{{ route('reba.show', $evaluacion->rebaEvaluacion->id) }}"
                                               class="inline-block bg-cyan-500 hover:bg-cyan-600 text-white text-sm font-semibold px-3 py-2 rounded-lg">
                                                Ver REBA
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