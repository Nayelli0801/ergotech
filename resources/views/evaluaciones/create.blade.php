<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nueva Evaluación
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto bg-white shadow rounded p-6">

            <form action="{{ route('evaluaciones.store') }}" method="POST">
                @csrf

                {{-- EMPRESA --}}
                <div class="mb-4">
                    <label class="block mb-1 font-medium">Empresa</label>
                    <select name="empresa_id" class="w-full border rounded px-3 py-2" required>
                        <option value="">Seleccionar</option>
                        @foreach($empresas as $empresa)
                            <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- EVALUADOR --}}
                <div class="mb-4">
                    <label class="block mb-1 font-medium">Evaluador</label>
                    <select name="user_id" class="w-full border rounded px-3 py-2" required>
                        <option value="">Seleccionar</option>
                        @foreach($evaluadores as $evaluador)
                            <option value="{{ $evaluador->id }}">{{ $evaluador->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- MÉTODO --}}
                <div class="mb-4">
                    <label class="block mb-1 font-medium">Método</label>
                    <select name="metodo" id="metodo" class="w-full border rounded px-3 py-2" required>
                        <option value="">Seleccionar método</option>
                        @foreach($metodos as $metodo)
                            <option value="{{ $metodo }}">{{ $metodo }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- FECHA --}}
                <div class="mb-4">
                    <label class="block mb-1 font-medium">Fecha</label>
                    <input type="date" name="fecha" class="w-full border rounded px-3 py-2" required>
                </div>

                {{-- OBSERVACIONES --}}
                <div class="mb-4">
                    <label class="block mb-1 font-medium">Observaciones</label>
                    <textarea name="observaciones" class="w-full border rounded px-3 py-2" rows="3"></textarea>
                </div>

                {{-- ================= REBA ================= --}}
                <div id="form-reba" class="hidden border-t pt-6 mt-6">

                    <h3 class="text-2xl font-bold text-blue-600 mb-6">
                        Evaluación REBA
                    </h3>

                    {{-- LADO --}}
                    <div class="mb-6">
                        <label class="block font-medium mb-2">Lado evaluado</label>
                        <div class="flex gap-6">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="lado" value="Izquierdo">
                                Izquierdo
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="lado" value="Derecho">
                                Derecho
                            </label>
                        </div>
                    </div>

                    {{-- GRUPO A --}}
                    <div class="bg-blue-50 p-5 rounded mb-6">
                        <h4 class="font-semibold text-blue-700 mb-4">Grupo A</h4>

                        {{-- CUELLO --}}
                        <div class="mb-4">
                            <label class="font-medium">Cuello</label>
                            <div class="mt-1">
                                <label class="block"><input type="radio" name="cuello" value="1"> 1 - Neutro</label>
                                <label class="block"><input type="radio" name="cuello" value="2"> 2 - Flexión/Extensión >20°</label>
                                <label class="block"><input type="radio" name="cuello" value="3"> 3 - Con torsión/inclinación</label>
                            </div>
                            <label class="block mt-2 text-sm text-gray-700">
                                <input type="checkbox" name="cuello_ajuste" value="1">
                                Ajuste (+1): torsión o inclinación lateral
                            </label>
                        </div>

                        {{-- TRONCO --}}
                        <div class="mb-4">
                            <label class="font-medium">Tronco</label>
                            <div class="mt-1">
                                <label class="block"><input type="radio" name="tronco" value="1"> 1 - Recto</label>
                                <label class="block"><input type="radio" name="tronco" value="2"> 2 - Flexión 0–20°</label>
                                <label class="block"><input type="radio" name="tronco" value="3"> 3 - Flexión 20–60°</label>
                                <label class="block"><input type="radio" name="tronco" value="4"> 4 - Flexión >60°</label>
                            </div>
                            <label class="block mt-2 text-sm text-gray-700">
                                <input type="checkbox" name="tronco_ajuste" value="1">
                                Ajuste (+1): girado o flexión lateral
                            </label>
                        </div>

                        {{-- PIERNAS --}}
                        <div class="mb-4">
                            <label class="font-medium">Piernas</label>
                            <div class="mt-1">
                                <label class="block"><input type="radio" name="piernas" value="1"> 1 - Soporte bilateral</label>
                                <label class="block"><input type="radio" name="piernas" value="2"> 2 - Peso desigual</label>
                                <label class="block"><input type="radio" name="piernas" value="3"> 3 - En cuclillas</label>
                                <label class="block"><input type="radio" name="piernas" value="4"> 4 - Apoyo inestable</label>
                            </div>
                        </div>

                        {{-- CARGA --}}
                        <div class="mb-4">
                            <label class="font-medium">Carga</label>
                            <div class="mt-1">
                                <label class="block"><input type="radio" name="carga" value="0" checked> 0 - &lt;5 kg</label>
                                <label class="block"><input type="radio" name="carga" value="1"> 1 - 5–10 kg</label>
                                <label class="block"><input type="radio" name="carga" value="2"> 2 - &gt;10 kg</label>
                            </div>
                        </div>
                    </div>

                    {{-- GRUPO B --}}
                    <div class="bg-green-50 p-5 rounded mb-6">
                        <h4 class="font-semibold text-green-700 mb-4">Grupo B</h4>

                        {{-- BRAZO --}}
                        <div class="mb-4">
                            <label class="font-medium">Brazo</label>
                            <div class="mt-1">
                                <label class="block"><input type="radio" name="brazo" value="1"> 1 - 20° ext a 20° flex</label>
                                <label class="block"><input type="radio" name="brazo" value="2"> 2 - 20°–45°</label>
                                <label class="block"><input type="radio" name="brazo" value="3"> 3 - 45°–90°</label>
                                <label class="block"><input type="radio" name="brazo" value="4"> 4 - &gt;90°</label>
                            </div>
                        </div>

                        {{-- ANTEBRAZO --}}
                        <div class="mb-4">
                            <label class="font-medium">Antebrazo</label>
                            <div class="mt-1">
                                <label class="block"><input type="radio" name="antebrazo" value="1"> 1 - 60°–100°</label>
                                <label class="block"><input type="radio" name="antebrazo" value="2"> 2 - Fuera de rango</label>
                            </div>
                        </div>

                        {{-- MUÑECA --}}
                        <div class="mb-4">
                            <label class="font-medium">Muñeca</label>
                            <div class="mt-1">
                                <label class="block"><input type="radio" name="muneca" value="1"> 1 - Neutra</label>
                                <label class="block"><input type="radio" name="muneca" value="2"> 2 - Flexión/extensión >15°</label>
                                <label class="block"><input type="radio" name="muneca" value="3"> 3 - Con desviación</label>
                            </div>
                            <label class="block mt-2 text-sm text-gray-700">
                                <input type="checkbox" name="muneca_ajuste" value="1">
                                Ajuste (+1): desviación o giro
                            </label>
                        </div>

                        {{-- AGARRE --}}
                        <div class="mb-4">
                            <label class="font-medium">Agarre / Acoplamiento</label>
                            <div class="mt-1">
                                <label class="block"><input type="radio" name="agarre" value="0" checked> 0 - Bueno</label>
                                <label class="block"><input type="radio" name="agarre" value="1"> 1 - Regular</label>
                                <label class="block"><input type="radio" name="agarre" value="2"> 2 - Malo</label>
                            </div>
                        </div>
                    </div>

                    {{-- ACTIVIDAD --}}
                    <div class="mb-6">
                        <label class="font-medium">Actividad</label>
                        <div class="mt-1">
                            <label class="block"><input type="radio" name="actividad" value="0" checked> 0 - Ocasional</label>
                            <label class="block"><input type="radio" name="actividad" value="1"> 1 - Repetitiva</label>
                            <label class="block"><input type="radio" name="actividad" value="2"> 2 - Estática prolongada</label>
                            <label class="block"><input type="radio" name="actividad" value="3"> 3 - Cambios rápidos / inestable</label>
                        </div>
                    </div>

                    {{-- BOTÓN CALCULAR --}}
                    <button type="button" id="calcular"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded mb-4">
                        Calcular Resultado
                    </button>

                    {{-- RESULTADO DINÁMICO --}}
                    <div id="resultado-reba" class="hidden p-4 rounded text-white font-semibold">
                        <p>Grupo A: <span id="grupoA"></span></p>
                        <p>Grupo B: <span id="grupoB"></span></p>
                        <p>Grupo C: <span id="grupoC"></span></p>
                        <hr class="my-2 opacity-40">
                        <p>Puntaje: <span id="puntaje"></span></p>
                        <p>Nivel: <span id="nivel"></span></p>
                    </div>

                </div>

                {{-- BOTONES --}}
                <div class="flex gap-3 mt-4">
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

    {{-- SCRIPT --}}
    <script>
