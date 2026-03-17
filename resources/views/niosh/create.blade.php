<x-app-layout>
    <div class="max-w-6xl mx-auto py-6 px-4 sm:px-6 space-y-5">
        <div>
            <h2 class="text-2xl font-bold text-blue-700">Evaluación NIOSH</h2>
            <p class="text-sm text-gray-500 mt-1">
                Captura los datos de levantamiento manual. El sistema calculará automáticamente los multiplicadores, el RWL, el índice de levantamiento y el nivel de riesgo.
            </p>
        </div>

        @if(session('error'))
            <div class="rounded-lg bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="rounded-lg bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('niosh.store', $evaluacion->id) }}" method="POST" class="space-y-5" id="nioshForm">
            @csrf

            {{-- Datos base --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                <h3 class="text-lg font-bold text-blue-700 mb-4">1. Datos generales</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm">
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Empresa</label>
                        <div class="text-gray-700">{{ $evaluacion->empresa->nombre ?? 'N/A' }}</div>
                    </div>

                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Sucursal</label>
                        <div class="text-gray-700">{{ $evaluacion->sucursal->nombre ?? 'N/A' }}</div>
                    </div>

                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Puesto</label>
                        <div class="text-gray-700">{{ $evaluacion->puesto->nombre ?? 'N/A' }}</div>
                    </div>

                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Trabajador</label>
                        <div class="text-gray-700">{{ $evaluacion->trabajador->nombre ?? 'N/A' }}</div>
                    </div>

                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Fecha</label>
                        <div class="text-gray-700">{{ $evaluacion->fecha_evaluacion ?? 'N/A' }}</div>
                    </div>

                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">Actividad general</label>
                        <div class="text-gray-700">{{ $evaluacion->actividad ?? 'No especificada' }}</div>
                    </div>
                </div>
            </div>

            {{-- Configuración --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                <h3 class="text-lg font-bold text-blue-700 mb-4">2. Configuración de la tarea</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Control significativo en el destino</label>
                        <select name="control_destino" id="control_destino"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                            <option value="no">No</option>
                            <option value="si">Sí</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Peso del objeto (kg)</label>
                        <input type="number" step="0.01" min="0" name="peso_objeto" id="peso_objeto"
                            value="{{ old('peso_objeto') }}"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Ej. 12">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Duración</label>
                        <select name="duracion" id="duracion"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Seleccione</option>
                            <option value="corta" {{ old('duracion') == 'corta' ? 'selected' : '' }}>Corta (≤ 1 h)</option>
                            <option value="moderada" {{ old('duracion') == 'moderada' ? 'selected' : '' }}>Moderada (1 a 2 h)</option>
                            <option value="larga" {{ old('duracion') == 'larga' ? 'selected' : '' }}>Larga (2 a 8 h)</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Datos de origen --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                <h3 class="text-lg font-bold text-blue-700 mb-4">3. Datos del levantamiento</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Distancia horizontal (H) en cm</label>
                        <input type="number" step="0.01" min="0" name="distancia_horizontal"
                            value="{{ old('distancia_horizontal') }}"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Ej. 40">
                        <p class="text-xs text-gray-500 mt-1">Distancia entre las manos y el cuerpo al levantar.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Altura inicial (V) en cm</label>
                        <input type="number" step="0.01" min="0" name="altura_inicial"
                            value="{{ old('altura_inicial') }}"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Ej. 75">
                        <p class="text-xs text-gray-500 mt-1">Altura de las manos al inicio del levantamiento.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Desplazamiento vertical (D) en cm</label>
                        <input type="number" step="0.01" min="0" name="desplazamiento_vertical"
                            value="{{ old('desplazamiento_vertical') }}"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Ej. 50">
                        <p class="text-xs text-gray-500 mt-1">Recorrido vertical total de la carga.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ángulo de asimetría (A) en grados</label>
                        <input type="number" step="0.01" min="0" name="angulo_asimetria"
                            value="{{ old('angulo_asimetria') }}"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Ej. 15">
                        <p class="text-xs text-gray-500 mt-1">Giro del tronco o del cuerpo durante el levantamiento.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Frecuencia de levantamiento (lev/min)</label>
                        <input type="number" step="0.01" min="0" name="frecuencia_levantamiento"
                            value="{{ old('frecuencia_levantamiento') }}"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Ej. 8">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Calidad de agarre</label>
                        <select name="calidad_agarre"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Seleccione</option>
                            <option value="bueno" {{ old('calidad_agarre') == 'bueno' ? 'selected' : '' }}>Bueno</option>
                            <option value="regular" {{ old('calidad_agarre') == 'regular' ? 'selected' : '' }}>Regular</option>
                            <option value="malo" {{ old('calidad_agarre') == 'malo' ? 'selected' : '' }}>Malo</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Vista previa --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                <h3 class="text-lg font-bold text-blue-700 mb-4">4. Resultado previo</h3>

                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-3 text-center">
                    <div class="rounded-xl border bg-slate-50 p-3">
                        <div class="text-xs text-gray-500">HM</div>
                        <div class="text-lg font-bold" id="prevHM">-</div>
                    </div>
                    <div class="rounded-xl border bg-slate-50 p-3">
                        <div class="text-xs text-gray-500">VM</div>
                        <div class="text-lg font-bold" id="prevVM">-</div>
                    </div>
                    <div class="rounded-xl border bg-slate-50 p-3">
                        <div class="text-xs text-gray-500">DM</div>
                        <div class="text-lg font-bold" id="prevDM">-</div>
                    </div>
                    <div class="rounded-xl border bg-slate-50 p-3">
                        <div class="text-xs text-gray-500">AM</div>
                        <div class="text-lg font-bold" id="prevAM">-</div>
                    </div>
                    <div class="rounded-xl border bg-slate-50 p-3">
                        <div class="text-xs text-gray-500">FM</div>
                        <div class="text-lg font-bold" id="prevFM">-</div>
                    </div>
                    <div class="rounded-xl border bg-slate-50 p-3">
                        <div class="text-xs text-gray-500">CM</div>
                        <div class="text-lg font-bold" id="prevCM">-</div>
                    </div>
                    <div class="rounded-xl border bg-blue-50 p-3 border-blue-100">
                        <div class="text-xs text-gray-500">RWL</div>
                        <div class="text-lg font-bold text-blue-700" id="prevRWL">-</div>
                    </div>
                    <div class="rounded-xl border bg-red-50 p-3 border-red-100">
                        <div class="text-xs text-gray-500">IL</div>
                        <div class="text-lg font-bold text-red-700" id="prevIL">-</div>
                    </div>
                </div>

                <div class="mt-4 rounded-xl border bg-amber-50 border-amber-100 p-4">
                    <p class="text-sm">
                        <span class="font-semibold">Nivel de riesgo:</span>
                        <span id="prevNivel">-</span>
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap gap-3">
                <button type="button" id="btnCalcularNiosh"
                    class="bg-blue-700 hover:bg-blue-800 text-white font-semibold px-5 py-2.5 rounded-lg shadow-sm">
                    Calcular
                </button>

                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2.5 rounded-lg shadow-sm">
                    Guardar evaluación NIOSH
                </button>

                <a href="{{ route('evaluaciones.index') }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2.5 rounded-lg">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

    <script>
        function redondear(valor) {
            return Math.round(valor * 1000) / 1000;
        }

        function obtenerCM(agarre, v) {
            agarre = (agarre || '').toLowerCase();

            if (agarre === 'bueno') return 1.0;
            if (agarre === 'regular') return v < 75 ? 0.95 : 1.0;
            if (agarre === 'malo') return 0.90;
            return 1.0;
        }

        function obtenerFM(frecuencia, duracion) {
            frecuencia = parseFloat(frecuencia || 0);

            if (duracion === 'corta') {
                if (frecuencia <= 0.2) return 1.00;
                if (frecuencia <= 1) return 0.94;
                if (frecuencia <= 2) return 0.91;
                if (frecuencia <= 3) return 0.88;
                if (frecuencia <= 4) return 0.84;
                if (frecuencia <= 5) return 0.80;
                if (frecuencia <= 6) return 0.75;
                if (frecuencia <= 7) return 0.70;
                if (frecuencia <= 8) return 0.60;
                return 0.45;
            }

            if (duracion === 'moderada') {
                if (frecuencia <= 0.2) return 0.95;
                if (frecuencia <= 1) return 0.88;
                if (frecuencia <= 2) return 0.84;
                if (frecuencia <= 3) return 0.79;
                if (frecuencia <= 4) return 0.72;
                if (frecuencia <= 5) return 0.60;
                if (frecuencia <= 6) return 0.50;
                return 0.35;
            }

            if (duracion === 'larga') {
                if (frecuencia <= 0.2) return 0.85;
                if (frecuencia <= 1) return 0.75;
                if (frecuencia <= 2) return 0.65;
                if (frecuencia <= 3) return 0.55;
                if (frecuencia <= 4) return 0.45;
                if (frecuencia <= 5) return 0.35;
                return 0.25;
            }

            return 1.0;
        }

        function clasificarIL(il) {
            if (il <= 1) return 'Bajo';
            if (il <= 3) return 'Medio';
            return 'Alto';
        }

        function calcularNioshPrevio() {
            const H = parseFloat(document.querySelector('[name="distancia_horizontal"]').value || 0);
            const V = parseFloat(document.querySelector('[name="altura_inicial"]').value || 0);
            const D = parseFloat(document.querySelector('[name="desplazamiento_vertical"]').value || 0);
            const A = parseFloat(document.querySelector('[name="angulo_asimetria"]').value || 0);
            const F = parseFloat(document.querySelector('[name="frecuencia_levantamiento"]').value || 0);
            const peso = parseFloat(document.querySelector('[name="peso_objeto"]').value || 0);
            const duracion = document.querySelector('[name="duracion"]').value || '';
            const agarre = document.querySelector('[name="calidad_agarre"]').value || '';

            if (!H || !V || !D || !peso || !duracion || !agarre) {
                return false;
            }

            const LC = 23;
            const HM = Math.min(1, 25 / H);
            const VM = Math.max(0, 1 - (0.003 * Math.abs(V - 75)));
            const DM = Math.min(1, 0.82 + (4.5 / D));
            const AM = Math.max(0, 1 - (0.0032 * A));
            const FM = obtenerFM(F, duracion);
            const CM = obtenerCM(agarre, V);

            const RWL = LC * HM * VM * DM * AM * FM * CM;
            const IL = peso / RWL;
            const nivel = clasificarIL(IL);

            document.getElementById('prevHM').innerText = redondear(HM);
            document.getElementById('prevVM').innerText = redondear(VM);
            document.getElementById('prevDM').innerText = redondear(DM);
            document.getElementById('prevAM').innerText = redondear(AM);
            document.getElementById('prevFM').innerText = redondear(FM);
            document.getElementById('prevCM').innerText = redondear(CM);
            document.getElementById('prevRWL').innerText = redondear(RWL);
            document.getElementById('prevIL').innerText = redondear(IL);
            document.getElementById('prevNivel').innerText = nivel;

            return true;
        }

        document.getElementById('btnCalcularNiosh').addEventListener('click', function () {
            if (!calcularNioshPrevio()) {
                alert('Completa los datos principales para calcular el resultado previo.');
            }
        });

        document.querySelectorAll('#nioshForm input, #nioshForm select').forEach(el => {
            el.addEventListener('change', calcularNioshPrevio);
            el.addEventListener('input', calcularNioshPrevio);
        });
    </script>
</x-app-layout>