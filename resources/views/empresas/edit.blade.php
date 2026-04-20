<x-app-layout>
    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">

                <!-- Header -->
                <div class="bg-sky-600 text-white px-6 py-4 flex justify-between items-center">
                    <h2 class="text-xl font-semibold">Editar Empresa</h2>
                    <p class="text-sm text-blue-100">Modifica los datos de la empresa</p>
                </div>

                <div class="p-6">
                    <form method="POST" action="{{ route('empresas.update', $empresa->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid md:grid-cols-2 gap-6">

                            <!-- IZQUIERDA -->
                            <div>

                                <div class="mb-5">
                                    <label class="block text-sm font-medium">Nombre</label>
                                    <input type="text" name="nombre"
                                        value="{{ old('nombre', $empresa->nombre) }}"
                                        class="w-full px-4 py-2 border rounded-lg">
                                </div>

                                <div class="mb-5">
                                    <label class="block text-sm font-medium">Razón social</label>
                                    <input type="text" name="razon_social"
                                        value="{{ old('razon_social', $empresa->razon_social) }}"
                                        class="w-full px-4 py-2 border rounded-lg">
                                </div>

                                <div class="mb-5">
                                    <label class="block text-sm font-medium">RFC</label>
                                    <input type="text" name="rfc"
                                        value="{{ old('rfc', $empresa->rfc) }}"
                                        class="w-full px-4 py-2 border rounded-lg">
                                </div>

                                <div class="mb-5">
                                    <label class="block text-sm font-medium">Teléfono</label>
                                    <input type="text" name="telefono"
                                        value="{{ old('telefono', $empresa->telefono) }}"
                                        class="w-full px-4 py-2 border rounded-lg">
                                </div>

                                <div class="mb-5">
                                    <label class="block text-sm font-medium">Correo</label>
                                    <input type="email" name="correo"
                                        value="{{ old('correo', $empresa->correo) }}"
                                        class="w-full px-4 py-2 border rounded-lg">
                                </div>

                                <div class="mb-5">
                                    <label class="block text-sm font-medium">Dirección</label>
                                    <textarea name="direccion"
                                        class="w-full px-4 py-2 border rounded-lg">{{ old('direccion', $empresa->direccion) }}</textarea>
                                </div>

                                <div class="flex items-center gap-2">
                                    <input type="checkbox" name="activo" value="1"
                                        {{ $empresa->activo ? 'checked' : '' }}>
                                    <label>Activa</label>
                                </div>

                            </div>

                            <!-- DERECHA (LOGO) -->
                            <div class="flex flex-col items-center">

                                <label class="block text-sm font-medium mb-2">Logo</label>

                                <!-- Logo actual -->
                                @if($empresa->logo)
                                    <img src="{{ asset($empresa->logo) }}"
                                        class="w-32 h-32 object-contain border rounded mb-3">
                                @else
                                    <div class="w-32 h-32 bg-gray-200 flex items-center justify-center rounded mb-3">
                                        Sin logo
                                    </div>
                                @endif

                                <!-- Preview -->
                                <img id="preview"
                                    class="w-32 h-32 object-contain border rounded mb-3 hidden">

                                <!-- Botón -->
                                <button type="button" id="selectImage"
                                    class="bg-gray-700 text-white px-4 py-2 rounded-lg">
                                    Cambiar logo
                                </button>

                                <input type="file" id="logoInput" class="hidden" accept="image/*">

                                <input type="hidden" name="logo_base64" id="logo_base64">

                            </div>

                        </div>

                        <!-- BOTONES -->
                        <div class="flex justify-end gap-3 mt-6">
                            <a href="{{ route('empresas.index') }}"
                                class="px-6 py-2 border rounded-lg hover:bg-gray-100">
                                Cancelar
                            </a>

                            <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Actualizar
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL -->
    <div id="cropModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white p-4 rounded-lg w-[500px]">
            <h2 class="text-lg font-bold mb-2">Editar logo</h2>

            <img id="modalImage" style="max-width:100%;">

            <div class="flex justify-end gap-2 mt-3">
                <button type="button" id="cancelCrop" class="bg-gray-400 text-white px-3 py-1 rounded">
                    Cancelar
                </button>
                <button type="button" id="saveCrop" class="bg-blue-500 text-white px-3 py-1 rounded">
                    Guardar
                </button>
            </div>
        </div>
    </div>

    <!-- Cropper -->
    <link href="https://unpkg.com/cropperjs/dist/cropper.min.css" rel="stylesheet"/>
    <script src="https://unpkg.com/cropperjs/dist/cropper.min.js"></script>

    <script>
        let cropper = null;

        const input = document.getElementById('logoInput');
        const modal = document.getElementById('cropModal');
        const modalImage = document.getElementById('modalImage');
        const preview = document.getElementById('preview');
        const base64Input = document.getElementById('logo_base64');

        document.getElementById('selectImage').onclick = () => input.click();

        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(ev) {
                modalImage.src = ev.target.result;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            };
            reader.readAsDataURL(file);
        });

        modalImage.onload = () => {
            if (cropper) cropper.destroy();

            cropper = new Cropper(modalImage, {
                aspectRatio: 1,
                viewMode: 1,
            });
        };

        document.getElementById('saveCrop').onclick = () => {
            if (!cropper) return;

            const canvas = cropper.getCroppedCanvas({
                width: 400,
                height: 400,
            });

            const base64 = canvas.toDataURL('image/png');

            preview.src = base64;
            preview.classList.remove('hidden');
            base64Input.value = base64;

            modal.classList.add('hidden');
        };

        document.getElementById('cancelCrop').onclick = () => {
            modal.classList.add('hidden');
        };
    </script>
</x-app-layout>