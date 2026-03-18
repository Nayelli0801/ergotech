<!DOCTYPE html> <html lang="es"> <head> <meta charset="UTF-8"> <meta name="viewport" content="width=device-width, initial-scale=1.0"> <title>ErgoTech</title> @vite(['resources/css/app.css', 'resources/js/app.js']) </head> <body class="bg-gray-100"> <div class="flex h-screen">
<!-- SIDEBAR -->
<aside class="w-64 bg-gradient-to-b from-blue-700 to-blue-800 text-white flex flex-col fixed h-screen shadow-xl">

    <!-- Logo -->
    <div class="p-6 text-2xl font-bold border-b border-blue-600 tracking-wide">
        <a href="{{ route('dashboard') }}" class="hover:text-blue-200 transition">
            ERGOTECH
        </a>
    </div>

    <!-- Menú -->
    <nav class="flex-1 p-4 space-y-2 overflow-y-auto text-sm">

        <p class="text-blue-200 text-xs uppercase tracking-wider mt-2">Principal</p>
        <a href="{{ route('dashboard') }}"
           class="block px-4 py-2 rounded-lg transition {{ request()->routeIs('dashboard') ? 'bg-blue-900 font-semibold shadow-inner' : 'hover:bg-blue-600 hover:pl-5' }}">
            Dashboard
        </a>

        <p class="text-blue-200 text-xs uppercase tracking-wider mt-4">Gestión</p>
        <a href="{{ route('empresas.index') }}"
           class="block px-4 py-2 rounded-lg transition {{ request()->routeIs('empresas.*') ? 'bg-blue-900 font-semibold shadow-inner' : 'hover:bg-blue-600 hover:pl-5' }}">
            Empresas
        </a>

        <a href="{{ route('sucursales.index') }}"
           class="block px-4 py-2 rounded-lg transition {{ request()->routeIs('sucursales.*') ? 'bg-blue-900 font-semibold shadow-inner' : 'hover:bg-blue-600 hover:pl-5' }}">
            Sucursales
        </a>

        <a href="{{ route('puestos.index') }}"
           class="block px-4 py-2 rounded-lg transition {{ request()->routeIs('puestos.*') ? 'bg-blue-900 font-semibold shadow-inner' : 'hover:bg-blue-600 hover:pl-5' }}">
            Puestos
        </a>

        <a href="{{ route('trabajadores.index') }}"
           class="block px-4 py-2 rounded-lg transition {{ request()->routeIs('trabajadores.*') ? 'bg-blue-900 font-semibold shadow-inner' : 'hover:bg-blue-600 hover:pl-5' }}">
            Trabajadores
        </a>

        <p class="text-blue-200 text-xs uppercase tracking-wider mt-4">Sistema</p>

        @if(auth()->user()->rol?->nombre === 'admin')
        <a href="{{ route('usuarios.index') }}"
           class="block px-4 py-2 rounded-lg transition {{ request()->routeIs('usuarios.*') ? 'bg-blue-900 font-semibold shadow-inner' : 'hover:bg-blue-600 hover:pl-5' }}">
            Usuarios
        </a>
        @endif

        <a href="{{ route('reportes.index') }}"
           class="block px-4 py-2 rounded-lg transition {{ request()->routeIs('reportes.*') ? 'bg-blue-900 font-semibold shadow-inner' : 'hover:bg-blue-600 hover:pl-5' }}">
            Reportes
        </a>

        <p class="text-blue-200 text-xs uppercase tracking-wider mt-4">Evaluación</p>
        <a href="{{ route('evaluaciones.index') }}"
           class="block px-4 py-2 rounded-lg transition {{ request()->routeIs('evaluaciones.index') ? 'bg-blue-900 font-semibold shadow-inner' : 'hover:bg-blue-600 hover:pl-5' }}">
            Evaluaciones
        </a>

        <a href="{{ route('evaluaciones.create') }}"
           class="block px-4 py-2 rounded-lg transition {{ request()->routeIs('evaluaciones.create') ? 'bg-blue-900 font-semibold shadow-inner' : 'hover:bg-blue-600 hover:pl-5' }}">
            Nueva evaluación
        </a>

        <p class="text-blue-200 text-xs uppercase tracking-wider mt-4">Cuenta</p>
        <a href="{{ route('profile.edit') }}"
           class="block px-4 py-2 rounded-lg transition {{ request()->routeIs('profile.*') ? 'bg-blue-900 font-semibold shadow-inner' : 'hover:bg-blue-600 hover:pl-5' }}">
            Perfil
        </a>
    </nav>

    <!-- Logout -->
    <div class="p-5 border-t border-blue-600">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="w-full text-left px-4 py-2 rounded-lg transition hover:bg-red-500 hover:text-white text-red-100">
                Cerrar sesión
            </button>
        </form>
    </div>
</aside>

<!-- CONTENIDO -->
<div class="ml-64 flex-1 min-h-screen flex flex-col">

    <!-- HEADER -->
    <header class="bg-white shadow px-8 py-4 flex justify-between items-center">

        <h1 class="text-xl font-semibold text-gray-800">
            Panel Administrador
        </h1>

        <div class="flex items-center gap-4">

            <!-- Rol -->
            <span class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full font-semibold">
                {{ ucfirst(Auth::user()->rol?->nombre ?? 'Usuario') }}
            </span>

            @if(Auth::user()->profile_photo)
                <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}"
                     class="w-10 h-10 rounded-full object-cover ring-2 ring-gray-300">
            @else
                <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-sm font-semibold text-gray-700">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            @endif

            <div class="text-sm text-gray-700 font-medium">
                {{ Auth::user()->name }}
                @if(Auth::user()->last_name)
                    {{ Auth::user()->last_name }}
                @endif
            </div>

        </div>

    </header>

    <!-- MAIN -->
    <main class="p-8 flex-1 overflow-y-auto">
        {{ $slot }}
    </main>

</div>
</div> </body> </html>