document.addEventListener('DOMContentLoaded', () => {

    const metodoSelect = document.getElementById('metodo');
    const formReba = document.getElementById('form-reba');
    const resultado = document.getElementById('resultado-reba');
    const btnCalcular = document.getElementById('calcular');

    // Si no existe el botón, no sigas (evita errores silenciosos)
    if (!btnCalcular) {
        console.error('No se encontró el botón #calcular');
        return;
    }

    metodoSelect?.addEventListener('change', function () {
        if (this.value === 'REBA') {
            formReba.classList.remove('hidden');
        } else {
            formReba.classList.add('hidden');
            resultado.classList.add('hidden');
        }
    });

    const pick = (name) => document.querySelector(`input[name="${name}"]:checked`)?.value ?? null;
    const check = (name) => document.querySelector(`input[name="${name}"]`)?.checked ? 1 : 0;

    btnCalcular.addEventListener('click', async () => {
        try {
            const payload = {
                tronco: pick('tronco'),
                cuello: pick('cuello'),
                piernas: pick('piernas'),
                carga: pick('carga'),

                brazo: pick('brazo'),
                antebrazo: pick('antebrazo'),
                muneca: pick('muneca'),

                tronco_ajuste: check('tronco_ajuste'),
                cuello_ajuste: check('cuello_ajuste'),
                muneca_ajuste: check('muneca_ajuste'),

                agarre: pick('agarre'),
                actividad: pick('actividad'),
            };

            console.log('Enviando a calcular:', payload);

            // Validación mínima en frontend para que no falle sin explicación
            const required = ['tronco','cuello','piernas','brazo','antebrazo','muneca'];
            const faltan = required.filter(k => !payload[k]);

            if (faltan.length > 0) {
                alert('Faltan seleccionar campos: ' + faltan.join(', '));
                return;
            }

            const res = await fetch("{{ route('reba.calcular') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: JSON.stringify(payload),
            });

            const data = await res.json();

            // Si el servidor devolvió error 422/500, aquí lo vemos
            if (!res.ok) {
                console.error('Error HTTP:', res.status, data);
                alert('Error al calcular. Revisa consola (F12).');
                return;
            }

            console.log('Respuesta:', data);

            // Mostrar valores
            document.getElementById('grupoA').innerText = data.grupoA ?? '-';
            document.getElementById('grupoB').innerText = data.grupoB ?? '-';
            document.getElementById('grupoC').innerText = data.grupoC ?? '-';
            document.getElementById('puntaje').innerText = data.puntaje ?? '-';
            document.getElementById('nivel').innerText = data.nivel ?? '-';

            resultado.classList.remove('hidden');

            // Colores
            resultado.classList.remove('bg-green-500','bg-yellow-500','bg-orange-500','bg-red-600','bg-gray-500');

            if(data.nivel === 'Riesgo inapreciable') resultado.classList.add('bg-gray-500');
            else if(data.nivel === 'Riesgo bajo') resultado.classList.add('bg-green-500');
            else if(data.nivel === 'Riesgo medio') resultado.classList.add('bg-yellow-500');
            else if(data.nivel === 'Riesgo alto') resultado.classList.add('bg-orange-500');
            else resultado.classList.add('bg-red-600');

        } catch (err) {
            console.error('Fallo JS:', err);
            alert('Hubo un error en JavaScript. Revisa consola (F12).');
        }
    });

});
</script>

</x-app-layout>