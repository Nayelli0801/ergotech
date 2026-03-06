<x-app-layout>
    <div class="max-w-4xl mx-auto py-8 px-6">
        <div class="bg-white shadow-lg rounded-2xl border border-gray-200 overflow-hidden">
            <div class="bg-blue-700 text-white px-6 py-4">
                <h2 class="text-2xl font-bold">Nuevo puesto</h2>
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

                <form action="{{ route('puestos.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sucursal</label>
                        <select name="sucursal_id" class="w-full rounded-lg border-gray-300" required>
                            <option value="">Seleccione una sucursal</option>
                            @foreach($sucursales as $sucursal)
                                <option value="{{ $sucursal->id }}">
                                    {{ $sucursal->nombre }} - {{ $sucursal->empresa->nombre ?? 'Sin empresa' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del puesto</label>
                        <input type="text" name="nombre" value="{{ old('nombre') }}" class="w-full rounded-lg border-gray-300" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Área</label>
                        <input type="text" name="area" value="{{ old('area') }}" class="w-full rounded-lg border-gray-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                        <select name="activo" class="w-full rounded-lg border-gray-300" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                        <textarea name="descripcion" rows="4" class="w-full rounded-lg border-gray-300">{{ old('descripcion') }}</textarea>
                    </div>

                    <div class="md:col-span-2 flex gap-3 pt-2">
                        <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white px-5 py-2.5 rounded-lg">
                            Guardar
                        </button>
                        <a href="{{ route('puestos.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-5 py-2.5 rounded-lg">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>