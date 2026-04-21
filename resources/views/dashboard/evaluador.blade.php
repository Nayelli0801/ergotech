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
                Panel de Consulta
            </h2>
            <p class="text-sm text-slate-500 max-w-3xl">
                Resumen de evaluaciones registradas y comportamiento general de los niveles de riesgo.
            </p>
        </div>

        {{-- MÉTRICAS --}}
        <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-4">
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm col-span-2 md:col-span-1">
                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Total</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalEvaluaciones }}</p>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">REBA</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalReba }}</p>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">RULA</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalRula }}</p>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">OWAS</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalOwas }}</p>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">NOM-036</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalNom036 }}</p>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">NIOSH</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalNiosh }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 2xl:grid-cols-12 gap-6">
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

            <div class="2xl:col-span-4 bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
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