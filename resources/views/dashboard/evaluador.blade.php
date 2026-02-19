<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Panel Administrador</h2>
    </x-slot>

    <div class="py-6 px-6">
        <div class="grid grid-cols-3 gap-6">

            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-gray-500">Usuarios</h3>
                <p class="text-3xl font-bold">
                    {{ \App\Models\User::count() }}
                </p>
            </div>

            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-gray-500">Empresas</h3>
                <p class="text-3xl font-bold">
                    {{ \App\Models\Empresa::count() }}
                </p>
            </div>

            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-gray-500">Evaluaciones</h3>
                <p class="text-3xl font-bold">
                    {{ \App\Models\Evaluacion::count() }}
                </p>
            </div>

        </div>
    </div>
</x-app-layout>
