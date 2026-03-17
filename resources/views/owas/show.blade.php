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

        function badgeClasses($cat) {
            return match((int)$cat) {
                1 => 'bg-green-100 text-green-700',
                2 => 'bg-yellow-100 text-yellow-700',
                3 => 'bg-red-100 text-red-700',
                4 => 'bg-gray-800 text-white',
                default => 'bg-gray-100 text-gray-700'
            };
        }

        function alertClasses($cat) {
            return match((int)$cat) {
                1 => 'bg-green-50 border-green-200 text-green-700',
                2 => 'bg-yellow-50 border-yellow-200 text-yellow-700',
                3 => 'bg-red-50 border-red-200 text-red-700',
                4 => 'bg-red-50 border-red-300 text-red-800',
                default => 'bg-gray-50 border-gray-200 text-gray-700'
            };
        }
    @endphp

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 space-y-5">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">
            <div>
                <h2 class="text-2xl font-bold text-blue-700">Resultado evaluación OWAS</h2>
                <p class="text-sm text-gray-500 mt-1">
                    Resumen de la evaluación ergonómica realizada con el método OWAS.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('owas.pdf', $owas->id) }}"
                   class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg shadow-sm">
                    Descargar PDF
                </a>

                <a href="{{ route('owas.index') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-4 py-2 rounded-lg">
                    Volver
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-5">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 bg-sky-600">
                    <h3 class="text-white text-lg font-semibold">Información de la evaluación</h3>
                </div>

                <div class="p-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="font-semibold text-gray-700">Fecha</p>
                            <p class="text-gray-600">{{ $owas->evaluacion->fecha_evaluacion ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700">Empresa</p>
                            <p class="text-gray-600">{{ $owas->evaluacion->empresa->nombre ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700">Sucursal</p>
                            <p class="text-gray-600">{{ $owas->evaluacion->sucursal->nombre ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700">Puesto</p>
                            <p class="text-gray-600">{{ $owas->evaluacion->puesto->nombre ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700">Trabajador</p>
                            <p class="text-gray-600">{{ $owas->evaluacion->trabajador->nombre ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700">Evaluador</p>
                            <p class="text-gray-600">{{ $owas->evaluacion->usuario->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700">Área</p>
                            <p class="text-gray-600">{{ $owas->evaluacion->area_evaluada ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700">Actividad</p>
                            <p class="text-gray-600">{{ $owas->evaluacion->actividad ?? 'N/A' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="font-semibold text-gray-700">Observaciones</p>
                            <p class="text-gray-600">{{ $owas->evaluacion->observaciones ?? 'Sin observaciones' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 bg-blue-700">
                    <h3 class="text-white text-lg font-semibold">Resultado de la evaluación</h3>
                </div>

                <div class="p-5 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-slate-50 border rounded-xl p-4">
                            <p class="text-xs uppercase tracking-wide text-gray-500">Código postura crítica</p>
                            <p class="text-xl font-bold text-slate-700 mt-1">{{ $owas->codigo_postura }}</p>
                        </div>

                        <div class="bg-yellow-50 border rounded-xl p-4">
                            <p class="text-xs uppercase tracking-wide text-gray-500">Nivel de riesgo global</p>
                            <p class="text-xl font-bold text-yellow-700 mt-1">{{ $nivelFinal }}</p>
                        </div>

                        <div class="bg-purple-50 border rounded-xl p-4">
                            <p class="text-xs uppercase tracking-wide text-gray-500">Categoría final</p>
                            <p class="mt-2">
                                <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold {{ badgeClasses($categoriaFinal) }}">
                                    {{ $categoriaFinal }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="rounded-xl border p-4 {{ alertClasses($categoriaFinal) }}">
                        <p class="text-sm">
                            <span class="font-semibold">Acción correctiva:</span>
                            {{ $owas->accion_correctiva }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="text-lg font-bold text-blue-700">Análisis por parte del cuerpo</h3>
            </div>

            <div class="p-5 space-y-6">
                @foreach($partes as $nombreParte => $grupoParte)
                    <div>
                        <h4 class="text-base font-bold text-gray-800 uppercase mb-3">{{ $nombreParte }}</h4>

                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm text-left border border-gray-200 rounded-lg overflow-hidden">
                                <thead class="bg-gray-50 text-gray-700">
                                    <tr>
                                        <th class="px-4 py-3 font-semibold">Código</th>
                                        <th class="px-4 py-3 font-semibold">Descripción</th>
                                        <th class="px-4 py-3 font-semibold">Frecuencia</th>
                                        <th class="px-4 py-3 font-semibold">Porcentaje</th>
                                        <th class="px-4 py-3 font-semibold">Categoría</th>
                                        <th class="px-4 py-3 font-semibold">Nivel</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($grupoParte as $codigo => $items)
                                        @php
                                            $descripcion = optional($items->firstWhere('concepto', 'codigo_'.$codigo.'_descripcion'))->valor;
                                            $frecuencia = optional($items->firstWhere('concepto', 'codigo_'.$codigo.'_frecuencia'))->puntaje;
                                            $porcentaje = optional($items->firstWhere('concepto', 'codigo_'.$codigo.'_porcentaje'))->puntaje;
                                            $categoria = optional($items->firstWhere('concepto', 'codigo_'.$codigo.'_categoria'))->puntaje;
                                            $nivel = optional($items->firstWhere('concepto', 'codigo_'.$codigo.'_categoria'))->valor;
                                        @endphp
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3">{{ $codigo }}</td>
                                            <td class="px-4 py-3">{{ $descripcion }}</td>
                                            <td class="px-4 py-3">{{ $frecuencia }}</td>
                                            <td class="px-4 py-3">{{ $porcentaje }}%</td>
                                            <td class="px-4 py-3">
                                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold {{ badgeClasses($categoria) }}">
                                                    {{ $categoria }}
                                                </span>
                                            </td>
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

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="text-lg font-bold text-blue-700">Análisis por posturas</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-700">
                        <tr>
                            <th class="px-4 py-3 font-semibold">#</th>
                            <th class="px-4 py-3 font-semibold">Espalda</th>
                            <th class="px-4 py-3 font-semibold">Brazos</th>
                            <th class="px-4 py-3 font-semibold">Piernas</th>
                            <th class="px-4 py-3 font-semibold">Carga</th>
                            <th class="px-4 py-3 font-semibold">Frecuencia</th>
                            <th class="px-4 py-3 font-semibold">%</th>
                            <th class="px-4 py-3 font-semibold">Código</th>
                            <th class="px-4 py-3 font-semibold">Categoría</th>
                            <th class="px-4 py-3 font-semibold">Nivel</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
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
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">{{ str_replace('POSTURA_', '', $seccion) }}</td>
                                <td class="px-4 py-3">{{ $espalda }}</td>
                                <td class="px-4 py-3">{{ $brazos }}</td>
                                <td class="px-4 py-3">{{ $piernas }}</td>
                                <td class="px-4 py-3">{{ $carga }}</td>
                                <td class="px-4 py-3">{{ $frecuencia }}</td>
                                <td class="px-4 py-3">{{ $porcentaje }}%</td>
                                <td class="px-4 py-3">{{ $codigo }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold {{ badgeClasses($categoria) }}">
                                        {{ $categoria }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">{{ $nivel }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>