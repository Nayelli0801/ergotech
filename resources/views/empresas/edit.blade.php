<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Empresa
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto bg-white shadow rounded p-6">

            <form action="{{ route('empresas.update', $empresa->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block mb-1">Nombre</label>
                    <input type="text"
                           name="nombre"
                           value="{{ $empresa->nombre }}"
                           class="w-full border rounded px-3 py-2"
                           required>
                </div>

                <button class="bg-green-500 text-white px-4 py-2 rounded">
                    Actualizar
                </button>

                <a href="{{ route('empresas.index') }}"
                   class="ml-3 text-gray-600">
                    Cancelar
                </a>

            </form>

        </div>
    </div>
</x-app-layout>
