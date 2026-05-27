<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-6">
        <div class="bg-white shadow-lg rounded-2xl border border-gray-200 overflow-hidden">

            <div class="bg-sky-600 text-white px-6 py-4 flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold">Resultado Check List OCRA</h2>
                    <p class="text-sm text-blue-100">Índice de riesgo por movimientos repetitivos</p>
                </div>

                <a href="{{ route('ocra.pdf', $ocra->id) }}"
                   class="bg-white text-sky-700 px-4 py-2 rounded-lg font-semibold hover:bg-gray-100">
                    Descargar PDF
                </a>
            </div>

            <div class="p-6 space-y-6">

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="border rounded-xl p-4 bg-gray-50">
                        <p class="text-xs text-gray-500">Empresa</p>
                        <p class="font-bold">{{ $ocra->evaluacion->empresa->nombre ?? 'N/A' }}</p>
                    </div>

                    <div class="border rounded-xl p-4 bg-gray-50">
                        <p class="text-xs text-gray-500">Puesto</p>
                        <p class="font-bold">{{ $ocra->evaluacion->puesto->nombre ?? 'N/A' }}</p>
                    </div>

                    <div class="border rounded-xl p-4 bg-gray-50">
                        <p class="text-xs text-gray-500">Trabajador</p>
                        <p class="font-bold">
                            {{ trim(($ocra->evaluacion->trabajador->nombre ?? '') . ' ' . ($ocra->evaluacion->trabajador->apellido_paterno ?? '') . ' ' . ($ocra->evaluacion->trabajador->apellido_materno ?? '')) ?: 'N/A' }}
                        </p>
                    </div>

                    <div class="border rounded-xl p-4 bg-gray-50">
                        <p class="text-xs text-gray-500">Lado evaluado</p>
                        <p class="font-bold">{{ $ocra->lado_evaluado }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="rounded-2xl border border-sky-200 bg-sky-50 p-5">
                        <p class="text-sm text-gray-600">ICKL</p>
                        <p class="text-5xl font-bold text-sky-700">{{ $ocra->ickl }}</p>
                    </div>

                    <div class="rounded-2xl border border-red-200 bg-red-50 p-5">
                        <p class="text-sm text-gray-600">Nivel de riesgo</p>
                        <p class="text-2xl font-bold text-red-700">{{ $ocra->nivel_riesgo }}</p>
                    </div>

                    <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5">
                        <p class="text-sm text-gray-600">Acción recomendada</p>
                        <p class="text-sm font-semibold text-amber-800">{{ $ocra->accion_recomendada }}</p>
                    </div>
                </div>

                <div class="border rounded-xl p-4">
                    <h3 class="font-bold text-gray-700 mb-3">Cálculos principales</h3>

                    <div class="grid grid-cols-2 md:grid-cols-5 gap-3 text-center">
                        <div class="bg-gray-50 border rounded-lg p-3">
                            <p class="text-xs text-gray-500">TNTR</p>
                            <p class="font-bold">{{ $ocra->tntr }} min</p>
                        </div>

                        <div class="bg-gray-50 border rounded-lg p-3">
                            <p class="text-xs text-gray-500">TNC</p>
                            <p class="font-bold">{{ $ocra->tnc }} seg</p>
                        </div>

                        <div class="bg-gray-50 border rounded-lg p-3">
                            <p class="text-xs text-gray-500">FF</p>
                            <p class="font-bold">{{ $ocra->ff }}</p>
                        </div>

                        <div class="bg-gray-50 border rounded-lg p-3">
                            <p class="text-xs text-gray-500">FP</p>
                            <p class="font-bold">{{ $ocra->fp }}</p>
                        </div>

                        <div class="bg-gray-50 border rounded-lg p-3">
                            <p class="text-xs text-gray-500">MD</p>
                            <p class="font-bold">{{ $ocra->md }}</p>
                        </div>
                    </div>
                </div>

                <div class="border rounded-xl overflow-hidden">
                    <div class="bg-gray-100 px-4 py-3 font-bold text-gray-700">
                        Detalle completo de factores
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