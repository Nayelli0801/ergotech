<x-app-layout>
    @php
        $riesgoColor = match(strtolower($niosh->nivel_riesgo ?? '')) {
            'bajo' => 'bg-emerald-50 border-emerald-200 text-emerald-700',
            'medio' => 'bg-amber-50 border-amber-200 text-amber-700',
            'alto' => 'bg-red-50 border-red-200 text-red-700',
            default => 'bg-slate-50 border-slate-200 text-slate-700',
        };
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Reporte de Evaluación NIOSH</h1>
                    <p class="text-sm text-slate-500 mt-1">Resultado ergonómico calculado automáticamente por ErgoTech</p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('niosh.pdf', $niosh->id) }}"
                       class="inline-flex items-center px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-semibold shadow hover:bg-blue-700 transition">
                        Descargar PDF
                    </a>
                    <a href="{{ route('niosh.excel', $niosh->id) }}"
                       class="inline-flex items-center px-4 py-2 rounded-xl bg-emerald-600 text-white text-sm font-semibold shadow hover:bg-emerald-700 transition">
                        Descargar Excel
                    </a>

                    <a href="{{ route('evaluaciones.index') }}"
                       class="inline-flex items-center px-4 py-2 rounded-xl bg-white border border-slate-300 text-slate-700 text-sm font-semibold hover:bg-slate-50 transition">
                        Volver
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <div class="xl:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                        <h2 class="text-lg font-semibold text-slate-800">Información general</h2>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div><p class="text-slate-500">Empresa</p><p class="font-semibold text-slate-800">{{ $niosh->evaluacion->empresa->nombre ?? 'N/A' }}</p></div>
                            <div><p class="text-slate-500">Sucursal</p><p class="font-semibold text-slate-800">{{ $niosh->evaluacion->sucursal->nombre ?? 'N/A' }}</p></div>
                            <div><p class="text-slate-500">Puesto</p><p class="font-semibold text-slate-800">{{ $niosh->evaluacion->puesto->nombre ?? 'N/A' }}</p></div>
                            <div><p class="text-slate-500">Trabajador</p><p class="font-semibold text-slate-800">{{ trim(($niosh->evaluacion->trabajador->nombre ?? '') . ' ' . ($niosh->evaluacion->trabajador->apellido_paterno ?? '') . ' ' . ($niosh->evaluacion->trabajador->apellido_materno ?? '')) ?: 'N/A' }}</p></div>
                            <div><p class="text-slate-500">Fecha</p><p class="font-semibold text-slate-800">{{ $niosh->evaluacion->fecha_evaluacion ?? 'N/A' }}</p></div>
                            <div><p class="text-slate-500">Evaluador</p><p class="font-semibold text-slate-800">{{ $niosh->evaluacion->usuario->name ?? 'N/A' }}</p></div>
                            <div class="md:col-span-2"><p class="text-slate-500">Actividad</p><p class="font-semibold text-slate-800">{{ $niosh->evaluacion->actividad ?? 'Sin actividad registrada' }}</p></div>
                            <div class="md:col-span-2"><p class="text-slate-500">Observaciones</p><p class="font-semibold text-slate-800">{{ $niosh->evaluacion->observaciones ?? 'Sin observaciones' }}</p></div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                        <h2 class="text-lg font-semibold text-slate-800">Parámetros evaluados</h2>
                    </div>

                    <div class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @php
                            $entradas = [
                                ['label' => 'Distancia horizontal', 'value' => $niosh->distancia_horizontal . ' cm'],
                                ['label' => 'Altura inicial', 'value' => $niosh->altura_inicial . ' cm'],
                                ['label' => 'Desplazamiento vertical', 'value' => $niosh->desplazamiento_vertical . ' cm'],
                                ['label' => 'Ángulo de asimetría', 'value' => $niosh->angulo_asimetria . '°'],
                                ['label' => 'Frecuencia', 'value' => $niosh->frecuencia_levantamiento],
                                ['label' => 'Duración', 'value' => $niosh->duracion],
                                ['label' => 'Calidad de agarre', 'value' => $niosh->calidad_agarre],
                                ['label' => 'Peso del objeto', 'value' => $niosh->peso_objeto . ' kg'],
                            ];
                        @endphp

                        @foreach($entradas as $item)
                            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                                <p class="text-xs uppercase tracking-wide text-slate-500">{{ $item['label'] }}</p>
                                <p class="mt-2 text-lg font-bold text-slate-800">{{ $item['value'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                        <h2 class="text-lg font-semibold text-slate-800">Detalle del cálculo</h2>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="bg-slate-100 text-slate-700">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold">Sección</th>
                                    <th class="px-4 py-3 text-left font-semibold">Concepto</th>
                                    <th class="px-4 py-3 text-left font-semibold">Valor</th>
                                    <th class="px-4 py-3 text-left font-semibold">Resultado</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200">
                                @forelse($niosh->detalles as $detalle)
                                    <tr class="hover:bg-slate-50">
                                        <td class="px-4 py-3 text-slate-700">{{ $detalle->seccion }}</td>
                                        <td class="px-4 py-3 text-slate-700">{{ $detalle->concepto }}</td>
                                        <td class="px-4 py-3 text-slate-700">{{ $detalle->valor }}</td>
                                        <td class="px-4 py-3 font-medium text-slate-800">{{ $detalle->resultado ?? '—' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-6 text-center text-slate-500">No hay detalles registrados.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-2xl border {{ $riesgoColor }} p-6 shadow-sm">
                    <p class="text-xs uppercase tracking-wide font-semibold">Nivel de riesgo</p>
                    <h3 class="mt-2 text-2xl font-bold">{{ $niosh->nivel_riesgo ?? 'N/A' }}</h3>
                    <p class="mt-3 text-sm">Índice de levantamiento: <span class="font-bold">{{ $niosh->indice_levantamiento ?? 'N/A' }}</span></p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                        <h2 class="text-lg font-semibold text-slate-800">Factores NIOSH</h2>
                    </div>

                    <div class="p-6 grid grid-cols-2 gap-4">
                        @php
                            $factores = [
                                'LC' => $niosh->constante_carga,
                                'HM' => $niosh->hm,
                                'VM' => $niosh->vm,
                                'DM' => $niosh->dm,
                                'AM' => $niosh->am,
                                'FM' => $niosh->fm,
                                'CM' => $niosh->cm,
                                'RWL' => $niosh->rwl,
                            ];
                        @endphp

                        @foreach($factores as $label => $valor)
                            <div class="rounded-xl border border-blue-100 bg-blue-50 p-4 text-center">
                                <p class="text-xs font-semibold uppercase tracking-wide text-blue-600">{{ $label }}</p>
                                <p class="mt-2 text-xl font-bold text-slate-800">{{ $valor }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                        <h2 class="text-lg font-semibold text-slate-800">Resumen ejecutivo</h2>
                    </div>

                    <div class="p-6 text-sm text-slate-700 space-y-3">
                        <p><span class="font-semibold">Peso analizado:</span> {{ $niosh->peso_objeto ?? 'N/A' }} kg</p>
                        <p><span class="font-semibold">Límite recomendado (RWL):</span> {{ $niosh->rwl ?? 'N/A' }} kg</p>
                        <p><span class="font-semibold">Conclusión:</span> {{ $niosh->nivel_riesgo ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>