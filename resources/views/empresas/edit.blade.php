<x-app-layout>
    <div class="p-6 max-w-7xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Editar Empresa</h1>

        <form action="{{ route('empresas.update', $empresa->id) }}" method="POST" enctype="multipart/form-data" class="bg-white shadow rounded-lg p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Columna izquierda: campos principales (2/3) -->
                <div class="md:col-span-2 space-y-4">
                    <!-- Tus campos existentes (sin cambios) -->
                    <div>
                        <label class="block font-semibold">Nombre</label>
                        <input type="text" name="nombre" value="{{ old('nombre', $empresa->nombre) }}" class="w-full border rounded-lg p-2">
                        @error('nombre') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block font-semibold">Razón social</label>
                        <input type="text" name="razon_social" value="{{ old('razon_social', $empresa->razon_social) }}" class="w-full border rounded-lg p-2">
                        @error('razon_social') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block font-semibold">RFC</label>
                        <input type="text" name="rfc" value="{{ old('rfc', $empresa->rfc) }}" class="w-full border rounded-lg p-2">
                        @error('rfc') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block font-semibold">Teléfono</label>
                        <input type="text" name="telefono" value="{{ old('telefono', $empresa->telefono) }}" class="w-full border rounded-lg p-2">
                        @error('telefono') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block font-semibold">Correo</label>
                        <input type="email" name="correo" value="{{ old('correo', $empresa->correo) }}" class="w-full border rounded-lg p-2">
                        @error('correo') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block font-semibold">Dirección</label>
                        <textarea name="direccion" class="w-full border rounded-lg p-2">{{ old('direccion', $empresa->direccion) }}</textarea>
                        @error('direccion') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="activo" value="1" {{ $empresa->activo ? 'checked' : '' }}>
                        <label>Activa</label>
                    </div>
                </div>

                <!-- Columna derecha: logo (1/3) - VERSIÓN CORREGIDA (similar al perfil) -->
                <div class="border-l pl-6 space-y-4">
                    <label class="block font-semibold">Logo de la empresa</label>
                    
                    <!-- Mostrar logo actual (circular o cuadrado, tú eliges) -->
                    <div class="mb-4 flex justify-center">
                        @if($empresa->logo)
                            <img src="{{ Storage::url($empresa->logo) }}" alt="Logo" class="w-40 h-40 object-cover rounded-full shadow-md">
                        @else
                            <div class="w-40 h-40 rounded-full bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-500 text-sm">Sin logo</span>
                            </div>
                        @endif
                    </div>

                    <!-- Label que activa el input file (estilo botón) -->
                    <label class="cursor-pointer inline-flex items-center gap-2 bg-gray-700 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                        Seleccionar imagen
                        <input type="file" name="logo" id="logo" class="hidden" accept="image/*">
                    </label>

                    <!-- Nombre del archivo seleccionado -->
                    <div id="file-name" class="text-sm text-gray-600 mt-2">Ningún archivo seleccionado</div>

                    <!-- Vista previa de la nueva imagen -->
                    <div id="preview-container" class="mt-4 hidden">
                        <p class="text-sm text-gray-600 mb-1">Vista previa:</p>
                        <img id="preview" src="#" alt="Vista previa" class="w-40 h-40 object-cover rounded-full shadow-md">
                    </div>

                    @error('logo')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="flex gap-3 mt-6 pt-4 border-t">
                <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">
                    Actualizar
                </button>
                <a href="{{ route('empresas.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('logo');
            const fileNameSpan = document.getElementById('file-name');
            const previewContainer = document.getElementById('preview-container');
            const previewImg = document.getElementById('preview');

            if (fileInput) {
                fileInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    fileNameSpan.textContent = file ? file.name : 'Ningún archivo seleccionado';

                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(ev) {
                            previewImg.src = ev.target.result;
                            previewContainer.classList.remove('hidden');
                        };
                        reader.readAsDataURL(file);
                    } else {
                        previewContainer.classList.add('hidden');
                        previewImg.src = '#';
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>