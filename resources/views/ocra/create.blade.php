<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-6">
        <div class="bg-white shadow-lg rounded-2xl border border-gray-200 overflow-hidden">

            <div class="bg-sky-600 text-white px-6 py-4">
                <h2 class="text-2xl font-bold">Evaluación Check List OCRA</h2>
                <p class="text-sm text-blue-100 mt-1">
                    Evaluación del riesgo por movimientos repetitivos de extremidades superiores.
                </p>
            </div>

            <form action="{{ route('ocra.store', $evaluacion->id) }}" method="POST" class="p-6 space-y-6">
                @csrf

                @if(session('error'))
                    <div class="rounded-lg bg-red-100 border border-red-300 text-red-700 px-4 py-3">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="rounded-lg bg-red-100 border border-red-300 text-red-700 px-4 py-3">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-gray-50 rounded-xl border p-4">
                        <p class="text-xs text-gray-500">Empresa</p>
                        <p class="font-bold text-gray-800">{{ $evaluacion->empresa->nombre ?? 'N/A' }}</p>
                    </div>

                    <div class="bg-gray-50 rounded-xl border p-4">
                        <p class="text-xs text-gray-500">Sucursal</p>
                        <p class="font-bold text-gray-800">{{ $evaluacion->sucursal->nombre ?? 'N/A' }}</p>
                    </div>

                    <div class="bg-gray-50 rounded-xl border p-4">
                        <p class="text-xs text-gray-500">Puesto</p>
                        <p class="font-bold text-gray-800">{{ $evaluacion->puesto->nombre ?? 'N/A' }}</p>
                    </div>

                    <div class="bg-gray-50 rounded-xl border p-4">
                        <p class="text-xs text-gray-500">Trabajador</p>
                        <p class="font-bold text-gray-800">
                            {{ trim(($evaluacion->trabajador->nombre ?? '') . ' ' . ($evaluacion->trabajador->apellido_paterno ?? '') . ' ' . ($evaluacion->trabajador->apellido_materno ?? '')) ?: 'N/A' }}
                        </p>
                    </div>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                    <h3 class="text-lg font-bold text-blue-800 mb-2">Fórmula del método</h3>
                    <p class="text-sm text-gray-700">
                        ICKL = (FR + FF + FFz + FP + FC) × MD
                    </p>
                    <p class="text-xs text-gray-600 mt-1">
                        El sistema calculará automáticamente TNTR, TNC, FF, FP, FC, MD e ICKL.
                    </p>
                </div>

                <section class="border rounded-2xl p-5">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">1. Datos organizativos</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="font-semibold text-gray-700">Lado evaluado</label>
                            <select name="lado_evaluado" required class="w-full rounded-lg border-gray-300 mt-1">
                                <option value="">Seleccione</option>
                                <option value="Derecho" {{ old('lado_evaluado') == 'Derecho' ? 'selected' : '' }}>Derecho</option>
                                <option value="Izquierdo" {{ old('lado_evaluado') == 'Izquierdo' ? 'selected' : '' }}>Izquierdo</option>
                                <option value="Ambos" {{ old('lado_evaluado') == 'Ambos' ? 'selected' : '' }}>Ambos</option>
                            </select>
                        </div>

                        <div>
                            <label class="font-semibold text-gray-700">Duración del turno DT / minutos</label>
                            <input type="number" name="duracion_turno" min="1" value="{{ old('duracion_turno', 480) }}" required class="w-full rounded-lg border-gray-300 mt-1">
                        </div>

                        <div>
                            <label class="font-semibold text-gray-700">Tiempo no repetitivo TNR / minutos</label>
                            <input type="number" name="tiempo_no_repetitivo" min="0" value="{{ old('tiempo_no_repetitivo', 0) }}" required class="w-full rounded-lg border-gray-300 mt-1">
                        </div>

                        <div>
                            <label class="font-semibold text-gray-700">Pausas P / minutos</label>
                            <input type="number" name="pausas" min="0" value="{{ old('pausas', 0) }}" required class="w-full rounded-lg border-gray-300 mt-1">
                        </div>

                        <div>
                            <label class="font-semibold text-gray-700">Almuerzo A / minutos</label>
                            <input type="number" name="almuerzo" min="0" value="{{ old('almuerzo', 0) }}" required class="w-full rounded-lg border-gray-300 mt-1">
                        </div>

                        <div>
                            <label class="font-semibold text-gray-700">Número de ciclos NC</label>
                            <input type="number" name="numero_ciclos" min="1" value="{{ old('numero_ciclos', 1) }}" required class="w-full rounded-lg border-gray-300 mt-1">
                        </div>
                    </div>
                </section>

                <section class="border rounded-2xl p-5">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">2. Factor de recuperación FR</h3>

                    <select name="fr" required class="w-full rounded-lg border-gray-300">
                        <option value="">Seleccione la situación más parecida</option>
                        <option value="0">0 - Interrupción de al menos 8 min cada hora o recuperación incluida en el ciclo</option>
                        <option value="2">2 - Al menos 4 interrupciones de 8 min en turno de 7-8 h</option>
                        <option value="3">3 - Tres pausas de al menos 8 min además del almuerzo</option>
                        <option value="4">4 - Dos pausas de al menos 8 min además del almuerzo</option>
                        <option value="6">6 - Solo una pausa o solo descanso de almuerzo en 8 h</option>
                        <option value="10">10 - No existen pausas reales, excepto pocos minutos</option>
                    </select>
                </section>

                <section class="border rounded-2xl p-5">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">3. Factor de frecuencia FF</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="font-semibold text-gray-700">Acciones técnicas dinámicas ATD</label>
                            <select name="atd" required class="w-full rounded-lg border-gray-300 mt-1">
                                <option value="">Seleccione</option>
                                <option value="0">0 - Movimientos lentos, 20 acciones/minuto</option>
                                <option value="1">1 - No demasiado rápidos, 30 acciones/minuto</option>
                                <option value="3">3 - Bastante rápidos, más de 40 acciones/minuto, con pausas</option>
                                <option value="4">4 - Más de 40 acciones/minuto, pausas ocasionales</option>
                                <option value="6">6 - Más de 50 acciones/minuto, pausas ocasionales</option>
                                <option value="8">8 - Más de 60 acciones/minuto, falta de pausas</option>
                                <option value="10">10 - 70 acciones/minuto o más, sin pausas</option>
                            </select>
                        </div>

                        <div>
                            <label class="font-semibold text-gray-700">Acciones técnicas estáticas ATE</label>
                            <select name="ate" required class="w-full rounded-lg border-gray-300 mt-1">
                                <option value="0">0 - No aplica o no hay acciones estáticas relevantes</option>
                                <option value="2.5">2.5 - Se sostiene objeto 5 seg o más durante 2/3 del ciclo</option>
                                <option value="4.5">4.5 - Se sostiene objeto 5 seg o más durante todo el ciclo</option>
                            </select>
                        </div>
                    </div>
                </section>

                <section class="border rounded-2xl p-5">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">4. Factor de fuerza FFz</h3>

                    <select name="ffz" required class="w-full rounded-lg border-gray-300">
                        <option value="">Seleccione</option>
                        <option value="0">0 - No se ejerce fuerza significativa</option>
                        <option value="2">2 - Fuerza moderada durante 1/3 del tiempo</option>
                        <option value="4">4 - Fuerza moderada 50% del tiempo o fuerza intensa muy breve</option>
                        <option value="6">6 - Fuerza moderada más del 50% o fuerza casi máxima muy breve</option>
                        <option value="8">8 - Fuerza moderada casi todo el tiempo o fuerza intensa 1% del tiempo</option>
                        <option value="12">12 - Fuerza casi máxima 1% del tiempo</option>
                        <option value="16">16 - Fuerza intensa 5% del tiempo</option>
                        <option value="24">24 - Fuerza intensa más del 10% o fuerza casi máxima 5%</option>
                        <option value="32">32 - Fuerza casi máxima más del 10% del tiempo</option>
                    </select>
                </section>

                <section class="border rounded-2xl p-5">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">5. Posturas y movimientos FP</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="font-semibold text-gray-700">Hombro PHo</label>
                            <select name="pho" required class="w-full rounded-lg border-gray-300 mt-1">
                                <option value="0">0 - Sin postura relevante</option>
                                <option value="1">1 - Brazo ligeramente elevado más de la mitad del tiempo</option>
                                <option value="2">2 - Brazo a la altura del hombro alrededor del 10%</option>
                                <option value="6">6 - Brazo a la altura del hombro alrededor de 1/3 del tiempo</option>
                                <option value="12">12 - Brazo a la altura del hombro más de la mitad del tiempo</option>
                                <option value="24">24 - Brazo a la altura del hombro todo el tiempo</option>
                            </select>
                        </div>

                        <div>
                            <label class="font-semibold text-gray-700">Codo PCo</label>
                            <select name="pco" required class="w-full rounded-lg border-gray-300 mt-1">
                                <option value="0">0 - Sin movimientos forzados relevantes</option>
                                <option value="2">2 - Movimientos repentinos al menos 1/3 del tiempo</option>
                                <option value="4">4 - Movimientos repentinos más de la mitad del tiempo</option>
                                <option value="8">8 - Movimientos repentinos casi todo el tiempo</option>
                            </select>
                        </div>

                        <div>
                            <label class="font-semibold text-gray-700">Muñeca PMu</label>
                            <select name="pmu" required class="w-full rounded-lg border-gray-300 mt-1">
                                <option value="0">0 - Sin postura forzada relevante</option>
                                <option value="2">2 - Postura extrema al menos 1/3 del tiempo</option>
                                <option value="4">4 - Postura extrema más de la mitad del tiempo</option>
                                <option value="8">8 - Postura extrema todo el tiempo</option>
                            </select>
                        </div>

                        <div>
                            <label class="font-semibold text-gray-700">Mano / agarre PMa</label>
                            <select name="pma" required class="w-full rounded-lg border-gray-300 mt-1">
                                <option value="0">0 - Sin agarre relevante</option>
                                <option value="2">2 - Agarre alrededor de 1/3 del tiempo</option>
                                <option value="4">4 - Agarre más de la mitad del tiempo</option>
                                <option value="8">8 - Agarre casi todo el tiempo</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="font-semibold text-gray-700">Movimientos estereotipados PEs</label>
                            <select name="pes" required class="w-full rounded-lg border-gray-300 mt-1">
                                <option value="0">0 - No existen o duran menos de 2/3 del tiempo</option>
                                <option value="1.5">1.5 - Movimientos idénticos al menos 2/3 del tiempo o ciclo entre 8 y 15 seg</option>
                                <option value="3">3 - Movimientos idénticos casi todo el tiempo o ciclo menor a 8 seg</option>
                            </select>
                        </div>
                    </div>
                </section>

                <section class="border rounded-2xl p-5">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">6. Factores adicionales FC</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="font-semibold text-gray-700">Factores físico-mecánicos Ffm</label>
                            <select name="ffm" required class="w-full rounded-lg border-gray-300 mt-1">
                                <option value="0">0 - No existen factores adicionales</option>
                                <option value="2">2 - Guantes inadecuados, golpes, frío, vibración, precisión o compresión</option>
                                <option value="3">3 - Varios factores concurrentes durante todo el tiempo</option>
                            </select>
                        </div>

                        <div>
                            <label class="font-semibold text-gray-700">Factores socio-organizativos Fso</label>
                            <select name="fso" required class="w-full rounded-lg border-gray-300 mt-1">
                                <option value="0">0 - Ritmo no impuesto por máquina</option>
                                <option value="1">1 - Ritmo parcialmente determinado por máquina</option>
                                <option value="2">2 - Ritmo totalmente determinado por máquina</option>
                            </select>
                        </div>
                    </div>
                </section>

                <section class="border rounded-2xl p-5">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Observaciones</h3>
                    <textarea name="observaciones" rows="4" class="w-full rounded-lg border-gray-300" placeholder="Escribe observaciones de la evaluación...">{{ old('observaciones') }}</textarea>
                </section>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('evaluaciones.index') }}"
                       class="px-5 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg font-semibold">
                        Cancelar
                    </a>

                    <button type="submit"
                            class="px-5 py-2 bg-sky-600 hover:bg-sky-700 text-white rounded-lg font-semibold">
                        Guardar evaluación OCRA
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>