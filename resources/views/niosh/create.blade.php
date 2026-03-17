<x-app-layout>
    <div class="max-w-6xl mx-auto py-6 px-4 sm:px-6">
        <div class="mb-5">
            <h2 class="text-2xl font-bold text-blue-700">Evaluación NIOSH</h2>
            <p class="text-sm text-gray-500 mt-1">
                Captura los datos del levantamiento manual de carga. El sistema calculará automáticamente el límite de peso recomendado y el índice de levantamiento.
            </p>
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

        <form action="{{ route('niosh.store', $evaluacion->id) }}" method="POST" class="space-y-5">
            @csrf

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
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
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Actividad general</label>
                    <div class="text-sm text-gray-700">{{ $evaluacion->actividad ?? 'No especificada' }}</div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Área evaluada</label>
                    <div class="text-sm text-gray-700">{{ $evaluacion->area_evaluada ?? 'No especificada' }}</div>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Observaciones generales</label>
                    <div class="text-sm text-gray-700">{{ $evaluacion->observaciones ?? 'Sin observaciones' }}</div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                <h3 class="text-lg font-bold text-blue-700 mb-4">1. Datos del levantamiento</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Distancia horizontal (H) en cm
                        </label>
                        <input
                            type="number"
                            step="0.01"
                            min="1"
                            name="distancia_horizontal"
                            value="{{ old('distancia_horizontal') }}"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Ej. 40"
                            required
                        >
                        <p class="text-xs text-gray-500 mt-1">
                            Distancia entre las manos y el cuerpo al levantar.
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Altura inicial (V) en cm
                        </label>
                        <input
                            type="number"
                            step="0.01"
                            min="0"
                            name="altura_inicial"
                            value="{{ old('altura_inicial') }}"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Ej. 75"
                            required
                        >
                        <p class="text-xs text-gray-500 mt-1">
                            Altura de las manos al inicio del levantamiento.
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Desplazamiento vertical (D) en cm
                        </label>
                        <input
                            type="number"
                            step="0.01"
                            min="1"
                            name="desplazamiento_vertical"
                            value="{{ old('desplazamiento_vertical') }}"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Ej. 50"
                            required
                        >
                        <p class="text-xs text-gray-500 mt-1">
                            Recorrido vertical total de la carga.
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Ángulo de asimetría (A) en grados
                        </label>
                        <input
                            type="number"
                            step="0.01"
                            min="0"
                            name="angulo_asimetria"
                            value="{{ old('angulo_asimetria') }}"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Ej. 15"
                            required
                        >
                        <p class="text-xs text-gray-500 mt-1">
                            Giro del tronco o desviación angular durante el levantamiento.
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Frecuencia de levantamiento (lev/min)
                        </label>
                        <input
                            type="number"
                            step="0.01"
                            min="0.01"
                            name="frecuencia_levantamiento"
                            value="{{ old('frecuencia_levantamiento') }}"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Ej. 3"
                            required
                        >
                        <p class="text-xs text-gray-500 mt-1">
                            Número de levantamientos realizados por minuto.
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Peso del objeto (kg)
                        </label>
                        <input
                            type="number"
                            step="0.01"
                            min="0.01"
                            name="peso_objeto"
                            value="{{ old('peso_objeto') }}"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Ej. 12"
                            required
                        >
                        <p class="text-xs text-gray-500 mt-1">
                            Peso real de la carga manipulada.
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Duración
                        </label>
                        <select
                            name="duracion"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                            required
                        >
                            <option value="">Seleccione</option>
                            <option value="corta" {{ old('duracion') == 'corta' ? 'selected' : '' }}>Corta</option>
                            <option value="moderada" {{ old('duracion') == 'moderada' ? 'selected' : '' }}>Moderada</option>
                            <option value="larga" {{ old('duracion') == 'larga' ? 'selected' : '' }}>Larga</option>
                        </select>
                        <p class="text-xs text-gray-500 mt-1">
                            Tiempo de exposición de la tarea observada.
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Calidad de agarre
                        </label>
                        <select
                            name="calidad_agarre"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                            required
                        >
                            <option value="">Seleccione</option>
                            <option value="bueno" {{ old('calidad_agarre') == 'bueno' ? 'selected' : '' }}>Bueno</option>
                            <option value="regular" {{ old('calidad_agarre') == 'regular' ? 'selected' : '' }}>Regular</option>
                            <option value="malo" {{ old('calidad_agarre') == 'malo' ? 'selected' : '' }}>Malo</option>
                        </select>
                        <p class="text-xs text-gray-500 mt-1">
                            Evalúa qué tan fácil es sujetar la carga.
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-sky-50 rounded-xl border border-sky-200 shadow-sm p-5">
                <h3 class="text-lg font-bold text-sky-700 mb-4">2. Guía rápida para el evaluador</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 text-sm text-gray-700">
                    <div class="bg-white rounded-lg border border-sky-100 p-4">
                        <div class="font-bold text-blue-700 mb-2">H</div>
                        Mientras más alejada esté la carga del cuerpo, menor será el peso recomendado.
                    </div>

                    <div class="bg-white rounded-lg border border-sky-100 p-4">
                        <div class="font-bold text-blue-700 mb-2">V</div>
                        Levantar desde alturas muy bajas o muy altas incrementa el riesgo.
                    </div>

                    <div class="bg-white rounded-lg border border-sky-100 p-4">
                        <div class="font-bold text-blue-700 mb-2">D</div>
                        Un mayor desplazamiento vertical exige más esfuerzo biomecánico.
                    </div>

                    <div class="bg-white rounded-lg border border-sky-100 p-4">
                        <div class="font-bold text-blue-700 mb-2">A</div>
                        Los giros o torsiones del tronco reducen el límite de peso recomendado.
                    </div>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white font-semibold px-5 py-2.5 rounded-lg shadow">
                    Guardar evaluación NIOSH
                </button>

                <a href="{{ route('evaluaciones.index') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2.5 rounded-lg">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-app-layout>