<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Evaluaciones NIOSH</h1>
                <p class="text-sm text-slate-500 mt-1">
                    Consulta las evaluaciones registradas del método NIOSH.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <div class="bg-white border border-slate-200 rounded-2xl px-4 py-3 shadow-sm">
                    <p class="text-xs uppercase tracking-wide text-slate-500">Total</p>
                    <p class="text-xl font-bold text-slate-800">{{ $nioshEvaluaciones->total() }}</p>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 text-sm shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                <h2 class="text-lg font-semibold text-slate-800">Listado de evaluaciones</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-slate-100 text-slate-700">
                        <tr>
                            <th class="px-4 py-3 font-semibold">ID</th>
                            <th class="px-4 py-3 font-semibold">Trabajador</th>
                            <th class="px-4 py-3 font-semibold">Empresa</th>
                            <th class="px-4 py-3 font-semibold">Fecha</th>
                            <th class="px-4 py-3 font-semibold">RWL</th>
                            <th class="px-4 py-3 font-semibold">Índice</th>
                            <th class="px-4 py-3 font-semibold">Riesgo</th>
                            <th class="px-4 py-3 font-semibold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($nioshEvaluaciones as $item)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 font-semibold text-slate-800">#{{ $item->id }}</td>
                                <td class="px-4 py-3 text-slate-700">
                                    {{ trim(($item->evaluacion->trabajador->nombre ?? '') . ' ' . ($item->evaluacion->trabajador->apellido_paterno ?? '') . ' ' . ($item->evaluacion->trabajador->apellido_materno ?? '')) ?: 'N/A' }}
                                </td>
                                <td class="px-4 py-3 text-slate-700">{{ $item->evaluacion->empresa->nombre ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ $item->evaluacion->fecha_evaluacion ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-slate-700 font-medium">{{ $item->rwl }} kg</td>
                                <td class="px-4 py-3 text-slate-700 font-medium">{{ $item->indice_levantamiento }}</td>
                                <td class="px-4 py-3">
                                    @php
                                        $riesgo = strtolower($item->nivel_riesgo ?? '');
                                        $riesgoClass = match($riesgo) {
                                            'bajo' => 'bg-emerald-100 text-emerald-700',
                                            'medio' => 'bg-amber-100 text-amber-700',
                                            default => 'bg-red-100 text-red-700',
                                        };
                                    @endphp
                                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold {{ $riesgoClass }}">
                                        {{ $item->nivel_riesgo }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('niosh.show', $item->id) }}"
                                           class="inline-flex items-center px-3 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold transition">
                                            Ver
                                        </a>
                                        <a href="{{ route('niosh.pdf', $item->id) }}"
                                           class="inline-flex items-center px-3 py-2 rounded-lg bg-slate-700 hover:bg-slate-800 text-white text-xs font-semibold transition">
                                            PDF
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-8 text-center text-slate-500">
                                    No hay evaluaciones NIOSH registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-4 border-t border-slate-200 bg-white">
                {{ $nioshEvaluaciones->links() }}
            </div>
        </div>
    </div>
</x-app-layout>