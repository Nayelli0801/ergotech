<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ErgoTech</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

{{-- 
    El atributo x-data="sidebarOpen: false" inicializa Alpine.js 
    para controlar la visibilidad del sidebar en móvil.
--}}
<body class="bg-gray-100" x-data="{ sidebarOpen: false }">

    <div class="min-h-screen flex">
        {{-- Overlay oscuro que aparece cuando el sidebar está abierto en móvil --}}
        <div
            x-show="sidebarOpen"
            x-transition.opacity
            class="fixed inset-0 bg-black/40 z-30 lg:hidden"
            @click="sidebarOpen = false"
            style="display: none;"
        ></div>

        {{-- 
            SIDEBAR 
            - Gradiente de fondo.
            - Posición fija en móvil, transformación para ocultar/mostrar.
            - En lg (escritorio) siempre visible (lg:translate-x-0 lg:static).
        --}}
        <aside
            class="fixed inset-y-0 left-0 z-40 w-64 bg-gradient-to-b from-blue-700 via-blue-800 to-blue-900 text-white flex flex-col transform transition-transform duration-300 lg:translate-x-0 lg:static shadow-2xl"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        >
            {{-- Logo y botón de cerrar en móvil --}}
            <div class="p-6 text-2xl font-bold border-b border-blue-600 tracking-wide flex items-center justify-between">
                <a href="{{ route('dashboard') }}" class="hover:text-blue-200 transition">
                    ERGOTECH
                </a>
                <button
                    class="lg:hidden text-white text-2xl"
                    @click="sidebarOpen = false"
                    type="button"
                >
                    ×
                </button>
            </div>

            {{-- Menú de navegación con control de roles --}}
            <nav class="flex-1 p-4 space-y-2 overflow-y-auto text-sm">
                @php
                    // Obtenemos el rol del usuario autenticado (en minúsculas)
                    $rol = strtolower(auth()->user()->rol?->nombre ?? 'visitante');
                @endphp

                <p class="text-blue-200 text-xs uppercase tracking-wider mt-2">Principal</p>
                <a href="{{ route('dashboard') }}"
                   class="block px-4 py-2 rounded-lg transition {{ request()->routeIs('dashboard') ? 'bg-blue-900 font-semibold shadow-inner' : 'hover:bg-blue-600 hover:pl-5' }}">
                    Dashboard
                </a>

                {{-- SECCIÓN GESTIÓN: visible para admin y evaluador --}}
                @if(in_array($rol, ['admin', 'evaluador']))
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
                @endif

                <p class="text-blue-200 text-xs uppercase tracking-wider mt-4">Sistema</p>

                {{-- SECCIÓN SISTEMA: solo admin ve Usuarios y Configuración --}}
                @if($rol === 'admin')
                    <a href="{{ route('usuarios.index') }}"
                       class="block px-4 py-2 rounded-lg transition {{ request()->routeIs('usuarios.*') ? 'bg-blue-900 font-semibold shadow-inner' : 'hover:bg-blue-600 hover:pl-5' }}">
                        Usuarios
                    </a>

                    {{-- Enlace a Configuración (solo admin) --}}
                    <a href="{{ route('configuracion.index') }}"
                       class="block px-4 py-2 rounded-lg transition hover:bg-blue-600 hover:pl-5">
                        Configuración
                    </a>
                @endif

                {{-- Reportes: visible para todos --}}
                <a href="{{ route('reportes.index') }}"
                   class="block px-4 py-2 rounded-lg transition {{ request()->routeIs('reportes.*') ? 'bg-blue-900 font-semibold shadow-inner' : 'hover:bg-blue-600 hover:pl-5' }}">
                    Reportes
                </a>

                {{-- SECCIÓN EVALUACIÓN: solo admin y evaluador --}}
                @if(in_array($rol, ['admin', 'evaluador']))
                    <p class="text-blue-200 text-xs uppercase tracking-wider mt-4">Evaluación</p>

                    <a href="{{ route('evaluaciones.index') }}"
                       class="block px-4 py-2 rounded-lg transition {{ request()->routeIs('evaluaciones.index') ? 'bg-blue-900 font-semibold shadow-inner' : 'hover:bg-blue-600 hover:pl-5' }}">
                        Evaluaciones
                    </a>

                    <a href="{{ route('evaluaciones.create') }}"
                       class="block px-4 py-2 rounded-lg transition {{ request()->routeIs('evaluaciones.create') ? 'bg-blue-900 font-semibold shadow-inner' : 'hover:bg-blue-600 hover:pl-5' }}">
                        Nueva evaluación
                    </a>
                @endif

                <p class="text-blue-200 text-xs uppercase tracking-wider mt-4">Cuenta</p>

                {{-- Perfil: visible para todos --}}
                <a href="{{ route('profile.edit') }}"
                   class="block px-4 py-2 rounded-lg transition {{ request()->routeIs('profile.*') ? 'bg-blue-900 font-semibold shadow-inner' : 'hover:bg-blue-600 hover:pl-5' }}">
                    Perfil
                </a>
            </nav>

            {{-- Botón de cerrar sesión --}}
            <div class="p-5 border-t border-blue-600">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full text-left px-4 py-2 rounded-lg transition hover:bg-red-500 hover:text-white text-red-100">
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </aside>

        {{-- CONTENIDO PRINCIPAL (derecha) --}}
        <div class="flex-1 min-w-0 flex flex-col transition-all duration-300"
             :class="{ 'lg:ml-64': true }">
            {{-- HEADER con botón hamburguesa y datos del usuario --}}
            <header class="bg-white shadow px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    {{-- Botón para abrir sidebar en móvil --}}
                    <button
                        class="lg:hidden inline-flex items-center justify-center rounded-lg border border-gray-300 px-3 py-2 text-gray-700"
                        @click="sidebarOpen = true"
                        type="button"
                    >
                        ☰
                    </button>

                    {{-- Título dinámico según el rol --}}
                    <h1 class="text-lg sm:text-xl font-semibold text-gray-800">
                        Panel {{ ucfirst($rol) }}
                    </h1>
                </div>

                <div class="flex items-center gap-4">
                    {{-- Badge con el nombre del rol (visible en pantallas medianas+) --}}
                    <span class="hidden sm:inline-block text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full font-semibold">
                        {{ ucfirst($rol) }}
                    </span>

                    {{-- Foto de perfil o inicial --}}
                    @if(Auth::user()->profile_photo)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}"
                             class="w-10 h-10 rounded-full object-cover ring-2 ring-gray-300">
                    @else
                        <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-sm font-semibold text-gray-700">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    @endif

                    {{-- Nombre completo del usuario (visible en sm+) --}}
                    <div class="hidden sm:block text-sm text-gray-700 font-medium truncate max-w-[180px]">
                        {{ Auth::user()->name }}
                        @if(Auth::user()->last_name)
                            {{ Auth::user()->last_name }}
                        @endif
                    </div>
                </div>
            </header>

            {{-- MAIN: aquí se inyecta el contenido de cada página (usando $slot) --}}
            <main class="p-4 sm:p-6 lg:p-8 flex-1 overflow-y-auto">
                {{ $slot }}
            </main>
        </div>
    </div>

    {{-- Para scripts adicionales que puedan agregarse desde las vistas hijas --}}
    @stack('scripts')
</body>
</html>