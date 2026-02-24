<x-app-layout>

    <h2 class="text-2xl font-bold mb-6">Usuarios</h2>

    <a href="{{ route('usuarios.create') }}"
       class="bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-lg text-white mb-4 inline-block">
        + Nuevo Usuario
    </a>

    <div class="bg-gray-900 rounded-xl shadow-lg overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-800 text-gray-300">
                <tr>
                    <th class="p-3">ID</th>
                    <th class="p-3">Nombre</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Rol</th>
                    <th class="p-3">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach($usuarios as $user)
                <tr class="border-b border-gray-800 hover:bg-gray-800">
                    <td class="p-3">{{ $user->id }}</td>
                    <td class="p-3">{{ $user->name }}</td>
                    <td class="p-3">{{ $user->email }}</td>
                    <td class="p-3">
                        {{ optional($user->rol)->nombre ?? 'Sin rol' }}
                    </td>
                    <td class="p-3 space-x-2">

                        <a href="{{ route('usuarios.edit', $user->id) }}"
                           class="bg-yellow-500 hover:bg-yellow-600 px-3 py-1 rounded text-white text-sm">
                            Editar
                        </a>

                        <form action="{{ route('usuarios.destroy', $user->id) }}"
                              method="POST"
                              class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-white text-sm">
                                Eliminar
                            </button>
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-app-layout>