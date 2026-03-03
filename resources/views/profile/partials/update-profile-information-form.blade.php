<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Información de Perfil
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Actualiza la información de tu cuenta y tu foto de perfil.
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" 
          enctype="multipart/form-data"
          class="mt-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            {{-- LADO IZQUIERDO (DATOS) --}}
            <div class="md:col-span-2 space-y-6">

                <div>
                    <x-input-label for="name" value="Nombre" />
                    <x-text-input id="name" name="name" type="text"
                        class="mt-1 block w-full"
                        :value="old('name', $user->name)"
                        required />
                </div>

                <div>
                    <x-input-label for="last_name" value="Apellido" />
                    <x-text-input id="last_name" name="last_name" type="text"
                        class="mt-1 block w-full"
                        :value="old('last_name', $user->last_name)" />
                </div>
                
                <div>
                    <x-input-label for="email" value="Correo electrónico" />
                    <x-text-input id="email" name="email" type="email"
                        class="mt-1 block w-full"
                        :value="old('email', $user->email)"
                        required />
                </div>

                <div>
                    <button type="submit"
                        class="inline-flex items-center px-5 py-2 bg-gray-800 
                               text-white text-sm font-medium rounded-lg 
                               hover:bg-gray-700 transition">
                         Guardar cambios
                    </button>
                </div>

            </div>

            {{-- LADO DERECHO (FOTO) --}}
            <div class="flex flex-col items-center">

                @if ($user->profile_photo)
                    <img src="{{ asset('storage/' . $user->profile_photo) }}"
                        class="w-40 h-40 rounded-full object-cover shadow-md mb-4">
                @else
                    <div class="w-40 h-40 rounded-full bg-gray-200 flex items-center justify-center mb-4">
                        <span class="text-gray-500 text-sm">Sin foto</span>
                    </div>
                @endif

                <label class="cursor-pointer inline-flex items-center gap-2 
                              bg-gray-700 text-white px-4 py-2 
                              rounded-lg hover:bg-gray-600 transition">

                     Editar foto
                    <input type="file" name="profile_photo" 
                           class="hidden" accept="image/*">
                </label>

            </div>

        </div>
    </form>
</section>