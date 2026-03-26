<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-6 space-y-6">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="text-3xl font-bold text-sky-600">Reportes de Evaluaciones</h2>
                <p class="text-sm text-gray-500 mt-1">
                    Consulta, filtra, exporta y analiza las evaluaciones registradas en ErgoTech.
                </p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                Filtros de evaluación
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Empresa</label>
                    <select id="filtroEmpresa" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Todas las empresas</option>
                        @foreach($empresas ?? [] as $empresa)
                            <option value="{{ $empresa->nombre }}">{{ $empresa->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Puesto</label>
                    <select id="filtroPuesto" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Todos los puestos</option>
                        @foreach($puestos ?? [] as $puesto)
                            <option value="{{ $puesto->nombre }}">{{ $puesto->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de evaluación</label>
                    <input type="date" id="filtroFecha" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Área evaluada</label>
                    <select id="filtroArea" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Todas las áreas</option>
                        <option value="Producción">Producción</option>
                        <option value="Laboratorio">Laboratorio</option>
                        <option value="Empaque">Empaque</option>
                    </select>
                </div>

                <div class="md:col-span-2 lg:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Observaciones (contiene)</label>
                    <input
                        type="text"
                        id="filtroObservaciones"
                        placeholder="Escribe palabras clave..."
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    >
                </div>
            </div>

            <div class="mt-5 flex flex-wrap gap-3">
                <button id="btnAplicarFiltros"
                        class="px-4 py-2 bg-sky-600 hover:bg-blue-800 rounded-lg font-semibold text-white shadow-sm">
                    Aplicar filtros
                </button>

                <button id="btnSimplificado"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-lg font-semibold text-white shadow-sm">
                    Generar simplificado
                </button>

                <button id="btnExcel"
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 rounded-lg font-semibold text-white shadow-sm">
                    Exportar a Excel
                </button>

                <button id="btnGraficas"
                        class="px-4 py-2 bg-amber-500 hover:bg-amber-600 rounded-lg font-semibold text-white shadow-sm">
                    Ver gráficas
                </button>

                <button id="btnCancelar"
                        class="px-4 py-2 bg-gray-500 hover:bg-gray-600 rounded-lg font-semibold text-white shadow-sm">
                    Limpiar filtros
                </button>
            </div>
        </div>

        <div id="simplificadoSection" class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-4 border-b border-gray-200 flex flex-col md:flex-row md:justify-between md:items-center gap-2">
                <h3 class="text-lg font-semibold text-gray-800">
                    Listado de Evaluaciones
                </h3>
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
                            <th class="px-4 py-3">Puesto</th>
                            <th class="px-4 py-3">Trabajador</th>
                            <th class="px-4 py-3">Fecha</th>
                            <th class="px-4 py-3">Área</th>
                            <th class="px-4 py-3">Resultado</th>
                            <th class="px-4 py-3">Observaciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaBody" class="divide-y divide-gray-200">
                        @forelse($evaluacionesData ?? [] as $eval)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $eval['id'] }}</td>
                                <td class="px-4 py-3">{{ $eval['empresa_nombre'] ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $eval['puesto_nombre'] ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $eval['trabajador_nombre'] ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $eval['fecha'] ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $eval['area'] ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $eval['resultado'] ?? 'N/A' }}</td>
                                <td class="px-4 py-3">
                                    {{ isset($eval['observaciones']) ? \Illuminate\Support\Str::limit($eval['observaciones'], 30) : '' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-6 text-center text-gray-500">
                                    No hay registros para mostrar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div id="graficasSection" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 hidden">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                Análisis gráfico de evaluaciones
            </h3>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-gray-50 rounded-xl border p-4">
                    <canvas id="graficoBarras"></canvas>
                </div>
                <div class="bg-gray-50 rounded-xl border p-4">
                    <canvas id="graficoPastel"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script type="application/json" id="evaluaciones-data">
        @json($evaluacionesData ?? [])
    </script>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.sheetjs.com/xlsx-0.20.2/package/dist/xlsx.full.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnSimplificado = document.getElementById('btnSimplificado');
            const btnExcel = document.getElementById('btnExcel');
            const btnGraficas = document.getElementById('btnGraficas');
            const btnAplicarFiltros = document.getElementById('btnAplicarFiltros');
            const btnCancelar = document.getElementById('btnCancelar');
            const simplificadoSection = document.getElementById('simplificadoSection');
            const graficasSection = document.getElementById('graficasSection');
            const tablaBody = document.getElementById('tablaBody');
            const totalRegistros = document.getElementById('totalRegistros');

            const filtroEmpresa = document.getElementById('filtroEmpresa');
            const filtroPuesto = document.getElementById('filtroPuesto');
            const filtroFecha = document.getElementById('filtroFecha');
            const filtroArea = document.getElementById('filtroArea');
            const filtroObservaciones = document.getElementById('filtroObservaciones');

            const evaluacionesOriginales = JSON.parse(
                document.getElementById('evaluaciones-data').textContent
            );

            const datosBase = evaluacionesOriginales.length ? evaluacionesOriginales : [
                { id: 1, empresa_nombre: 'Empresa A', puesto_nombre: 'Operario', trabajador_nombre: 'Juan Pérez', fecha: '2025-03-01', area: 'Producción', resultado: 85, observaciones: 'Cumple con normas', evaluador_nombre: 'Admin', metodo: 'REBA' },
                { id: 2, empresa_nombre: 'Empresa A', puesto_nombre: 'Supervisor', trabajador_nombre: 'María López', fecha: '2025-03-02', area: 'Laboratorio', resultado: 92, observaciones: 'Excelente desempeño', evaluador_nombre: 'Admin', metodo: 'RULA' },
                { id: 3, empresa_nombre: 'Empresa B', puesto_nombre: 'Gerente', trabajador_nombre: 'Carlos Ruiz', fecha: '2025-03-03', area: 'Empaque', resultado: 78, observaciones: 'Requiere mejora en tiempos', evaluador_nombre: 'Admin', metodo: 'OWAS' },
                { id: 4, empresa_nombre: 'Empresa C', puesto_nombre: 'Operario', trabajador_nombre: 'Ana Gómez', fecha: '2025-03-04', area: 'Producción', resultado: 88, observaciones: 'Buen trabajo', evaluador_nombre: 'Admin', metodo: 'NIOSH' },
                { id: 5, empresa_nombre: 'Empresa B', puesto_nombre: 'Supervisor', trabajador_nombre: 'Luis Torres', fecha: '2025-03-05', area: 'Laboratorio', resultado: 95, observaciones: 'Sobresaliente', evaluador_nombre: 'Admin', metodo: 'NOM-036' },
            ];

            let evaluacionesFiltradas = [...datosBase];
            let chartBarras = null;
            let chartPastel = null;

            function truncarTexto(texto, limite = 30) {
                if (!texto) return '';
                return texto.length > limite ? texto.substring(0, limite) + '...' : texto;
            }

            function renderTabla(datos) {
                tablaBody.innerHTML = '';

                if (!datos.length) {
                    tablaBody.innerHTML = `
                        <tr>
                            <td colspan="8" class="px-4 py-6 text-center text-gray-500">
                                No se encontraron registros con los filtros aplicados.
                            </td>
                        </tr>
                    `;
                    totalRegistros.textContent = 'Mostrando 0 registros';
                    return;
                }

                datos.forEach(e => {
                    const row = document.createElement('tr');
                    row.className = 'hover:bg-gray-50 border-b border-gray-200';
                    row.innerHTML = `
                        <td class="px-4 py-3">${e.id ?? ''}</td>
                        <td class="px-4 py-3">${e.empresa_nombre ?? 'N/A'}</td>
                        <td class="px-4 py-3">${e.puesto_nombre ?? 'N/A'}</td>
                        <td class="px-4 py-3">${e.trabajador_nombre ?? 'N/A'}</td>
                        <td class="px-4 py-3">${e.fecha ?? 'N/A'}</td>
                        <td class="px-4 py-3">${e.area ?? 'N/A'}</td>
                        <td class="px-4 py-3">${e.resultado ?? 'N/A'}</td>
                        <td class="px-4 py-3">${truncarTexto(e.observaciones)}</td>
                    `;
                    tablaBody.appendChild(row);
                });

                totalRegistros.textContent = `Mostrando ${datos.length} registros`;
            }

            function filtrarEvaluaciones() {
                const empresa = filtroEmpresa.value;
                const puesto = filtroPuesto.value;
                const fecha = filtroFecha.value;
                const area = filtroArea.value;
                const obs = filtroObservaciones.value.trim().toLowerCase();

                evaluacionesFiltradas = datosBase.filter(e => {
                    if (empresa && e.empresa_nombre !== empresa) return false;
                    if (puesto && e.puesto_nombre !== puesto) return false;
                    if (fecha && e.fecha !== fecha) return false;
                    if (area && e.area !== area) return false;
                    if (obs && !(e.observaciones || '').toLowerCase().includes(obs)) return false;
                    return true;
                });

                renderTabla(evaluacionesFiltradas);
            }

            function renderGraficas() {
                const ctxBarras = document.getElementById('graficoBarras').getContext('2d');
                const ctxPastel = document.getElementById('graficoPastel').getContext('2d');

                const datosGrafica = evaluacionesFiltradas.length ? evaluacionesFiltradas : [];

                const puestos = [...new Set(datosGrafica.map(e => e.puesto_nombre).filter(Boolean))];
                const promedios = puestos.map(p => {
                    const datosPuesto = datosGrafica.filter(e => e.puesto_nombre === p);
                    const suma = datosPuesto.reduce((acc, e) => acc + (parseFloat(e.resultado) || 0), 0);
                    return datosPuesto.length ? Number((suma / datosPuesto.length).toFixed(2)) : 0;
                });

                const areas = [...new Set(datosGrafica.map(e => e.area).filter(Boolean))];
                const conteoAreas = areas.map(a => datosGrafica.filter(e => e.area === a).length);

                if (chartBarras) chartBarras.destroy();
                if (chartPastel) chartPastel.destroy();

                chartBarras = new Chart(ctxBarras, {
                    type: 'bar',
                    data: {
                        labels: puestos,
                        datasets: [{
                            label: 'Promedio de resultado',
                            data: promedios
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: false },
                            title: { display: true, text: 'Resultado promedio por puesto' }
                        },
                        scales: {
                            y: { beginAtZero: true, max: 100 }
                        }
                    }
                });

                chartPastel = new Chart(ctxPastel, {
                    type: 'pie',
                    data: {
                        labels: areas,
                        datasets: [{
                            data: conteoAreas
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            title: { display: true, text: 'Distribución de evaluaciones por área' }
                        }
                    }
                });
            }

            btnAplicarFiltros.addEventListener('click', () => {
                filtrarEvaluaciones();
                if (!graficasSection.classList.contains('hidden')) {
                    renderGraficas();
                }
            });

            btnSimplificado.addEventListener('click', () => {
                simplificadoSection.classList.remove('hidden');
                graficasSection.classList.add('hidden');
                filtrarEvaluaciones();
            });

            btnExcel.addEventListener('click', () => {
                const datosAmpliados = evaluacionesFiltradas.map(e => ({
                    ID: e.id ?? '',
                    Empresa: e.empresa_nombre ?? '',
                    Puesto: e.puesto_nombre ?? '',
                    Trabajador: e.trabajador_nombre ?? '',
                    Fecha: e.fecha ?? '',
                    Área: e.area ?? '',
                    Resultado: e.resultado ?? '',
                    Observaciones: e.observaciones ?? '',
                    Evaluador: e.evaluador_nombre ?? 'No asignado',
                    Método: e.metodo ?? 'No definido'
                }));

                const wb = XLSX.utils.book_new();
                const ws = XLSX.utils.json_to_sheet(datosAmpliados);
                XLSX.utils.book_append_sheet(wb, ws, 'Evaluaciones');
                XLSX.writeFile(wb, 'evaluaciones_ergotech.xlsx');
            });

            btnGraficas.addEventListener('click', () => {
                simplificadoSection.classList.add('hidden');
                graficasSection.classList.remove('hidden');
                filtrarEvaluaciones();
                renderGraficas();
            });

            btnCancelar.addEventListener('click', () => {
                filtroEmpresa.value = '';
                filtroPuesto.value = '';
                filtroFecha.value = '';
                filtroArea.value = '';
                filtroObservaciones.value = '';
                evaluacionesFiltradas = [...datosBase];
                renderTabla(evaluacionesFiltradas);

                if (!graficasSection.classList.contains('hidden')) {
                    renderGraficas();
                }
            });

            renderTabla(evaluacionesFiltradas);
            simplificadoSection.classList.remove('hidden');
            graficasSection.classList.add('hidden');
        });
    </script>
    @endpush
</x-app-layout>