<x-app-layout>
    <div class="max-w-4xl mx-auto py-8 px-6">
        <div class="bg-white shadow-lg rounded-2xl border border-gray-200 overflow-hidden">
            <div class="bg-blue-700 text-white px-6 py-4">
                <h2 class="text-2xl font-bold">Nueva sucursal</h2>
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

                <form action="{{ route('sucursales.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Empresa</label>
                        <select name="empresa_id" class="w-full rounded-lg border-gray-300" required>
                            <option value="">Seleccione una empresa</option>
                            @foreach($empresas as $empresa)
                                <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                        <input type="text" name="nombre" value="{{ old('nombre') }}" class="w-full rounded-lg border-gray-300" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                        <input type="text" name="direccion" value="{{ old('direccion') }}" class="w-full rounded-lg border-gray-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                        <input type="text" name="telefono" value="{{ old('telefono') }}" class="w-full rounded-lg border-gray-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Responsable</label>
                        <input type="text" name="responsable" value="{{ old('responsable') }}" class="w-full rounded-lg border-gray-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                        <select name="activo" class="w-full rounded-lg border-gray-300" required>
                            <option value="1">Activa</option>
                            <option value="0">Inactiva</option>
                        </select>
                    </div>

                    <div class="md:col-span-2 flex gap-3 pt-2">
                        <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white px-5 py-2.5 rounded-lg">
                            Guardar
                        </button>
                        <a href="{{ route('sucursales.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-5 py-2.5 rounded-lg">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>