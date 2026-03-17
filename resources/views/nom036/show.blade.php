<x-app-layout>
    <div class="max-w-6xl mx-auto py-6 px-4 sm:px-6 space-y-5">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">
            <div>
                <h2 class="text-2xl font-bold text-blue-700">Resultado NOM-036</h2>
                <p class="text-sm text-gray-500 mt-1">
                    Resumen y detalle de la evaluación registrada con NOM-036.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('nom036.pdf', $nom036->id) }}"
                   class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg shadow">
                    Descargar PDF
                </a>

                <a href="{{ route('evaluaciones.index') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-4 py-2 rounded-lg">
                    Volver
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="rounded-lg bg-green-50 border border-green-200 text-green-700 px-4 py-3 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <h3 class="text-lg font-bold text-blue-700 mb-4">Resumen general</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm">
                <div class="bg-gray-50 rounded-xl border p-4">
                    <span class="font-semibold block text-gray-700">Empresa</span>
                    <div class="mt-1 text-gray-700">{{ $nom036->evaluacion->empresa->nombre ?? 'N/A' }}</div>
                </div>

                <div class="bg-gray-50 rounded-xl border p-4">
                    <span class="font-semibold block text-gray-700">Sucursal</span>
                    <div class="mt-1 text-gray-700">{{ $nom036->evaluacion->sucursal->nombre ?? 'N/A' }}</div>
                </div>

                <div class="bg-gray-50 rounded-xl border p-4">
                    <span class="font-semibold block text-gray-700">Puesto</span>
                    <div class="mt-1 text-gray-700">{{ $nom036->evaluacion->puesto->nombre ?? 'N/A' }}</div>
                </div>

                <div class="bg-gray-50 rounded-xl border p-4">
                    <span class="font-semibold block text-gray-700">Trabajador</span>
                    <div class="mt-1 text-gray-700">{{ $nom036->evaluacion->trabajador->nombre ?? 'N/A' }}</div>
                </div>

                <div class="bg-gray-50 rounded-xl border p-4">
                    <span class="font-semibold block text-gray-700">Fecha</span>
                    <div class="mt-1 text-gray-700">{{ $nom036->evaluacion->fecha_evaluacion ?? 'N/A' }}</div>
                </div>

                <div class="bg-gray-50 rounded-xl border p-4">
                    <span class="font-semibold block text-gray-700">Resultado final</span>
                    <div class="mt-1 text-gray-700">{{ $nom036->evaluacion->resultado_final ?? 'N/A' }}</div>
                </div>

                <div class="bg-red-50 rounded-xl border border-red-200 p-4">
                    <span class="font-semibold block text-red-700">Nivel de riesgo</span>
                    <div class="mt-1 font-bold text-red-700">{{ $nom036->nivel_riesgo }}</div>
                </div>

                <div class="bg-amber-50 rounded-xl border border-amber-200 p-4 md:col-span-2 lg:col-span-2">
                    <span class="font-semibold block text-amber-700">Recomendación</span>
                    <div class="mt-1 text-gray-700">{{ $nom036->evaluacion->recomendaciones ?? 'N/A' }}</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <h3 class="text-lg font-bold text-blue-700 mb-4">Datos de la actividad</h3>

            @php
                $detallesGenerales = $nom036->detalles->where('seccion', 'General');
                $tareasSeleccionadas = optional($detallesGenerales->firstWhere('concepto', 'Tareas seleccionadas'))->valor ?? 'No especificadas';
                $tareaObservada = optional($detallesGenerales->firstWhere('concepto', 'Tarea observada'))->valor ?? 'No especificada';
                $medioAyuda = optional($detallesGenerales->firstWhere('concepto', 'Medio de ayuda utilizado'))->valor ?? 'No especificado';
                $descripcionApoyo = optional($detallesGenerales->firstWhere('concepto', 'Descripción del apoyo o equipo utilizado'))->valor ?? 'No especificada';
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div class="bg-gray-50 rounded-xl border p-4">
                    <span class="font-semibold">Tareas seleccionadas</span>
                    <div class="mt-1 text-gray-700">{{ $tareasSeleccionadas }}</div>
                </div>

                <div class="bg-gray-50 rounded-xl border p-4">
                    <span class="font-semibold">Tarea observada</span>
                    <div class="mt-1 text-gray-700">{{ $tareaObservada }}</div>
                </div>

                <div class="bg-gray-50 rounded-xl border p-4">
                    <span class="font-semibold">Medio de ayuda utilizado</span>
                    <div class="mt-1 text-gray-700">{{ $medioAyuda }}</div>
                </div>

                <div class="bg-gray-50 rounded-xl border p-4">
                    <span class="font-semibold">Descripción del apoyo o equipo</span>
                    <div class="mt-1 text-gray-700">{{ $descripcionApoyo }}</div>
                </div>
            </div>

            <div class="mt-4 rounded-xl border bg-gray-50 p-4">
                <span class="font-semibold text-sm">Observaciones</span>
                <div class="text-sm text-gray-700 mt-1">
                    {{ $nom036->observaciones ?? 'Sin observaciones' }}
                </div>
            </div>
        </div>

        @php
            $secciones = $nom036->detalles
                ->whereNotIn('seccion', ['General', 'Resultado'])
                ->groupBy('seccion');
        @endphp

        @foreach($secciones as $nombreSeccion => $items)
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                <h3 class="text-lg font-bold text-blue-700 mb-4">{{ $nombreSeccion }}</h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="border px-3 py-2 text-left">Concepto</th>
                                <th class="border px-3 py-2 text-left">Valor seleccionado</th>
                                <th class="border px-3 py-2 text-left">Resultado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $detalle)
                                <tr>
                                    <td class="border px-3 py-2">{{ $detalle->concepto }}</td>
                                    <td class="border px-3 py-2">{{ $detalle->valor }}</td>
                                    <td class="border px-3 py-2">{{ $detalle->resultado ?? '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach

        @php
            $resultados = $nom036->detalles->where('seccion', 'Resultado');
        @endphp

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <h3 class="text-lg font-bold text-blue-700 mb-4">Resultado final</h3>

            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="border px-3 py-2 text-left">Concepto</th>
                            <th class="border px-3 py-2 text-left">Valor</th>
                            <th class="border px-3 py-2 text-left">Resultado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($resultados as $detalle)
                            <tr>
                                <td class="border px-3 py-2">{{ $detalle->concepto }}</td>
                                <td class="border px-3 py-2">{{ $detalle->valor }}</td>
                                <td class="border px-3 py-2">{{ $detalle->resultado ?? '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>