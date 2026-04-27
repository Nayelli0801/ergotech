<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-6 space-y-6">

        {{-- ENCABEZADO --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="text-3xl font-bold text-sky-600">
                    Centro de reportes ergonómicos
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Consulta evaluaciones, identifica puestos críticos y genera reportes para seguimiento y toma de decisiones.
                </p>
            </div>

            @if($soloLectura)
                <span class="inline-flex px-4 py-2 rounded-full bg-yellow-100 text-yellow-700 text-sm font-semibold">
                    Modo visitante: solo lectura
                </span>
            @endif
        </div>

        {{-- RESUMEN EJECUTIVO --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-1">Resumen ejecutivo</h3>
            <p class="text-sm text-gray-500 mb-5">
                Información general del conjunto de evaluaciones registradas.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
                <div class="rounded-2xl bg-slate-50 border p-4">
                    <p class="text-sm text-gray-500">Total de evaluaciones</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalEvaluaciones }}</p>
                </div>

                <div class="rounded-2xl bg-slate-50 border p-4">
                    <p class="text-sm text-gray-500">Método más usado</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $metodoMasUsado }}</p>
                </div>

                <div class="rounded-2xl bg-slate-50 border p-4">
                    <p class="text-sm text-gray-500">Nivel predominante</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $nivelPredominante }}</p>
                </div>

                <div class="rounded-2xl bg-red-50 border border-red-200 p-4">
                    <p class="text-sm text-gray-500">Riesgos altos detectados</p>
                    <p class="text-3xl font-bold text-red-600">{{ $riesgosAltos }}</p>
                </div>
            </div>
        </div>

        {{-- FILTROS --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                Filtros avanzados
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Empresa</label>
                    <select id="filtroEmpresa" class="w-full rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500">
                        <option value="">Todas las empresas</option>
                        @foreach($empresas ?? [] as $empresa)
                            <option value="{{ $empresa->nombre }}">{{ $empresa->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Puesto</label>
                    <select id="filtroPuesto" class="w-full rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500">
                        <option value="">Todos los puestos</option>
                        @foreach($puestos ?? [] as $puesto)
                            <option value="{{ $puesto->nombre }}">{{ $puesto->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Método</label>
                    <select id="filtroMetodo" class="w-full rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500">
                        <option value="">Todos los métodos</option>
                        <option value="REBA">REBA</option>
                        <option value="RULA">RULA</option>
                        <option value="OWAS">OWAS</option>
                        <option value="NIOSH">NIOSH</option>
                        <option value="NOM-036">NOM-036</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha</label>
                    <input type="date" id="filtroFecha" class="w-full rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nivel de riesgo</label>
                    <select id="filtroRiesgo" class="w-full rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500">
                        <option value="">Todos los niveles</option>
                        <option value="Bajo">Bajo</option>
                        <option value="Medio">Medio</option>
                        <option value="Alto">Alto</option>
                        <option value="Muy alto">Muy alto</option>
                        <option value="No aceptable">No aceptable</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Buscar observaciones</label>
                    <input type="text" id="filtroObservaciones"
                           placeholder="Palabra clave..."
                           class="w-full rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500">
                </div>
            </div>

            <div class="mt-5 flex flex-wrap gap-3">
                <button type="button" id="btnAplicarFiltros"
                        class="bg-sky-600 hover:bg-sky-700 rounded-lg font-semibold text-white px-5 py-2.5">
                    Aplicar filtros
                </button>

                <button type="button" id="btnLimpiar"
                        class="bg-red-100 hover:bg-red-200 rounded-lg font-semibold text-red-700 px-5 py-2.5">
                    Limpiar filtros
                </button>

                <a href="{{ route('reportes.excel') }}"
                   class="bg-green-100 hover:bg-green-200 rounded-lg font-semibold text-green-700 px-5 py-2.5">
                    Exportar reporte Excel
                </a>
            </div>
        </div>

        {{-- PUESTOS CRÍTICOS --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b bg-slate-50">
                <h3 class="text-lg font-bold text-gray-900">Ranking de puestos críticos</h3>
                <p class="text-sm text-gray-500">Puestos con mayor cantidad de evaluaciones en riesgo alto o muy alto.</p>
            </div>

            <div class="p-6">
                @if($puestosCriticos->count())
                    <div class="space-y-3">
                        @foreach($puestosCriticos as $index => $puesto)
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 rounded-2xl border p-4 bg-slate-50">
                                <div>
                                    <p class="font-bold text-gray-900">
                                        {{ $index + 1 }}. {{ $puesto['puesto'] }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        {{ $puesto['total'] }} evaluaciones registradas
                                    </p>
                                </div>

                                <div class="text-right">
                                    <p class="font-bold text-red-600">
                                        {{ $puesto['riesgos_altos'] }} riesgos altos
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        {{ $puesto['porcentaje'] }}% del puesto
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">No hay información suficiente para generar ranking.</p>
                @endif
            </div>
        </div>

        {{-- RECOMENDACIONES --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Recomendaciones automáticas</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="rounded-2xl border bg-slate-50 p-4">
                    <h4 class="font-bold text-gray-900 mb-2">Seguimiento</h4>
                    <p class="text-sm text-gray-600">
                        Priorizar la revisión de evaluaciones con nivel alto, muy alto o no aceptable.
                    </p>
                </div>

                <div class="rounded-2xl border bg-slate-50 p-4">
                    <h4 class="font-bold text-gray-900 mb-2">Puestos críticos</h4>
                    <p class="text-sm text-gray-600">
                        Revisar condiciones de trabajo en los puestos con mayor frecuencia de riesgo.
                    </p>
                </div>

                <div class="rounded-2xl border bg-slate-50 p-4">
                    <h4 class="font-bold text-gray-900 mb-2">Exportación</h4>
                    <p class="text-sm text-gray-600">
                        Generar reportes en Excel para documentar hallazgos y acciones correctivas.
                    </p>
                </div>
            </div>
        </div>

        {{-- TABLA DETALLADA --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-4 border-b border-gray-200 flex flex-col md:flex-row md:justify-between md:items-center gap-2">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">
                        Reporte detallado de evaluaciones
                    </h3>
                    <p class="text-sm text-gray-500">
                        Consulta resultados, niveles de riesgo y acciones recomendadas.
                    </p>
                </div>

                <span class="text-sm text-gray-500" id="totalRegistros">
                    Mostrando {{ count($evaluacionesData ?? []) }} registros
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="bg-sky-600 text-white">
                        <tr>
                            <th class="px-4 py-3">ID</th>
                            <th class="px-4 py-3">Empresa</th>
                            <th class="px-4 py-3">Trabajador</th>
                            <th class="px-4 py-3">Puesto</th>
                            <th class="px-4 py-3">Método</th>
                            <th class="px-4 py-3">Fecha</th>
                            <th class="px-4 py-3">Resultado</th>
                            <th class="px-4 py-3">Riesgo</th>
                            <th class="px-4 py-3">Acción recomendada</th>
                        </tr>
                    </thead>
                    <tbody id="tablaBody" class="divide-y divide-gray-200"></tbody>
                </table>
            </div>
        </div>
    </div>

    <script type="application/json" id="evaluaciones-data">
        @json($evaluacionesData ?? [])
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const datosBase = JSON.parse(document.getElementById('evaluaciones-data').textContent || '[]');
            let datosFiltrados = [...datosBase];

            const tablaBody = document.getElementById('tablaBody');
            const totalRegistros = document.getElementById('totalRegistros');

            const filtroEmpresa = document.getElementById('filtroEmpresa');
            const filtroPuesto = document.getElementById('filtroPuesto');
            const filtroMetodo = document.getElementById('filtroMetodo');
            const filtroFecha = document.getElementById('filtroFecha');
            const filtroRiesgo = document.getElementById('filtroRiesgo');
            const filtroObservaciones = document.getElementById('filtroObservaciones');

            function normalizar(texto) {
                return (texto || '').toString().toLowerCase().trim();
            }

            function truncarTexto(texto, limite = 55) {
                if (!texto) return 'Sin recomendación';
                return texto.length > limite ? texto.substring(0, limite) + '...' : texto;
            }

            function claseRiesgo(riesgo) {
                const r = normalizar(riesgo);

                if (r.includes('muy alto') || r.includes('no aceptable')) return 'bg-red-100 text-red-700';
                if (r.includes('alto')) return 'bg-orange-100 text-orange-700';
                if (r.includes('medio')) return 'bg-yellow-100 text-yellow-700';
                if (r.includes('bajo')) return 'bg-green-100 text-green-700';

                return 'bg-gray-100 text-gray-700';
            }

            function renderTabla(datos) {
                tablaBody.innerHTML = '';

                if (!datos.length) {
                    tablaBody.innerHTML = `
                        <tr>
                            <td colspan="9" class="px-4 py-8 text-center text-gray-500">
                                No se encontraron evaluaciones con los filtros aplicados.
                            </td>
                        </tr>
                    `;
                    totalRegistros.textContent = 'Mostrando 0 registros';
                    return;
                }

                datos.forEach(e => {
                    const row = document.createElement('tr');
                    row.className = 'hover:bg-gray-50';

                    row.innerHTML = `
                        <td class="px-4 py-3 font-semibold">${e.id ?? ''}</td>
                        <td class="px-4 py-3">${e.empresa_nombre ?? 'N/A'}</td>
                        <td class="px-4 py-3">${e.trabajador_nombre ?? 'N/A'}</td>
                        <td class="px-4 py-3">${e.puesto_nombre ?? 'N/A'}</td>
                        <td class="px-4 py-3 font-semibold">${e.metodo ?? 'N/A'}</td>
                        <td class="px-4 py-3">${e.fecha ?? 'N/A'}</td>
                        <td class="px-4 py-3 font-semibold">${e.resultado ?? 'N/A'}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold ${claseRiesgo(e.nivel_riesgo)}">
                                ${e.nivel_riesgo ?? 'N/A'}
                            </span>
                        </td>
                        <td class="px-4 py-3">${truncarTexto(e.accion_recomendada)}</td>
                    `;

                    tablaBody.appendChild(row);
                });

                totalRegistros.textContent = `Mostrando ${datos.length} registros`;
            }

            function aplicarFiltros() {
                const empresa = filtroEmpresa.value;
                const puesto = filtroPuesto.value;
                const metodo = filtroMetodo.value;
                const fecha = filtroFecha.value;
                const riesgo = filtroRiesgo.value;
                const obs = normalizar(filtroObservaciones.value);

                datosFiltrados = datosBase.filter(e => {
                    if (empresa && e.empresa_nombre !== empresa) return false;
                    if (puesto && e.puesto_nombre !== puesto) return false;
                    if (metodo && normalizar(e.metodo) !== normalizar(metodo)) return false;
                    if (fecha && e.fecha !== fecha) return false;
                    if (riesgo && !normalizar(e.nivel_riesgo).includes(normalizar(riesgo))) return false;
                    if (obs && !normalizar(e.observaciones).includes(obs)) return false;

                    return true;
                });

                renderTabla(datosFiltrados);
            }

            document.getElementById('btnAplicarFiltros').addEventListener('click', aplicarFiltros);

            document.getElementById('btnLimpiar').addEventListener('click', function () {
                filtroEmpresa.value = '';
                filtroPuesto.value = '';
                filtroMetodo.value = '';
                filtroFecha.value = '';
                filtroRiesgo.value = '';
                filtroObservaciones.value = '';

                datosFiltrados = [...datosBase];
                renderTabla(datosFiltrados);
            });

            renderTabla(datosFiltrados);
        });
    </script>
</x-app-layout>