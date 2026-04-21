<x-app-layout>
    <div class="max-w-4xl mx-auto py-8 px-6">
        <div class="bg-white shadow-lg rounded-2xl border border-gray-200 overflow-hidden">
            <div class="bg-sky-600 text-white px-6 py-4">
                <h2 class="text-2xl font-bold">Nueva Empresa</h2>
                <p class="text-sm text-blue-100">Registra una nueva empresa</p>
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

                <form action="{{ route('empresas.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                        <input type="text" name="nombre" value="{{ old('nombre') }}" class="w-full border rounded-lg p-2 border-gray-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Razón social</label>
                        <input type="text" name="razon_social" value="{{ old('razon_social') }}" class="w-full border rounded-lg p-2 border-gray-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">RFC</label>
                        <input type="text" name="rfc" value="{{ old('rfc') }}" class="w-full border rounded-lg p-2 border-gray-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                        <input type="text" name="telefono" value="{{ old('telefono') }}" class="w-full border rounded-lg p-2 border-gray-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Correo</label>
                        <input type="email" name="correo" value="{{ old('correo') }}" class="w-full border rounded-lg p-2 border-gray-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                        <textarea name="direccion" rows="4" class="w-full border rounded-lg p-2 border-gray-300">{{ old('direccion') }}</textarea>
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="activo" value="1" checked>
                        <label class="text-sm text-gray-700">Activa</label>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="submit" class="bg-green-600 text-white px-5 py-2.5 rounded-lg hover:bg-green-700 transition">
                            Guardar
                        </button>

                        <a href="{{ route('empresas.index') }}" class="bg-gray-200 text-gray-800 px-5 py-2.5 rounded-lg hover:bg-gray-300 transition">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>