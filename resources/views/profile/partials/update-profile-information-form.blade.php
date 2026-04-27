<section>
    <header>
        <h2 class="text-lg font-semibold text-slate-800">
            Información de Perfil
        </h2>

        <p class="mt-1 text-sm text-slate-500">
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
                    <x-input-label for="name" value="Nombre" class="text-sm font-medium text-gray-700" />
                    <x-text-input id="name" name="name" type="text"
                        class="mt-1 block w-full rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500"
                        :value="old('name', $user->name)"
                        required />
                </div>

                <div>
                    <x-input-label for="last_name" value="Apellido" class="text-sm font-medium text-gray-700" />
                    <x-text-input id="last_name" name="last_name" type="text"
                        class="mt-1 block w-full rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500"
                        :value="old('last_name', $user->last_name)" />
                </div>
                
                <div>
                    <x-input-label for="email" value="Correo electrónico" class="text-sm font-medium text-gray-700" />
                    <x-text-input id="email" name="email" type="email"
                        class="mt-1 block w-full rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500"
                        :value="old('email', $user->email)"
                        required />
                </div>

                <div>
                    <button type="submit"
                        class="inline-flex items-center justify-center w-[150px] h-[42px]
                               bg-sky-600 hover:bg-sky-700
                               text-white text-sm font-semibold rounded-lg
                               shadow-sm transition">
                        Guardar cambios
                    </button>
                </div>

            </div>

            {{-- LADO DERECHO (FOTO) --}}
            <div class="flex flex-col items-center">

                @if ($user->profile_photo)
                    <img src="{{ asset('storage/' . $user->profile_photo) }}"
                        class="w-40 h-40 rounded-full object-cover shadow-md mb-4 border border-gray-200">
                @else
                    <div class="w-40 h-40 rounded-full bg-gray-200 flex items-center justify-center mb-4 border border-gray-300">
                        <span class="text-gray-500 text-sm">Sin foto</span>
                    </div>
                @endif

                <label class="cursor-pointer inline-flex items-center justify-center
                              w-[150px] h-[42px]
                              bg-sky-100 hover:bg-sky-200 text-sky-700
                              text-sm font-semibold rounded-lg transition">

                    Editar foto
                    <input type="file" name="profile_photo" 
                           class="hidden" accept="image/*">
                </label>

            </div>

        </div>
    </form>
</section>