<section>

    {{-- Encabezado --}}
    <header>
        <h2 class="text-lg font-semibold text-slate-800">
            {{ __('Actualizar Contraseña') }}
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            {{ __('Asegúrate de que tu cuenta esté usando una contraseña larga y aleatoria para mantener la seguridad.') }}
        </p>
    </header>

    {{-- Formulario --}}
    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        
        @csrf
        @method('put')

        {{-- Contraseña actual --}}
        <div>
            <x-input-label 
                for="update_password_current_password" 
                :value="__('Contraseña Actual')" 
                class="text-sm font-medium text-gray-700"
            />
            
            <x-text-input 
                id="update_password_current_password" 
                name="current_password" 
                type="password" 
                class="mt-1 block w-full rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500"
                autocomplete="current-password" 
            />
            
            <x-input-error 
                :messages="$errors->updatePassword->get('current_password')" 
                class="mt-2" 
            />
        </div>

        {{-- Nueva contraseña --}}
        <div>
            <x-input-label 
                for="update_password_password" 
                :value="__('Nueva Contraseña')" 
                class="text-sm font-medium text-gray-700"
            />
            
            <x-text-input 
                id="update_password_password" 
                name="password" 
                type="password" 
                class="mt-1 block w-full rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500"
                autocomplete="new-password" 
            />
            
            <x-input-error 
                :messages="$errors->updatePassword->get('password')" 
                class="mt-2" 
            />
        </div>

        {{-- Confirmar contraseña --}}
        <div>
            <x-input-label 
                for="update_password_password_confirmation" 
                :value="__('Confirmar Contraseña')" 
                class="text-sm font-medium text-gray-700"
            />
            
            <x-text-input 
                id="update_password_password_confirmation" 
                name="password_confirmation" 
                type="password" 
                class="mt-1 block w-full rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500"
                autocomplete="new-password" 
            />
            
            <x-input-error 
                :messages="$errors->updatePassword->get('password_confirmation')" 
                class="mt-2" 
            />
        </div>

        {{-- Botón --}}
        <div class="flex items-center gap-4">

            <button type="submit"
                class="inline-flex items-center justify-center
                       w-[140px] h-[42px]
                       bg-sky-600 hover:bg-sky-700
                       text-white text-sm font-semibold
                       rounded-lg shadow-sm transition">
                {{ __('Guardar') }}
            </button>

            {{-- Mensaje éxito --}}
            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-slate-500"
                >
                    {{ __('Guardado correctamente.') }}
                </p>
            @endif

        </div>

    </form>
</section>