<x-app-layout>
    @php
        $detallesGenerales = $nom036->detalles->where('seccion', 'General');
        $tareasSeleccionadas = optional($detallesGenerales->firstWhere('concepto', 'Tareas seleccionadas'))->valor ?? 'No especificadas';
        $tareaObservada = optional($detallesGenerales->firstWhere('concepto', 'Tarea observada'))->valor ?? 'No especificada';
        $medioAyuda = optional($detallesGenerales->firstWhere('concepto', 'Medio de ayuda utilizado'))->valor ?? 'No especificado';
        $descripcionApoyo = optional($detallesGenerales->firstWhere('concepto', 'Descripción del apoyo o equipo utilizado'))->valor ?? 'No especificada';

        $secciones = $nom036->detalles
            ->whereNotIn('seccion', ['General', 'Resultado'])
            ->groupBy('seccion');

        $resultados = $nom036->detalles->where('seccion', 'Resultado');

        $riesgoColor = match (strtolower($nom036->nivel_riesgo ?? '')) {
            'bajo' => 'bg-emerald-50 border-emerald-200 text-emerald-700',
            'medio' => 'bg-amber-50 border-amber-200 text-amber-700',
            'alto' => 'bg-red-50 border-red-200 text-red-700',
            default => 'bg-slate-50 border-slate-200 text-slate-700',
        };
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Reporte de Evaluación NOM-036</h1>
                <p class="text-sm text-slate-500 mt-1">Factores de riesgo ergonómico por manejo manual de cargas</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('nom036.pdf', $nom036->id) }}"
                   class="inline-flex items-center px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-semibold shadow hover:bg-blue-700 transition">
                    Descargar PDF
                </a>
                <a href="{{ route('evaluaciones.index') }}"
                   class="inline-flex items-center px-4 py-2 rounded-xl border border-slate-300 bg-white text-slate-700 text-sm font-semibold hover:bg-slate-50 transition">
                    Volver
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <div class="xl:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                        <h2 class="text-lg font-semibold text-slate-800">Datos generales</h2>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div><p class="text-slate-500">Empresa</p><p class="font-semibold">{{ $nom036->evaluacion->empresa->nombre ?? 'N/A' }}</p></div>
                        <div><p class="text-slate-500">Sucursal</p><p class="font-semibold">{{ $nom036->evaluacion->sucursal->nombre ?? 'N/A' }}</p></div>
                        <div><p class="text-slate-500">Puesto</p><p class="font-semibold">{{ $nom036->evaluacion->puesto->nombre ?? 'N/A' }}</p></div>
                        <div><p class="text-slate-500">Trabajador</p><p class="font-semibold">{{ $nom036->evaluacion->trabajador->nombre ?? 'N/A' }}</p></div>
                        <div><p class="text-slate-500">Fecha</p><p class="font-semibold">{{ $nom036->evaluacion->fecha_evaluacion ?? 'N/A' }}</p></div>
                        <div><p class="text-slate-500">Resultado final</p><p class="font-semibold">{{ $nom036->evaluacion->resultado_final ?? 'N/A' }}</p></div>
                        <div class="md:col-span-2"><p class="text-slate-500">Recomendación</p><p class="font-semibold">{{ $nom036->evaluacion->recomendaciones ?? 'N/A' }}</p></div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                        <h2 class="text-lg font-semibold text-slate-800">Datos de la actividad</h2>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div class="md:col-span-2"><p class="text-slate-500">Tareas seleccionadas</p><p class="font-semibold">{{ $tareasSeleccionadas }}</p></div>
                        <div><p class="text-slate-500">Tarea observada</p><p class="font-semibold">{{ $tareaObservada }}</p></div>
                        <div><p class="text-slate-500">Medio de ayuda utilizado</p><p class="font-semibold">{{ $medioAyuda }}</p></div>
                        <div class="md:col-span-2"><p class="text-slate-500">Descripción del apoyo o equipo</p><p class="font-semibold">{{ $descripcionApoyo }}</p></div>
                    </div>
                </div>

                @foreach($secciones as $nombreSeccion => $items)
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                            <h2 class="text-lg font-semibold text-slate-800">{{ $nombreSeccion }}</h2>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead class="bg-slate-100">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-semibold">Concepto</th>
                                        <th class="px-4 py-3 text-left font-semibold">Valor seleccionado</th>
                                        <th class="px-4 py-3 text-left font-semibold">Resultado</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200">
                                    @foreach($items as $detalle)
                                        <tr class="hover:bg-slate-50">
                                            <td class="px-4 py-3">{{ $detalle->concepto }}</td>
                                            <td class="px-4 py-3">{{ $detalle->valor }}</td>
                                            <td class="px-4 py-3">{{ $detalle->resultado ?? '—' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="space-y-6">
                <div class="rounded-2xl border {{ $riesgoColor }} p-6 shadow-sm">
                    <p class="text-xs uppercase tracking-wide font-semibold">Nivel de riesgo</p>
                    <h3 class="mt-2 text-2xl font-bold">{{ $nom036->nivel_riesgo ?? 'N/A' }}</h3>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                        <h2 class="text-lg font-semibold text-slate-800">Observaciones</h2>
                    </div>
                    <div class="p-6 text-sm text-slate-700">
                        {{ $nom036->observaciones ?? 'Sin observaciones.' }}
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                        <h2 class="text-lg font-semibold text-slate-800">Resultado final</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="bg-slate-100">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold">Concepto</th>
                                    <th class="px-4 py-3 text-left font-semibold">Valor</th>
                                    <th class="px-4 py-3 text-left font-semibold">Resultado</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200">
                                @foreach($resultados as $detalle)
                                    <tr>
                                        <td class="px-4 py-3">{{ $detalle->concepto }}</td>
                                        <td class="px-4 py-3">{{ $detalle->valor }}</td>
                                        <td class="px-4 py-3">{{ $detalle->resultado ?? '—' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>