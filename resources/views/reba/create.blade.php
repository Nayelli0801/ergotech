<x-app-layout>
    <div class="max-w-6xl mx-auto py-5 px-4 sm:px-6">
        <div class="mb-5">
            <h2 class="text-xl sm:text-2xl font-bold text-blue-700">Evaluación REBA</h2>
            <p class="text-sm text-gray-500 mt-1">Completa el cuestionario. El sistema calcula en tiempo real y te muestra el detalle antes de guardar.</p>
        </div>

        @if(session('error'))
            <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('reba.store') }}" method="POST" id="rebaForm" class="space-y-5">
            @csrf

            <input type="hidden" name="empresa_id" value="{{ $datosBase['empresa_id'] }}">
            <input type="hidden" name="sucursal_id" value="{{ $datosBase['sucursal_id'] }}">
            <input type="hidden" name="puesto_id" value="{{ $datosBase['puesto_id'] }}">
            <input type="hidden" name="trabajador_id" value="{{ $datosBase['trabajador_id'] }}">
            <input type="hidden" name="fecha_evaluacion" value="{{ $datosBase['fecha_evaluacion'] }}">
            <input type="hidden" name="area_evaluada" value="{{ $datosBase['area_evaluada'] }}">
            <input type="hidden" name="actividad_general" value="{{ $datosBase['actividad_general'] }}">
            <input type="hidden" name="observaciones" value="{{ $datosBase['observaciones'] }}">

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Fecha</label>
                    <div class="text-sm text-gray-700">{{ $datosBase['fecha_evaluacion'] }}</div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Área evaluada</label>
                    <div class="text-sm text-gray-700">{{ $datosBase['area_evaluada'] ?: 'No especificada' }}</div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Actividad general</label>
                    <div class="text-sm text-gray-700">{{ $datosBase['actividad_general'] ?: 'No especificada' }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
                <section class="bg-slate-50 border border-slate-200 rounded-2xl shadow-sm p-4 sm:p-5">
                    <div class="mb-4">
                        <h3 class="text-lg sm:text-xl font-bold text-blue-700">Grupo A</h3>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <h4 class="text-base sm:text-lg font-semibold text-gray-900 mb-2">Cuello</h4>
                            <div class="space-y-2 text-sm sm:text-base">
                                <label class="flex items-start gap-2"><input type="radio" name="cuello" value="1" required class="mt-1"> <span>1 - Neutro</span></label>
                                <label class="flex items-start gap-2"><input type="radio" name="cuello" value="2" class="mt-1"> <span>2 - Flexión/Extensión &gt;20°</span></label>
                                <label class="flex items-start gap-2"><input type="radio" name="cuello" value="3" class="mt-1"> <span>3 - Con torsión/inclinación</span></label>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-base sm:text-lg font-semibold text-gray-900 mb-2">Tronco</h4>
                            <div class="space-y-2 text-sm sm:text-base">
                                <label class="flex items-start gap-2"><input type="radio" name="tronco" value="1" required class="mt-1"> <span>1 - Recto</span></label>
                                <label class="flex items-start gap-2"><input type="radio" name="tronco" value="2" class="mt-1"> <span>2 - Flexión 0–20°</span></label>
                                <label class="flex items-start gap-2"><input type="radio" name="tronco" value="3" class="mt-1"> <span>3 - Flexión 20–60°</span></label>
                                <label class="flex items-start gap-2"><input type="radio" name="tronco" value="4" class="mt-1"> <span>4 - Flexión &gt;60°</span></label>
                                <label class="flex items-start gap-2"><input type="radio" name="tronco" value="5" class="mt-1"> <span>5 - Postura severamente comprometida</span></label>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-base sm:text-lg font-semibold text-gray-900 mb-2">Piernas</h4>
                            <div class="space-y-2 text-sm sm:text-base">
                                <label class="flex items-start gap-2"><input type="radio" name="piernas" value="1" required class="mt-1"> <span>1 - Soporte bilateral</span></label>
                                <label class="flex items-start gap-2"><input type="radio" name="piernas" value="2" class="mt-1"> <span>2 - Peso desigual</span></label>
                                <label class="flex items-start gap-2"><input type="radio" name="piernas" value="3" class="mt-1"> <span>3 - En cuclillas</span></label>
                                <label class="flex items-start gap-2"><input type="radio" name="piernas" value="4" class="mt-1"> <span>4 - Apoyo inestable</span></label>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-base sm:text-lg font-semibold text-gray-900 mb-2">Carga</h4>
                            <div class="space-y-2 text-sm sm:text-base">
                                <label class="flex items-start gap-2"><input type="radio" name="carga" value="0" required class="mt-1"> <span>0 - &lt; 5 kg</span></label>
                                <label class="flex items-start gap-2"><input type="radio" name="carga" value="1" class="mt-1"> <span>1 - 5–10 kg</span></label>
                                <label class="flex items-start gap-2"><input type="radio" name="carga" value="2" class="mt-1"> <span>2 - &gt; 10 kg</span></label>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="bg-green-50 border border-green-100 rounded-2xl shadow-sm p-4 sm:p-5">
                    <div class="mb-4">
                        <h3 class="text-lg sm:text-xl font-bold text-green-700">Grupo B</h3>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <h4 class="text-base sm:text-lg font-semibold text-gray-900 mb-2">Brazo</h4>
                            <div class="space-y-2 text-sm sm:text-base">
                                <label class="flex items-start gap-2"><input type="radio" name="brazo" value="1" required class="mt-1"> <span>1 - 20° ext a 20° flex</span></label>
                                <label class="flex items-start gap-2"><input type="radio" name="brazo" value="2" class="mt-1"> <span>2 - 20°–45°</span></label>
                                <label class="flex items-start gap-2"><input type="radio" name="brazo" value="3" class="mt-1"> <span>3 - 45°–90°</span></label>
                                <label class="flex items-start gap-2"><input type="radio" name="brazo" value="4" class="mt-1"> <span>4 - &gt;90°</span></label>
                                <label class="flex items-start gap-2"><input type="radio" name="brazo" value="5" class="mt-1"> <span>5 - Elevado con ajuste adicional</span></label>
                                <label class="flex items-start gap-2"><input type="radio" name="brazo" value="6" class="mt-1"> <span>6 - Muy elevado con ajuste adicional</span></label>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-base sm:text-lg font-semibold text-gray-900 mb-2">Antebrazo</h4>
                            <div class="space-y-2 text-sm sm:text-base">
                                <label class="flex items-start gap-2"><input type="radio" name="antebrazo" value="1" required class="mt-1"> <span>1 - 60°–100°</span></label>
                                <label class="flex items-start gap-2"><input type="radio" name="antebrazo" value="2" class="mt-1"> <span>2 - Fuera de rango</span></label>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-base sm:text-lg font-semibold text-gray-900 mb-2">Muñeca</h4>
                            <div class="space-y-2 text-sm sm:text-base">
                                <label class="flex items-start gap-2"><input type="radio" name="muneca" value="1" required class="mt-1"> <span>1 - Neutra</span></label>
                                <label class="flex items-start gap-2"><input type="radio" name="muneca" value="2" class="mt-1"> <span>2 - Flexión/extensión &gt;15°</span></label>
                                <label class="flex items-start gap-2"><input type="radio" name="muneca" value="3" class="mt-1"> <span>3 - Con desviación</span></label>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-base sm:text-lg font-semibold text-gray-900 mb-2">Calidad de agarre</h4>
                            <div class="space-y-2 text-sm sm:text-base">
                                <label class="flex items-start gap-2"><input type="radio" name="tipo_agarre" value="0" required class="mt-1"> <span>0 - Bueno</span></label>
                                <label class="flex items-start gap-2"><input type="radio" name="tipo_agarre" value="1" class="mt-1"> <span>1 - Regular</span></label>
                                <label class="flex items-start gap-2"><input type="radio" name="tipo_agarre" value="2" class="mt-1"> <span>2 - Malo</span></label>
                                <label class="flex items-start gap-2"><input type="radio" name="tipo_agarre" value="3" class="mt-1"> <span>3 - Muy malo</span></label>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-base sm:text-lg font-semibold text-gray-900 mb-2">Actividad REBA</h4>
                            <div class="space-y-2 text-sm sm:text-base">
                                <label class="flex items-start gap-2"><input type="radio" name="actividad_reba" value="0" required class="mt-1"> <span>0 - Sin repetición importante</span></label>
                                <label class="flex items-start gap-2"><input type="radio" name="actividad_reba" value="1" class="mt-1"> <span>1 - Repetitiva leve</span></label>
                                <label class="flex items-start gap-2"><input type="radio" name="actividad_reba" value="2" class="mt-1"> <span>2 - Repetitiva moderada</span></label>
                                <label class="flex items-start gap-2"><input type="radio" name="actividad_reba" value="3" class="mt-1"> <span>3 - Repetitiva intensa</span></label>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <div class="flex flex-wrap gap-3">
                <button type="button" id="btnCalcularManual"
                    class="bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold px-5 py-2.5 rounded-lg shadow-sm">
                    Calcular
                </button>

                <button type="submit" id="btnGuardar"
                    class="bg-green-600 text-white text-sm font-semibold px-5 py-2.5 rounded-lg shadow-sm disabled:opacity-50 disabled:cursor-not-allowed"
                    disabled>
                    Guardar evaluación
                </button>

                <a href="{{ route('evaluaciones.index') }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-semibold px-5 py-2.5 rounded-lg">
                    Cancelar
                </a>
            </div>

            <div id="resultadoReba" class="hidden bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-5">
                <h3 class="text-lg sm:text-xl font-bold text-blue-700 mb-4">Resultado previo</h3>

                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-5">
                    <div class="bg-slate-50 border rounded-xl p-3">
                        <p class="text-xs uppercase tracking-wide text-gray-500">Puntuación A</p>
                        <p id="prevA" class="text-xl font-bold text-slate-700 mt-1">0</p>
                    </div>
                    <div class="bg-green-50 border rounded-xl p-3">
                        <p class="text-xs uppercase tracking-wide text-gray-500">Puntuación B</p>
                        <p id="prevB" class="text-xl font-bold text-green-700 mt-1">0</p>
                    </div>
                    <div class="bg-yellow-50 border rounded-xl p-3">
                        <p class="text-xs uppercase tracking-wide text-gray-500">Puntuación C</p>
                        <p id="prevC" class="text-xl font-bold text-yellow-700 mt-1">0</p>
                    </div>
                    <div class="bg-purple-50 border rounded-xl p-3">
                        <p class="text-xs uppercase tracking-wide text-gray-500">Puntuación Final</p>
                        <p id="prevFinal" class="text-xl font-bold text-purple-700 mt-1">0</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-5">
                    <div class="rounded-xl bg-blue-50 border border-blue-100 p-4">
                        <p class="text-sm"><span class="font-semibold">Nivel de riesgo:</span> <span id="prevNivel">-</span></p>
                    </div>
                    <div class="rounded-xl bg-amber-50 border border-amber-100 p-4">
                        <p class="text-sm"><span class="font-semibold">Acción requerida:</span> <span id="prevAccion">-</span></p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div class="bg-slate-50 rounded-xl p-4 border">
                        <h4 class="text-base font-semibold mb-3 text-blue-700">Detalle Grupo A</h4>
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li><strong>Cuello:</strong> <span id="dCuello">-</span></li>
                            <li><strong>Tronco:</strong> <span id="dTronco">-</span></li>
                            <li><strong>Piernas:</strong> <span id="dPiernas">-</span></li>
                            <li><strong>Carga:</strong> <span id="dCarga">-</span></li>
                        </ul>
                    </div>

                    <div class="bg-green-50 rounded-xl p-4 border">
                        <h4 class="text-base font-semibold mb-3 text-green-700">Detalle Grupo B</h4>
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li><strong>Brazo:</strong> <span id="dBrazo">-</span></li>
                            <li><strong>Antebrazo:</strong> <span id="dAntebrazo">-</span></li>
                            <li><strong>Muñeca:</strong> <span id="dMuneca">-</span></li>
                            <li><strong>Agarre:</strong> <span id="dAgarre">-</span></li>
                            <li><strong>Actividad:</strong> <span id="dActividad">-</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script type="application/json" id="reba-matrices">
        @json($matrices)
    </script>

    <script>
        const rebaMatrices = JSON.parse(
            document.getElementById('reba-matrices').textContent
        );

        const riskLevels = [
            { max: 1, nivel: 'Inapreciable', accion: 'No requiere acción.' },
            { max: 3, nivel: 'Bajo', accion: 'Puede ser necesaria alguna acción.' },
            { max: 7, nivel: 'Medio', accion: 'Se requiere acción.' },
            { max: 10, nivel: 'Alto', accion: 'Se requiere acción pronto.' },
            { max: 99, nivel: 'Muy alto', accion: 'Se requiere actuación inmediata.' }
        ];

        const btnGuardar = document.getElementById('btnGuardar');
        const btnCalcularManual = document.getElementById('btnCalcularManual');

        function getRadioValue(name) {
            const selected = document.querySelector(`input[name="${name}"]:checked`);
            return selected ? parseInt(selected.value) : null;
        }

        function getRadioText(name) {
            const selected = document.querySelector(`input[name="${name}"]:checked`);
            return selected ? selected.parentElement.innerText.trim() : '-';
        }

        function clasificarRiesgo(finalScore) {
            return riskLevels.find(item => finalScore <= item.max);
        }

        function allComplete() {
            return [
                'cuello', 'tronco', 'piernas', 'carga',
                'brazo', 'antebrazo', 'muneca', 'tipo_agarre',
                'actividad_reba'
            ].every(name => getRadioValue(name) !== null);
        }

        function calcularReba() {
            if (!allComplete()) {
                btnGuardar.disabled = true;
                return false;
            }

            const cuello = getRadioValue('cuello');
            const tronco = getRadioValue('tronco');
            const piernas = getRadioValue('piernas');
            const carga = getRadioValue('carga');
            const brazo = getRadioValue('brazo');
            const antebrazo = getRadioValue('antebrazo');
            const muneca = getRadioValue('muneca');
            const agarre = getRadioValue('tipo_agarre');
            const actividad = getRadioValue('actividad_reba');

            const aBase = rebaMatrices.tablaA[tronco][cuello][piernas];
            let puntuacionA = aBase + carga;
            puntuacionA = Math.max(1, Math.min(12, puntuacionA));

            const bBase = rebaMatrices.tablaB[brazo][antebrazo][muneca];
            let puntuacionB = bBase + agarre;
            puntuacionB = Math.max(1, Math.min(12, puntuacionB));

            const puntuacionC = rebaMatrices.tablaC[puntuacionA][puntuacionB];
            const puntuacionFinal = puntuacionC + actividad;

            const clasificacion = clasificarRiesgo(puntuacionFinal);

            document.getElementById('prevA').innerText = puntuacionA;
            document.getElementById('prevB').innerText = puntuacionB;
            document.getElementById('prevC').innerText = puntuacionC;
            document.getElementById('prevFinal').innerText = puntuacionFinal;
            document.getElementById('prevNivel').innerText = clasificacion.nivel;
            document.getElementById('prevAccion').innerText = clasificacion.accion;

            document.getElementById('dCuello').innerText = getRadioText('cuello');
            document.getElementById('dTronco').innerText = getRadioText('tronco');
            document.getElementById('dPiernas').innerText = getRadioText('piernas');
            document.getElementById('dCarga').innerText = getRadioText('carga');
            document.getElementById('dBrazo').innerText = getRadioText('brazo');
            document.getElementById('dAntebrazo').innerText = getRadioText('antebrazo');
            document.getElementById('dMuneca').innerText = getRadioText('muneca');
            document.getElementById('dAgarre').innerText = getRadioText('tipo_agarre');
            document.getElementById('dActividad').innerText = getRadioText('actividad_reba');

            document.getElementById('resultadoReba').classList.remove('hidden');
            btnGuardar.disabled = false;
            return true;
        }

        document.querySelectorAll('input[type="radio"]').forEach(input => {
            input.addEventListener('change', () => {
                if (allComplete()) {
                    calcularReba();
                } else {
                    btnGuardar.disabled = true;
                }
            });
        });

        btnCalcularManual.addEventListener('click', () => {
            if (!calcularReba()) {
                alert('Completa todo el cuestionario antes de calcular.');
            } else {
                document.getElementById('resultadoReba').scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });

        document.getElementById('rebaForm').addEventListener('submit', function (e) {
            if (!calcularReba()) {
                e.preventDefault();
                alert('Completa y calcula la evaluación antes de guardar.');
            }
        });
    </script>
</x-app-layout>