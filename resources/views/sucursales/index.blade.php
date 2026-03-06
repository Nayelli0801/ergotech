<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-6">
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-200">
            <div class="bg-blue-700 text-white px-6 py-4 flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold">Sucursales</h2>
                    <p class="text-sm text-blue-100 mt-1">Listado de sucursales registradas.</p>
                </div>

                <a href="{{ route('sucursales.create') }}"
                   class="bg-white text-blue-700 hover:bg-blue-50 font-semibold px-4 py-2 rounded-lg shadow">
                    Nueva sucursal
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
                                <th class="px-4 py-3 text-left">Empresa</th>
                                <th class="px-4 py-3 text-left">Nombre</th>
                                <th class="px-4 py-3 text-left">Dirección</th>
                                <th class="px-4 py-3 text-left">Teléfono</th>
                                <th class="px-4 py-3 text-left">Responsable</th>
                                <th class="px-4 py-3 text-left">Estado</th>
                                <th class="px-4 py-3 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($sucursales as $sucursal)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3">{{ $sucursal->id }}</td>
                                    <td class="px-4 py-3">{{ $sucursal->empresa->nombre ?? 'N/A' }}</td>
                                    <td class="px-4 py-3">{{ $sucursal->nombre }}</td>
                                    <td class="px-4 py-3">{{ $sucursal->direccion ?? 'N/A' }}</td>
                                    <td class="px-4 py-3">{{ $sucursal->telefono ?? 'N/A' }}</td>
                                    <td class="px-4 py-3">{{ $sucursal->responsable ?? 'N/A' }}</td>
                                    <td class="px-4 py-3">
                                        @if($sucursal->activo)
                                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-sm">Activa</span>
                                        @else
                                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-sm">Inactiva</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <a href="{{ route('sucursales.edit', $sucursal->id) }}"
                                           class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold px-3 py-2 rounded-lg mr-2">
                                            Editar
                                        </a>

                                        <form action="{{ route('sucursales.destroy', $sucursal->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('¿Eliminar esta sucursal?')"
                                                    class="bg-red-500 hover:bg-red-600 text-white text-sm font-semibold px-3 py-2 rounded-lg">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-6 text-center text-gray-500">
                                        No hay sucursales registradas.
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