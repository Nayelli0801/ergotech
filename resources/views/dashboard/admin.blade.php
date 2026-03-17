<x-app-layout>
    @php
        $metodosLabelsJson = json_encode(array_keys($metodos));
        $metodosDataJson = json_encode(array_values($metodos));
        $riesgosLabelsJson = json_encode(array_keys($riesgoPorcentaje));
        $riesgosDataJson = json_encode(array_values($riesgoPorcentaje));
    @endphp

    <div class="space-y-6">
        <div class="flex flex-col gap-2">
            <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-slate-800">
                Panel Administrador
            </h2>
            <p class="text-sm text-slate-500 max-w-3xl">
                Vista general del sistema con métricas principales, comportamiento de evaluaciones y accesos rápidos.
            </p>
        </div>

        {{-- MÉTRICAS PRINCIPALES --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Usuarios</p>
                        <p class="mt-2 text-3xl md:text-4xl font-bold text-slate-900">{{ $totalUsuarios }}</p>
                    </div>
                    <div class="h-11 w-11 rounded-xl bg-slate-100 flex items-center justify-center text-slate-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5V4H2v16h5m10 0v-2a4 4 0 00-4-4H9a4 4 0 00-4 4v2m12 0H7m10-9a3 3 0 11-6 0 3 3 0 016 0zm-8 0a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Empresas</p>
                        <p class="mt-2 text-3xl md:text-4xl font-bold text-slate-900">{{ $totalEmpresas }}</p>
                    </div>
                    <div class="h-11 w-11 rounded-xl bg-slate-100 flex items-center justify-center text-slate-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V7l8-4 6 3v15M9 9h.01M9 12h.01M9 15h.01M13 9h.01M13 12h.01M13 15h.01"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm sm:col-span-2 xl:col-span-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Evaluaciones</p>
                        <p class="mt-2 text-3xl md:text-4xl font-bold text-slate-900">{{ $totalEvaluaciones }}</p>
                    </div>
                    <div class="h-11 w-11 rounded-xl bg-slate-100 flex items-center justify-center text-slate-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-6m3 6V7m3 10v-4m3 8H6a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2v14a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- MÉTODOS --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-base md:text-lg font-semibold text-slate-800">Resumen por método</h3>
                    <p class="text-sm text-slate-500">Distribución rápida de evaluaciones registradas.</p>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-3">
                @foreach([
                    'REBA' => $totalReba,
                    'RULA' => $totalRula,
                    'OWAS' => $totalOwas,
                    'NOM-036' => $totalNom036,
                    'NIOSH' => $totalNiosh,
                ] as $nombre => $valor)
                    <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-4">
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">{{ $nombre }}</p>
                        <p class="mt-2 text-2xl font-bold text-slate-900">{{ $valor }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ACCIONES + GRAFICAS --}}
        <div class="grid grid-cols-1 2xl:grid-cols-12 gap-6">
            <div class="2xl:col-span-4 space-y-6">
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                    <h3 class="text-base md:text-lg font-semibold text-slate-800">Acciones rápidas</h3>
                    <p class="text-sm text-slate-500 mt-1">Atajos para tareas frecuentes del sistema.</p>

                    <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 2xl:grid-cols-1 gap-3">
                        <a href="{{ route('usuarios.create') }}"
                           class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                            Crear usuario
                        </a>

                        <a href="{{ route('empresas.create') }}"
                           class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                            Nueva empresa
                        </a>

                        <a href="{{ route('evaluaciones.create') }}"
                           class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                            Nueva evaluación
                        </a>

                        <a href="{{ route('reportes.index') }}"
                           class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                            Ver reportes
                        </a>
                    </div>
                </div>

                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                    <div class="mb-4">
                        <h3 class="text-base md:text-lg font-semibold text-slate-800">% de riesgo</h3>
                        <p class="text-sm text-slate-500">Distribución porcentual general.</p>
                    </div>

                    <div class="space-y-4">
                        @foreach($riesgoPorcentaje as $nivel => $porcentaje)
                            @php
                                $barClass = match($nivel) {
                                    'Bajo' => 'bg-emerald-500',
                                    'Medio' => 'bg-amber-500',
                                    'Alto' => 'bg-red-500',
                                    'Muy alto' => 'bg-rose-700',
                                    'Inapreciable' => 'bg-slate-500',
                                    default => 'bg-blue-500',
                                };
                            @endphp

                            <div>
                                <div class="flex items-center justify-between text-sm mb-1.5">
                                    <span class="font-medium text-slate-700">{{ $nivel }}</span>
                                    <span class="font-semibold text-slate-900">{{ $porcentaje }}%</span>
                                </div>

                                <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                                    <div
                                        class="{{ $barClass }} h-2.5 rounded-full transition-all duration-500 barra-riesgo"
                                        data-width="{{ $porcentaje }}"
                                    ></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="2xl:col-span-8 grid grid-cols-1 xl:grid-cols-2 gap-6">
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                    <div class="mb-4">
                        <h3 class="text-base md:text-lg font-semibold text-slate-800">Conteo por método</h3>
                        <p class="text-sm text-slate-500">Cantidad total de evaluaciones por metodología.</p>
                    </div>
                    <div class="relative h-[260px] sm:h-[300px]">
                        <canvas id="metodosChart"></canvas>
                    </div>
                </div>

                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                    <div class="mb-4">
                        <h3 class="text-base md:text-lg font-semibold text-slate-800">Distribución de riesgo</h3>
                        <p class="text-sm text-slate-500">Participación porcentual por nivel de riesgo.</p>
                    </div>
                    <div class="relative h-[260px] sm:h-[300px]">
                        <canvas id="riesgoChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- ÚLTIMAS EVALUACIONES --}}
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-slate-200">
            <div class="px-5 py-4 border-b border-slate-200">
                <h3 class="text-base md:text-lg font-semibold text-slate-800">Últimas evaluaciones</h3>
                <p class="text-sm text-slate-500">Registros recientes dentro del sistema.</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-5 py-3 text-left font-medium text-slate-500 uppercase tracking-wider">Empresa</th>
                            <th class="px-5 py-3 text-left font-medium text-slate-500 uppercase tracking-wider">Método</th>
                            <th class="px-5 py-3 text-left font-medium text-slate-500 uppercase tracking-wider">Fecha</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($ultimasEvaluaciones as $evaluacion)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-5 py-4 whitespace-nowrap text-slate-800">
                                    {{ $evaluacion->empresa->nombre ?? 'N/A' }}
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap text-slate-700">
                                    {{ $evaluacion->metodo->nombre ?? 'N/A' }}
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap text-slate-700">
                                    {{ $evaluacion->created_at ? $evaluacion->created_at->format('d/m/Y') : 'N/A' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-5 py-8 text-center text-sm text-slate-500">
                                    No hay evaluaciones registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script id="metodos-labels-json" type="application/json">{!! $metodosLabelsJson !!}</script>
    <script id="metodos-data-json" type="application/json">{!! $metodosDataJson !!}</script>
    <script id="riesgos-labels-json" type="application/json">{!! $riesgosLabelsJson !!}</script>
    <script id="riesgos-data-json" type="application/json">{!! $riesgosDataJson !!}</script>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.barra-riesgo').forEach(function (barra) {
                    barra.style.width = (barra.dataset.width || 0) + '%';
                });

                const metodosLabels = JSON.parse(document.getElementById('metodos-labels-json').textContent);
                const metodosData = JSON.parse(document.getElementById('metodos-data-json').textContent);
                const riesgosLabels = JSON.parse(document.getElementById('riesgos-labels-json').textContent);
                const riesgosData = JSON.parse(document.getElementById('riesgos-data-json').textContent);

                const metodosCanvas = document.getElementById('metodosChart');
                if (metodosCanvas) {
                    const metodosCtx = metodosCanvas.getContext('2d');
                    new Chart(metodosCtx, {
                        type: 'bar',
                        data: {
                            labels: metodosLabels,
                            datasets: [{
                                label: 'Evaluaciones',
                                data: metodosData,
                                backgroundColor: '#334155',
                                borderRadius: 8,
                                maxBarThickness: 42
                            }]
                        },
                        options: {
                            maintainAspectRatio: false,
                            responsive: true,
                            plugins: {
                                legend: { display: false }
                            },
                            scales: {
                                x: {
                                    grid: { display: false },
                                    ticks: {
                                        color: '#475569',
                                        font: { size: 11 }
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    grid: { color: '#e2e8f0' },
                                    ticks: {
                                        precision: 0,
                                        color: '#475569',
                                        font: { size: 11 }
                                    }
                                }
                            }
                        }
                    });
                }

                const riesgoCanvas = document.getElementById('riesgoChart');
                if (riesgoCanvas) {
                    const riesgoCtx = riesgoCanvas.getContext('2d');
                    new Chart(riesgoCtx, {
                        type: 'doughnut',
                        data: {
                            labels: riesgosLabels,
                            datasets: [{
                                data: riesgosData,
                                backgroundColor: [
                                    '#10b981',
                                    '#f59e0b',
                                    '#ef4444',
                                    '#be123c',
                                    '#64748b'
                                ],
                                borderWidth: 0
                            }]
                        },
                        options: {
                            maintainAspectRatio: false,
                            responsive: true,
                            cutout: '62%',
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        boxWidth: 12,
                                        boxHeight: 12,
                                        padding: 16,
                                        color: '#334155',
                                        font: { size: 11 }
                                    }
                                }
                            }
                        }
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>