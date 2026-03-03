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

<h3 class="text-xl font-semibold text-blue-600 mb-4">
    Evaluación REBA
</h3>

{{-- GRUPO A --}}
<div class="bg-blue-50 p-4 rounded mb-6">
    <h4 class="font-semibold text-blue-700 mb-3">Grupo A</h4>

    {{-- Cuello --}}
    <div class="mb-4">
        <label class="block font-medium mb-1">Cuello</label>
        <label class="block"><input type="radio" name="cuello" value="1" required> 1 - Neutro</label>
        <label class="block"><input type="radio" name="cuello" value="2"> 2 - Flexión/Extensión >20°</label>
        <label class="block"><input type="radio" name="cuello" value="3"> 3 - Con torsión/inclinación</label>
    </div>

    {{-- Tronco --}}
    <div class="mb-4">
        <label class="block font-medium mb-1">Tronco</label>
        <label class="block"><input type="radio" name="tronco" value="1" required> 1 - Recto</label>
        <label class="block"><input type="radio" name="tronco" value="2"> 2 - Flexión 0–20°</label>
        <label class="block"><input type="radio" name="tronco" value="3"> 3 - Flexión 20–60°</label>
        <label class="block"><input type="radio" name="tronco" value="4"> 4 - Flexión >60°</label>
    </div>

    {{-- Piernas --}}
    <div class="mb-4">
        <label class="block font-medium mb-1">Piernas</label>
        <label class="block"><input type="radio" name="piernas" value="1" required> 1 - Soporte bilateral</label>
        <label class="block"><input type="radio" name="piernas" value="2"> 2 - Peso desigual</label>
        <label class="block"><input type="radio" name="piernas" value="3"> 3 - En cuclillas</label>
        <label class="block"><input type="radio" name="piernas" value="4"> 4 - Apoyo inestable</label>
    </div>

    {{-- Carga --}}
    <div class="mb-4">
        <label class="block font-medium mb-1">Carga</label>
        <label class="block"><input type="radio" name="carga" value="0" required> 0 - <5 kg</label>
        <label class="block"><input type="radio" name="carga" value="1"> 1 - 5–10 kg</label>
        <label class="block"><input type="radio" name="carga" value="2"> 2 - >10 kg</label>
    </div>
</div>

{{-- GRUPO B --}}
<div class="bg-green-50 p-4 rounded mb-6">
    <h4 class="font-semibold text-green-700 mb-3">Grupo B</h4>

    {{-- Brazo --}}
    <div class="mb-4">
        <label class="block font-medium mb-1">Brazo</label>
        <label class="block"><input type="radio" name="brazo" value="1" required> 1 - 20° ext a 20° flex</label>
        <label class="block"><input type="radio" name="brazo" value="2"> 2 - 20°–45°</label>
        <label class="block"><input type="radio" name="brazo" value="3"> 3 - 45°–90°</label>
        <label class="block"><input type="radio" name="brazo" value="4"> 4 - >90°</label>
    </div>

    {{-- Antebrazo --}}
    <div class="mb-4">
        <label class="block font-medium mb-1">Antebrazo</label>
        <label class="block"><input type="radio" name="antebrazo" value="1" required> 1 - 60°–100°</label>
        <label class="block"><input type="radio" name="antebrazo" value="2"> 2 - Fuera de rango</label>
    </div>

    {{-- Muñeca --}}
    <div class="mb-4">
        <label class="block font-medium mb-1">Muñeca</label>
        <label class="block"><input type="radio" name="muneca" value="1" required> 1 - Neutra</label>
        <label class="block"><input type="radio" name="muneca" value="2"> 2 - Flexión/extensión >15°</label>
        <label class="block"><input type="radio" name="muneca" value="3"> 3 - Con desviación</label>
    </div>
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