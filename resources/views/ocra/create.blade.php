<x-app-layout>
    <div class="max-w-6xl mx-auto py-8 px-6">
        <div class="bg-white shadow-lg rounded-2xl border border-gray-200 overflow-hidden">

            <div class="bg-sky-600 text-white px-6 py-4">
                <h2 class="text-2xl font-bold">Evaluación OCRA</h2>
                <p class="text-sm">Movimientos repetitivos de extremidades superiores</p>
            </div>

            <form action="{{ route('ocra.store', $evaluacion->id) }}" method="POST" class="p-6 space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="font-semibold">Empresa</label>
                        <input type="text" value="{{ $evaluacion->empresa->nombre ?? 'N/A' }}" readonly
                               class="w-full rounded-lg border-gray-300 bg-gray-100">
                    </div>

                    <div>
                        <label class="font-semibold">Puesto</label>
                        <input type="text" value="{{ $evaluacion->puesto->nombre ?? 'N/A' }}" readonly
                               class="w-full rounded-lg border-gray-300 bg-gray-100">
                    </div>

                    <div>
                        <label class="font-semibold">Trabajador</label>
                        <input type="text" value="{{ $evaluacion->trabajador->nombre ?? 'N/A' }}" readonly
                               class="w-full rounded-lg border-gray-300 bg-gray-100">
                    </div>

                    <div>
                        <label class="font-semibold">Fecha</label>
                        <input type="text" value="{{ $evaluacion->fecha_evaluacion }}" readonly
                               class="w-full rounded-lg border-gray-300 bg-gray-100">
                    </div>
                </div>

                <hr>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="font-semibold">Lado evaluado</label>
                        <select name="lado_evaluado" required class="w-full rounded-lg border-gray-300">
                            <option value="">Seleccione</option>
                            <option value="Derecho">Derecho</option>
                            <option value="Izquierdo">Izquierdo</option>
                            <option value="Ambos">Ambos</option>
                        </select>
                    </div>

                    <div>
                        <label class="font-semibold">Duración de la tarea (horas)</label>
                        <input type="number" step="0.1" name="duracion_tarea" required
                               class="w-full rounded-lg border-gray-300">
                    </div>

                    <div>
                        <label class="font-semibold">Acciones técnicas</label>
                        <input type="number" name="acciones_tecnicas" required
                               class="w-full rounded-lg border-gray-300">
                    </div>

                    <div>
                        <label class="font-semibold">Frecuencia de acciones</label>
                        <input type="number" name="frecuencia_acciones" required
                               class="w-full rounded-lg border-gray-300">
                    </div>
                </div>

                <div class="bg-gray-50 border rounded-xl p-4">
                    <h3 class="text-lg font-bold text-gray-700 mb-4">Factores de riesgo</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach([
                            'fuerza' => 'Fuerza',
                            'postura_hombro' => 'Postura de hombro',
                            'postura_codo' => 'Postura de codo',
                            'postura_muneca' => 'Postura de muñeca',
                            'postura_mano' => 'Postura de mano',
                            'repetitividad' => 'Repetitividad',
                            'factores_adicionales' => 'Factores adicionales',
                            'recuperacion' => 'Recuperación'
                        ] as $campo => $label)
                            <div>
                                <label class="font-semibold">{{ $label }} / 0 a 10</label>
                                <input type="number" name="{{ $campo }}" min="0" max="10" required
                                       class="w-full rounded-lg border-gray-300">
                            </div>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="font-semibold">Observaciones</label>
                    <textarea name="observaciones" rows="4"
                              class="w-full rounded-lg border-gray-300"
                              placeholder="Escribe observaciones de la evaluación..."></textarea>
                </div>

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