<x-app-layout>

    <div class="p-6">

        <!-- Título -->
        <h2 class="text-3xl font-bold text-gray-800 mb-8">Panel Administrador</h2>

        <!-- MÉTRICAS -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <!-- Tarjeta Usuarios -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 text-indigo-900 p-6 rounded-2xl shadow-md border border-indigo-100">
                <p class="text-sm font-medium uppercase tracking-wider text-indigo-600">USUARIOS</p>
                <p class="text-5xl font-bold mt-2">{{ $totalUsuarios }}</p>
            </div>
            <!-- Tarjeta Empresas -->
            <div class="bg-gradient-to-br from-emerald-50 to-teal-50 text-teal-900 p-6 rounded-2xl shadow-md border border-teal-100">
                <p class="text-sm font-medium uppercase tracking-wider text-teal-600">EMPRESAS</p>
                <p class="text-5xl font-bold mt-2">{{ $totalEmpresas }}</p>
            </div>
            <!-- Tarjeta Evaluaciones -->
            <div class="bg-gradient-to-br from-amber-50 to-orange-50 text-amber-900 p-6 rounded-2xl shadow-md border border-amber-100">
                <p class="text-sm font-medium uppercase tracking-wider text-amber-600">EVALUACIONES</p>
                <p class="text-5xl font-bold mt-2">{{ $totalEvaluaciones }}</p>
            </div>
        </div>

        <!-- ACCIONES RÁPIDAS (centradas) -->
        <div class="mb-12">
            <h3 class="text-xl font-semibold text-gray-700 mb-6 text-center">Acciones rápidas</h3>
            <div class="flex flex-wrap justify-center gap-4">
                <!-- Crear Usuario -->
                <a href="{{ route('usuarios.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-md transition duration-150 ease-in-out">
                    <i class="fas fa-user-plus mr-2"></i> Crear Usuario
                </a>
                <!-- Nueva Empresa -->
                <a href="{{ route('empresas.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-xl shadow-md transition duration-150 ease-in-out">
                    <i class="fas fa-building mr-2"></i> Nueva Empresa
                </a>
                <!-- Nueva Evaluación -->
                <a href="{{ route('evaluaciones.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-xl shadow-md transition duration-150 ease-in-out">
                    <i class="fas fa-clipboard-list mr-2"></i> Nueva Evaluación
                </a>
                <!-- Ver Reportes -->
                <a href="{{ route('reportes.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-rose-600 hover:bg-rose-700 text-white font-medium rounded-xl shadow-md transition duration-150 ease-in-out">
                    <i class="fas fa-chart-bar mr-2"></i> Ver Reportes
                </a>
            </div>
        </div>

        <!-- ÚLTIMAS EVALUACIONES -->
        <div>
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Últimas Evaluaciones</h3>
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Empresa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Método</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($ultimasEvaluaciones as $evaluacion)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $evaluacion->empresa->nombre ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $evaluacion->metodo }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $evaluacion->created_at->format('d/m/Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No hay evaluaciones registradas
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Firma (opcional, como en la imagen) -->
        <div class="mt-8 text-right text-sm text-gray-500">
            Fernanda Contreras
        </div>

    </div>

</x-app-layout>

