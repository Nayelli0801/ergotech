<x-app-layout>
    <div class="max-w-6xl mx-auto py-6 px-4 sm:px-6">
        <div class="mb-5">
            <h2 class="text-2xl font-bold text-blue-700">Evaluación NOM-036</h2>
            <p class="text-sm text-gray-500 mt-1">
                Captura las condiciones observadas de manejo manual de cargas. El sistema calculará un nivel de riesgo inicial.
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

        <form action="{{ route('nom036.store', $evaluacion->id) }}" method="POST" class="space-y-5">
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
            </div>

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                <h3 class="text-lg font-bold text-blue-700 mb-4">1. Datos de la tarea</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de actividad</label>
                        <select name="tipo_actividad" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="">Seleccione</option>
                            <option value="levantar">Levantar</option>
                            <option value="bajar">Bajar</option>
                            <option value="transportar">Transportar</option>
                            <option value="empujar">Empujar</option>
                            <option value="jalar">Jalar</option>
                            <option value="arrastrar">Arrastrar</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Objeto manipulado</label>
                        <input type="text" name="objeto_manipulado" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Ej. Caja, costal, bandeja">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Peso de la carga (kg)</label>
                        <input type="number" step="0.01" name="peso_carga" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Frecuencia</label>
                        <input type="number" step="0.01" name="frecuencia" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Veces por periodo">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Duración (horas)</label>
                        <input type="number" step="0.01" name="duracion" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Distancia recorrida (m)</label>
                        <input type="number" step="0.01" name="distancia_recorrida" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Altura inicial (cm)</label>
                        <input type="number" step="0.01" name="altura_inicial" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Altura final (cm)</label>
                        <input type="number" step="0.01" name="altura_final" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                <h3 class="text-lg font-bold text-blue-700 mb-4">2. Posturas y condiciones</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Postura del tronco</label>
                        <select name="postura_tronco" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Seleccione</option>
                            <option value="neutral">Neutral</option>
                            <option value="forzada">Forzada</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Postura de brazos</label>
                        <select name="postura_brazos" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Seleccione</option>
                            <option value="neutral">Neutral</option>
                            <option value="forzada">Forzada</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Postura de piernas</label>
                        <select name="postura_piernas" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Seleccione</option>
                            <option value="neutral">Neutral</option>
                            <option value="forzada">Forzada</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Agarre</label>
                        <select name="agarre" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Seleccione</option>
                            <option value="bueno">Bueno</option>
                            <option value="regular">Regular</option>
                            <option value="malo">Malo</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Condiciones ambientales</label>
                        <select name="condiciones_ambientales" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Seleccione</option>
                            <option value="favorables">Favorables</option>
                            <option value="desfavorables">Desfavorables</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Superficie de trabajo</label>
                        <select name="superficie_trabajo" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Seleccione</option>
                            <option value="regular">Regular</option>
                            <option value="irregular">Irregular</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Espacio de trabajo</label>
                        <select name="espacio_trabajo" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Seleccione</option>
                            <option value="adecuado">Adecuado</option>
                            <option value="reducido">Reducido</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-3">
                    <label class="flex items-center gap-2 text-sm text-gray-700">
                        <input class="rounded border-gray-300" type="checkbox" name="asimetria" value="1">
                        <span>Existe asimetría o giro del cuerpo</span>
                    </label>

                    <label class="flex items-center gap-2 text-sm text-gray-700">
                        <input class="rounded border-gray-300" type="checkbox" name="movimientos_repetitivos" value="1">
                        <span>Existen movimientos repetitivos</span>
                    </label>

                    <label class="flex items-center gap-2 text-sm text-gray-700">
                        <input class="rounded border-gray-300" type="checkbox" name="fuerza_brusca" value="1">
                        <span>Se aplica fuerza brusca</span>
                    </label>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                <h3 class="text-lg font-bold text-blue-700 mb-4">3. Observaciones</h3>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Observaciones específicas NOM-036</label>
                    <textarea name="observaciones" rows="4" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Describe hallazgos, condiciones y comentarios relevantes..."></textarea>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white font-semibold px-5 py-2.5 rounded-lg shadow">
                    Guardar evaluación NOM-036
                </button>

                <a href="{{ route('evaluaciones.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2.5 rounded-lg">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-app-layout>