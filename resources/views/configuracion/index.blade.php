<x-app-layout>

    <div class="space-y-6">

        <!-- HEADER -->
        <div>
            <h2 class="text-2xl font-bold text-slate-800">
                Configuración
            </h2>
            <p class="text-sm text-slate-500">
                Administra los parámetros generales del sistema
            </p>
        </div>

        <!-- GRID PRINCIPAL -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- AJUSTES GENERALES -->
            <div class="bg-white rounded-2xl shadow p-5 hover:shadow-lg transition">
                <h3 class="font-semibold text-slate-700 mb-2">
                    Ajustes generales
                </h3>
                <p class="text-sm text-slate-500">
                    Configura parámetros básicos del sistema
                </p>
            </div>

            <!-- SEGURIDAD -->
            <div class="bg-white rounded-2xl shadow p-5 hover:shadow-lg transition">
                <h3 class="font-semibold text-slate-700 mb-2">
                    Seguridad
                </h3>
                <p class="text-sm text-slate-500">
                    Gestiona accesos y permisos de usuarios
                </p>
            </div>

        </div>

        <!-- ACTIVIDAD RECIENTE (LOGS MINI PREVIEW) -->
        <div class="bg-white rounded-2xl shadow p-6 space-y-4">

            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-slate-800">
                    Actividad reciente
                </h3>

                <a href="{{ route('logs.index') }}"
                   class="text-sky-600 text-sm font-semibold hover:underline">
                    Ver todos →
                </a>
            </div>

            <div class="space-y-3">

                @forelse($logs as $log)
                    <div class="flex items-center justify-between bg-slate-50 rounded-xl px-4 py-3">

                        <div class="text-sm text-slate-700">
                            <span class="font-semibold">
                                {{ $log->user->name ?? 'Sistema' }}
                            </span>

                            realizó

                            <span class="px-2 py-1 rounded-lg text-xs font-semibold
                                @if($log->accion == 'login') bg-green-100 text-green-700
                                @elseif($log->accion == 'create') bg-blue-100 text-blue-700
                                @elseif($log->accion == 'update') bg-yellow-100 text-yellow-700
                                @elseif($log->accion == 'delete') bg-red-100 text-red-700
                                @else bg-slate-100 text-slate-700
                                @endif
                            ">
                                {{ $log->accion }}
                            </span>

                            en

                            <span class="text-slate-500">
                                {{ $log->modulo }}
                            </span>
                        </div>

                        <div class="text-xs text-slate-400">
                            {{ $log->created_at->diffForHumans() }}
                        </div>

                    </div>
                @empty
                    <p class="text-sm text-slate-500">
                        No hay actividad reciente
                    </p>
                @endforelse

            </div>

        </div>

    </div>

</x-app-layout>
