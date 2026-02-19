<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Empresas
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-4">
                <a href="{{ route('empresas.create') }}"
                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Nueva Empresa
                </a>
            </div>

            <div class="bg-white shadow rounded p-6">
                <ul>
                    @foreach($empresas as $empresa)
                        <li class="mb-2">
                            {{ $empresa->nombre }}

                            <a href="{{ route('empresas.edit', $empresa->id) }}"
                               class="text-yellow-600 ml-4">
                                Editar
                            </a>

                            <form action="{{ route('empresas.destroy', $empresa->id) }}"
                                  method="POST"
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 ml-2">
                                    Eliminar
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
</x-app-layout>
