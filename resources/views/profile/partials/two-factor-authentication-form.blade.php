{{-- ========================================= --}}
{{-- SECCIÓN: AUTENTICACIÓN DE DOS FACTORES   --}}
{{-- ========================================= --}}

<section>

    {{-- Encabezado --}}
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Autenticación de Dos Factores
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Agrega una capa extra de seguridad a tu cuenta activando la autenticación en dos pasos.
        </p>
    </header>

    <div class="mt-6 flex gap-4">

        {{-- ============================= --}}
        {{-- BOTÓN ACTIVAR                --}}
        {{-- ============================= --}}

        <form method="POST" action="/user/two-factor-authentication">
            @csrf

            <button 
                type="submit"
                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
                @if(auth()->user()->two_factor_secret) disabled @endif
            >
                Activar
            </button>
        </form>

        {{-- ============================= --}}
        {{-- BOTÓN DESACTIVAR             --}}
        {{-- ============================= --}}

        <form method="POST" action="/user/two-factor-authentication">
            @csrf
            @method('DELETE')

            <button 
                type="submit"
                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
                @if(!auth()->user()->two_factor_secret) disabled @endif
            >
                Desactivar
            </button>
        </form>

    </div>

</section>
