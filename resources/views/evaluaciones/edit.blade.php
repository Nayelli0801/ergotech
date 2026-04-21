<x-app-layout>
    <div class="max-w-5xl mx-auto py-8 px-6">
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-200">
            <div class="bg-amber-500 text-white px-6 py-4">
                <h2 class="text-2xl font-bold">Editar evaluación</h2>
                <p class="text-sm text-amber-100 mt-1">
                    Modifica los datos generales de la evaluación.
                </p>
            </div>

            <div class="p-6">
                @if ($errors->any())
                    <div class="mb-6 rounded-lg bg-red-100 border border-red-300 text-red-700 px-4 py-3">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('evaluaciones.update', $evaluacion->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Empresa</label>
                            <select name="empresa_id" class="w-full rounded-lg border-gray-300 focus:ring-sky-500 focus:border-sky-500" required>
                                <option value="">Seleccione una empresa</option>
                                @foreach($empresas as $empresa)
                                    <option value="{{ $empresa->id }}" {{ old('empresa_id', $evaluacion->empresa_id) == $empresa->id ? 'selected' : '' }}>
                                        {{ $empresa->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Sucursal</label>
                            <select name="sucursal_id" class="w-full rounded-lg border-gray-300 focus:ring-sky-500 focus:border-sky-500" required>
                                <option value="">Seleccione una sucursal</option>
                                @foreach($sucursales as $sucursal)
                                    <option value="{{ $sucursal->id }}" {{ old('sucursal_id', $evaluacion->sucursal_id) == $sucursal->id ? 'selected' : '' }}>
                                        {{ $sucursal->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Puesto</label>
                            <select name="puesto_id" class="w-full rounded-lg border-gray-300 focus:ring-sky-500 focus:border-sky-500" required>
                                <option value="">Seleccione un puesto</option>
                                @foreach($puestos as $puesto)
                                    <option value="{{ $puesto->id }}" {{ old('puesto_id', $evaluacion->puesto_id) == $puesto->id ? 'selected' : '' }}>
                                        {{ $puesto->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Trabajador</label>
                            <select name="trabajador_id" class="w-full rounded-lg border-gray-300 focus:ring-sky-500 focus:border-sky-500" required>
                                <option value="">Seleccione un trabajador</option>
                                @foreach($trabajadores as $trabajador)
                                    <option value="{{ $trabajador->id }}" {{ old('trabajador_id', $evaluacion->trabajador_id) == $trabajador->id ? 'selected' : '' }}>
                                        {{ $trabajador->nombre }} {{ $trabajador->apellido_paterno }} {{ $trabajador->apellido_materno }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Método</label>
                            <input type="text"
                                   value="{{ $evaluacion->metodo->nombre ?? 'N/A' }}"
                                   class="w-full rounded-lg border-gray-300 bg-gray-100 text-gray-600"
                                   disabled>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Fecha de evaluación</label>
                            <input type="date"
                                   name="fecha_evaluacion"
                                   value="{{ old('fecha_evaluacion', $evaluacion->fecha_evaluacion) }}"
                                   class="w-full rounded-lg border-gray-300 focus:ring-sky-500 focus:border-sky-500"
                                   required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Área evaluada</label>
                        <input type="text"
                               name="area_evaluada"
                               value="{{ old('area_evaluada', $evaluacion->area_evaluada) }}"
                               class="w-full rounded-lg border-gray-300 focus:ring-sky-500 focus:border-sky-500">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Actividad</label>
                        <input type="text"
                               name="actividad"
                               value="{{ old('actividad', $evaluacion->actividad) }}"
                               class="w-full rounded-lg border-gray-300 focus:ring-sky-500 focus:border-sky-500">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Observaciones</label>
                        <textarea name="observaciones"
                                  rows="4"
                                  class="w-full rounded-lg border-gray-300 focus:ring-sky-500 focus:border-sky-500">{{ old('observaciones', $evaluacion->observaciones) }}</textarea>
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('evaluaciones.index') }}"
                           class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2.5 rounded-lg">
                            Cancelar
                        </a>

                        <button type="submit"
                                class="bg-amber-500 hover:bg-amber-600 text-white font-semibold px-5 py-2.5 rounded-lg shadow">
                            Guardar cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>