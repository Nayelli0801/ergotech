<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ErgoTech</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100" x-data="{ sidebarOpen: false }">

    <div class="min-h-screen flex">
        {{-- Overlay móvil --}}
        <div
            x-show="sidebarOpen"
            x-transition.opacity
            class="fixed inset-0 bg-black/40 z-30 lg:hidden"
            @click="sidebarOpen = false"
            style="display: none;"
        ></div>

        {{-- Sidebar --}}
        <aside
            class="fixed inset-y-0 left-0 z-40 w-64 bg-blue-700 text-white flex flex-col transform transition-transform duration-300
                   lg:translate-x-0 lg:static lg:flex"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        >
            <div class="p-6 text-2xl font-bold border-b border-blue-600 flex items-center justify-between">
                <a href="{{ route('dashboard') }}">ERGOTECH</a>

                <button
                    class="lg:hidden text-white text-2xl"
                    @click="sidebarOpen = false"
                    type="button"
                >
                    ×
                </button>
            </div>

            <nav class="flex-1 p-4 space-y-2 overflow-y-auto text-sm">
                <p class="text-blue-200 text-xs uppercase tracking-wider mt-2">Principal</p>
                <a href="{{ route('dashboard') }}"
                   class="block px-4 py-2 rounded {{ request()->routeIs('dashboard') ? 'bg-blue-800 font-semibold' : 'hover:bg-blue-600' }}">
                    Dashboard
                </a>

                <p class="text-blue-200 text-xs uppercase tracking-wider mt-4">Gestión</p>
                <a href="{{ route('empresas.index') }}"
                   class="block px-4 py-2 rounded {{ request()->routeIs('empresas.*') ? 'bg-blue-800 font-semibold' : 'hover:bg-blue-600' }}">
                    Empresas
                </a>

                <a href="{{ route('sucursales.index') }}"
                   class="block px-4 py-2 rounded {{ request()->routeIs('sucursales.*') ? 'bg-blue-800 font-semibold' : 'hover:bg-blue-600' }}">
                    Sucursales
                </a>

                <a href="{{ route('puestos.index') }}"
                   class="block px-4 py-2 rounded {{ request()->routeIs('puestos.*') ? 'bg-blue-800 font-semibold' : 'hover:bg-blue-600' }}">
                    Puestos
                </a>

                <a href="{{ route('trabajadores.index') }}"
                   class="block px-4 py-2 rounded {{ request()->routeIs('trabajadores.*') ? 'bg-blue-800 font-semibold' : 'hover:bg-blue-600' }}">
                    Trabajadores
                </a>

                <p class="text-blue-200 text-xs uppercase tracking-wider mt-4">Sistema</p>
                <a href="{{ route('usuarios.index') }}"
                   class="block px-4 py-2 rounded {{ request()->routeIs('usuarios.*') ? 'bg-blue-800 font-semibold' : 'hover:bg-blue-600' }}">
                    Usuarios
                </a>

                <a href="{{ route('reportes.index') }}"
                   class="block px-4 py-2 rounded {{ request()->routeIs('reportes.*') ? 'bg-blue-800 font-semibold' : 'hover:bg-blue-600' }}">
                    Reportes
                </a>

                <p class="text-blue-200 text-xs uppercase tracking-wider mt-4">Evaluación</p>
                <a href="{{ route('evaluaciones.index') }}"
                   class="block px-4 py-2 rounded {{ request()->routeIs('evaluaciones.index') ? 'bg-blue-800 font-semibold' : 'hover:bg-blue-600' }}">
                    Evaluaciones
                </a>

                <a href="{{ route('evaluaciones.create') }}"
                   class="block px-4 py-2 rounded {{ request()->routeIs('evaluaciones.create') ? 'bg-blue-800 font-semibold' : 'hover:bg-blue-600' }}">
                    Nueva evaluación
                </a>

                <p class="text-blue-200 text-xs uppercase tracking-wider mt-4">Cuenta</p>
                <a href="{{ route('profile.edit') }}"
                   class="block px-4 py-2 rounded {{ request()->routeIs('profile.*') ? 'bg-blue-800 font-semibold' : 'hover:bg-blue-600' }}">
                    Perfil
                </a>
            </nav>

            <div class="p-5 border-t border-blue-600">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full text-left px-4 py-2 rounded hover:bg-red-500 hover:text-white text-red-100">
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </aside>

        {{-- Contenido --}}
        <div class="flex-1 min-w-0 flex flex-col">
            <header class="bg-white shadow px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <button
                        class="lg:hidden inline-flex items-center justify-center rounded-lg border border-gray-300 px-3 py-2 text-gray-700"
                        @click="sidebarOpen = true"
                        type="button"
                    >
                        ☰
                    </button>

                    @php
                        $tituloPanel = 'Panel de Control';

                        if (Auth::check()) {
                            if (Auth::user()->isAdmin()) {
                                $tituloPanel = 'Panel Administrador';
                            } elseif (Auth::user()->isEvaluador()) {
                                $tituloPanel = 'Panel Evaluador';
                            } else {
                                $tituloPanel = 'Panel Visitante';
                            }
                        }
                    @endphp

                    <h1 class="text-lg sm:text-xl font-semibold text-gray-800">
                        {{ $tituloPanel }}
                    </h1>
                </div>

                <div class="flex items-center gap-3 min-w-0">
                    @if(Auth::user()->profile_photo)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}"
                             class="w-10 h-10 rounded-full object-cover ring-2 ring-gray-300">
                    @else
                        <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-sm font-semibold text-gray-700">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    @endif

                    <div class="hidden sm:block text-sm text-gray-700 font-medium truncate max-w-[180px]">
                        {{ Auth::user()->name }}
                        @if(Auth::user()->last_name)
                            {{ Auth::user()->last_name }}
                        @endif
                    </div>
                </div>
            </header>

            <main class="p-4 sm:p-6 lg:p-8 flex-1 overflow-y-auto">
                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>