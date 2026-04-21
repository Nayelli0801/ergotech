<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-6">
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-200">
            <div class="bg-sky-600 text-white px-6 py-4 flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold">Puestos</h2>
                    <p class="text-sm text-blue-100 mt-1">Listado de puestos registrados.</p>
                </div>

                <a href="{{ route('puestos.create') }}"
                   class="bg-white text-blue-700 hover:bg-blue-50 font-semibold px-4 py-2 rounded-lg shadow">
                    Nuevo puesto
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
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Sucursal</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Empresa</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Nombre</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Área</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Estado</th>
                                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">
                            @forelse($puestos as $puesto)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-700 font-medium">{{ $puesto->id }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $puesto->sucursal->nombre ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $puesto->sucursal->empresa->nombre ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $puesto->nombre }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $puesto->area ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        @if($puesto->activo)
                                            <span class="inline-block px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                                Activo
                                            </span>
                                        @else
                                            <span class="inline-block px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">
                                                Inactivo
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3 text-center">
                                        <div class="flex flex-wrap justify-center items-center gap-2">
                                            <a href="{{ route('puestos.edit', $puesto->id) }}"
                                               class="inline-flex items-center justify-center w-[100px] h-[38px] bg-sky-100 hover:bg-sky-200 text-sky-700 text-sm font-semibold rounded-lg transition">
                                                Editar
                                            </a>

                                            <form action="{{ route('puestos.destroy', $puesto->id) }}" method="POST"
                                                  onsubmit="return confirm('¿Eliminar este puesto?')">
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
                                    <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                                        No hay puestos registrados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(method_exists($puestos, 'links'))
                    <div class="mt-4">
                        {{ $puestos->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>