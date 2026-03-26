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

    <div
        x-show="sidebarOpen"
        x-transition.opacity
        class="fixed inset-0 bg-slate-950/40 z-30 lg:hidden"
        @click="sidebarOpen = false"
        style="display: none;"
    ></div>

    <aside
        class="fixed inset-y-0 left-0 z-40 w-72 bg-gradient-to-b from-sky-700 via-sky-600 to-sky-500 text-white flex flex-col transform transition-transform duration-300 lg:translate-x-0 lg:static lg:flex shadow-2xl lg:shadow-none"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    >

        <!-- HEADER NUEVO -->
        <div class="px-6 py-5 border-b border-white/20 flex flex-col items-center gap-3">

            <div class="w-full bg-white/90 rounded-xl shadow-lg p-3 flex items-center justify-center">

        <img
            src="{{ asset('images/ergotech-logo.png') }}"
            alt="ErgoTech"
            class="max-h-16 object-contain"
        >

        </div>

            </a>

            <button
                class="lg:hidden text-white text-2xl shrink-0 absolute right-4 top-4"
                @click="sidebarOpen = false"
                type="button"
            >
                ×
            </button>

        </div>
            <nav class="flex-1 px-5 py-6 space-y-6 overflow-y-auto">
                <div>
                    <p class="px-3 mb-3 text-[11px] font-semibold uppercase tracking-[0.22em] text-white/50 px-2">
                        Principal
                    </p>

                    @if(Route::has('dashboard'))
                        <a href="{{ route('dashboard') }}"
                           span class="flex items-center rounded-xl px-4 py-3 text-[15px] transition {{ request()->routeIs('dashboard') ? 'bg-sky-800 shadow-lg ring-1 ring-white/20 text-white font-semibold shadow-sm' : 'text-white/95 hover:bg-white/20 hover:translate-x-1 transition-all duration-200' }}">
                            Dashboard
                        </a>
                    @endif
                </div>

                @if(in_array($rol, ['admin', 'evaluador']))
                    <div>
                        <p class="px-3 mb-3 mt-6 text-[11px] font-semibold uppercase tracking-[0.22em] text-white/50">
                            Gestión
                        </p>

                        <div class="space-y-1.5">
                            @if(Route::has('empresas.index'))
                                <a href="{{ route('empresas.index') }}"
                                   class="flex items-center rounded-2xl px-4 py-2.5 text-[15px] font-medium transition {{ request()->routeIs('empresas.*') ? 'bg-sky-700 shadow-md text-white font-semibold shadow-sm' : 'text-white/95 hover:bg-white/20 transition-all duration-200' }}">
                                    Empresas
                                </a>
                            @endif

                            @if(Route::has('sucursales.index'))
                                <a href="{{ route('sucursales.index') }}"
                                   class="flex items-center rounded-xl px-4 py-3 text-[15px] transition {{ request()->routeIs('sucursales.*') ? 'bg-sky-700 shadow-md text-white font-semibold shadow-sm' : 'text-white/95 hover:bg-white/20 transition-all duration-200' }}">
                                    Sucursales
                                </a>
                            @endif

                            @if(Route::has('puestos.index'))
                                <a href="{{ route('puestos.index') }}"
                                   class="flex items-center rounded-xl px-4 py-3 text-[15px] transition {{ request()->routeIs('puestos.*') ? 'bg-sky-700 shadow-md text-white font-semibold shadow-sm' : 'text-white/95 hover:bg-white/20 transition-all duration-200' }}">
                                    Puestos
                                </a>
                            @endif

                            @if(Route::has('trabajadores.index'))
                                <a href="{{ route('trabajadores.index') }}"
                                   class="flex items-center rounded-xl px-4 py-3 text-[15px] transition {{ request()->routeIs('trabajadores.*') ? 'bg-sky-700 shadow-md text-white font-semibold shadow-sm' : 'text-white/95 hover:bg-white/20 transition-all duration-200' }}">
                                    Trabajadores
                                </a>
                            @endif
                        </div>
                    </div>
                @endif

                <div>
                    <p class="px-3 mb-3 text-[11px] font-semibold uppercase tracking-[0.18em] text-white/65">
                        Sistema
                    </p>

                    <div class="space-y-1.5">
                        @if($rol === 'admin' && Route::has('usuarios.index'))
                            <a href="{{ route('usuarios.index') }}"
                               class="flex items-center rounded-xl px-4 py-3 text-[15px] transition {{ request()->routeIs('usuarios.*') ? 'bg-sky-700 shadow-md text-white font-semibold shadow-sm' : 'text-white/95 hover:bg-white/20 transition-all duration-200' }}">
                                Usuarios
                            </a>
                        @endif

                        @if($rol === 'admin' && Route::has('configuracion.index'))
                            <a href="{{ route('configuracion.index') }}"
                               class="flex items-center rounded-xl px-4 py-3 text-[15px] transition {{ request()->routeIs('configuracion.*') ? 'bg-sky-700 shadow-md text-white font-semibold shadow-sm' : 'text-white/95 hover:bg-white/20 transition-all duration-200' }}">
                                Configuración
                            </a>
                        @endif

                        @if(Route::has('reportes.index'))
                            <a href="{{ route('reportes.index') }}"
                               class="flex items-center rounded-xl px-4 py-3 text-[15px] transition {{ request()->routeIs('reportes.*') ? 'bg-sky-700 shadow-md text-white font-semibold shadow-sm' : 'text-white/95 hover:bg-white/20 transition-all duration-200' }}">
                                Reportes
                            </a>
                        @endif
                    </div>
                </div>

                @if(in_array($rol, ['admin', 'evaluador']))
                    <div>
                        <p class="px-3 mb-3 text-[11px] font-semibold uppercase tracking-[0.18em] text-white/65">
                            Evaluación
                        </p>

                        <div class="space-y-1.5">
                            @if(Route::has('evaluaciones.index'))
                                <a href="{{ route('evaluaciones.index') }}"
                                   class="flex items-center rounded-xl px-4 py-3 text-[15px] transition {{ request()->routeIs('evaluaciones.index') ? 'bg-sky-700 shadow-md text-white font-semibold shadow-sm' : 'text-white/95 hover:bg-white/20 transition-all duration-200' }}">
                                    Evaluaciones
                                </a>
                            @endif

                            @if(Route::has('evaluaciones.create'))
                                <a href="{{ route('evaluaciones.create') }}"
                                   class="flex items-center rounded-xl px-4 py-3 text-[15px] transition {{ request()->routeIs('evaluaciones.create') ? 'bg-sky-700 shadow-md text-white font-semibold shadow-sm' : 'text-white/95 hover:bg-white/20 transition-all duration-200' }}">
                                    Nueva evaluación
                                </a>
                            @endif
                        </div>
                    </div>
                @endif

                <div>
                    <p class="px-3 mb-3 text-[11px] font-semibold uppercase tracking-[0.18em] text-white/65">
                        Cuenta
                    </p>

                    @if(Route::has('profile.edit'))
                        <a href="{{ route('profile.edit') }}"
                           class="flex items-center rounded-xl px-4 py-3 text-[15px] transition {{ request()->routeIs('profile.*') ? 'bg-sky-700 shadow-md text-white font-semibold shadow-sm' : 'text-white/95 hover:bg-white/20 transition-all duration-200' }}">
                            Perfil
                        </a>
                    @endif
                </div>
            </nav>

            <div class="p-5 border-t border-white/15">
                @if(Route::has('logout'))
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full rounded-xl px-4 py-3 text-left text-[15px] font-medium text-white/95 hover:bg-white/20 hover:translate-x-1 transition-all duration-200 transition">
                            Cerrar sesión
                        </button>
                    </form>
                @endif
            </div>
        </aside>

        <div class="flex-1 min-w-0 flex flex-col">
            <header class="h-20 bg-white shadow-sm border-b border-slate-200 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
                <div class="flex items-center gap-4 min-w-0">
                    <button
                        class="lg:hidden inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-3 py-2 text-slate-700 shadow-sm"
                        @click="sidebarOpen = true"
                        type="button"
                    >
                        ☰
                    </button>

                    <div class="hidden sm:flex h-11 w-11 rounded-xl bg-slate-50 items-center justify-center overflow-hidden">
                        <img
                            src="{{ asset('images/ergotech-logo.png') }}"
                            alt="ErgoTech"
                            class="h-8 w-8 object-contain"
                        >
                    </div>

                    <div class="min-w-0">
                        <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-800 truncate">
                            {{ $tituloPanel }}
                        </h1>
                        <p class="hidden md:block text-sm text-slate-500 mt-0.5">
                            ErgoTech · Plataforma de evaluación ergonómica
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <span class="hidden sm:inline-block text-xs bg-sky-100 text-sky-700 px-3 py-1 rounded-full font-semibold">
                        {{ ucfirst($rol) }}
                    </span>

                    @if(Auth::user()->profile_photo)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}"
                             class="w-11 h-11 rounded-full object-cover ring-2 ring-slate-200">
                    @else
                        <div class="w-11 h-11 rounded-full bg-slate-200 flex items-center justify-center text-sm font-semibold text-slate-700">
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
                            {{ Auth::user()->isAdmin() ? 'Administrador' : (Auth::user()->isEvaluador() ? 'Evaluador' : 'Usuario') }}
                        </p>
                    </div>
                </div>
            </header>

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