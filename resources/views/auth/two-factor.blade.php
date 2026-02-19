<x-guest-layout>

    <div class="mb-4 text-sm text-gray-600">
        Verificación en dos pasos. Ingresa el código enviado a tu correo.
    </div>

    @if ($errors->any())
        <div class="mb-4 text-red-600">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('2fa.store') }}">
        @csrf

        <div>
            <x-input-label for="code" value="Código" />
            <x-text-input id="code" class="block mt-1 w-full" type="text" name="code" required autofocus />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                Verificar
            </x-primary-button>
        </div>
    </form>

</x-guest-layout>