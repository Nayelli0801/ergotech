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

                {{-- Empresa --}}
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

                {{-- Evaluador --}}
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

                {{-- Método --}}
<div class="mb-4">
    <label class="block mb-1 font-medium">Método</label>
    <select name="metodo"
            id="metodo"
            class="w-full border rounded px-3 py-2"
            required>
        <option value="">Seleccionar método</option>
        @foreach($metodos as $metodo)
            <option value="{{ $metodo }}">
                {{ $metodo }}
            </option>
        @endforeach
    </select>
</div>

                {{-- Fecha --}}
                <div class="mb-4">
                    <label class="block mb-1 font-medium">Fecha</label>
                    <input type="date"
                           name="fecha"
                           class="w-full border rounded px-3 py-2"
                           required>
                </div>

                {{-- Observaciones --}}
                <div class="mb-4">
                    <label class="block mb-1 font-medium">Observaciones</label>
                    <textarea name="observaciones"
                              class="w-full border rounded px-3 py-2"
                              rows="4"></textarea>
                </div>

                {{-- FORMULARIO REBA --}}
<div id="form-reba" class="hidden border-t pt-4 mt-4">

    <h3 class="font-semibold text-lg mb-3 text-blue-600">
        Evaluación REBA
    </h3>

    <div class="grid grid-cols-2 gap-4">

        <div>
            <label class="block mb-1">Cuello</label>
            <input type="number" name="cuello"
                   class="w-full border rounded px-3 py-2"
                   min="0" max="5">
        </div>

        <div>
            <label class="block mb-1">Tronco</label>
            <input type="number" name="tronco"
                   class="w-full border rounded px-3 py-2"
                   min="0" max="5">
        </div>

        <div>
            <label class="block mb-1">Piernas</label>
            <input type="number" name="piernas"
                   class="w-full border rounded px-3 py-2"
                   min="0" max="5">
        </div>

        <div>
            <label class="block mb-1">Carga</label>
            <input type="number" name="carga"
                   class="w-full border rounded px-3 py-2"
                   min="0" max="5">
        </div>

        <div>
            <label class="block mb-1">Brazo</label>
            <input type="number" name="brazo"
                   class="w-full border rounded px-3 py-2"
                   min="0" max="5">
        </div>

        <div>
            <label class="block mb-1">Antebrazo</label>
            <input type="number" name="antebrazo"
                   class="w-full border rounded px-3 py-2"
                   min="0" max="5">
        </div>

        <div>
            <label class="block mb-1">Muñeca</label>
            <input type="number" name="muneca"
                   class="w-full border rounded px-3 py-2"
                   min="0" max="5">
        </div>

    </div>

</div>

                {{-- Botones --}}
                <div class="flex gap-3">
                    <button type="submit"
                            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
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


    <script>
document.addEventListener('DOMContentLoaded', function () {

    const metodoSelect = document.getElementById('metodo');
    const formReba = document.getElementById('form-reba');

    metodoSelect.addEventListener('change', function () {

        if (this.value === 'REBA') {
            formReba.classList.remove('hidden');
        } else {
            formReba.classList.add('hidden');
        }

    });

});
</script>

</x-app-layout>