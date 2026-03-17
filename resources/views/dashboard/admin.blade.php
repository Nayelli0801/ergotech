<x-app-layout>
    <div class="space-y-8">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Panel Administrador</h2>
            <p class="text-sm text-gray-500 mt-1">
                Resumen general del sistema y accesos rápidos.
            </p>
        </div>

        {{-- MÉTRICAS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 text-indigo-900 p-6 rounded-2xl shadow-sm border border-indigo-100">
                <p class="text-sm font-medium uppercase tracking-wider text-indigo-600">Usuarios</p>
                <p class="text-4xl sm:text-5xl font-bold mt-2">{{ $totalUsuarios }}</p>
            </div>

            <div class="bg-gradient-to-br from-emerald-50 to-teal-50 text-teal-900 p-6 rounded-2xl shadow-sm border border-teal-100">
                <p class="text-sm font-medium uppercase tracking-wider text-teal-600">Empresas</p>
                <p class="text-4xl sm:text-5xl font-bold mt-2">{{ $totalEmpresas }}</p>
            </div>

            <div class="bg-gradient-to-br from-amber-50 to-orange-50 text-amber-900 p-6 rounded-2xl shadow-sm border border-amber-100 md:col-span-2 xl:col-span-1">
                <p class="text-sm font-medium uppercase tracking-wider text-amber-600">Evaluaciones</p>
                <p class="text-4xl sm:text-5xl font-bold mt-2">{{ $totalEvaluaciones }}</p>
            </div>
        </div>

        {{-- ACCIONES RÁPIDAS --}}
        <div>
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Acciones rápidas</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
                <a href="{{ route('usuarios.create') }}"
                   class="inline-flex items-center justify-center px-6 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-sm transition">
                    Crear Usuario
                </a>

                <a href="{{ route('empresas.create') }}"
                   class="inline-flex items-center justify-center px-6 py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-xl shadow-sm transition">
                    Nueva Empresa
                </a>

                <a href="{{ route('evaluaciones.create') }}"
                   class="inline-flex items-center justify-center px-6 py-4 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-xl shadow-sm transition">
                    Nueva Evaluación
                </a>

                <a href="{{ route('reportes.index') }}"
                   class="inline-flex items-center justify-center px-6 py-4 bg-rose-600 hover:bg-rose-700 text-white font-medium rounded-xl shadow-sm transition">
                    Ver Reportes
                </a>
            </div>
        </div>

        {{-- ÚLTIMAS EVALUACIONES --}}
        <div>
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Últimas Evaluaciones</h3>

            <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Empresa</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Método</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($ultimasEvaluaciones as $evaluacion)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900">
                                        {{ $evaluacion->empresa->nombre ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900">
                                        {{ $evaluacion->metodo->nombre ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900">
                                        {{ $evaluacion->created_at ? $evaluacion->created_at->format('d/m/Y') : 'N/A' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-6 text-center text-sm text-gray-500">
                                        No hay evaluaciones registradas
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>