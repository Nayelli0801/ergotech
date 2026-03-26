<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-6">
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-200">
            <div class="bg-sky-600 text-white px-6 py-4 flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold">Trabajadores</h2>
                    <p class="text-sm text-blue-100 mt-1">Listado de trabajadores registrados.</p>
                </div>

                <a href="{{ route('trabajadores.create') }}"
                   class="bg-white text-blue-700 hover:bg-blue-50 font-semibold px-4 py-2 rounded-lg shadow">
                    Nuevo trabajador
                </a>
            </div>

            <div class="p-6">
                @if(session('success'))
                    <div class="mb-4 rounded-lg bg-green-100 border border-green-300 text-green-700 px-4 py-3">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 text-left">ID</th>
                                <th class="px-4 py-3 text-left">Nombre completo</th>
                                <th class="px-4 py-3 text-left">Puesto</th>
                                <th class="px-4 py-3 text-left">Sexo</th>
                                <th class="px-4 py-3 text-left">Edad</th>
                                <th class="px-4 py-3 text-left">Estado</th>
                                <th class="px-4 py-3 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($trabajadores as $trabajador)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3">{{ $trabajador->id }}</td>
                                    <td class="px-4 py-3">
                                        {{ trim(($trabajador->nombre ?? '') . ' ' . ($trabajador->apellido_paterno ?? '') . ' ' . ($trabajador->apellido_materno ?? '')) }}
                                    </td>
                                    <td class="px-4 py-3">{{ $trabajador->puesto->nombre ?? 'N/A' }}</td>
                                    <td class="px-4 py-3">{{ $trabajador->sexo ?? 'N/A' }}</td>
                                    <td class="px-4 py-3">{{ $trabajador->edad ?? 'N/A' }}</td>
                                    <td class="px-4 py-3">
                                        @if($trabajador->activo)
                                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-sm">Activo</span>
                                        @else
                                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-sm">Inactivo</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <a href="{{ route('trabajadores.edit', $trabajador->id) }}"
                                           class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold px-3 py-2 rounded-lg mr-2">
                                            Editar
                                        </a>

                                        <form action="{{ route('trabajadores.destroy', $trabajador->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('¿Eliminar este trabajador?')"
                                                    class="bg-red-500 hover:bg-red-600 text-white text-sm font-semibold px-3 py-2 rounded-lg">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                                        No hay trabajadores registrados.
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