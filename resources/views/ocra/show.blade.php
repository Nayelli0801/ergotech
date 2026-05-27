<x-app-layout>
    <div class="max-w-6xl mx-auto py-8 px-6">
        <div class="bg-white shadow-lg rounded-2xl border border-gray-200 overflow-hidden">

            <div class="bg-sky-600 text-white px-6 py-4 flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold">Resultado OCRA</h2>
                    <p class="text-sm">Evaluación de movimientos repetitivos</p>
                </div>

                <a href="{{ route('ocra.pdf', $ocra->id) }}"
                   class="bg-white text-sky-700 px-4 py-2 rounded-lg font-semibold hover:bg-gray-100">
                    Descargar PDF
                </a>
            </div>

            <div class="p-6 space-y-6">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="border rounded-xl p-4">
                        <h3 class="font-bold text-gray-700 mb-2">Datos generales</h3>
                        <p><strong>Empresa:</strong> {{ $ocra->evaluacion->empresa->nombre ?? 'N/A' }}</p>
                        <p><strong>Sucursal:</strong> {{ $ocra->evaluacion->sucursal->nombre ?? 'N/A' }}</p>
                        <p><strong>Puesto:</strong> {{ $ocra->evaluacion->puesto->nombre ?? 'N/A' }}</p>
                        <p><strong>Trabajador:</strong> {{ $ocra->evaluacion->trabajador->nombre ?? 'N/A' }}</p>
                    </div>

                    <div class="border rounded-xl p-4">
                        <h3 class="font-bold text-gray-700 mb-2">Resultado final</h3>
                        <p class="text-4xl font-bold text-sky-700">{{ $ocra->indice_ocra }}</p>
                        <p>
                            <strong>Nivel de riesgo:</strong>
                            <span class="font-bold text-red-600">{{ $ocra->nivel_riesgo }}</span>
                        </p>
                        <p><strong>Lado evaluado:</strong> {{ $ocra->lado_evaluado }}</p>
                    </div>
                </div>

                <div class="border rounded-xl overflow-hidden">
                    <div class="bg-gray-100 px-4 py-3 font-bold text-gray-700">
                        Detalles de evaluación
                    </div>

                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left">Sección</th>
                                <th class="px-4 py-2 text-left">Concepto</th>
                                <th class="px-4 py-2 text-left">Valor</th>
                                <th class="px-4 py-2 text-left">Puntaje</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ocra->detalles as $detalle)
                                <tr class="border-t">
                                    <td class="px-4 py-2">{{ $detalle->seccion }}</td>
                                    <td class="px-4 py-2">{{ $detalle->concepto }}</td>
                                    <td class="px-4 py-2">{{ $detalle->valor }}</td>
                                    <td class="px-4 py-2">{{ $detalle->puntaje ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="border rounded-xl p-4">
                    <h3 class="font-bold text-gray-700 mb-2">Recomendaciones</h3>
                    <p>{{ $ocra->recomendaciones }}</p>
                </div>

                @if($ocra->observaciones)
                    <div class="border rounded-xl p-4">
                        <h3 class="font-bold text-gray-700 mb-2">Observaciones</h3>
                        <p>{{ $ocra->observaciones }}</p>
                    </div>
                @endif

                <div class="flex justify-end">
                    <a href="{{ route('evaluaciones.index') }}"
                       class="px-5 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg font-semibold">
                        Volver
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>