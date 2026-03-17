<x-app-layout>
    <div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Evaluación NOM-036</h1>
            <p class="text-sm text-slate-500 mt-1">
                Selecciona una o varias tareas realizadas y captura las condiciones observadas. El sistema calculará el riesgo automáticamente.
            </p>
        </div>

        @if(session('error'))
            <div class="mb-4 rounded-2xl bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 rounded-2xl bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm shadow-sm">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('nom036.store', $evaluacion->id) }}" method="POST" class="space-y-6" id="nom036Form">
            @csrf

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                    <h2 class="text-lg font-semibold text-slate-800">Información general</h2>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-xs uppercase tracking-wide text-slate-500 mb-1">Empresa</label>
                        <div class="text-sm font-semibold text-slate-800">{{ $evaluacion->empresa->nombre ?? 'N/A' }}</div>
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-wide text-slate-500 mb-1">Sucursal</label>
                        <div class="text-sm font-semibold text-slate-800">{{ $evaluacion->sucursal->nombre ?? 'N/A' }}</div>
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-wide text-slate-500 mb-1">Puesto</label>
                        <div class="text-sm font-semibold text-slate-800">{{ $evaluacion->puesto->nombre ?? 'N/A' }}</div>
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-wide text-slate-500 mb-1">Trabajador</label>
                        <div class="text-sm font-semibold text-slate-800">
                            {{ trim(($evaluacion->trabajador->nombre ?? '') . ' ' . ($evaluacion->trabajador->apellido_paterno ?? '') . ' ' . ($evaluacion->trabajador->apellido_materno ?? '')) ?: 'N/A' }}
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-wide text-slate-500 mb-1">Fecha</label>
                        <div class="text-sm font-semibold text-slate-800">{{ $evaluacion->fecha_evaluacion ?? 'N/A' }}</div>
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-wide text-slate-500 mb-1">Actividad general</label>
                        <div class="text-sm font-semibold text-slate-800">{{ $evaluacion->actividad ?? 'No especificada' }}</div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                    <h2 class="text-lg font-semibold text-slate-800">1. Configuración de la evaluación</h2>
                </div>

                <div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-3">Tareas realizadas</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach([
                                'levantar' => 'Levantar',
                                'bajar' => 'Bajar',
                                'transportar' => 'Transportar',
                                'empujar' => 'Empujar',
                                'jalar' => 'Jalar',
                            ] as $value => $label)
                                <label class="flex items-center gap-3 rounded-xl border border-slate-200 px-4 py-3 bg-slate-50 hover:bg-slate-100 transition cursor-pointer">
                                    <input type="checkbox" name="tareas[]" value="{{ $value }}" class="tarea-check rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm font-medium text-slate-700">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                        <p class="text-xs text-slate-500 mt-3">
                            Marca todas las tareas que realmente se realizan en la actividad observada.
                        </p>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Medio de ayuda utilizado</label>
                            <select name="medio_ayuda" class="w-full rounded-xl border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Seleccione</option>
                                <option value="Sin ayuda">Sin ayuda</option>
                                <option value="Con equipo auxiliar manual">Con equipo auxiliar manual</option>
                                <option value="Con equipo con ruedas">Con equipo con ruedas</option>
                                <option value="Con ayuda de otra persona">Con ayuda de otra persona</option>
                                <option value="Mixta">Mixta</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Nombre de la tarea</label>
                            <input type="text" name="tarea_nombre"
                                class="w-full rounded-xl border-slate-300 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Ej. Levantar caja y transportarla al área de empaque">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Descripción del apoyo o equipo utilizado</label>
                            <input type="text" name="descripcion_apoyo"
                                class="w-full rounded-xl border-slate-300 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Ej. Diablito, carrito, mesa elevadora, apoyo de compañero">
                        </div>
                    </div>
                </div>
            </div>

            {{-- LEVANTAR --}}
            <div id="bloque_levantar" class="hidden bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                    <h2 class="text-lg font-semibold text-slate-800">2. Cuestionario: Levantar</h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Peso y frecuencia de la carga</label>
                        <select name="lev_peso_frecuencia" class="w-full rounded-xl border-slate-300">
                            <option value="">Seleccione</option>
                            <option value="0|Carga ligera y frecuencia baja">Carga ligera y frecuencia baja</option>
                            <option value="1|Carga moderada o frecuencia media">Carga moderada o frecuencia media</option>
                            <option value="2|Carga alta o frecuencia alta">Carga alta o frecuencia alta</option>
                            <option value="3|Carga muy alta y/o frecuencia muy alta">Carga muy alta y/o frecuencia muy alta</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Distancia horizontal entre las manos y la espalda baja</label>
                        <select name="lev_distancia_horizontal" class="w-full rounded-xl border-slate-300">
                            <option value="">Seleccione</option>
                            <option value="0|Manos muy cercanas a la espalda baja">Manos muy cercanas a la espalda baja</option>
                            <option value="1|Manos cercanas a la espalda baja">Manos cercanas a la espalda baja</option>
                            <option value="2|Distancia moderada respecto a la espalda baja">Distancia moderada respecto a la espalda baja</option>
                            <option value="3|Separación grande o brazos muy flexionados">Separación grande o brazos muy flexionados</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Asimetría de la espalda o la carga</label>
                        <select name="lev_asimetria" class="w-full rounded-xl border-slate-300">
                            <option value="">Seleccione</option>
                            <option value="0|No hay asimetría">No hay asimetría</option>
                            <option value="1|Asimetría leve">Asimetría leve</option>
                            <option value="2|Asimetría moderada">Asimetría moderada</option>
                            <option value="3|Asimetría marcada">Asimetría marcada</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Restricciones posturales por espacio disponible</label>
                        <select name="lev_restricciones_posturales" class="w-full rounded-xl border-slate-300">
                            <option value="">Seleccione</option>
                            <option value="0|No existen restricciones posturales">No existen restricciones posturales</option>
                            <option value="1|Restricciones leves">Restricciones leves</option>
                            <option value="2|Restricciones moderadas">Restricciones moderadas</option>
                            <option value="3|Restricciones severas">Restricciones severas</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Agarre de la carga</label>
                        <select name="lev_agarre_carga" class="w-full rounded-xl border-slate-300">
                            <option value="">Seleccione</option>
                            <option value="0|Buen agarre">Buen agarre</option>
                            <option value="1|Agarre aceptable">Agarre aceptable</option>
                            <option value="2|Agarre deficiente">Agarre deficiente</option>
                            <option value="3|Agarre muy deficiente">Agarre muy deficiente</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Superficie del suelo</label>
                        <select name="lev_superficie_suelo" class="w-full rounded-xl border-slate-300">
                            <option value="">Seleccione</option>
                            <option value="0|Buen estado, seca, limpia, firme y nivelada">Buen estado, seca, limpia, firme y nivelada</option>
                            <option value="1|Aceptable">Aceptable</option>
                            <option value="2|Irregular o con riesgo moderado">Irregular o con riesgo moderado</option>
                            <option value="3|Mala condición">Mala condición</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Factores ambientales</label>
                        <select name="lev_factores_ambientales" class="w-full rounded-xl border-slate-300">
                            <option value="">Seleccione</option>
                            <option value="0|No existen">No existen</option>
                            <option value="1|Leves">Leves</option>
                            <option value="2|Moderados">Moderados</option>
                            <option value="3|Severos">Severos</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- BAJAR --}}
            <div id="bloque_bajar" class="hidden bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                    <h2 class="text-lg font-semibold text-slate-800">2. Cuestionario: Bajar</h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Peso y frecuencia de la carga</label>
                        <select name="baj_peso_frecuencia" class="w-full rounded-xl border-slate-300">
                            <option value="">Seleccione</option>
                            <option value="0|Carga ligera y frecuencia baja">Carga ligera y frecuencia baja</option>
                            <option value="1|Carga moderada o frecuencia media">Carga moderada o frecuencia media</option>
                            <option value="2|Carga alta o frecuencia alta">Carga alta o frecuencia alta</option>
                            <option value="3|Carga muy alta y/o frecuencia muy alta">Carga muy alta y/o frecuencia muy alta</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Control de descenso</label>
                        <select name="baj_control_descenso" class="w-full rounded-xl border-slate-300">
                            <option value="">Seleccione</option>
                            <option value="0|Totalmente controlado">Totalmente controlado</option>
                            <option value="1|Ligera dificultad">Ligera dificultad</option>
                            <option value="2|Difícil de controlar">Difícil de controlar</option>
                            <option value="3|Descenso brusco o muy difícil">Descenso brusco o muy difícil</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Asimetría</label>
                        <select name="baj_asimetria" class="w-full rounded-xl border-slate-300">
                            <option value="">Seleccione</option>
                            <option value="0|Sin asimetría">Sin asimetría</option>
                            <option value="1|Leve">Leve</option>
                            <option value="2|Moderada">Moderada</option>
                            <option value="3|Marcada">Marcada</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Restricciones posturales</label>
                        <select name="baj_restricciones_posturales" class="w-full rounded-xl border-slate-300">
                            <option value="">Seleccione</option>
                            <option value="0|No existen">No existen</option>
                            <option value="1|Leves">Leves</option>
                            <option value="2|Moderadas">Moderadas</option>
                            <option value="3|Severas">Severas</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Agarre de la carga</label>
                        <select name="baj_agarre_carga" class="w-full rounded-xl border-slate-300">
                            <option value="">Seleccione</option>
                            <option value="0|Buen agarre">Buen agarre</option>
                            <option value="1|Agarre aceptable">Agarre aceptable</option>
                            <option value="2|Agarre deficiente">Agarre deficiente</option>
                            <option value="3|Agarre muy deficiente">Agarre muy deficiente</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Superficie del suelo</label>
                        <select name="baj_superficie_suelo" class="w-full rounded-xl border-slate-300">
                            <option value="">Seleccione</option>
                            <option value="0|Buen estado, seca, limpia, firme y nivelada">Buen estado, seca, limpia, firme y nivelada</option>
                            <option value="1|Aceptable">Aceptable</option>
                            <option value="2|Irregular o con riesgo moderado">Irregular o con riesgo moderado</option>
                            <option value="3|Mala condición">Mala condición</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- TRANSPORTAR --}}
            <div id="bloque_transportar" class="hidden bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                    <h2 class="text-lg font-semibold text-slate-800">2. Cuestionario: Transportar</h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Peso y frecuencia de la carga</label>
                        <select name="tra_peso_frecuencia" class="w-full rounded-xl border-slate-300">
                            <option value="">Seleccione</option>
                            <option value="0|Carga ligera y frecuencia baja">Carga ligera y frecuencia baja</option>
                            <option value="1|Carga moderada o frecuencia media">Carga moderada o frecuencia media</option>
                            <option value="2|Carga alta o frecuencia alta">Carga alta o frecuencia alta</option>
                            <option value="3|Carga muy alta y/o frecuencia muy alta">Carga muy alta y/o frecuencia muy alta</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Distancia de transporte</label>
                        <select name="tra_distancia_transporte" class="w-full rounded-xl border-slate-300">
                            <option value="">Seleccione</option>
                            <option value="0|Entre 0 y 4 m">Entre 0 y 4 m</option>
                            <option value="1|Entre 4 y 10 m">Entre 4 y 10 m</option>
                            <option value="2|Entre 10 y 20 m">Entre 10 y 20 m</option>
                            <option value="3|Más de 20 m">Más de 20 m</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Asimetría de la carga</label>
                        <select name="tra_asimetria" class="w-full rounded-xl border-slate-300">
                            <option value="">Seleccione</option>
                            <option value="0|No hay asimetría">No hay asimetría</option>
                            <option value="1|Leve">Leve</option>
                            <option value="2|Moderada">Moderada</option>
                            <option value="3|Marcada">Marcada</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Agarre de la carga</label>
                        <select name="tra_agarre_carga" class="w-full rounded-xl border-slate-300">
                            <option value="">Seleccione</option>
                            <option value="0|Buen agarre">Buen agarre</option>
                            <option value="1|Agarre aceptable">Agarre aceptable</option>
                            <option value="2|Agarre deficiente">Agarre deficiente</option>
                            <option value="3|Agarre muy deficiente">Agarre muy deficiente</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Superficie del suelo</label>
                        <select name="tra_superficie_suelo" class="w-full rounded-xl border-slate-300">
                            <option value="">Seleccione</option>
                            <option value="0|Buen estado, seca, limpia, firme y nivelada">Buen estado, seca, limpia, firme y nivelada</option>
                            <option value="1|Aceptable">Aceptable</option>
                            <option value="2|Irregular o con riesgo moderado">Irregular o con riesgo moderado</option>
                            <option value="3|Mala condición">Mala condición</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Obstáculos en la ruta</label>
                        <select name="tra_obstaculos" class="w-full rounded-xl border-slate-300">
                            <option value="">Seleccione</option>
                            <option value="0|No hay obstáculos">No hay obstáculos</option>
                            <option value="1|Obstáculos menores">Obstáculos menores</option>
                            <option value="2|Obstáculos moderados o pendiente">Obstáculos moderados o pendiente</option>
                            <option value="3|Ruta muy obstaculizada">Ruta muy obstaculizada</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Factores ambientales</label>
                        <select name="tra_factores_ambientales" class="w-full rounded-xl border-slate-300">
                            <option value="">Seleccione</option>
                            <option value="0|No existen">No existen</option>
                            <option value="1|Leves">Leves</option>
                            <option value="2|Moderados">Moderados</option>
                            <option value="3|Severos">Severos</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- EMPUJAR --}}
            <div id="bloque_empujar" class="hidden bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                    <h2 class="text-lg font-semibold text-slate-800">2. Cuestionario: Empujar</h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Peso de la carga</label>
                        <select name="emp_peso_carga" class="w-full rounded-xl border-slate-300">
                            <option value="">Seleccione</option>
                            <option value="0|Menor a 50 kg">Menor a 50 kg</option>
                            <option value="1|Entre 50 y 100 kg">Entre 50 y 100 kg</option>
                            <option value="2|Entre 100 y 200 kg">Entre 100 y 200 kg</option>
                            <option value="3|Mayor a 200 kg">Mayor a 200 kg</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Postura</label>
                        <select name="emp_postura" class="w-full rounded-xl border-slate-300">
                            <option value="">Seleccione</option>
                            <option value="0|Postura adecuada">Postura adecuada</option>
                            <option value="1|Ligera inclinación">Ligera inclinación</option>
                            <option value="2|Inclinación moderada">Inclinación moderada</option>
                            <option value="3|Postura forzada">Postura forzada</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Agarre de la mano</label>
                        <select name="emp_agarre_mano" class="w-full rounded-xl border-slate-300">
                            <option value="">Seleccione</option>
                            <option value="0|Buen agarre">Buen agarre</option>
                            <option value="1|Agarre parcial">Agarre parcial</option>
                            <option value="2|Agarre deficiente">Agarre deficiente</option>
                            <option value="3|Agarre muy deficiente">Agarre muy deficiente</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Patrón de trabajo</label>
                        <select name="emp_patron_trabajo" class="w-full rounded-xl border-slate-300">
                            <option value="">Seleccione</option>
                            <option value="0|No repetitivo o con amplia recuperación">No repetitivo o con amplia recuperación</option>
                            <option value="1|Repetitivo con pausas">Repetitivo con pausas</option>
                            <option value="2|Repetitivo con recuperación limitada">Repetitivo con recuperación limitada</option>
                            <option value="3|Repetitivo sin pausas">Repetitivo sin pausas</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Distancia por viaje</label>
                        <select name="emp_distancia_viaje" class="w-full rounded-xl border-slate-300">
                            <option value="">Seleccione</option>
                            <option value="0|Menor a 10 m">Menor a 10 m</option>
                            <option value="1|Entre 10 y 20 m">Entre 10 y 20 m</option>
                            <option value="2|Entre 20 y 30 m">Entre 20 y 30 m</option>
                            <option value="3|Más de 30 m">Más de 30 m</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Condición del equipo auxiliar</label>
                        <select name="emp_condicion_equipo" class="w-full rounded-xl border-slate-300">
                            <option value="">Seleccione</option>
                            <option value="0|Buen mantenimiento">Buen mantenimiento</option>
                            <option value="1|Aceptable">Aceptable</option>
                            <option value="2|Deficiente">Deficiente</option>
                            <option value="3|Muy mala">Muy mala</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- JALAR --}}
            <div id="bloque_jalar" class="hidden bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                    <h2 class="text-lg font-semibold text-slate-800">2. Cuestionario: Jalar</h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Peso de la carga</label>
                        <select name="jal_peso_carga" class="w-full rounded-xl border-slate-300">
                            <option value="">Seleccione</option>
                            <option value="0|Menor a 50 kg">Menor a 50 kg</option>
                            <option value="1|Entre 50 y 100 kg">Entre 50 y 100 kg</option>
                            <option value="2|Entre 100 y 200 kg">Entre 100 y 200 kg</option>
                            <option value="3|Mayor a 200 kg">Mayor a 200 kg</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Postura</label>
                        <select name="jal_postura" class="w-full rounded-xl border-slate-300">
                            <option value="">Seleccione</option>
                            <option value="0|Postura adecuada">Postura adecuada</option>
                            <option value="1|Ligera inclinación">Ligera inclinación</option>
                            <option value="2|Inclinación moderada">Inclinación moderada</option>
                            <option value="3|Postura forzada">Postura forzada</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Agarre de la mano</label>
                        <select name="jal_agarre_mano" class="w-full rounded-xl border-slate-300">
                            <option value="">Seleccione</option>
                            <option value="0|Buen agarre">Buen agarre</option>
                            <option value="1|Agarre parcial">Agarre parcial</option>
                            <option value="2|Agarre deficiente">Agarre deficiente</option>
                            <option value="3|Agarre muy deficiente">Agarre muy deficiente</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Patrón de trabajo</label>
                        <select name="jal_patron_trabajo" class="w-full rounded-xl border-slate-300">
                            <option value="">Seleccione</option>
                            <option value="0|No repetitivo o con amplia recuperación">No repetitivo o con amplia recuperación</option>
                            <option value="1|Repetitivo con pausas">Repetitivo con pausas</option>
                            <option value="2|Repetitivo con recuperación limitada">Repetitivo con recuperación limitada</option>
                            <option value="3|Repetitivo sin pausas">Repetitivo sin pausas</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Distancia por viaje</label>
                        <select name="jal_distancia_viaje" class="w-full rounded-xl border-slate-300">
                            <option value="">Seleccione</option>
                            <option value="0|Menor a 10 m">Menor a 10 m</option>
                            <option value="1|Entre 10 y 20 m">Entre 10 y 20 m</option>
                            <option value="2|Entre 20 y 30 m">Entre 20 y 30 m</option>
                            <option value="3|Más de 30 m">Más de 30 m</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Condición del equipo auxiliar</label>
                        <select name="jal_condicion_equipo" class="w-full rounded-xl border-slate-300">
                            <option value="">Seleccione</option>
                            <option value="0|Buen mantenimiento">Buen mantenimiento</option>
                            <option value="1|Aceptable">Aceptable</option>
                            <option value="2|Deficiente">Deficiente</option>
                            <option value="3|Muy mala">Muy mala</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                    <h2 class="text-lg font-semibold text-slate-800">3. Observaciones</h2>
                </div>
                <div class="p-6">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Observaciones específicas NOM-036</label>
                    <textarea name="observaciones" rows="4"
                        class="w-full rounded-xl border-slate-300 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Describe hallazgos, condiciones y comentarios relevantes...">{{ old('observaciones') }}</textarea>
                </div>
            </div>

            <div class="flex flex-wrap gap-3 pt-2">
                <button type="submit"
                    class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-sm transition">
                    Guardar evaluación NOM-036
                </button>

                <a href="{{ route('evaluaciones.index') }}"
                    class="inline-flex items-center bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 font-semibold px-5 py-2.5 rounded-xl transition">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

    <script>
        const tareaChecks = document.querySelectorAll('.tarea-check');

        const bloques = {
            levantar: document.getElementById('bloque_levantar'),
            bajar: document.getElementById('bloque_bajar'),
            transportar: document.getElementById('bloque_transportar'),
            empujar: document.getElementById('bloque_empujar'),
            jalar: document.getElementById('bloque_jalar'),
        };

        function toggleBloquesNom036() {
            Object.values(bloques).forEach(bloque => bloque.classList.add('hidden'));

            tareaChecks.forEach(check => {
                if (check.checked && bloques[check.value]) {
                    bloques[check.value].classList.remove('hidden');
                }
            });
        }

        tareaChecks.forEach(check => {
            check.addEventListener('change', toggleBloquesNom036);
        });

        window.addEventListener('load', toggleBloquesNom036);
    </script>
</x-app-layout>