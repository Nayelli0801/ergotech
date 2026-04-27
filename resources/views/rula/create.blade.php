<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 space-y-5">
        <div>
            <h2 class="text-2xl font-bold text-blue-700">Nueva evaluación RULA</h2>
            <p class="text-sm text-gray-500 mt-1">
                Selecciona la postura observada. El sistema calculará automáticamente el resultado.
            </p>
        </div>

        @if(session('error'))
            <div class="rounded-lg bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="rounded-lg bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm">
                <strong>Se encontraron errores:</strong>
                <ul class="list-disc pl-5 mt-2 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="rulaForm" method="POST" action="{{ route('rula.store', $evaluacion->id) }}" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">
                <div class="xl:col-span-2 space-y-5">

                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                        <div class="bg-blue-700 px-5 py-4">
                            <h3 class="text-white font-bold">Datos de la evaluación</h3>
                        </div>

                        <div class="p-5 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Empresa</label>
                                <div class="text-sm text-gray-700">{{ $evaluacion->empresa->nombre ?? 'N/A' }}</div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Sucursal</label>
                                <div class="text-sm text-gray-700">{{ $evaluacion->sucursal->nombre ?? 'N/A' }}</div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Puesto</label>
                                <div class="text-sm text-gray-700">{{ $evaluacion->puesto->nombre ?? 'N/A' }}</div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Trabajador</label>
                                <div class="text-sm text-gray-700">{{ $evaluacion->trabajador->nombre ?? 'N/A' }}</div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Fecha</label>
                                <div class="text-sm text-gray-700">{{ $evaluacion->fecha_evaluacion ?? 'N/A' }}</div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Área evaluada</label>
                                <div class="text-sm text-gray-700">{{ $evaluacion->area_evaluada ?: 'No especificada' }}</div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Actividad general</label>
                                <div class="text-sm text-gray-700">{{ $evaluacion->actividad ?: 'No especificada' }}</div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Observaciones</label>
                                <div class="text-sm text-gray-700">{{ $evaluacion->observaciones ?: 'Sin observaciones' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                        <h3 class="text-lg font-bold text-blue-700 mb-4">1. Información básica</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Lado evaluado</label>
                                <select name="lado_evaluado" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 calc">
                                    <option value="Derecho">Derecho</option>
                                    <option value="Izquierdo">Izquierdo</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tarea evaluada</label>
                                <input type="text" name="tarea" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Ej. Ensamble de piezas">
                            </div>
                        </div>
                    </div>

                    <div class="bg-sky-50 border border-sky-200 rounded-xl shadow-sm p-5">
                        <h3 class="text-lg font-bold text-sky-800 mb-4">2. Grupo A: Brazo, antebrazo y muñeca</h3>

                        <div class="space-y-4">
                            <div class="bg-white border border-gray-200 rounded-xl p-4">
                                <h4 class="font-semibold text-gray-900 mb-2">Brazo</h4>

                                <label class="block text-sm font-medium text-gray-700 mb-1">Posición del brazo</label>
                                <select name="brazo_base" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 calc">
                                    <option value="1">Desde 20° de extensión a 20° de flexión</option>
                                    <option value="2">Extensión >20° o flexión >20° y &lt;45°</option>
                                    <option value="3">Flexión >45° y 90°</option>
                                    <option value="4">Flexión >90°</option>
                                </select>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-sm mt-4">
                                    <label class="flex items-center gap-2">
                                        <input class="rounded border-gray-300 calc" type="checkbox" name="brazo_hombro_elevado" value="1">
                                        <span>Hombro elevado o brazo rotado</span>
                                    </label>

                                    <label class="flex items-center gap-2">
                                        <input class="rounded border-gray-300 calc" type="checkbox" name="brazo_abducido" value="1">
                                        <span>Brazo separado del cuerpo</span>
                                    </label>

                                    <label class="flex items-center gap-2">
                                        <input class="rounded border-gray-300 calc" type="checkbox" name="brazo_apoyo" value="1">
                                        <span>Tiene punto de apoyo</span>
                                    </label>
                                </div>
                            </div>

                            <div class="bg-white border border-gray-200 rounded-xl p-4">
                                <h4 class="font-semibold text-gray-900 mb-2">Antebrazo</h4>

                                <label class="block text-sm font-medium text-gray-700 mb-1">Posición del antebrazo</label>
                                <select name="antebrazo_base" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 calc">
                                    <option value="1">Flexión entre 60° y 100°</option>
                                    <option value="2">Flexión &lt;60° o &gt;100°</option>
                                </select>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm mt-4">
                                    <label class="flex items-center gap-2">
                                        <input class="rounded border-gray-300 calc" type="checkbox" name="antebrazo_fuera_cuerpo" value="1">
                                        <span>Trabaja a un lado del cuerpo</span>
                                    </label>

                                    <label class="flex items-center gap-2">
                                        <input class="rounded border-gray-300 calc" type="checkbox" name="antebrazo_cruza_linea_media" value="1">
                                        <span>Cruza la línea media</span>
                                    </label>
                                </div>
                            </div>

                            <div class="bg-white border border-gray-200 rounded-xl p-4">
                                <h4 class="font-semibold text-gray-900 mb-2">Muñeca</h4>

                                <label class="block text-sm font-medium text-gray-700 mb-1">Posición de la muñeca</label>
                                <select name="muneca_base" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 calc">
                                    <option value="1">Posición neutra</option>
                                    <option value="2">Flexión o extensión &gt;0° y &lt;15°</option>
                                    <option value="3">Flexión o extensión &gt;15°</option>
                                </select>

                                <label class="flex items-center gap-2 text-sm mt-4">
                                    <input class="rounded border-gray-300 calc" type="checkbox" name="muneca_desviacion" value="1">
                                    <span>Desviación radial o cubital</span>
                                </label>
                            </div>

                            <div class="bg-white border border-gray-200 rounded-xl p-4">
                                <h4 class="font-semibold text-gray-900 mb-2">Giro de muñeca</h4>

                                <label class="block text-sm font-medium text-gray-700 mb-1">Giro de muñeca</label>
                                <select name="giro_muneca" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 calc">
                                    <option value="1">Pronación o supinación media</option>
                                    <option value="2">Pronación o supinación extrema</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="bg-amber-50 border border-amber-200 rounded-xl shadow-sm p-5">
                        <h3 class="text-lg font-bold text-amber-800 mb-4">3. Grupo B: Cuello, tronco y piernas</h3>

                        <div class="space-y-4">
                            <div class="bg-white border border-gray-200 rounded-xl p-4">
                                <h4 class="font-semibold text-gray-900 mb-2">Cuello</h4>

                                <label class="block text-sm font-medium text-gray-700 mb-1">Posición del cuello</label>
                                <select name="cuello_base" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 calc">
                                    <option value="1">Flexión entre 0° y 10°</option>
                                    <option value="2">Flexión >10° y ≤20°</option>
                                    <option value="3">Flexión >20°</option>
                                    <option value="4">Extensión en cualquier grado</option>
                                </select>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm mt-4">
                                    <label class="flex items-center gap-2">
                                        <input class="rounded border-gray-300 calc" type="checkbox" name="cuello_rotado" value="1">
                                        <span>Cabeza rotada</span>
                                    </label>

                                    <label class="flex items-center gap-2">
                                        <input class="rounded border-gray-300 calc" type="checkbox" name="cuello_inclinado" value="1">
                                        <span>Inclinación lateral de la cabeza</span>
                                    </label>
                                </div>
                            </div>

                            <div class="bg-white border border-gray-200 rounded-xl p-4">
                                <h4 class="font-semibold text-gray-900 mb-2">Tronco</h4>

                                <label class="block text-sm font-medium text-gray-700 mb-1">Posición del tronco</label>
                                <select name="tronco_base" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 calc">
                                    <option value="1">Erguido o sentado bien apoyado</option>
                                    <option value="2">Flexión entre >0° y 20°</option>
                                    <option value="3">Flexión >20° y ≤60°</option>
                                    <option value="4">Flexión >60°</option>
                                </select>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm mt-4">
                                    <label class="flex items-center gap-2">
                                        <input class="rounded border-gray-300 calc" type="checkbox" name="tronco_rotado" value="1">
                                        <span>Tronco rotado</span>
                                    </label>

                                    <label class="flex items-center gap-2">
                                        <input class="rounded border-gray-300 calc" type="checkbox" name="tronco_inclinado" value="1">
                                        <span>Inclinación lateral del tronco</span>
                                    </label>
                                </div>
                            </div>

                            <div class="bg-white border border-gray-200 rounded-xl p-4">
                                <h4 class="font-semibold text-gray-900 mb-2">Piernas</h4>

                                <label class="block text-sm font-medium text-gray-700 mb-1">Condición de piernas</label>
                                <select name="piernas" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 calc">
                                    <option value="1">Bien apoyadas / peso simétrico</option>
                                    <option value="2">Apoyo inestable / peso no simétrico</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="bg-green-50 border border-green-200 rounded-xl shadow-sm p-5">
                        <h3 class="text-lg font-bold text-green-800 mb-4">4. Factores adicionales</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Uso muscular</label>
                                <select name="uso_muscular" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 calc">
                                    <option value="0">Sin incremento</option>
                                    <option value="1">Postura estática o repetida frecuentemente</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fuerza / Carga</label>
                                <select name="carga_fuerza" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 calc">
                                    <option value="0">Menor a 2 kg o sin carga adicional</option>
                                    <option value="1">Entre 2 y 10 kg, intermitente</option>
                                    <option value="2">Entre 2 y 10 kg repetitiva / mayor a 10 kg intermitente</option>
                                    <option value="3">Mayor a 10 kg repetitiva o esfuerzo brusco</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 mt-5">
                            <a href="{{ route('evaluaciones.index') }}"
                               class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2.5 rounded-lg">
                                Cancelar
                            </a>

                            <button type="submit"
                                    class="bg-blue-700 hover:bg-blue-800 text-white font-semibold px-5 py-2.5 rounded-lg shadow-sm">
                                Guardar evaluación RULA
                            </button>
                        </div>
                    </div>
                </div>

                <div class="xl:col-span-1">
                    <div class="sticky top-5">
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                            <div class="bg-blue-700 px-5 py-4">
                                <h3 class="text-white font-bold">Resultado en tiempo real</h3>
                            </div>

                            <div class="p-5">
                                <div class="grid grid-cols-3 gap-3 mb-4">
                                    <div class="border rounded-xl p-3 text-center bg-slate-50">
                                        <div class="text-xs text-gray-500">Brazo</div>
                                        <div class="text-xl font-bold" id="resBrazo">-</div>
                                    </div>

                                    <div class="border rounded-xl p-3 text-center bg-slate-50">
                                        <div class="text-xs text-gray-500">Antebrazo</div>
                                        <div class="text-xl font-bold" id="resAntebrazo">-</div>
                                    </div>

                                    <div class="border rounded-xl p-3 text-center bg-slate-50">
                                        <div class="text-xs text-gray-500">Muñeca</div>
                                        <div class="text-xl font-bold" id="resMuneca">-</div>
                                    </div>

                                    <div class="border rounded-xl p-3 text-center bg-slate-50">
                                        <div class="text-xs text-gray-500">Cuello</div>
                                        <div class="text-xl font-bold" id="resCuello">-</div>
                                    </div>

                                    <div class="border rounded-xl p-3 text-center bg-slate-50">
                                        <div class="text-xs text-gray-500">Tronco</div>
                                        <div class="text-xl font-bold" id="resTronco">-</div>
                                    </div>

                                    <div class="border rounded-xl p-3 text-center bg-slate-50">
                                        <div class="text-xs text-gray-500">Piernas</div>
                                        <div class="text-xl font-bold" id="resPiernas">-</div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-4 gap-3 mb-4">
                                    <div class="border rounded-xl p-3 text-center bg-blue-50">
                                        <div class="text-xs text-gray-500">A</div>
                                        <div class="text-lg font-bold" id="resA">-</div>
                                    </div>

                                    <div class="border rounded-xl p-3 text-center bg-blue-50">
                                        <div class="text-xs text-gray-500">B</div>
                                        <div class="text-lg font-bold" id="resB">-</div>
                                    </div>

                                    <div class="border rounded-xl p-3 text-center bg-blue-50">
                                        <div class="text-xs text-gray-500">C</div>
                                        <div class="text-lg font-bold" id="resC">-</div>
                                    </div>

                                    <div class="border rounded-xl p-3 text-center bg-blue-50">
                                        <div class="text-xs text-gray-500">D</div>
                                        <div class="text-lg font-bold" id="resD">-</div>
                                    </div>
                                </div>

                                <div class="rounded-xl border border-green-200 bg-green-50 p-4">
                                    <div class="mb-2">
                                        <strong>Puntuación final:</strong>
                                        <span id="resFinal">-</span>
                                    </div>

                                    <div class="mb-2">
                                        <strong>Nivel de riesgo:</strong><br>
                                        <span id="resNivel" class="text-gray-600">-</span>
                                    </div>

                                    <div>
                                        <strong>Acción requerida:</strong><br>
                                        <span id="resAccion" class="text-gray-600">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        async function calcularRula() {
            const form = document.getElementById('rulaForm');
            const formData = new FormData(form);

            try {
                const response = await fetch("{{ route('rula.calcular') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();

                document.getElementById('resBrazo').innerText = data.brazo ?? '-';
                document.getElementById('resAntebrazo').innerText = data.antebrazo ?? '-';
                document.getElementById('resMuneca').innerText = data.muneca ?? '-';
                document.getElementById('resCuello').innerText = data.cuello ?? '-';
                document.getElementById('resTronco').innerText = data.tronco ?? '-';
                document.getElementById('resPiernas').innerText = data.piernas ?? '-';

                document.getElementById('resA').innerText = data.puntuacion_a ?? '-';
                document.getElementById('resB').innerText = data.puntuacion_b ?? '-';
                document.getElementById('resC').innerText = data.puntuacion_c ?? '-';
                document.getElementById('resD').innerText = data.puntuacion_d ?? '-';

                document.getElementById('resFinal').innerText = data.puntuacion_final ?? '-';
                document.getElementById('resNivel').innerText = data.nivel_riesgo ?? '-';
                document.getElementById('resAccion').innerText = data.accion_requerida ?? '-';
            } catch (error) {
                console.error('Error al calcular RULA:', error);
            }
        }

        document.querySelectorAll('.calc').forEach(el => {
            el.addEventListener('change', calcularRula);
        });

        window.addEventListener('load', calcularRula);
    </script>
</x-app-layout>