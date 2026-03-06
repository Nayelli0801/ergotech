<x-app-layout>
    <div class="max-w-5xl mx-auto py-8 px-6">
        <div class="bg-white shadow-lg rounded-2xl border border-gray-200 overflow-hidden">
            <div class="bg-yellow-500 text-white px-6 py-4">
                <h2 class="text-2xl font-bold">Editar trabajador</h2>
            </div>

            <div class="p-6">
                @if($errors->any())
                    <div class="mb-4 rounded-lg bg-red-100 border border-red-300 text-red-700 px-4 py-3">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('trabajadores.update', $trabajador->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Puesto</label>
                        <select name="puesto_id" class="w-full rounded-lg border-gray-300" required>
                            @foreach($puestos as $puesto)
                                <option value="{{ $puesto->id }}" {{ $trabajador->puesto_id == $puesto->id ? 'selected' : '' }}>
                                    {{ $puesto->nombre }} - {{ $puesto->sucursal->nombre ?? '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                        <input type="text" name="nombre" value="{{ old('nombre', $trabajador->nombre) }}" class="w-full rounded-lg border-gray-300" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Apellido paterno</label>
                        <input type="text" name="apellido_paterno" value="{{ old('apellido_paterno', $trabajador->apellido_paterno) }}" class="w-full rounded-lg border-gray-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Apellido materno</label>
                        <input type="text" name="apellido_materno" value="{{ old('apellido_materno', $trabajador->apellido_materno) }}" class="w-full rounded-lg border-gray-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sexo</label>
                        <select name="sexo" class="w-full rounded-lg border-gray-300">
                            <option value="">Seleccione</option>
                            <option value="Masculino" {{ $trabajador->sexo == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                            <option value="Femenino" {{ $trabajador->sexo == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Edad</label>
                        <input type="number" name="edad" value="{{ old('edad', $trabajador->edad) }}" class="w-full rounded-lg border-gray-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estatura</label>
                        <input type="number" step="0.01" name="estatura" value="{{ old('estatura', $trabajador->estatura) }}" class="w-full rounded-lg border-gray-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Peso</label>
                        <input type="number" step="0.01" name="peso" value="{{ old('peso', $trabajador->peso) }}" class="w-full rounded-lg border-gray-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Antigüedad</label>
                        <input type="number" step="0.01" name="antiguedad" value="{{ old('antiguedad', $trabajador->antiguedad) }}" class="w-full rounded-lg border-gray-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                        <select name="activo" class="w-full rounded-lg border-gray-300" required>
                            <option value="1" {{ $trabajador->activo ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ !$trabajador->activo ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>

                    <div class="md:col-span-2 flex gap-3 pt-2">
                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2.5 rounded-lg">
                            Actualizar
                        </button>
                        <a href="{{ route('trabajadores.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-5 py-2.5 rounded-lg">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>