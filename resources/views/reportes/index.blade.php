{{-- resources/views/reportes/index.blade.php --}}
<x-app-layout>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- ENCABEZADO --}}
            <div class="mb-6 flex justify-between items-center">
                <h2 class="text-3xl font-bold text-gray-800">Reportes de Evaluaciones</h2>
            </div>

            {{-- PANEL DE FILTROS --}}
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-filter mr-2 text-indigo-500"></i> Filtros de evaluación
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    {{-- Empresa --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Empresa</label>
                        <select id="filtroEmpresa" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Seleccione una empresa</option>
                            @foreach($empresas ?? [] as $empresa)
                                <option value="{{ $empresa->nombre }}">{{ $empresa->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Puesto --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Puesto</label>
                        <select id="filtroPuesto" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Seleccione un puesto</option>
                            @foreach($puestos ?? [] as $puesto)
                                <option value="{{ $puesto->nombre }}">{{ $puesto->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Fecha de evaluación --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fecha de evaluación</label>
                        <input type="date" id="filtroFecha" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>

                    {{-- Área evaluada --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Área evaluada</label>
                        <select id="filtroArea" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Todas las áreas</option>
                            <option value="Producción">Producción</option>
                            <option value="Laboratorio">Laboratorio</option>
                            <option value="Empaque">Empaque</option>
                        </select>
                    </div>

                    {{-- Observaciones --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Observaciones (contiene)</label>
                        <input type="text" id="filtroObservaciones" placeholder="Escribe palabras clave..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                </div>

                {{-- Botones de acción --}}
                <div class="mt-4 flex flex-wrap gap-3">
                    <button id="btnAplicarFiltros" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-md font-semibold text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <i class="fas fa-search mr-2"></i>Aplicar filtros
                    </button>
                    <button id="btnSimplificado" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-md font-semibold text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <i class="fas fa-table mr-2"></i>Generar Simplificado
                    </button>
                    <button id="btnExcel" class="px-4 py-2 bg-green-600 hover:bg-green-700 rounded-md font-semibold text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        <i class="fas fa-file-excel mr-2"></i>Exportar a Excel (Ampliado)
                    </button>
                    <button id="btnGraficas" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 rounded-md font-semibold text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2">
                        <i class="fas fa-chart-pie mr-2"></i>Ver Gráficas
                    </button>
                    <button id="btnCancelar" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 rounded-md font-semibold text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">
                        <i class="fas fa-times mr-2"></i>Cancelar
                    </button>
                </div>
            </div>

            {{-- SECCIÓN DE REPORTE SIMPLIFICADO (TABLA) --}}
            <div id="simplificadoSection" class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
                <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-list-alt mr-2 text-indigo-500"></i> Listado de Evaluaciones (Simplificado)
                    </h3>
                    <span class="text-sm text-gray-500" id="totalRegistros">Mostrando {{ count($evaluacionesData ?? []) }} registros</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-blue-800 text-gray-300">
                            <tr>
                                <th class="p-3">ID</th>
                                <th class="p-3">Empresa</th>
                                <th class="p-3">Puesto</th>
                                <th class="p-3">Trabajador</th>
                                <th class="p-3">Fecha</th>
                                <th class="p-3">Área</th>
                                <th class="p-3">Resultado</th>
                                <th class="p-3">Observaciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            @foreach($evaluacionesData ?? [] as $eval)
                            <tr class="border-b border-blue-800 hover:bg-gray-50">
                                <td class="p-3">{{ $eval['id'] }}</td>
                                <td class="p-3">{{ $eval['empresa_nombre'] ?? 'N/A' }}</td>
                                <td class="p-3">{{ $eval['puesto_nombre'] ?? 'N/A' }}</td>
                                <td class="p-3">{{ $eval['trabajador_nombre'] ?? 'N/A' }}</td>
                                <td class="p-3">{{ $eval['fecha'] }}</td>
                                <td class="p-3">{{ $eval['area'] }}</td>
                                <td class="p-3">{{ $eval['resultado'] }}</td>
                                <td class="p-3">{{ Str::limit($eval['observaciones'], 30) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- SECCIÓN DE GRÁFICAS --}}
            <div id="graficasSection" class="bg-white p-6 rounded-lg shadow-md hidden">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-chart-line mr-2 text-indigo-500"></i> Análisis Gráfico de Evaluaciones
                </h3>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <canvas id="graficoBarras"></canvas>
                    </div>
                    <div>
                        <canvas id="graficoPastel"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    {{-- Librerías necesarias --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.sheetjs.com/xlsx-0.20.2/package/dist/xlsx.full.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elementos del DOM
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

            // Datos provenientes del controlador (o array vacío)
            const evaluacionesOriginales = @json($evaluacionesData ?? []);

            // Si no hay datos reales, usamos datos de ejemplo para que la demo funcione
            const datosEjemplo = evaluacionesOriginales.length ? evaluacionesOriginales : [
                { id: 1, empresa_nombre: 'Empresa A', puesto_nombre: 'Operario', trabajador_nombre: 'Juan Pérez', fecha: '2025-03-01', area: 'Producción', resultado: 85, observaciones: 'Cumple con normas' },
                { id: 2, empresa_nombre: 'Empresa A', puesto_nombre: 'Supervisor', trabajador_nombre: 'María López', fecha: '2025-03-02', area: 'Laboratorio', resultado: 92, observaciones: 'Excelente desempeño' },
                { id: 3, empresa_nombre: 'Empresa B', puesto_nombre: 'Gerente', trabajador_nombre: 'Carlos Ruiz', fecha: '2025-03-03', area: 'Empaque', resultado: 78, observaciones: 'Requiere mejora en tiempos' },
                { id: 4, empresa_nombre: 'Empresa C', puesto_nombre: 'Operario', trabajador_nombre: 'Ana Gómez', fecha: '2025-03-04', area: 'Producción', resultado: 88, observaciones: 'Buen trabajo' },
                { id: 5, empresa_nombre: 'Empresa B', puesto_nombre: 'Supervisor', trabajador_nombre: 'Luis Torres', fecha: '2025-03-05', area: 'Laboratorio', resultado: 95, observaciones: 'Sobresaliente' },
            ];

            let evaluacionesFiltradas = [...datosEjemplo];

            // Función para filtrar los datos
            function filtrarEvaluaciones() {
                const empresa = filtroEmpresa.value;
                const puesto = filtroPuesto.value;
                const fecha = filtroFecha.value;
                const area = filtroArea.value;
                const obs = filtroObservaciones.value.toLowerCase();

                evaluacionesFiltradas = datosEjemplo.filter(e => {
                    if (empresa && e.empresa_nombre !== empresa) return false;
                    if (puesto && e.puesto_nombre !== puesto) return false;
                    if (fecha && e.fecha !== fecha) return false;
                    if (area && e.area !== area) return false;
                    if (obs && !e.observaciones.toLowerCase().includes(obs)) return false;
                    return true;
                });

                renderTabla(evaluacionesFiltradas);
            }

            // Renderizar tabla
            function renderTabla(datos) {
                tablaBody.innerHTML = '';
                datos.forEach(e => {
                    const row = document.createElement('tr');
                    row.className = 'border-b border-blue-800 hover:bg-gray-50';
                    row.innerHTML = `
                        <td class="p-3">${e.id}</td>
                        <td class="p-3">${e.empresa_nombre || 'N/A'}</td>
                        <td class="p-3">${e.puesto_nombre || 'N/A'}</td>
                        <td class="p-3">${e.trabajador_nombre || 'N/A'}</td>
                        <td class="p-3">${e.fecha}</td>
                        <td class="p-3">${e.area}</td>
                        <td class="p-3">${e.resultado}</td>
                        <td class="p-3">${e.observaciones ? e.observaciones.substring(0,30)+'...' : ''}</td>
                    `;
                    tablaBody.appendChild(row);
                });
                totalRegistros.textContent = `Mostrando ${datos.length} registros`;
            }

            // Eventos de filtros
            btnAplicarFiltros.addEventListener('click', filtrarEvaluaciones);

            // Botones de tipo de reporte
            btnSimplificado.addEventListener('click', () => {
                simplificadoSection.classList.remove('hidden');
                graficasSection.classList.add('hidden');
                filtrarEvaluaciones();
            });

            btnExcel.addEventListener('click', () => {
                const datosAmpliados = evaluacionesFiltradas.map(e => ({
                    ID: e.id,
                    Empresa: e.empresa_nombre,
                    Puesto: e.puesto_nombre,
                    Trabajador: e.trabajador_nombre,
                    Fecha: e.fecha,
                    Área: e.area,
                    Resultado: e.resultado,
                    Observaciones: e.observaciones,
                    Evaluador: e.evaluador_nombre ?? 'No asignado',
                    Método: e.metodo ?? 'Estándar'
                }));

                const wb = XLSX.utils.book_new();
                const ws = XLSX.utils.json_to_sheet(datosAmpliados);
                XLSX.utils.book_append_sheet(wb, ws, 'Evaluaciones');
                XLSX.writeFile(wb, 'evaluaciones_ergotech.xlsx');
            });

            btnGraficas.addEventListener('click', () => {
                simplificadoSection.classList.add('hidden');
                graficasSection.classList.remove('hidden');
                renderGraficas();
            });

            btnCancelar.addEventListener('click', () => {
                filtroEmpresa.value = '';
                filtroPuesto.value = '';
                filtroFecha.value = '';
                filtroArea.value = '';
                filtroObservaciones.value = '';
                evaluacionesFiltradas = [...datosEjemplo];
                renderTabla(datosEjemplo);
            });

            // Gráficas
            let chartBarras, chartPastel;
            function renderGraficas() {
                const ctxBarras = document.getElementById('graficoBarras').getContext('2d');
                const ctxPastel = document.getElementById('graficoPastel').getContext('2d');

                // Datos para gráfico de barras: promedio por puesto
                const puestos = [...new Set(datosEjemplo.map(e => e.puesto_nombre))];
                const promedios = puestos.map(p => {
                    const datosPuesto = datosEjemplo.filter(e => e.puesto_nombre === p);
                    const suma = datosPuesto.reduce((acc, e) => acc + e.resultado, 0);
                    return datosPuesto.length ? (suma / datosPuesto.length) : 0;
                });

                // Datos para gráfico de pastel: cantidad por área
                const areas = [...new Set(datosEjemplo.map(e => e.area))];
                const conteoAreas = areas.map(a => datosEjemplo.filter(e => e.area === a).length);

                if (chartBarras) chartBarras.destroy();
                if (chartPastel) chartPastel.destroy();

                chartBarras = new Chart(ctxBarras, {
                    type: 'bar',
                    data: {
                        labels: puestos,
                        datasets: [{
                            label: 'Promedio de resultado',
                            data: promedios,
                            backgroundColor: 'rgba(99, 102, 241, 0.5)',
                            borderColor: 'rgb(79, 70, 229)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: false },
                            title: { display: true, text: 'Resultado promedio por puesto' }
                        },
                        scales: { y: { beginAtZero: true, max: 100 } }
                    }
                });

                chartPastel = new Chart(ctxPastel, {
                    type: 'pie',
                    data: {
                        labels: areas,
                        datasets: [{
                            data: conteoAreas,
                            backgroundColor: ['#6366F1', '#34D399', '#FBBF24', '#F87171', '#60A5FA'],
                            hoverOffset: 4
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

            // Inicializar
            renderTabla(datosEjemplo);
            simplificadoSection.classList.remove('hidden');
            graficasSection.classList.add('hidden');
        });
    </script>
    @endpush

</x-app-layout>