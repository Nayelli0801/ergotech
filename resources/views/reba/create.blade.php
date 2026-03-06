<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4">
        <h2 class="text-2xl font-bold text-blue-700 mb-5">Evaluación REBA</h2>

        @if(session('error'))
            <div class="mb-4 rounded-lg bg-red-100 border border-red-300 text-red-700 px-4 py-3">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 rounded-lg bg-red-100 border border-red-300 text-red-700 px-4 py-3">
                <ul class="list-disc pl-5 text-sm">
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
            <input type="hidden" name="fecha" value="{{ $datosBase['fecha'] }}">
            <input type="hidden" name="observaciones" value="{{ $datosBase['observaciones'] }}">

            <div class="bg-white rounded-xl shadow border border-gray-200 p-4">
                <p class="text-sm text-gray-700">
                    <strong>Fecha:</strong> {{ $datosBase['fecha'] }}
                </p>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-5">
                <!-- Grupo A -->
                <div class="bg-slate-100 rounded-xl p-6 shadow border border-slate-200">
                    <h3 class="text-2xl font-bold text-blue-700 mb-6">Grupo A</h3>

                    <div class="mb-6">
                        <h4 class="text-xl font-semibold mb-3">Cuello</h4>
                        <div class="space-y-2 text-lg">
                            <label class="flex items-start gap-3">
                                <input type="radio" name="cuello" value="1" required class="mt-1">
                                <span>1 - Neutro</span>
                            </label>
                            <label class="flex items-start gap-3">
                                <input type="radio" name="cuello" value="2" class="mt-1">
                                <span>2 - Flexión/Extensión &gt;20°</span>
                            </label>
                            <label class="flex items-start gap-3">
                                <input type="radio" name="cuello" value="3" class="mt-1">
                                <span>3 - Con torsión/inclinación</span>
                            </label>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-xl font-semibold mb-3">Tronco</h4>
                        <div class="space-y-2 text-lg">
                            <label class="flex items-start gap-3">
                                <input type="radio" name="tronco" value="1" required class="mt-1">
                                <span>1 - Recto</span>
                            </label>
                            <label class="flex items-start gap-3">
                                <input type="radio" name="tronco" value="2" class="mt-1">
                                <span>2 - Flexión 0–20°</span>
                            </label>
                            <label class="flex items-start gap-3">
                                <input type="radio" name="tronco" value="3" class="mt-1">
                                <span>3 - Flexión 20–60°</span>
                            </label>
                            <label class="flex items-start gap-3">
                                <input type="radio" name="tronco" value="4" class="mt-1">
                                <span>4 - Flexión &gt;60°</span>
                            </label>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-xl font-semibold mb-3">Piernas</h4>
                        <div class="space-y-2 text-lg">
                            <label class="flex items-start gap-3">
                                <input type="radio" name="piernas" value="1" required class="mt-1">
                                <span>1 - Soporte bilateral</span>
                            </label>
                            <label class="flex items-start gap-3">
                                <input type="radio" name="piernas" value="2" class="mt-1">
                                <span>2 - Peso desigual</span>
                            </label>
                            <label class="flex items-start gap-3">
                                <input type="radio" name="piernas" value="3" class="mt-1">
                                <span>3 - En cuclillas</span>
                            </label>
                            <label class="flex items-start gap-3">
                                <input type="radio" name="piernas" value="4" class="mt-1">
                                <span>4 - Apoyo inestable</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-xl font-semibold mb-3">Carga</h4>
                        <div class="space-y-2 text-lg">
                            <label class="flex items-start gap-3">
                                <input type="radio" name="carga" value="0" required class="mt-1">
                                <span>0 - &lt; 5 kg</span>
                            </label>
                            <label class="flex items-start gap-3">
                                <input type="radio" name="carga" value="1" class="mt-1">
                                <span>1 - 5–10 kg</span>
                            </label>
                            <label class="flex items-start gap-3">
                                <input type="radio" name="carga" value="2" class="mt-1">
                                <span>2 - &gt; 10 kg</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Grupo B -->
                <div class="bg-green-50 rounded-xl p-6 shadow border border-green-100">
                    <h3 class="text-2xl font-bold text-green-700 mb-6">Grupo B</h3>

                    <div class="mb-6">
                        <h4 class="text-xl font-semibold mb-3">Brazo</h4>
                        <div class="space-y-2 text-lg">
                            <label class="flex items-start gap-3">
                                <input type="radio" name="brazo" value="1" required class="mt-1">
                                <span>1 - 20° ext a 20° flex</span>
                            </label>
                            <label class="flex items-start gap-3">
                                <input type="radio" name="brazo" value="2" class="mt-1">
                                <span>2 - 20°–45°</span>
                            </label>
                            <label class="flex items-start gap-3">
                                <input type="radio" name="brazo" value="3" class="mt-1">
                                <span>3 - 45°–90°</span>
                            </label>
                            <label class="flex items-start gap-3">
                                <input type="radio" name="brazo" value="4" class="mt-1">
                                <span>4 - &gt;90°</span>
                            </label>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-xl font-semibold mb-3">Antebrazo</h4>
                        <div class="space-y-2 text-lg">
                            <label class="flex items-start gap-3">
                                <input type="radio" name="antebrazo" value="1" required class="mt-1">
                                <span>1 - 60°–100°</span>
                            </label>
                            <label class="flex items-start gap-3">
                                <input type="radio" name="antebrazo" value="2" class="mt-1">
                                <span>2 - Fuera de rango</span>
                            </label>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-xl font-semibold mb-3">Muñeca</h4>
                        <div class="space-y-2 text-lg">
                            <label class="flex items-start gap-3">
                                <input type="radio" name="muneca" value="1" required class="mt-1">
                                <span>1 - Neutra</span>
                            </label>
                            <label class="flex items-start gap-3">
                                <input type="radio" name="muneca" value="2" class="mt-1">
                                <span>2 - Flexión/extensión &gt;15°</span>
                            </label>
                            <label class="flex items-start gap-3">
                                <input type="radio" name="muneca" value="3" class="mt-1">
                                <span>3 - Con desviación</span>
                            </label>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-xl font-semibold mb-3">Tipo de agarre</h4>
                        <div class="space-y-2 text-lg">
                            <label class="flex items-start gap-3">
                                <input type="radio" name="tipo_agarre" value="0" required class="mt-1">
                                <span>0 - Bueno</span>
                            </label>
                            <label class="flex items-start gap-3">
                                <input type="radio" name="tipo_agarre" value="1" class="mt-1">
                                <span>1 - Regular</span>
                            </label>
                            <label class="flex items-start gap-3">
                                <input type="radio" name="tipo_agarre" value="2" class="mt-1">
                                <span>2 - Malo</span>
                            </label>
                            <label class="flex items-start gap-3">
                                <input type="radio" name="tipo_agarre" value="3" class="mt-1">
                                <span>3 - Muy malo</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-xl font-semibold mb-3">Actividad</h4>
                        <div class="space-y-2 text-lg">
                            <label class="flex items-start gap-3">
                                <input type="radio" name="actividad" value="0" required class="mt-1">
                                <span>0 - Sin repetición importante</span>
                            </label>
                            <label class="flex items-start gap-3">
                                <input type="radio" name="actividad" value="1" class="mt-1">
                                <span>1 - Repetitiva leve</span>
                            </label>
                            <label class="flex items-start gap-3">
                                <input type="radio" name="actividad" value="2" class="mt-1">
                                <span>2 - Repetitiva moderada</span>
                            </label>
                            <label class="flex items-start gap-3">
                                <input type="radio" name="actividad" value="3" class="mt-1">
                                <span>3 - Repetitiva intensa</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap gap-3">
                <button type="button" onclick="calcularReba()"
                    class="bg-blue-700 hover:bg-blue-800 text-white font-semibold px-5 py-2.5 rounded-lg shadow">
                    Calcular
                </button>

                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2.5 rounded-lg shadow">
                    Guardar evaluación
                </button>

                <a href="{{ route('evaluaciones.index') }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2.5 rounded-lg">
                    Cancelar
                </a>
            </div>

            <div id="resultadoReba" class="hidden bg-white rounded-xl shadow border border-gray-200 p-5">
                <h3 class="text-xl font-bold text-blue-700 mb-4">Resultado previo</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-5">
                    <div class="bg-slate-100 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Puntuación A</p>
                        <p id="prevA" class="text-2xl font-bold text-slate-700">0</p>
                    </div>
                    <div class="bg-green-100 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Puntuación B</p>
                        <p id="prevB" class="text-2xl font-bold text-green-700">0</p>
                    </div>
                    <div class="bg-yellow-100 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Puntuación C</p>
                        <p id="prevC" class="text-2xl font-bold text-yellow-700">0</p>
                    </div>
                    <div class="bg-purple-100 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Puntuación Final</p>
                        <p id="prevFinal" class="text-2xl font-bold text-purple-700">0</p>
                    </div>
                </div>

                <div class="mb-5 text-base">
                    <p><strong>Nivel de riesgo:</strong> <span id="prevNivel">-</span></p>
                    <p><strong>Acción requerida:</strong> <span id="prevAccion">-</span></p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="bg-slate-50 rounded-lg p-4 border">
                        <h4 class="text-lg font-semibold mb-3 text-blue-700">Detalle Grupo A</h4>
                        <ul class="space-y-2 text-sm">
                            <li><strong>Cuello:</strong> <span id="dCuello">-</span></li>
                            <li><strong>Tronco:</strong> <span id="dTronco">-</span></li>
                            <li><strong>Piernas:</strong> <span id="dPiernas">-</span></li>
                            <li><strong>Carga:</strong> <span id="dCarga">-</span></li>
                        </ul>
                    </div>

                    <div class="bg-green-50 rounded-lg p-4 border">
                        <h4 class="text-lg font-semibold mb-3 text-green-700">Detalle Grupo B</h4>
                        <ul class="space-y-2 text-sm">
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

    <script>
        function getRadioValue(name) {
            const selected = document.querySelector(`input[name="${name}"]:checked`);
            return selected ? parseInt(selected.value) : null;
        }

        function getRadioText(name) {
            const selected = document.querySelector(`input[name="${name}"]:checked`);
            return selected ? selected.parentElement.innerText.trim() : '-';
        }

        function calcularReba() {
            const cuello = getRadioValue('cuello');
            const tronco = getRadioValue('tronco');
            const piernas = getRadioValue('piernas');
            const carga = getRadioValue('carga');
            const brazo = getRadioValue('brazo');
            const antebrazo = getRadioValue('antebrazo');
            const muneca = getRadioValue('muneca');
            const tipoAgarre = getRadioValue('tipo_agarre');
            const actividad = getRadioValue('actividad');

            if (
                cuello === null || tronco === null || piernas === null || carga === null ||
                brazo === null || antebrazo === null || muneca === null ||
                tipoAgarre === null || actividad === null
            ) {
                alert('Completa todo el cuestionario antes de calcular.');
                return;
            }

            const puntuacionA = cuello + tronco + piernas + carga;
            const puntuacionB = brazo + antebrazo + muneca + tipoAgarre;
            const puntuacionC = puntuacionA + puntuacionB;
            const puntuacionFinal = puntuacionC + actividad;

            let nivel = '';
            let accion = '';

            if (puntuacionFinal <= 3) {
                nivel = 'Riesgo bajo';
                accion = 'No es necesaria acción inmediata';
            } else if (puntuacionFinal <= 7) {
                nivel = 'Riesgo medio';
                accion = 'Puede requerirse acción';
            } else if (puntuacionFinal <= 10) {
                nivel = 'Riesgo alto';
                accion = 'Es necesaria la actuación pronto';
            } else {
                nivel = 'Riesgo muy alto';
                accion = 'Es necesaria la actuación inmediata';
            }

            document.getElementById('prevA').innerText = puntuacionA;
            document.getElementById('prevB').innerText = puntuacionB;
            document.getElementById('prevC').innerText = puntuacionC;
            document.getElementById('prevFinal').innerText = puntuacionFinal;
            document.getElementById('prevNivel').innerText = nivel;
            document.getElementById('prevAccion').innerText = accion;

            document.getElementById('dCuello').innerText = getRadioText('cuello');
            document.getElementById('dTronco').innerText = getRadioText('tronco');
            document.getElementById('dPiernas').innerText = getRadioText('piernas');
            document.getElementById('dCarga').innerText = getRadioText('carga');
            document.getElementById('dBrazo').innerText = getRadioText('brazo');
            document.getElementById('dAntebrazo').innerText = getRadioText('antebrazo');
            document.getElementById('dMuneca').innerText = getRadioText('muneca');
            document.getElementById('dAgarre').innerText = getRadioText('tipo_agarre');
            document.getElementById('dActividad').innerText = getRadioText('actividad');

            document.getElementById('resultadoReba').classList.remove('hidden');
            document.getElementById('resultadoReba').scrollIntoView({ behavior: 'smooth' });
        }
    </script>
</x-app-layout>