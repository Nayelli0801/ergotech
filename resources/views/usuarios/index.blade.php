<x-app-layout>

<div class="max-w-6xl mx-auto mt-6">

<div class="bg-white rounded-xl shadow-lg overflow-hidden">

    <!-- Encabezado -->
    <div class="bg-sky-600 text-white px-6 py-4 flex justify-between items-center">

        <div>
            <h2 class="text-xl font-bold">Usuarios</h2>
            <p class="text-sm text-blue-100">Listado de usuarios registrados.</p>
        </div>

        <a href="{{ route('usuarios.create') }}"
           class="bg-white text-blue-700 font-semibold px-4 py-2 rounded-lg shadow hover:bg-gray-100 transition">
            Nuevo usuario
        </a>

    </div>

    <!-- Tabla -->
    <div class="overflow-x-auto">

        <table class="w-full text-left">

            <thead class="bg-gray-100 text-gray-600 text-sm uppercase">
                <tr>
                    <th class="p-4">ID</th>
                    <th class="p-4">Nombre</th>
                    <th class="p-4">Correo electrónico</th>
                    <th class="p-4">Rol</th>
                    <th class="p-4">Acciones</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                @forelse($usuarios as $user)

                <tr class="hover:bg-gray-50 transition">

                    <td class="p-4">{{ $user->id }}</td>

                    <td class="p-4 font-medium text-gray-800">
                        {{ $user->name }}
                    </td>

                    <td class="p-4 text-gray-600">
                        {{ $user->email }}
                    </td>

                    <!-- Rol con colores dinámicos -->
                    <td class="p-4">
                        @php
                            $rol = strtolower(optional($user->rol)->nombre ?? 'sin rol');

                            $color = match($rol) {
                                'admin' => 'bg-blue-100 text-blue-700',
                                'evaluador' => 'bg-green-100 text-green-700',
                                'visitante' => 'bg-gray-100 text-gray-700',
                                default => 'bg-gray-100 text-gray-700'
                            };
                        @endphp

                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $color }}">
                            {{ ucfirst($rol) }}
                        </span>
                    </td>

                    <!-- Acciones -->
                    <td class="p-4 flex gap-2">

                        <a href="{{ route('usuarios.edit', $user->id) }}"
                           class="bg-yellow-500 hover:bg-yellow-600 px-3 py-1 rounded text-white text-sm">
                            Editar
                        </a>

                        <form action="{{ route('usuarios.destroy', $user->id) }}"
                              method="POST"
                              onsubmit="return confirm('¿Estás seguro de eliminar este usuario?')">
                            @csrf
                            @method('DELETE')

                            <button class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-white text-sm">
                                Eliminar
                            </button>
                        </form>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="5" class="text-center text-gray-500 py-6">
                        No hay usuarios registrados.
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

</div>

</x-app-layout>


