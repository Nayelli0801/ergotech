{{-- ============================= --}}
{{-- SECCIÓN: ELIMINAR CUENTA     --}}
{{-- ============================= --}}

<section class="space-y-6">

    {{-- Encabezado de la sección --}}
    <header>
        {{-- Título --}}
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Eliminar Cuenta') }}
        </h2>

        {{-- Descripción informativa --}}
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán eliminados permanentemente. Antes de eliminar tu cuenta, por favor descarga cualquier información que desees conservar.') }}
        </p>
    </header>

    {{-- Botón que abre el modal de confirmación --}}
    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >
        {{ __('Eliminar Cuenta') }}
    </x-danger-button>

    {{-- Modal de confirmación --}}
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>

        {{-- Formulario para eliminar cuenta --}}
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">

            {{-- Token de seguridad CSRF --}}
            @csrf

            {{-- Método DELETE porque HTML solo permite GET y POST --}}
            @method('delete')

            {{-- Título del modal --}}
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('¿Estás segura de que deseas eliminar tu cuenta?') }}
            </h2>

            {{-- Mensaje de advertencia --}}
            <p class="mt-1 text-sm text-gray-600">
                {{ __('Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán eliminados permanentemente. Por favor ingresa tu contraseña para confirmar que deseas eliminar tu cuenta de forma definitiva.') }}
            </p>

            {{-- Campo para confirmar contraseña --}}
            <div class="mt-6">

                {{-- Etiqueta del input (oculta visualmente) --}}
                <x-input-label 
                    for="password" 
                    value="{{ __('Contraseña') }}" 
                    class="sr-only" 
                />

                {{-- Input de contraseña --}}
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Contraseña') }}"
                />

                {{-- Mostrar errores de validación --}}
                <x-input-error 
                    :messages="$errors->userDeletion->get('password')" 
                    class="mt-2" 
                />
            </div>

            {{-- Botones del modal --}}
            <div class="mt-6 flex justify-end">

                {{-- Botón cancelar (cierra el modal) --}}
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                {{-- Botón confirmar eliminación --}}
                <x-danger-button class="ms-3">
                    {{ __('Eliminar Cuenta') }}
                </x-danger-button>

            </div>

        </form>
    </x-modal>
</section>
