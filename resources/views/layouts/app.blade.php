<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ErgoTech</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 text-slate-800" x-data="{ sidebarOpen: false }">

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

    $rol = strtolower(auth()->user()->rol?->nombre ?? 'visitante');
@endphp

<div class="min-h-screen flex">

    <!-- Overlay móvil -->
    <div
        x-show="sidebarOpen"
        x-transition.opacity
        class="fixed inset-0 bg-slate-950/40 z-30 lg:hidden"
        @click="sidebarOpen = false"
        style="display: none;"
    ></div>

    <!-- Sidebar -->
    <aside
        class="fixed inset-y-0 left-0 z-40 w-72 bg-sky-600 text-white flex flex-col transform transition-transform duration-300 lg:translate-x-0 lg:static lg:flex shadow-xl"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    >
        <!-- Header sidebar -->
        <div class="px-6 py-5 border-b border-white/20 flex flex-col items-center gap-3 relative">

            <div class="w-full bg-white/95 rounded-2xl shadow-lg p-4 flex items-center justify-center">
                <img
                    src="{{ asset('images/ergotech-logo.png') }}"
                    alt="ErgoTech"
                    class="max-h-20 object-contain"
                >
            </div>

            <button
                class="lg:hidden text-white text-2xl shrink-0 absolute right-4 top-4"
                @click="sidebarOpen = false"
                type="button"
            >
                ×
            </button>
        </div>

        <!-- Navegación -->
        <nav class="flex-1 px-5 py-6 space-y-6 overflow-y-auto">

            <!-- Principal -->
            <div>
                <p class="text-[18px] font-bold uppercase tracking-wider text-white mt-4 mb-2">
                    Principal
                </p>

                <div class="bg-white/20 rounded-xl p-2 space-y-1">
                    @if(Route::has('dashboard'))
                        <a href="{{ route('dashboard') }}"
                           class="flex items-center rounded-xl px-4 py-3 text-[15px] transition {{ request()->routeIs('dashboard') ? 'bg-sky-800 ring-1 ring-white/20 text-white font-semibold shadow-sm' : 'text-white/95 hover:bg-white/20 hover:translate-x-1 transition-all duration-200' }}">
                            Dashboard
                        </a>
                    @endif
                </div>
            </div>

            <!-- Gestión -->
            @if(in_array($rol, ['admin', 'evaluador']))
                <div>
                    <p class="text-[18px] font-bold uppercase tracking-wider text-white mt-4 mb-2">
                        Gestión
                    </p>

                    <div class="bg-white/20 rounded-xl p-2 space-y-1">
                        @if(Route::has('empresas.index'))
                            <a href="{{ route('empresas.index') }}"
                               class="flex items-center rounded-xl px-4 py-3 text-[15px] transition {{ request()->routeIs('empresas.*') ? 'bg-sky-700 shadow-md text-white font-semibold' : 'text-white/95 hover:bg-white/20 transition-all duration-200' }}">
                                Empresas
                            </a>
                        @endif

                        @if(Route::has('sucursales.index'))
                            <a href="{{ route('sucursales.index') }}"
                               class="flex items-center rounded-xl px-4 py-3 text-[15px] transition {{ request()->routeIs('sucursales.*') ? 'bg-sky-700 shadow-md text-white font-semibold' : 'text-white/95 hover:bg-white/20 transition-all duration-200' }}">
                                Sucursales
                            </a>
                        @endif

                        @if(Route::has('puestos.index'))
                            <a href="{{ route('puestos.index') }}"
                               class="flex items-center rounded-xl px-4 py-3 text-[15px] transition {{ request()->routeIs('puestos.*') ? 'bg-sky-700 shadow-md text-white font-semibold' : 'text-white/95 hover:bg-white/20 transition-all duration-200' }}">
                                Puestos
                            </a>
                        @endif

                        @if(Route::has('trabajadores.index'))
                            <a href="{{ route('trabajadores.index') }}"
                               class="flex items-center rounded-xl px-4 py-3 text-[15px] transition {{ request()->routeIs('trabajadores.*') ? 'bg-sky-700 shadow-md text-white font-semibold' : 'text-white/95 hover:bg-white/20 transition-all duration-200' }}">
                                Trabajadores
                            </a>
                        @endif

                        @if(Route::has('usuarios.index'))
                            <a href="{{ route('usuarios.index') }}"
                               class="flex items-center rounded-xl px-4 py-3 text-[15px] transition {{ request()->routeIs('usuarios.*') ? 'bg-sky-700 shadow-md text-white font-semibold' : 'text-white/95 hover:bg-white/20 transition-all duration-200' }}">
                                Usuarios
                            </a>
                        @endif

                        @if(Route::has('configuracion.index'))
                            <a href="{{ route('configuracion.index') }}"
                               class="flex items-center rounded-xl px-4 py-3 text-[15px] transition {{ request()->routeIs('configuracion.*') ? 'bg-sky-700 shadow-md text-white font-semibold' : 'text-white/95 hover:bg-white/20 transition-all duration-200' }}">
                                Configuración
                            </a>
                        @endif

                        @if(Route::has('reportes.index'))
                            <a href="{{ route('reportes.index') }}"
                               class="flex items-center rounded-xl px-4 py-3 text-[15px] transition {{ request()->routeIs('reportes.*') ? 'bg-sky-700 shadow-md text-white font-semibold' : 'text-white/95 hover:bg-white/20 transition-all duration-200' }}">
                                Reportes
                            </a>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Evaluación -->
            @if(in_array($rol, ['admin', 'evaluador']))
                <div>
                    <p class="text-[18px] font-bold uppercase tracking-wider text-white mt-4 mb-2">
                        Evaluación
                    </p>

                    <div class="bg-white/20 rounded-xl p-2 space-y-1">
                        @if(Route::has('evaluaciones.index'))
                            <a href="{{ route('evaluaciones.index') }}"
                               class="flex items-center rounded-xl px-4 py-3 text-[15px] transition {{ request()->routeIs('evaluaciones.index') ? 'bg-sky-700 shadow-md text-white font-semibold' : 'text-white/95 hover:bg-white/20 transition-all duration-200' }}">
                                Evaluaciones
                            </a>
                        @endif

                        @if(Route::has('evaluaciones.create'))
                            <a href="{{ route('evaluaciones.create') }}"
                               class="flex items-center rounded-xl px-4 py-3 text-[15px] transition {{ request()->routeIs('evaluaciones.create') ? 'bg-sky-700 shadow-md text-white font-semibold' : 'text-white/95 hover:bg-white/20 transition-all duration-200' }}">
                                Nueva evaluación
                            </a>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Cuenta -->
            <div>
                <p class="text-[18px] font-bold uppercase tracking-wider text-white mt-4 mb-2">
                    Cuenta
                </p>

                <div class="bg-white/20 rounded-xl p-2 space-y-1">
                    @if(Route::has('profile.edit'))
                        <a href="{{ route('profile.edit') }}"
                           class="flex items-center rounded-xl px-4 py-3 text-[15px] transition {{ request()->routeIs('profile.*') ? 'bg-sky-700 shadow-md text-white font-semibold' : 'text-white/95 hover:bg-white/20 transition-all duration-200' }}">
                            Perfil
                        </a>
                    @endif
                </div>
            </div>
        </nav>

        <!-- Footer sidebar -->
        <div class="p-5 border-t border-white/15">
            @if(Route::has('logout'))
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="w-full inline-flex items-center justify-center rounded-xl bg-white text-sky-700 font-semibold px-4 py-3 hover:bg-slate-100 transition"
                    >
                        Cerrar sesión
                    </button>
                </form>
            @endif
        </div>
    </aside>

    <!-- Contenido principal -->
    <div class="flex-1 min-w-0 flex flex-col">

        <!-- Header -->
        <header class="h-24 bg-white border-b border-slate-200 px-4 sm:px-6 lg:px-8 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-4 min-w-0">
                <button
                    class="lg:hidden inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-3 py-2 text-slate-700 shadow-sm"
                    @click="sidebarOpen = true"
                    type="button"
                >
                    ☰
                </button>

                <div class="hidden sm:flex h-16 w-16 rounded-full bg-white items-center justify-center overflow-hidden border border-sky-200 shadow-sm">
                    <img
                        src="{{ asset('images/logo_chico.png') }}"
                        alt="ErgoTech"
                        class="h-full w-full object-cover"
                    >
                </div>

                <div class="min-w-0">
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 leading-tight truncate">
                        {{ $tituloPanel }}
                    </h1>
                    <p class="hidden md:block text-base text-slate-500 mt-1">
                        ErgoTech · Plataforma de evaluación ergonómica
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <span class="hidden sm:inline-block text-sm bg-sky-100 text-sky-700 px-4 py-2 rounded-full font-semibold">
                    {{ ucfirst($rol) }}
                </span>

                @if(Auth::user()->profile_photo)
                    <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}"
                         class="w-12 h-12 rounded-full object-cover ring-2 ring-slate-200">
                @else
                    <div class="w-12 h-12 rounded-full bg-slate-200 flex items-center justify-center text-sm font-semibold text-slate-700">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif

                <div class="hidden sm:block text-right min-w-0">
                    <p class="text-sm font-semibold text-slate-800 truncate max-w-[180px]">
                        {{ Auth::user()->name }}
                        @if(Auth::user()->last_name)
                            {{ Auth::user()->last_name }}
                        @endif
                    </p>
                    <p class="text-xs text-slate-500">
                        {{ Auth::user()->isAdmin() ? 'Usuario' : (Auth::user()->isEvaluador() ? 'Usuario' : 'Usuario') }}
                    </p>
                </div>
            </div>
        </header>

        <!-- Main -->
        <main class="flex-1 overflow-y-auto">
            <div class="p-4 sm:p-6 lg:p-8">
                {{ $slot }}
            </div>
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>