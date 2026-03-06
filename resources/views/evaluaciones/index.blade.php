<x-app-layout>
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Empresas</h1>

            <a href="{{ route('empresas.create') }}"
               class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                + Nueva Empresa
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-green-100 text-green-800 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="w-full border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">Nombre</th>
                        <th class="p-3 text-left">Razón social</th>
                        <th class="p-3 text-left">RFC</th>
                        <th class="p-3 text-left">Teléfono</th>
                        <th class="p-3 text-left">Correo</th>
                        <th class="p-3 text-left">Estado</th>
                        <th class="p-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($empresas as $empresa)
                        <tr class="border-t">
                            <td class="p-3">{{ $empresa->nombre }}</td>
                            <td class="p-3">{{ $empresa->razon_social }}</td>
                            <td class="p-3">{{ $empresa->rfc }}</td>
                            <td class="p-3">{{ $empresa->telefono }}</td>
                            <td class="p-3">{{ $empresa->correo }}</td>
                            <td class="p-3">
                                @if($empresa->activo)
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-sm">Activa</span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-sm">Inactiva</span>
                                @endif
                            </td>
                            <td class="p-3 text-center space-x-2">
                                <a href="{{ route('empresas.show', $empresa->id) }}"
                                   class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                    Ver
                                </a>

                                <a href="{{ route('empresas.edit', $empresa->id) }}"
                                   class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                                    Editar
                                </a>

                                <form action="{{ route('empresas.destroy', $empresa->id) }}"
                                      method="POST"
                                      class="inline-block"
                                      onsubmit="return confirm('¿Deseas eliminar esta empresa?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-4 text-center text-gray-500">
                                No hay empresas registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $empresas->links() }}
        </div>
    </div>
</x-app-layout>