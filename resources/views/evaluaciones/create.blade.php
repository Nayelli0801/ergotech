<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nueva Evaluación
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto bg-white shadow rounded p-6">

            <form action="{{ route('evaluaciones.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block mb-1 font-medium">Empresa</label>
                    <select name="empresa_id"
                            class="w-full border rounded px-3 py-2"
                            required>
                        <option value="">Seleccionar</option>
                        @foreach($empresas as $empresa)
                            <option value="{{ $empresa->id }}">
                                {{ $empresa->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-medium">Evaluador</label>
                    <select name="user_id"
                            class="w-full border rounded px-3 py-2"
                            required>
                        <option value="">Seleccionar</option>
                        @foreach($evaluadores as $evaluador)
                            <option value="{{ $evaluador->id }}">
                                {{ $evaluador->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-medium">Método</label>
                    <input type="text"
                           name="metodo"
                           class="w-full border rounded px-3 py-2"
                           required>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-medium">Fecha</label>
                    <input type="date"
                           name="fecha"
                           class="w-full border rounded px-3 py-2"
                           required>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-medium">Observaciones</label>
                    <textarea name="observaciones"
                              class="w-full border rounded px-3 py-2"
                              rows="4"></textarea>
                </div>

                <div class="flex gap-3">
                    <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                        Guardar
                    </button>

                    <a href="{{ route('evaluaciones.index') }}"
                       class="text-gray-600 px-4 py-2">
                        Cancelar
                    </a>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>
