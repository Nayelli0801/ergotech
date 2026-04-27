<section class="space-y-6">

    {{-- HEADER --}}
    <header>
        <h2 class="text-lg font-semibold text-slate-800">
            {{ __('Eliminar Cuenta') }}
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            {{ __('Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán eliminados permanentemente. Antes de eliminar tu cuenta, por favor descarga cualquier información que desees conservar.') }}
        </p>
    </header>

    {{-- BOTÓN ABRIR MODAL --}}
    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="inline-flex items-center justify-center
               w-[180px] h-[42px]
               bg-red-100 hover:bg-red-200 text-red-700
               text-sm font-semibold rounded-lg
               shadow-sm transition"
    >
        {{ __('Eliminar Cuenta') }}
    </x-danger-button>

    {{-- MODAL --}}
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>

        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 space-y-5">
            @csrf
            @method('delete')

            {{-- TÍTULO --}}
            <h2 class="text-lg font-semibold text-slate-800">
                {{ __('¿Estás segura de que deseas eliminar tu cuenta?') }}
            </h2>

            {{-- DESCRIPCIÓN --}}
            <p class="text-sm text-slate-500 leading-relaxed">
                {{ __('Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán eliminados permanentemente. Por favor ingresa tu contraseña para confirmar que deseas eliminar tu cuenta de forma definitiva.') }}
            </p>

            {{-- INPUT --}}
            <div>
                <x-input-label 
                    for="password" 
                    value="{{ __('Contraseña') }}" 
                    class="sr-only" 
                />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full rounded-lg border-gray-300 focus:ring-sky-500 focus:border-sky-500"
                    placeholder="{{ __('Contraseña') }}"
                />

                <x-input-error 
                    :messages="$errors->userDeletion->get('password')" 
                    class="mt-2" 
                />
            </div>

            {{-- BOTONES --}}
            <div class="flex flex-wrap justify-end gap-3 pt-2">

                {{-- CANCELAR --}}
                <x-secondary-button 
                    x-on:click="$dispatch('close')"
                    class="inline-flex items-center justify-center
                           w-[120px] h-[42px]
                           bg-gray-200 hover:bg-gray-300 text-gray-800
                           text-sm font-semibold rounded-lg transition"
                >
                    {{ __('Cancelar') }}
                </x-secondary-button>

                {{-- ELIMINAR --}}
                <x-danger-button 
                    class="inline-flex items-center justify-center
                           w-[160px] h-[42px]
                           bg-red-500 hover:bg-red-600 text-white
                           text-sm font-semibold rounded-lg
                           shadow-sm transition"
                >
                    {{ __('Eliminar Cuenta') }}
                </x-danger-button>

            </div>

        </form>
    </x-modal>
</section>