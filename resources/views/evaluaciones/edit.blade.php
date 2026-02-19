<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Evaluación
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto bg-white shadow rounded p-6">

            <form action="{{ route('evaluaciones.update', $evaluacion->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block mb-1 font-medium">Empresa</label>
                    <select name="empresa_id"
                            class="w-full border rounded px-3 py-2"
                            required>
                        @foreach($empresas as $empresa)
                            <option value="{{ $empresa->id }}"
                                {{ $evaluacion->empresa_id == $empresa->id ? 'selected' : '' }}>
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
                        @foreach($evaluadores as $evaluador)
                            <option value="{{ $evaluador->id }}"
                                {{ $evaluacion->user_id == $evaluador->id ? 'selected' : '' }}>
                                {{ $evaluador->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-medium">Método</label>
                    <input type="text"
                           name="metodo"
                           value="{{ $evaluacion->metodo }}"
                           class="w-full border rounded px-3 py-2"
                           required>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-medium">Fecha</label>
                    <input type="date"
                           name="fecha"
                           value="{{ $evaluacion->fecha }}"
                           class="w-full border rounded px-3 py-2"
                           required>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-medium">Observaciones</label>
                    <textarea name="observaciones"
                              class="w-full border rounded px-3 py-2"
                              rows="4">{{ $evaluacion->observaciones }}</textarea>
                </div>

                <div class="flex gap-3">
                    <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                        Actualizar
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
