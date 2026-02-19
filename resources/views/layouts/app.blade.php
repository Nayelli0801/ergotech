<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>ErgoTech</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-gray-100">

<div class="flex h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-gray-950 border-r border-gray-800 flex flex-col">

        <div class="p-6 text-2xl font-bold text-indigo-400 tracking-wide">
            ERGOTECH
        </div>

        <nav class="flex-1 px-4 space-y-2 text-sm">

            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-2 p-3 rounded-lg hover:bg-indigo-600/20 hover:text-indigo-400 transition">
                🏠 Dashboard
            </a>

            @if(auth()->user()->rol->nombre === 'admin')

                <a href="{{ route('empresas.index') }}"
                   class="flex items-center gap-2 p-3 rounded-lg hover:bg-indigo-600/20 hover:text-indigo-400 transition">
                    🏢 Empresas
                </a>

                <a href="{{ route('usuarios.index') }}"
                   class="flex items-center gap-2 p-3 rounded-lg hover:bg-indigo-600/20 hover:text-indigo-400 transition">
                    👥 Usuarios
                </a>

            @endif

            @if(auth()->user()->rol->nombre !== 'visitante')

                <a href="{{ route('evaluaciones.index') }}"
                   class="flex items-center gap-2 p-3 rounded-lg hover:bg-indigo-600/20 hover:text-indigo-400 transition">
                    📊 Evaluaciones
                </a>

            @endif

            <a href="{{ route('profile.edit') }}"
               class="flex items-center gap-2 p-3 rounded-lg hover:bg-indigo-600/20 hover:text-indigo-400 transition">
                ⚙ Perfil
            </a>

        </nav>

        <div class="p-4 border-t border-gray-800">

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full text-left p-2 rounded-lg hover:bg-red-600/20 hover:text-red-400 transition">
                    🚪 Cerrar sesión
                </button>
            </form>

        </div>

    </aside>

    <!-- CONTENIDO -->
    <main class="flex-1 p-10 overflow-y-auto">

        <div class="bg-gray-900/60 backdrop-blur-lg p-8 rounded-2xl shadow-xl border border-gray-800">
            {{ $slot }}
        </div>

    </main>

</div>

</body>
</html>
