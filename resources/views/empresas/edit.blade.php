<x-app-layout>
    <div class="max-w-5xl mx-auto py-8 px-6">
        <div class="bg-white shadow-lg rounded-2xl border border-gray-200 overflow-hidden">

            {{-- Header --}}
            <div class="bg-sky-600 text-white px-6 py-4">
                <h2 class="text-2xl font-bold">Editar Empresa</h2>
                <p class="text-sm text-blue-100">Actualiza la información de la empresa</p>
            </div>

            <div class="p-6">
                <form action="{{ route('empresas.update', $empresa->id) }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                        {{-- IZQUIERDA --}}
                        <div class="space-y-4">

                            <div>
                                <label class="block text-sm font-medium mb-1">Nombre</label>
                                <input type="text"
                                       name="nombre"
                                       value="{{ $empresa->nombre }}"
                                       class="w-full border rounded-lg p-2 border-gray-300">
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">Razón social</label>
                                <input type="text"
                                       name="razon_social"
                                       value="{{ $empresa->razon_social }}"
                                       class="w-full border rounded-lg p-2 border-gray-300">
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">RFC</label>
                                <input type="text"
                                       name="rfc"
                                       value="{{ $empresa->rfc }}"
                                       class="w-full border rounded-lg p-2 border-gray-300">
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">Teléfono</label>
                                <input type="text"
                                       name="telefono"
                                       value="{{ $empresa->telefono }}"
                                       class="w-full border rounded-lg p-2 border-gray-300">
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">Correo</label>
                                <input type="email"
                                       name="correo"
                                       value="{{ $empresa->correo }}"
                                       class="w-full border rounded-lg p-2 border-gray-300">
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">Dirección</label>
                                <textarea name="direccion"
                                          rows="4"
                                          class="w-full border rounded-lg p-2 border-gray-300">{{ $empresa->direccion }}</textarea>
                            </div>

                        </div>

                        {{-- DERECHA --}}
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Logo actual
                            </label>

                            <div class="w-full h-64 border rounded-xl bg-white flex items-center justify-center p-4 mb-4">
                                @if($empresa->logo)
                                    <img src="{{ asset('storage/'.$empresa->logo) }}"
                                         class="max-w-full max-h-full object-contain">
                                @else
                                    <span class="text-gray-400">
                                        Sin logo
                                    </span>
                                @endif
                            </div>

                            {{-- Input personalizado --}}
                            <input 
                                type="file"
                                name="logo"
                                id="logo"
                                accept="image/*"
                                class="hidden"
                                onchange="updateFileName(this)"
                            >

                            <div class="flex items-center gap-3">
                                <label for="logo"
                                    class="cursor-pointer bg-sky-600 hover:bg-sky-700 text-white px-5 py-2 rounded-lg transition">
                                    Cambiar imagen
                                </label>

                                <span id="file-name" class="text-sm text-gray-500">
                                    Ningún archivo seleccionado
                                </span>
                            </div>

                            <p class="text-xs text-gray-400 mt-2">
                                Si subes una nueva imagen reemplazará el logo actual.
                            </p>

                            <div class="mt-5 flex items-center gap-2">
                                <input type="hidden" name="activo" value="0">

                                <input type="checkbox"
                                       name="activo"
                                       value="1"
                                       {{ $empresa->activo ? 'checked' : '' }}>

                                <label>Activa</label>
                            </div>
                        </div>
                    </div>

                    {{-- Botones --}}
                    <div class="flex gap-4 pt-6">
                        <button type="submit"
                            class="bg-sky-600 hover:bg-sky-700 text-white px-7 py-3 rounded-lg">
                            Actualizar
                        </button>

                        <a href="{{ route('empresas.index') }}"
                           class="bg-gray-200 hover:bg-gray-300 px-7 py-3 rounded-lg">
                            Cancelar
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
function updateFileName(input) {
    const fileName = input.files.length > 0 
        ? input.files[0].name 
        : 'Ningún archivo seleccionado';

    document.getElementById('file-name').textContent = fileName;
}
</script>