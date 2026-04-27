<section>

    {{-- Encabezado --}}
    <header>
        <h2 class="text-lg font-semibold text-slate-800">
            Autenticación de Dos Factores
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            Agrega una capa extra de seguridad a tu cuenta activando la autenticación en dos pasos.
        </p>
    </header>

    <div class="mt-6 flex flex-wrap gap-3">

        {{-- ACTIVAR --}}
        <form method="POST" action="/user/two-factor-authentication">
            @csrf

            <button 
                type="submit"
                class="inline-flex items-center justify-center
                       w-[140px] h-[42px]
                       bg-sky-600 hover:bg-sky-700
                       text-white text-sm font-semibold
                       rounded-lg shadow-sm transition
                       disabled:bg-gray-300 disabled:text-gray-500 disabled:cursor-not-allowed"
                @if(auth()->user()->two_factor_secret) disabled @endif
            >
                Activar
            </button>
        </form>

        {{-- DESACTIVAR --}}
        <form method="POST" action="/user/two-factor-authentication">
            @csrf
            @method('DELETE')

            <button 
                type="submit"
                class="inline-flex items-center justify-center
                       w-[140px] h-[42px]
                       bg-red-100 hover:bg-red-200
                       text-red-700 text-sm font-semibold
                       rounded-lg transition
                       disabled:bg-gray-300 disabled:text-gray-500 disabled:cursor-not-allowed"
                @if(!auth()->user()->two_factor_secret) disabled @endif
            >
                Desactivar
            </button>
        </form>

    </div>

</section>