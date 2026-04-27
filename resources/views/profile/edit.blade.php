<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-sky-600">
            Perfil de usuario
        </h2>
        <p class="text-sm text-gray-500 mt-1">
            Administra tu información personal, seguridad y configuración de acceso.
        </p>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-6 space-y-6">

            {{-- INFORMACIÓN --}}
            <div class="bg-white border border-gray-200 shadow-sm rounded-2xl p-6">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- PASSWORD --}}
            <div class="bg-white border border-gray-200 shadow-sm rounded-2xl p-6">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- 2FA --}}
            <div class="bg-white border border-gray-200 shadow-sm rounded-2xl p-6">
                <div class="max-w-xl">
                    @include('profile.partials.two-factor-authentication-form')
                </div>
            </div>

            {{-- ELIMINAR --}}
            <div class="bg-white border border-gray-200 shadow-sm rounded-2xl p-6">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>