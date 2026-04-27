<x-app-layout>
    <div class="max-w-4xl mx-auto py-8 px-6">
        <div class="bg-white shadow-lg rounded-2xl border border-gray-200 overflow-hidden">
            <div class="bg-sky-600 text-white px-6 py-4">
                <h2 class="text-2xl font-bold">Editar sucursal</h2>
                <p class="text-sm text-blue-100">Modifica los datos de la sucursal</p>
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

                <form action="{{ route('sucursales.update', $sucursal->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Empresa</label>
                        <select name="empresa_id" class="w-full rounded-lg border-gray-300" required>
                            <option value="">Seleccione una empresa</option>
                            @foreach($empresas as $empresa)
                                <option value="{{ $empresa->id }}"
                                    {{ old('empresa_id', $sucursal->empresa_id) == $empresa->id ? 'selected' : '' }}>
                                    {{ $empresa->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                        <input type="text" name="nombre"
                               value="{{ old('nombre', $sucursal->nombre) }}"
                               class="w-full rounded-lg border-gray-300" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                        <input type="text" name="direccion"
                               value="{{ old('direccion', $sucursal->direccion) }}"
                               class="w-full rounded-lg border-gray-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                        <input type="text" name="telefono"
                               value="{{ old('telefono', $sucursal->telefono) }}"
                               class="w-full rounded-lg border-gray-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Responsable</label>
                        <input type="text" name="responsable"
                               value="{{ old('responsable', $sucursal->responsable) }}"
                               class="w-full rounded-lg border-gray-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                        <select name="activo" class="w-full rounded-lg border-gray-300" required>
                            <option value="1" {{ old('activo', $sucursal->activo) == 1 ? 'selected' : '' }}>Activa</option>
                            <option value="0" {{ old('activo', $sucursal->activo) == 0 ? 'selected' : '' }}>Inactiva</option>
                        </select>
                    </div>

                    <div class="md:col-span-2 flex flex-wrap justify-end gap-3 pt-2">

    {{-- CANCELAR --}}
    <a href="{{ route('sucursales.index') }}"
       class="inline-flex items-center justify-center w-[120px] h-[42px]
              bg-gray-200 hover:bg-gray-300 text-gray-800
              text-sm font-semibold rounded-lg transition">
        Cancelar
    </a>

    {{-- ACTUALIZAR --}}
    <button type="submit"
        class="inline-flex items-center justify-center w-[120px] h-[42px]
               bg-sky-600 hover:bg-sky-700 text-white
               text-sm font-semibold rounded-lg transition shadow-sm">
        Actualizar
    </button>

</div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>