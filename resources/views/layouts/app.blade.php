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
            class="fixed inset-y-0 left-0 z-40 w-72 bg-[#2F9CC3] text-white flex flex-col transform transition-transform duration-300 lg:translate-x-0 lg:static lg:flex shadow-2xl lg:shadow-none"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        >
            <div class="h-24 px-6 border-b border-white/15 flex items-center justify-between">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-4 min-w-0">
                    <div class="h-14 w-14 bg-white rounded-2xl p-2 flex items-center justify-center shadow-md shrink-0">
                        <img
                            src="{{ asset('images/ergotech-logo.png') }}"
                            alt="ErgoTech"
                            class="h-full w-full object-contain"
                        >
                    </div>

                    <div class="min-w-0">
                        <p class="text-[1.65rem] leading-none font-extrabold tracking-tight text-white truncate">
                            ERGOTECH
                        </p>
                        <p class="text-sm text-white/80 mt-1 truncate">
                            Sistema ergonómico
                        </p>
                    </div>
                </a>

                <button
                    class="lg:hidden text-white text-2xl shrink-0"
                    @click="sidebarOpen = false"
                    type="button"
                >
                    ×
                </button>
            </div>

            <nav class="flex-1 px-5 py-6 space-y-6 overflow-y-auto">
                <div>
                    <p class="px-3 mb-3 text-[11px] font-semibold uppercase tracking-[0.18em] text-white/65">
                        Principal
                    </p>

                    @if(Route::has('dashboard'))
                        <a href="{{ route('dashboard') }}"
                           class="flex items-center rounded-xl px-4 py-3 text-[15px] transition {{ request()->routeIs('dashboard') ? 'bg-[#1E6F8C] text-white font-semibold shadow-sm' : 'text-white/95 hover:bg-white/10' }}">
                            Dashboard
                        </a>
                    @endif
                </div>

                @if(in_array($rol, ['admin', 'evaluador']))
                    <div>
                        <p class="px-3 mb-3 text-[11px] font-semibold uppercase tracking-[0.18em] text-white/65">
                            Gestión
                        </p>

                        <div class="space-y-1.5">
                            @if(Route::has('empresas.index'))
                                <a href="{{ route('empresas.index') }}"
                                   class="flex items-center rounded-xl px-4 py-3 text-[15px] transition {{ request()->routeIs('empresas.*') ? 'bg-[#1E6F8C] text-white font-semibold shadow-sm' : 'text-white/95 hover:bg-white/10' }}">
                                    Empresas
                                </a>
                            @endif

                            @if(Route::has('sucursales.index'))
                                <a href="{{ route('sucursales.index') }}"
                                   class="flex items-center rounded-xl px-4 py-3 text-[15px] transition {{ request()->routeIs('sucursales.*') ? 'bg-[#1E6F8C] text-white font-semibold shadow-sm' : 'text-white/95 hover:bg-white/10' }}">
                                    Sucursales
                                </a>
                            @endif

                            @if(Route::has('puestos.index'))
                                <a href="{{ route('puestos.index') }}"
                                   class="flex items-center rounded-xl px-4 py-3 text-[15px] transition {{ request()->routeIs('puestos.*') ? 'bg-[#1E6F8C] text-white font-semibold shadow-sm' : 'text-white/95 hover:bg-white/10' }}">
                                    Puestos
                                </a>
                            @endif

                            @if(Route::has('trabajadores.index'))
                                <a href="{{ route('trabajadores.index') }}"
                                   class="flex items-center rounded-xl px-4 py-3 text-[15px] transition {{ request()->routeIs('trabajadores.*') ? 'bg-[#1E6F8C] text-white font-semibold shadow-sm' : 'text-white/95 hover:bg-white/10' }}">
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
                               class="flex items-center rounded-xl px-4 py-3 text-[15px] transition {{ request()->routeIs('usuarios.*') ? 'bg-[#1E6F8C] text-white font-semibold shadow-sm' : 'text-white/95 hover:bg-white/10' }}">
                                Usuarios
                            </a>
                        @endif

                        @if($rol === 'admin' && Route::has('configuracion.index'))
                            <a href="{{ route('configuracion.index') }}"
                               class="flex items-center rounded-xl px-4 py-3 text-[15px] transition {{ request()->routeIs('configuracion.*') ? 'bg-[#1E6F8C] text-white font-semibold shadow-sm' : 'text-white/95 hover:bg-white/10' }}">
                                Configuración
                            </a>
                        @endif

                        @if(Route::has('reportes.index'))
                            <a href="{{ route('reportes.index') }}"
                               class="flex items-center rounded-xl px-4 py-3 text-[15px] transition {{ request()->routeIs('reportes.*') ? 'bg-[#1E6F8C] text-white font-semibold shadow-sm' : 'text-white/95 hover:bg-white/10' }}">
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
                                   class="flex items-center rounded-xl px-4 py-3 text-[15px] transition {{ request()->routeIs('evaluaciones.index') ? 'bg-[#1E6F8C] text-white font-semibold shadow-sm' : 'text-white/95 hover:bg-white/10' }}">
                                    Evaluaciones
                                </a>
                            @endif

                            @if(Route::has('evaluaciones.create'))
                                <a href="{{ route('evaluaciones.create') }}"
                                   class="flex items-center rounded-xl px-4 py-3 text-[15px] transition {{ request()->routeIs('evaluaciones.create') ? 'bg-[#1E6F8C] text-white font-semibold shadow-sm' : 'text-white/95 hover:bg-white/10' }}">
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
                           class="flex items-center rounded-xl px-4 py-3 text-[15px] transition {{ request()->routeIs('profile.*') ? 'bg-[#1E6F8C] text-white font-semibold shadow-sm' : 'text-white/95 hover:bg-white/10' }}">
                            Perfil
                        </a>
                    @endif
                </div>
            </nav>

            <div class="p-5 border-t border-white/15">
                @if(Route::has('logout'))
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full rounded-xl px-4 py-3 text-left text-[15px] font-medium text-white/95 hover:bg-white/10 transition">
                            Cerrar sesión
                        </button>
                    </form>
                @endif
            </div>
        </aside>

        <div class="flex-1 min-w-0 flex flex-col">
            <header class="h-24 bg-white border-b border-slate-200 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
                <div class="flex items-center gap-4 min-w-0">
                    <button
                        class="lg:hidden inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-3 py-2 text-slate-700 shadow-sm"
                        @click="sidebarOpen = true"
                        type="button"
                    >
                        ☰
                    </button>

                    <div class="hidden sm:flex h-11 w-11 rounded-xl bg-slate-100 items-center justify-center overflow-hidden">
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