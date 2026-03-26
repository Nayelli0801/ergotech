<x-app-layout>
    @php
        $detalles = $owas->detalles;

        $posturas = $detalles->filter(fn($d) => str_starts_with($d->seccion, 'POSTURA_'))
            ->groupBy('seccion')
            ->sortKeys();

        $partes = [
            'espalda' => $detalles->where('seccion', 'PARTE_ESPALDA')->groupBy(function ($item) {
                return explode('_', $item->concepto)[1] ?? null;
            }),
            'brazos' => $detalles->where('seccion', 'PARTE_BRAZOS')->groupBy(function ($item) {
                return explode('_', $item->concepto)[1] ?? null;
            }),
            'piernas' => $detalles->where('seccion', 'PARTE_PIERNAS')->groupBy(function ($item) {
                return explode('_', $item->concepto)[1] ?? null;
            }),
        ];

        $categoriaFinal = optional($detalles->firstWhere('concepto', 'categoria_final'))->puntaje ?? 1;
        $nivelFinal = optional($detalles->firstWhere('concepto', 'categoria_final'))->valor ?? 'No definido';

        $badgeClass = match((int)$categoriaFinal) {
            1 => 'bg-emerald-50 border-emerald-200 text-emerald-700',
            2 => 'bg-amber-50 border-amber-200 text-amber-700',
            3 => 'bg-red-50 border-red-200 text-red-700',
            4 => 'bg-slate-200 border-slate-300 text-slate-800',
            default => 'bg-slate-50 border-slate-200 text-slate-700'
        };
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Reporte de Evaluación OWAS</h1>
                <p class="text-sm text-slate-500 mt-1">Resultado ergonómico generado por ErgoTech</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('owas.pdf', $owas->id) }}"
                   class="inline-flex items-center px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-semibold shadow hover:bg-blue-700 transition">
                    Descargar PDF
                </a>
                <a href="{{ route('owas.excel', $owas->id) }}"
                   class="inline-flex items-center px-4 py-2 rounded-xl bg-emerald-600 text-white text-sm font-semibold shadow hover:bg-emerald-700 transition">
                    Descargar Excel
                </a>
                <a href="{{ route('evaluaciones.index') }}"
                   class="inline-flex items-center px-4 py-2 rounded-xl border border-slate-300 bg-white text-slate-700 text-sm font-semibold hover:bg-slate-50 transition">
                    Volver
                </a>
            </div>
        </div>

        <div class="space-y-6">
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                <div class="xl:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                        <h2 class="text-lg font-semibold text-slate-800">Información de la evaluación</h2>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div><p class="text-slate-500">ID</p><p class="font-semibold">{{ $owas->id }}</p></div>
                        <div><p class="text-slate-500">Fecha</p><p class="font-semibold">{{ $owas->evaluacion->fecha_evaluacion ?? 'N/A' }}</p></div>
                        <div><p class="text-slate-500">Empresa</p><p class="font-semibold">{{ $owas->evaluacion->empresa->nombre ?? 'N/A' }}</p></div>
                        <div><p class="text-slate-500">Sucursal</p><p class="font-semibold">{{ $owas->evaluacion->sucursal->nombre ?? 'N/A' }}</p></div>
                        <div><p class="text-slate-500">Puesto</p><p class="font-semibold">{{ $owas->evaluacion->puesto->nombre ?? 'N/A' }}</p></div>
                        <div><p class="text-slate-500">Trabajador</p><p class="font-semibold">{{ $owas->evaluacion->trabajador->nombre ?? 'N/A' }}</p></div>
                        <div><p class="text-slate-500">Evaluador</p><p class="font-semibold">{{ $owas->evaluacion->usuario->name ?? 'N/A' }}</p></div>
                        <div><p class="text-slate-500">Área</p><p class="font-semibold">{{ $owas->evaluacion->area_evaluada ?? 'N/A' }}</p></div>
                        <div><p class="text-slate-500">Actividad</p><p class="font-semibold">{{ $owas->evaluacion->actividad ?? 'N/A' }}</p></div>
                        <div class="md:col-span-2"><p class="text-slate-500">Observaciones</p><p class="font-semibold">{{ $owas->evaluacion->observaciones ?? 'Sin observaciones' }}</p></div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="rounded-2xl border {{ $badgeClass }} p-6 shadow-sm">
                        <p class="text-xs uppercase tracking-wide font-semibold">Categoría final</p>
                        <h3 class="mt-2 text-3xl font-bold">{{ $categoriaFinal }}</h3>
                        <p class="mt-3 text-sm"><span class="font-bold">Nivel:</span> {{ $nivelFinal }}</p>
                        <p class="mt-1 text-sm"><span class="font-bold">Código:</span> {{ $owas->codigo_postura }}</p>
                    </div>

                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                            <h2 class="text-lg font-semibold text-slate-800">Acción correctiva</h2>
                        </div>
                        <div class="p-6 text-sm text-slate-700">
                            {{ $owas->accion_correctiva ?? 'No definida' }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                    <h2 class="text-lg font-semibold text-slate-800">Análisis por parte del cuerpo</h2>
                </div>

                <div class="p-6 space-y-6">
                    @foreach($partes as $nombreParte => $grupoParte)
                        <div>
                            <h3 class="text-sm font-bold uppercase tracking-wide text-slate-700 mb-3">{{ $nombreParte }}</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-sm">
                                    <thead class="bg-slate-100">
                                        <tr>
                                            <th class="px-4 py-3 text-left font-semibold">Código</th>
                                            <th class="px-4 py-3 text-left font-semibold">Descripción</th>
                                            <th class="px-4 py-3 text-left font-semibold">Frecuencia</th>
                                            <th class="px-4 py-3 text-left font-semibold">Porcentaje</th>
                                            <th class="px-4 py-3 text-left font-semibold">Categoría</th>
                                            <th class="px-4 py-3 text-left font-semibold">Nivel</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200">
                                        @foreach($grupoParte as $codigo => $items)
                                            @php
                                                $descripcion = optional($items->firstWhere('concepto', 'codigo_'.$codigo.'_descripcion'))->valor;
                                                $frecuencia = optional($items->firstWhere('concepto', 'codigo_'.$codigo.'_frecuencia'))->puntaje;
                                                $porcentaje = optional($items->firstWhere('concepto', 'codigo_'.$codigo.'_porcentaje'))->puntaje;
                                                $categoria = optional($items->firstWhere('concepto', 'codigo_'.$codigo.'_categoria'))->puntaje;
                                                $nivel = optional($items->firstWhere('concepto', 'codigo_'.$codigo.'_categoria'))->valor;
                                            @endphp
                                            <tr>
                                                <td class="px-4 py-3">{{ $codigo }}</td>
                                                <td class="px-4 py-3">{{ $descripcion }}</td>
                                                <td class="px-4 py-3">{{ $frecuencia }}</td>
                                                <td class="px-4 py-3">{{ $porcentaje }}%</td>
                                                <td class="px-4 py-3">{{ $categoria }}</td>
                                                <td class="px-4 py-3">{{ $nivel }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                    <h2 class="text-lg font-semibold text-slate-800">Análisis por posturas</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-slate-100">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">#</th>
                                <th class="px-4 py-3 text-left font-semibold">Espalda</th>
                                <th class="px-4 py-3 text-left font-semibold">Brazos</th>
                                <th class="px-4 py-3 text-left font-semibold">Piernas</th>
                                <th class="px-4 py-3 text-left font-semibold">Carga</th>
                                <th class="px-4 py-3 text-left font-semibold">Frecuencia</th>
                                <th class="px-4 py-3 text-left font-semibold">%</th>
                                <th class="px-4 py-3 text-left font-semibold">Código</th>
                                <th class="px-4 py-3 text-left font-semibold">Categoría</th>
                                <th class="px-4 py-3 text-left font-semibold">Nivel</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @foreach($posturas as $seccion => $grupo)
                                @php
                                    $espalda = optional($grupo->firstWhere('concepto', 'espalda'))->valor;
                                    $brazos = optional($grupo->firstWhere('concepto', 'brazos'))->valor;
                                    $piernas = optional($grupo->firstWhere('concepto', 'piernas'))->valor;
                                    $carga = optional($grupo->firstWhere('concepto', 'carga'))->valor;
                                    $frecuencia = optional($grupo->firstWhere('concepto', 'frecuencia'))->puntaje;
                                    $porcentaje = optional($grupo->firstWhere('concepto', 'porcentaje'))->puntaje;
                                    $codigo = optional($grupo->firstWhere('concepto', 'codigo_postura'))->valor;
                                    $categoria = optional($grupo->firstWhere('concepto', 'categoria_riesgo'))->puntaje;
                                    $nivel = optional($grupo->firstWhere('concepto', 'categoria_riesgo'))->valor;
                                @endphp
                                <tr>
                                    <td class="px-4 py-3">{{ str_replace('POSTURA_', '', $seccion) }}</td>
                                    <td class="px-4 py-3">{{ $espalda }}</td>
                                    <td class="px-4 py-3">{{ $brazos }}</td>
                                    <td class="px-4 py-3">{{ $piernas }}</td>
                                    <td class="px-4 py-3">{{ $carga }}</td>
                                    <td class="px-4 py-3">{{ $frecuencia }}</td>
                                    <td class="px-4 py-3">{{ $porcentaje }}%</td>
                                    <td class="px-4 py-3">{{ $codigo }}</td>
                                    <td class="px-4 py-3">{{ $categoria }}</td>
                                    <td class="px-4 py-3">{{ $nivel }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>