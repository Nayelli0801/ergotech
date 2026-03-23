<x-app-layout>
    @php
        $riesgoColor = match (strtolower($reba->nivel_riesgo ?? '')) {
            'bajo' => 'bg-emerald-50 border-emerald-200 text-emerald-700',
            'medio' => 'bg-amber-50 border-amber-200 text-amber-700',
            'alto' => 'bg-red-50 border-red-200 text-red-700',
            default => 'bg-slate-50 border-slate-200 text-slate-700',
        };
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Reporte de Evaluación REBA</h1>
                <p class="text-sm text-slate-500 mt-1">Resultado ergonómico generado por ErgoTech</p>
            </div>

            <div class="flex flex-wrap gap-3">
                {{-- PDF --}}
                <a href="{{ route('reba.pdf', $reba->id) }}"
                   class="inline-flex items-center px-4 py-2 rounded-xl bg-red-600 text-white text-sm font-semibold shadow hover:bg-red-700 transition">
                    Descargar PDF
                </a>

                {{-- Excel --}}
                @if(Route::has('reba.excel'))
                    <a href="{{ route('reba.excel', $reba->id) }}"
                       class="inline-flex items-center px-4 py-2 rounded-xl bg-emerald-600 text-white text-sm font-semibold shadow hover:bg-emerald-700 transition">
                        Descargar Excel
                    </a>
                @endif

                {{-- Word --}}
                @if(Route::has('reba.word'))
                    <a href="{{ route('reba.word', $reba->id) }}"
                       class="inline-flex items-center px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-semibold shadow hover:bg-blue-700 transition">
                        Descargar Word
                    </a>
                @endif

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
                        <div><p class="text-slate-500">Empresa</p><p class="font-semibold">{{ $reba->evaluacion->empresa->nombre ?? 'N/A' }}</p></div>
                        <div><p class="text-slate-500">Sucursal</p><p class="font-semibold">{{ $reba->evaluacion->sucursal->nombre ?? 'N/A' }}</p></div>
                        <div><p class="text-slate-500">Puesto</p><p class="font-semibold">{{ $reba->evaluacion->puesto->nombre ?? 'N/A' }}</p></div>
                        <div><p class="text-slate-500">Trabajador</p><p class="font-semibold">{{ trim(($reba->evaluacion->trabajador->nombre ?? '') . ' ' . ($reba->evaluacion->trabajador->apellido_paterno ?? '') . ' ' . ($reba->evaluacion->trabajador->apellido_materno ?? '')) ?: 'N/A' }}</p></div>
                        <div><p class="text-slate-500">Fecha</p><p class="font-semibold">{{ $reba->evaluacion->fecha_evaluacion ?? 'N/A' }}</p></div>
                        <div><p class="text-slate-500">Evaluador</p><p class="font-semibold">{{ $reba->evaluacion->usuario->name ?? 'N/A' }}</p></div>
                        <div><p class="text-slate-500">Área evaluada</p><p class="font-semibold">{{ $reba->evaluacion->area_evaluada ?? 'N/A' }}</p></div>
                        <div><p class="text-slate-500">Actividad</p><p class="font-semibold">{{ $reba->evaluacion->actividad ?? 'N/A' }}</p></div>
                        <div class="md:col-span-2"><p class="text-slate-500">Observaciones</p><p class="font-semibold">{{ $reba->evaluacion->observaciones ?? 'Sin observaciones' }}</p></div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                        <h2 class="text-lg font-semibold text-slate-800">Detalle de la evaluación</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="bg-slate-100">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold">Sección</th>
                                    <th class="px-4 py-3 text-left font-semibold">Concepto</th>
                                    <th class="px-4 py-3 text-left font-semibold">Valor</th>
                                    <th class="px-4 py-3 text-left font-semibold">Puntaje</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200">
                                @forelse($reba->detalles as $detalle)
                                    <tr class="hover:bg-slate-50">
                                        <td class="px-4 py-3">{{ $detalle->seccion }}</td>
                                        <td class="px-4 py-3">{{ ucfirst(str_replace('_', ' ', $detalle->concepto)) }}</td>
                                        <td class="px-4 py-3">{{ $detalle->valor }}</td>
                                        <td class="px-4 py-3 font-semibold">{{ $detalle->puntaje }}</td>
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
                    <h3 class="mt-2 text-2xl font-bold">{{ $reba->nivel_riesgo ?? 'N/A' }}</h3>
                    <p class="mt-3 text-sm">Acción requerida: <span class="font-bold">{{ $reba->accion_requerida ?? 'N/A' }}</span></p>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                        <h2 class="text-lg font-semibold text-slate-800">Puntuaciones</h2>
                    </div>
                    <div class="p-6 grid grid-cols-2 gap-4">
                        @foreach([
                            'Puntuación A' => $reba->puntuacion_a,
                            'Puntuación B' => $reba->puntuacion_b,
                            'Puntuación C' => $reba->puntuacion_c,
                            'Puntuación Final' => $reba->puntuacion_final,
                        ] as $label => $valor)
                            <div class="rounded-xl border border-blue-100 bg-blue-50 p-4 text-center">
                                <p class="text-xs uppercase tracking-wide font-semibold text-blue-600">{{ $label }}</p>
                                <p class="mt-2 text-2xl font-bold text-slate-800">{{ $valor }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>