<x-app-layout>

    <div class="p-6">

        <h2 class="text-3xl font-bold mb-8">Panel Administrador</h2>

        <!-- MÉTRICAS -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

            <div class="bg-white text-blue-900 p-6 rounded-2xl shadow-lg">
                <p class="text-sm">USUARIOS</p>
                <h3 class="text-5xl font-bold mt-3">{{ $totalUsuarios }}</h3>
            </div>

            <div class="bg-white text-blue-900 p-6 rounded-2xl shadow-lg">
                <p class="text-sm">EMPRESAS</p>
                <h3 class="text-5xl font-bold mt-3">{{ $totalEmpresas }}</h3>
            </div>

            <div class="bg-white text-blue-900 p-6 rounded-2xl shadow-lg">
                <p class="text-sm">EVALUACIONES</p>
                <h3 class="text-5xl font-bold mt-3">{{ $totalEvaluaciones }}</h3>
            </div>

        </div>

        <!-- ACCIONES RÁPIDAS -->
        <div class="mb-10">
            <h3 class="text-xl font-semibold mb-4">Acciones rápidas</h3>

            <div class="flex flex-wrap gap-4">

                <a href="{{ route('usuarios.create') }}"
                   class="bg-blue-500 text-white hover:bg-blue-600 px-5 py-3 rounded-xl shadow">
                   ➕ Crear Usuario
                </a>

                <a href="{{ route('empresas.create') }}"
                   class="bg-blue-500 text-white hover:bg-blue-600 px-5 py-3 rounded-xl shadow">
                   ➕ Nueva Empresa
                </a>

                <a href="{{ route('evaluaciones.create') }}"
                   class="bg-blue-500 text-white hover:bg-blue-600 px-5 py-3 rounded-xl shadow">
                   ➕ Nueva Evaluación
                </a>

                <a href="{{ route('reportes.index') }}"
                   class="bg-blue-500 text-white hover:bg-blue-600 px-5 py-3 rounded-xl shadow">
                   📥 Ver Reportes
                </a>

            </div>
        </div>

        <!-- ÚLTIMAS EVALUACIONES -->
        <div>
            <h3 class="text-xl font-semibold mb-4">Últimas Evaluaciones</h3>

            <div class="bg-blue-50 text-white rounded-xl overflow-hidden shadow">
                <table class="w-full text-left">
                    <thead class="bg-blue-700">
                        <tr>
                            <th class="p-3">Empresa</th>
                            <th class="p-3">Método</th>
                            <th class="p-3">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ultimasEvaluaciones as $evaluacion)
                            <tr class="border-b border-gray-700">
                                <td class="p-3">
                                    {{ $evaluacion->empresa->nombre ?? 'N/A' }}
                                </td>
                                <td class="p-3">
                                    {{ $evaluacion->metodo }}
                                </td>
                                <td class="p-3">
                                    {{ $evaluacion->created_at->format('d/m/Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-3 text-center">
                                    No hay evaluaciones registradas
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</x-app-layout>

