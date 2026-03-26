<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-6">

        <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-200">

            {{-- HEADER AZUL --}}
            <div class="bg-sky-600 text-white px-6 py-4 flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold">Empresas</h2>
                    <p class="text-sm text-blue-100 mt-1">
                        Listado de empresas registradas.
                    </p>
                </div>

                <a href="{{ route('empresas.create') }}"
                   class="bg-white text-blue-700 hover:bg-blue-50 font-semibold px-4 py-2 rounded-lg shadow">
                    Nueva empresa
                </a>
            </div>


            <div class="max-w-7xl mx-auto py-8 px-6">

                @if(session('success'))
                    <div class="mb-4 rounded-lg bg-green-100 border border-green-300 text-green-700 px-4 py-3">
                        {{ session('success') }}
                    </div>
                @endif


                <div class="overflow-x-auto">

                    <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">

                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Nombre</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Razón social</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">RFC</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Teléfono</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Correo</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Estado</th>
                                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Acciones</th>
                            </tr>
                        </thead>


                        <tbody class="divide-y divide-gray-200">

                            @forelse($empresas as $empresa)

                                <tr class="hover:bg-gray-50">

                                    <td class="px-4 py-3">{{ $empresa->nombre }}</td>
                                    <td class="px-4 py-3">{{ $empresa->razon_social }}</td>
                                    <td class="px-4 py-3">{{ $empresa->rfc }}</td>
                                    <td class="px-4 py-3">{{ $empresa->telefono }}</td>
                                    <td class="px-4 py-3">{{ $empresa->correo }}</td>

                                    <td class="px-4 py-3">
                                        @if($empresa->activo)
                                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-sm">
                                                Activa
                                            </span>
                                        @else
                                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-sm">
                                                Inactiva
                                            </span>
                                        @endif
                                    </td>


                                    <td class="px-4 py-3 text-center">

                                        <a href="{{ route('empresas.show', $empresa->id) }}"
                                           class="inline-block bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold px-3 py-2 rounded-lg mr-2">
                                            Ver
                                        </a>

                                        <a href="{{ route('empresas.edit', $empresa->id) }}"
                                           class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold px-3 py-2 rounded-lg mr-2">
                                            Editar
                                        </a>

                                        <form action="{{ route('empresas.destroy', $empresa->id) }}"
                                              method="POST"
                                              class="inline-block"
                                              onsubmit="return confirm('¿Deseas eliminar esta empresa?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="bg-red-500 hover:bg-red-600 text-white text-sm font-semibold px-3 py-2 rounded-lg">
                                                Eliminar
                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="7" class="px-4 py-6 text-center text-gray-500">
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

        </div>

    </div>
</x-app-layout>