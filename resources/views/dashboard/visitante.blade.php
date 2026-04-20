<x-app-layout>

    @php
        $metodosLabelsJson = json_encode(array_keys($metodos));
        $metodosDataJson = json_encode(array_values($metodos));
        $riesgosLabelsJson = json_encode(array_keys($riesgoPorcentaje));
        $riesgosDataJson = json_encode(array_values($riesgoPorcentaje));
    @endphp

    <div class="space-y-6">

        {{-- HEADER --}}
        <div>
            <h2 class="text-2xl md:text-3xl font-bold text-slate-800">
                Panel de Consulta
            </h2>
            <p class="text-sm text-slate-500">
                Visualiza información general de las evaluaciones ergonómicas registradas en el sistema.
            </p>
        </div>

        {{-- RESUMEN GENERAL --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <div class="bg-white border rounded-2xl p-5 shadow-sm">
                <p class="text-sm text-slate-500">Total de evaluaciones</p>
                <p class="text-3xl font-bold text-slate-800 mt-1">
                    {{ $totalEvaluaciones }}
                </p>
            </div>

            <div class="bg-white border rounded-2xl p-5 shadow-sm">
                <p class="text-sm text-slate-500">Método más utilizado</p>
                <p class="text-lg font-semibold text-slate-800 mt-1">
                    {{ array_key_first($metodos) ?? 'N/A' }}
                </p>
            </div>

            <div class="bg-white border rounded-2xl p-5 shadow-sm">
                <p class="text-sm text-slate-500">Nivel de riesgo predominante</p>
                <p class="text-lg font-semibold text-slate-800 mt-1">
                    {{ array_key_first($riesgoPorcentaje) ?? 'N/A' }}
                </p>
            </div>

        </div>

        {{-- GRÁFICAS --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- MÉTODOS --}}
            <div class="bg-white border rounded-2xl p-5 shadow-sm">
                <h3 class="font-semibold text-slate-800 mb-2">
                    Evaluaciones por método
                </h3>
                <p class="text-sm text-slate-500 mb-4">
                    Distribución general de evaluaciones realizadas.
                </p>

                <div class="h-[280px]">
                    <canvas id="metodosChart"></canvas>
                </div>
            </div>

            {{-- RIESGO --}}
            <div class="bg-white border rounded-2xl p-5 shadow-sm">
                <h3 class="font-semibold text-slate-800 mb-2">
                    Niveles de riesgo
                </h3>
                <p class="text-sm text-slate-500 mb-4">
                    Porcentaje de riesgo detectado en evaluaciones.
                </p>

                <div class="h-[280px]">
                    <canvas id="riesgoChart"></canvas>
                </div>
            </div>

        </div>

        {{-- BARRAS DE RIESGO --}}
        <div class="bg-white border rounded-2xl p-5 shadow-sm">
            <h3 class="font-semibold text-slate-800 mb-4">
                Distribución de riesgo (%)
            </h3>

            <div class="space-y-4">
                @foreach($riesgoPorcentaje as $nivel => $porcentaje)

                    @php
                        $color = match($nivel) {
                            'Bajo' => 'bg-emerald-500',
                            'Medio' => 'bg-amber-500',
                            'Alto' => 'bg-red-500',
                            'Muy alto' => 'bg-rose-700',
                            default => 'bg-slate-500'
                        };
                    @endphp

                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span>{{ $nivel }}</span>
                            <span class="font-semibold">{{ $porcentaje }}%</span>
                        </div>

                        <div class="w-full bg-gray-200 h-2 rounded-full">
                            <div class="{{ $color }} h-2 rounded-full barra" data-width="{{ $porcentaje }}"></div>
                        </div>
                    </div>

                @endforeach
            </div>
        </div>

    </div>

    {{-- DATA --}}
    <script id="metodos-labels-json" type="application/json">{!! $metodosLabelsJson !!}</script>
    <script id="metodos-data-json" type="application/json">{!! $metodosDataJson !!}</script>
    <script id="riesgos-labels-json" type="application/json">{!! $riesgosLabelsJson !!}</script>
    <script id="riesgos-data-json" type="application/json">{!! $riesgosDataJson !!}</script>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // barras animadas
            document.querySelectorAll('.barra').forEach(b => {
                b.style.width = (b.dataset.width || 0) + '%';
            });

            const metodosLabels = JSON.parse(document.getElementById('metodos-labels-json').textContent);
            const metodosData = JSON.parse(document.getElementById('metodos-data-json').textContent);

            const riesgosLabels = JSON.parse(document.getElementById('riesgos-labels-json').textContent);
            const riesgosData = JSON.parse(document.getElementById('riesgos-data-json').textContent);

            // chart métodos
            new Chart(document.getElementById('metodosChart'), {
                type: 'bar',
                data: {
                    labels: metodosLabels,
                    datasets: [{
                        data: metodosData
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } }
                }
            });

            // chart riesgo
            new Chart(document.getElementById('riesgoChart'), {
                type: 'doughnut',
                data: {
                    labels: riesgosLabels,
                    datasets: [{
                        data: riesgosData
                    }]
                },
                options: {
                    responsive: true,
                    cutout: '60%'
                }
            });

        });
    </script>
    @endpush

</x-app-layout>
