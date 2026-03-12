<x-app-layout>
    <div class="max-w-6xl mx-auto py-6 px-4 sm:px-6">
        <div class="mb-5">
            <h2 class="text-2xl font-bold text-blue-700">Resultado NOM-036 #{{ $nom036->id }}</h2>
        </div>

        @if(session('success'))
            <div class="mb-4 rounded-lg bg-green-50 border border-green-200 text-green-700 px-4 py-3 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4 flex gap-3">
            <a href="{{ route('nom036.pdf', $nom036->id) }}"
               class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg shadow">
                Descargar PDF
            </a>

            <a href="{{ route('evaluaciones.index') }}"
               class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-4 py-2 rounded-lg">
                Volver
            </a>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 mb-5">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div><span class="font-semibold">Empresa:</span> {{ $nom036->evaluacion->empresa->nombre ?? 'N/A' }}</div>
                <div><span class="font-semibold">Sucursal:</span> {{ $nom036->evaluacion->sucursal->nombre ?? 'N/A' }}</div>
                <div><span class="font-semibold">Puesto:</span> {{ $nom036->evaluacion->puesto->nombre ?? 'N/A' }}</div>
                <div><span class="font-semibold">Trabajador:</span> {{ $nom036->evaluacion->trabajador->nombre ?? 'N/A' }}</div>
                <div><span class="font-semibold">Tipo de actividad:</span> {{ $nom036->tipo_actividad }}</div>
                <div><span class="font-semibold">Nivel de riesgo:</span> {{ $nom036->nivel_riesgo }}</div>
            </div>

            <div class="mt-4">
                <span class="font-semibold">Observaciones:</span>
                <div class="text-sm text-gray-700 mt-1">
                    {{ $nom036->observaciones ?? 'Sin observaciones' }}
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <h3 class="text-lg font-bold text-blue-700 mb-4">Detalle de factores evaluados</h3>

            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="border px-3 py-2 text-left">Sección</th>
                            <th class="border px-3 py-2 text-left">Concepto</th>
                            <th class="border px-3 py-2 text-left">Valor</th>
                            <th class="border px-3 py-2 text-left">Resultado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($nom036->detalles as $detalle)
                            <tr>
                                <td class="border px-3 py-2">{{ $detalle->seccion }}</td>
                                <td class="border px-3 py-2">{{ $detalle->concepto }}</td>
                                <td class="border px-3 py-2">{{ $detalle->valor }}</td>
                                <td class="border px-3 py-2">{{ $detalle->resultado }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="border px-3 py-2 text-center">No hay detalles registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>