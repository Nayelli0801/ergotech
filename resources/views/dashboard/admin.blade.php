<x-app-layout>

    <h1 class="text-3xl font-bold mb-8 text-gray-800 dark:text-gray-100">
        Panel Administrador
    </h1>

    <!-- TARJETAS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="bg-indigo-100 dark:bg-indigo-700 text-indigo-900 dark:text-white p-6 rounded-xl shadow-lg">
            <h3 class="text-sm uppercase opacity-80">Usuarios</h3>
            <p class="text-4xl font-bold mt-3">
                {{ \App\Models\User::count() }}
            </p>
        </div>

        <div class="bg-green-100 dark:bg-green-700 text-green-900 dark:text-white p-6 rounded-xl shadow-lg">
            <h3 class="text-sm uppercase opacity-80">Empresas</h3>
            <p class="text-4xl font-bold mt-3">
                {{ \App\Models\Empresa::count() }}
            </p>
        </div>

        <div class="bg-purple-100 dark:bg-purple-700 text-purple-900 dark:text-white p-6 rounded-xl shadow-lg">
            <h3 class="text-sm uppercase opacity-80">Evaluaciones</h3>
            <p class="text-4xl font-bold mt-3">
                {{ \App\Models\Evaluacion::count() }}
            </p>
        </div>

    </div>

    <!-- BOTONES -->
    <div class="mt-10 grid grid-cols-1 md:grid-cols-4 gap-4">

        <a href="{{ route('usuarios.index') }}"
           class="bg-indigo-500 hover:bg-indigo-600 text-white font-semibold text-center py-3 rounded-lg shadow-md transition">
            👥 Gestionar Usuarios
        </a>

        <a href="{{ route('empresas.index') }}"
           class="bg-green-500 hover:bg-green-600 text-white font-semibold text-center py-3 rounded-lg shadow-md transition">
            🏢 Gestionar Empresas
        </a>

        <a href="{{ route('evaluaciones.index') }}"
           class="bg-purple-500 hover:bg-purple-600 text-white font-semibold text-center py-3 rounded-lg shadow-md transition">
            📋 Gestionar Evaluaciones
        </a>

        <a href="{{ route('reportes.index') }}"
           class="bg-blue-500 hover:bg-blue-600 text-white font-semibold text-center py-3 rounded-lg shadow-md transition">
            📊 Ver Reportes
        </a>

    </div>

</x-app-layout>
