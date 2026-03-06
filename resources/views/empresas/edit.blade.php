<x-app-layout>
    <div class="p-6 max-w-3xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Editar Empresa</h1>

        <form action="{{ route('empresas.update', $empresa->id) }}" method="POST" class="bg-white shadow rounded-lg p-6 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-semibold">Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre', $empresa->nombre) }}" class="w-full border rounded-lg p-2">
                @error('nombre')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-semibold">Razón social</label>
                <input type="text" name="razon_social" value="{{ old('razon_social', $empresa->razon_social) }}" class="w-full border rounded-lg p-2">
                @error('razon_social')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-semibold">RFC</label>
                <input type="text" name="rfc" value="{{ old('rfc', $empresa->rfc) }}" class="w-full border rounded-lg p-2">
                @error('rfc')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-semibold">Teléfono</label>
                <input type="text" name="telefono" value="{{ old('telefono', $empresa->telefono) }}" class="w-full border rounded-lg p-2">
                @error('telefono')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-semibold">Correo</label>
                <input type="email" name="correo" value="{{ old('correo', $empresa->correo) }}" class="w-full border rounded-lg p-2">
                @error('correo')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-semibold">Dirección</label>
                <textarea name="direccion" class="w-full border rounded-lg p-2">{{ old('direccion', $empresa->direccion) }}</textarea>
                @error('direccion')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="activo" value="1" {{ $empresa->activo ? 'checked' : '' }}>
                <label>Activa</label>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">
                    Actualizar
                </button>

                <a href="{{ route('empresas.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-app-layout>