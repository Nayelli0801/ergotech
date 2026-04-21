<x-app-layout>
    <div class="max-w-6xl mx-auto py-8 px-6">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200">

            <div class="bg-sky-600 text-white px-6 py-4 flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold">Usuarios</h2>
                    <p class="text-sm text-blue-100">Listado de usuarios registrados.</p>
                </div>

                <a href="{{ route('usuarios.create') }}"
                   class="bg-white text-blue-700 font-semibold px-4 py-2 rounded-lg shadow hover:bg-gray-100 transition">
                    Nuevo usuario
                </a>
            </div>

            <div class="p-6">
                @if(session('success'))
                    <div class="mb-4 rounded-lg bg-green-100 border border-green-300 text-green-700 px-4 py-3">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 rounded-lg bg-red-100 border border-red-300 text-red-700 px-4 py-3">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">ID</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Nombre</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Correo electrónico</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Rol</th>
                                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">
                            @forelse($usuarios as $user)
                                @php
                                    $rol = strtolower(optional($user->rol)->nombre ?? 'sin rol');

                                    $color = match($rol) {
                                        'admin' => 'bg-blue-100 text-blue-700',
                                        'evaluador' => 'bg-green-100 text-green-700',
                                        'visitante' => 'bg-gray-100 text-gray-700',
                                        default => 'bg-gray-100 text-gray-700'
                                    };
                                @endphp

                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3 text-sm text-gray-700 font-medium">
                                        {{ $user->id }}
                                    </td>

                                    <td class="px-4 py-3 text-sm text-gray-800 font-medium">
                                        {{ $user->name }}
                                        @if($user->last_name)
                                            {{ $user->last_name }}
                                        @endif
                                    </td>

                                    <td class="px-4 py-3 text-sm text-gray-600">
                                        {{ $user->email }}
                                    </td>

                                    <td class="px-4 py-3">
                                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $color }}">
                                            {{ ucfirst($rol) }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3 text-center">
                                        <div class="flex flex-wrap justify-center items-center gap-2">
                                            <a href="{{ route('usuarios.edit', $user->id) }}"
                                               class="inline-flex items-center justify-center w-[100px] h-[38px] bg-sky-100 hover:bg-sky-200 text-sky-700 text-sm font-semibold rounded-lg transition">
                                                Editar
                                            </a>

                                            <form action="{{ route('usuarios.destroy', $user->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('¿Estás seguro de eliminar este usuario?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="inline-flex items-center justify-center w-[100px] h-[38px] bg-red-100 hover:bg-red-200 text-red-700 text-sm font-semibold rounded-lg transition">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
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

                @if(method_exists($usuarios, 'links'))
                    <div class="mt-4">
                        {{ $usuarios->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>