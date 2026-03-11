<x-app-layout>
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-11">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
                    <div>
                        <h2 class="fw-bold mb-1">Nueva evaluación OWAS</h2>
                        <p class="text-muted mb-0">
                            Registra una observación por vez. Puedes agregar, editar, duplicar o eliminar observaciones antes de guardar.
                        </p>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('owas.index') }}" class="btn btn-outline-primary">
                            Ver evaluaciones OWAS
                        </a>
                        <a href="{{ route('evaluaciones.index') }}" class="btn btn-outline-secondary">
                            Volver a evaluaciones
                        </a>
                    </div>
                </div>

                @if(session('error'))
                    <div class="alert alert-danger shadow-sm border-0">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger shadow-sm border-0">
                        <strong>Corrige los siguientes errores:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('owas.store') }}" method="POST" id="form-owas">
                    @csrf

                    <input type="hidden" name="empresa_id" value="{{ $datosBase['empresa_id'] }}">
                    <input type="hidden" name="sucursal_id" value="{{ $datosBase['sucursal_id'] }}">
                    <input type="hidden" name="puesto_id" value="{{ $datosBase['puesto_id'] }}">
                    <input type="hidden" name="trabajador_id" value="{{ $datosBase['trabajador_id'] }}">
                    <input type="hidden" name="fecha_evaluacion" value="{{ $datosBase['fecha_evaluacion'] }}">
                    <input type="hidden" name="area_evaluada" value="{{ $datosBase['area_evaluada'] }}">
                    <input type="hidden" name="actividad_general" value="{{ $datosBase['actividad_general'] }}">
                    <input type="hidden" name="observaciones" value="{{ $datosBase['observaciones'] }}">

                    <div class="row g-4">
                        <!-- COLUMNA IZQUIERDA -->
                        <div class="col-12 col-lg-8">
                            <!-- DATOS GENERALES -->
                            <div class="card border-0 shadow-sm rounded-4 mb-4">
                                <div class="card-header bg-white border-0 pt-4 px-4">
                                    <h5 class="fw-bold mb-0">Datos generales de la evaluación</h5>
                                </div>
                                <div class="card-body px-4 pb-4">
                                    <div class="row g-3">
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="bg-light rounded-4 p-3 h-100 border">
                                                <div class="text-muted small">Fecha</div>
                                                <div class="fw-semibold">{{ $datosBase['fecha_evaluacion'] }}</div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="bg-light rounded-4 p-3 h-100 border">
                                                <div class="text-muted small">Área evaluada</div>
                                                <div class="fw-semibold">{{ $datosBase['area_evaluada'] ?? 'No especificada' }}</div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="bg-light rounded-4 p-3 h-100 border">
                                                <div class="text-muted small">Actividad</div>
                                                <div class="fw-semibold">{{ $datosBase['actividad_general'] ?? 'No especificada' }}</div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="bg-light rounded-4 p-3 h-100 border">
                                                <div class="text-muted small">Observaciones</div>
                                                <div class="fw-semibold">{{ $datosBase['observaciones'] ?? 'Sin observaciones' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- BLOQUE DE OBSERVACIÓN -->
                            <div class="card border-0 shadow-sm rounded-4 mb-4">
                                <div class="card-header text-white border-0 rounded-top-4 px-4 py-3" style="background: linear-gradient(90deg, #0d6efd, #0b5ed7);">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                        <h5 class="fw-bold mb-0">Bloque de observación</h5>
                                        <span id="modo-edicion-badge" class="badge bg-warning text-dark d-none">
                                            Editando observación
                                        </span>
                                    </div>
                                </div>

                                <div class="card-body px-4 py-4">
                                    <div class="alert alert-info border-0 rounded-4 mb-4">
                                        <strong>Instrucción:</strong>
                                        Observa una postura y selecciona la opción que mejor la describa en cada apartado.
                                    </div>

                                    <input type="hidden" id="editando-index" value="">

                                    <div class="row g-4">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label fw-semibold">1. Posición de la espalda</label>
                                            <select id="espalda" class="form-select form-select-lg rounded-3" onchange="actualizarVistaPrevia()">
                                                <option value="1">Recta</option>
                                                <option value="2">Flexionada o extendida</option>
                                                <option value="3">Girada o flexionada lateralmente</option>
                                                <option value="4">Flexionada y girada</option>
                                            </select>
                                            <div class="form-text">Selecciona cómo se observa el tronco del trabajador.</div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label class="form-label fw-semibold">2. Posición de los brazos</label>
                                            <select id="brazos" class="form-select form-select-lg rounded-3" onchange="actualizarVistaPrevia()">
                                                <option value="1">Ambos brazos por debajo del nivel de los hombros</option>
                                                <option value="2">Un brazo al nivel o por encima del hombro</option>
                                                <option value="3">Ambos brazos al nivel o por encima del hombro</option>
                                            </select>
                                            <div class="form-text">Selecciona la posición general de los brazos.</div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label class="form-label fw-semibold">3. Posición de las piernas</label>
                                            <select id="piernas" class="form-select form-select-lg rounded-3" onchange="actualizarVistaPrevia()">
                                                <option value="1">Sentado</option>
                                                <option value="2">Parado sobre las dos piernas rectas</option>
                                                <option value="3">Parado sobre una pierna recta</option>
                                                <option value="4">Parado o en cuclillas sobre ambos pies</option>
                                                <option value="5">Parado o en cuclillas sobre un pie</option>
                                                <option value="6">Arrodillado sobre una o ambas rodillas</option>
                                                <option value="7">Caminando</option>
                                            </select>
                                            <div class="form-text">Selecciona la forma de apoyo o desplazamiento.</div>
                                        </div>

                                        <div class="col-12 col-md-3">
                                            <label class="form-label fw-semibold">4. Carga manipulada</label>
                                            <select id="carga" class="form-select form-select-lg rounded-3" onchange="actualizarVistaPrevia()">
                                                <option value="1">Menos de 10 kg</option>
                                                <option value="2">Entre 10 y 20 kg</option>
                                                <option value="3">Más de 20 kg</option>
                                            </select>
                                            <div class="form-text">Peso aproximado.</div>
                                        </div>

                                        <div class="col-12 col-md-3">
                                            <label class="form-label fw-semibold">5. Frecuencia observada</label>
                                            <select id="frecuencia" class="form-select form-select-lg rounded-3" onchange="actualizarVistaPrevia()">
                                                <option value="1">1 vez</option>
                                                <option value="2">2 veces</option>
                                                <option value="3">3 veces</option>
                                                <option value="4">4 veces</option>
                                                <option value="5">5 veces</option>
                                                <option value="6">6 veces</option>
                                                <option value="7">7 veces</option>
                                                <option value="8">8 veces</option>
                                                <option value="9">9 veces</option>
                                                <option value="10">10 veces</option>
                                            </select>
                                            <div class="form-text">Veces observadas.</div>
                                        </div>
                                    </div>

                                    <div class="row g-3 mt-2">
                                        <div class="col-12 col-md-3">
                                            <div class="border rounded-4 p-3 bg-light h-100">
                                                <div class="text-muted small mb-1">Código de postura</div>
                                                <div class="fs-4 fw-bold" id="preview-codigo">1111</div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-2">
                                            <div class="border rounded-4 p-3 bg-light h-100">
                                                <div class="text-muted small mb-1">Categoría</div>
                                                <span id="preview-categoria" class="badge bg-success fs-6">1</span>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-3">
                                            <div class="border rounded-4 p-3 bg-light h-100">
                                                <div class="text-muted small mb-1">Nivel de riesgo</div>
                                                <div class="fs-5 fw-bold" id="preview-nivel">Bajo</div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-4">
                                            <div class="border rounded-4 p-3 bg-light h-100">
                                                <div class="text-muted small mb-1">Acción requerida</div>
                                                <div class="fw-semibold" id="preview-accion">No requiere acción.</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap gap-2 mt-4">
                                        <button type="button" class="btn btn-success btn-lg px-4" id="btn-agregar" onclick="guardarObservacion()">
                                            Agregar observación
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary btn-lg px-4" onclick="limpiarCaptura()">
                                            Limpiar selección
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-lg px-4 d-none" id="btn-cancelar-edicion" onclick="cancelarEdicion()">
                                            Cancelar edición
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- TABLA DE OBSERVACIONES -->
                            <div class="card border-0 shadow-sm rounded-4 mb-4">
                                <div class="card-header bg-white border-0 px-4 pt-4">
                                    <h5 class="fw-bold mb-0">Observaciones registradas</h5>
                                </div>
                                <div class="card-body px-4 pb-4">
                                    <div class="alert alert-light border rounded-4 mb-3">
                                        Puedes <strong>editar</strong>, <strong>duplicar</strong> o <strong>eliminar</strong> cualquier observación antes de guardar.
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Espalda</th>
                                                    <th>Brazos</th>
                                                    <th>Piernas</th>
                                                    <th>Carga</th>
                                                    <th>Frecuencia</th>
                                                    <th>Código</th>
                                                    <th>Categoría</th>
                                                    <th>Nivel</th>
                                                    <th>Acción</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody-observaciones">
                                                <tr id="fila-vacia">
                                                    <td colspan="11" class="text-center text-muted py-4">
                                                        Aún no hay observaciones registradas.
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div id="inputs-ocultos"></div>
                                </div>
                            </div>
                        </div>

                        <!-- COLUMNA DERECHA -->
                        <div class="col-12 col-lg-4">
                            <div class="sticky-top" style="top: 20px;">
                                <div class="card border-0 shadow-sm rounded-4 mb-4">
                                    <div class="card-header text-white border-0 rounded-top-4 px-4 py-3" style="background: linear-gradient(90deg, #198754, #157347);">
                                        <h5 class="fw-bold mb-0">Resumen automático</h5>
                                    </div>
                                    <div class="card-body px-4 py-4">
                                        <div class="row g-3">
                                            <div class="col-6">
                                                <div class="border rounded-4 p-3 text-center bg-light h-100">
                                                    <div class="text-muted small">Observaciones</div>
                                                    <div class="fs-3 fw-bold" id="total-posturas">0</div>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="border rounded-4 p-3 text-center bg-light h-100">
                                                    <div class="text-muted small">Frecuencia total</div>
                                                    <div class="fs-3 fw-bold" id="frecuencia-total">0</div>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="border rounded-4 p-3 text-center bg-light h-100">
                                                    <div class="text-muted small">Categoría máxima</div>
                                                    <div class="fs-3 fw-bold" id="categoria-maxima">-</div>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="border rounded-4 p-3 text-center bg-light h-100">
                                                    <div class="text-muted small">Nivel global</div>
                                                    <div class="fs-6 fw-bold" id="nivel-riesgo">-</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="alert alert-light border rounded-4 mt-3 mb-0">
                                            <strong>Acción requerida:</strong><br>
                                            <span id="accion-requerida">-</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="card border-0 shadow-sm rounded-4">
                                    <div class="card-header bg-white border-0 px-4 pt-4">
                                        <h5 class="fw-bold mb-0">Acciones</h5>
                                    </div>
                                    <div class="card-body px-4 pb-4 d-grid gap-2">
                                        <button type="submit" class="btn btn-success btn-lg">
                                            Guardar evaluación
                                        </button>

                                        <a href="{{ route('owas.index') }}" class="btn btn-outline-primary btn-lg">
                                            Ver evaluaciones OWAS
                                        </a>

                                        <a href="{{ route('evaluaciones.index') }}" class="btn btn-outline-secondary btn-lg">
                                            Volver
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const matrizOWAS = {
            '1111':1,'1112':1,'1113':1,'1121':1,'1122':1,'1123':1,'1131':1,'1132':1,'1133':1,'1141':2,'1142':2,'1143':2,'1151':2,'1152':2,'1153':2,'1161':1,'1162':1,'1163':1,'1171':1,'1172':1,'1173':1,
            '1211':1,'1212':1,'1213':1,'1221':1,'1222':1,'1223':1,'1231':1,'1232':1,'1233':1,'1241':2,'1242':2,'1243':2,'1251':2,'1252':2,'1253':2,'1261':1,'1262':1,'1263':1,'1271':1,'1272':1,'1273':1,
            '1311':1,'1312':1,'1313':1,'1321':1,'1322':1,'1323':1,'1331':1,'1332':1,'1333':1,'1341':2,'1342':2,'1343':3,'1351':2,'1352':2,'1353':3,'1361':1,'1362':1,'1363':1,'1371':1,'1372':1,'1373':2,
            '2111':2,'2112':2,'2113':3,'2121':2,'2122':2,'2123':3,'2131':2,'2132':2,'2133':3,'2141':3,'2142':3,'2143':3,'2151':3,'2152':3,'2153':3,'2161':2,'2162':2,'2163':2,'2171':2,'2172':3,'2173':3,
            '2211':2,'2212':2,'2213':3,'2221':2,'2222':2,'2223':3,'2231':2,'2232':3,'2233':3,'2241':3,'2242':4,'2243':4,'2251':3,'2252':4,'2253':4,'2261':3,'2262':3,'2263':4,'2271':2,'2272':3,'2273':4,
            '2311':3,'2312':3,'2313':4,'2321':2,'2322':2,'2323':3,'2331':3,'2332':3,'2333':3,'2341':3,'2342':4,'2343':4,'2351':4,'2352':4,'2353':4,'2361':4,'2362':4,'2363':4,'2371':2,'2372':3,'2373':4,
            '3111':1,'3112':1,'3113':1,'3121':1,'3122':1,'3123':1,'3131':1,'3132':1,'3133':2,'3141':3,'3142':3,'3143':3,'3151':4,'3152':4,'3153':4,'3161':1,'3162':1,'3163':1,'3171':1,'3172':1,'3173':1,
            '3211':2,'3212':2,'3213':3,'3221':1,'3222':1,'3223':1,'3231':1,'3232':1,'3233':2,'3241':4,'3242':4,'3243':4,'3251':4,'3252':4,'3253':4,'3261':3,'3262':3,'3263':3,'3271':1,'3272':1,'3273':1,
            '3311':2,'3312':2,'3313':3,'3321':1,'3322':1,'3323':1,'3331':2,'3332':3,'3333':3,'3341':4,'3342':4,'3343':4,'3351':4,'3352':4,'3353':4,'3361':4,'3362':4,'3363':4,'3371':1,'3372':1,'3373':1,
            '4111':2,'4112':3,'4113':3,'4121':2,'4122':2,'4123':3,'4131':2,'4132':2,'4133':3,'4141':4,'4142':4,'4143':4,'4151':4,'4152':4,'4153':4,'4161':4,'4162':4,'4163':4,'4171':2,'4172':3,'4173':4,
            '4211':3,'4212':3,'4213':4,'4221':2,'4222':3,'4223':4,'4231':3,'4232':3,'4233':4,'4241':4,'4242':4,'4243':4,'4251':4,'4252':4,'4253':4,'4261':4,'4262':4,'4263':4,'4271':2,'4272':3,'4273':4,
            '4311':4,'4312':4,'4313':4,'4321':2,'4322':3,'4323':4,'4331':3,'4332':3,'4333':4,'4341':4,'4342':4,'4343':4,'4351':4,'4352':4,'4353':4,'4361':4,'4362':4,'4363':4,'4371':2,'4372':3,'4373':4
        };

        const categorias = {
            1: { nivel: 'Bajo', accion: 'No requiere acción.', color: 'success' },
            2: { nivel: 'Medio', accion: 'Se requieren acciones correctivas en un futuro cercano.', color: 'warning' },
            3: { nivel: 'Alto', accion: 'Se requieren acciones correctivas lo antes posible.', color: 'danger' },
            4: { nivel: 'Muy alto', accion: 'Se requiere tomar acciones correctivas inmediatamente.', color: 'dark' }
        };

        const textos = {
            espalda: {
                1: 'Recta',
                2: 'Flexionada o extendida',
                3: 'Girada o flexionada lateralmente',
                4: 'Flexionada y girada'
            },
            brazos: {
                1: 'Ambos brazos por debajo del nivel de los hombros',
                2: 'Un brazo al nivel o por encima del hombro',
                3: 'Ambos brazos al nivel o por encima del hombro'
            },
            piernas: {
                1: 'Sentado',
                2: 'Parado sobre las dos piernas rectas',
                3: 'Parado sobre una pierna recta',
                4: 'Parado o en cuclillas sobre ambos pies',
                5: 'Parado o en cuclillas sobre un pie',
                6: 'Arrodillado sobre una o ambas rodillas',
                7: 'Caminando'
            },
            carga: {
                1: 'Menos de 10 kg',
                2: 'Entre 10 y 20 kg',
                3: 'Más de 20 kg'
            }
        };

        let observaciones = [];

        function obtenerActual() {
            const espalda = document.getElementById('espalda').value;
            const brazos = document.getElementById('brazos').value;
            const piernas = document.getElementById('piernas').value;
            const carga = document.getElementById('carga').value;
            const frecuencia = document.getElementById('frecuencia').value;
            const codigo = `${espalda}${brazos}${piernas}${carga}`;
            const categoria = matrizOWAS[codigo] ?? 1;

            return {
                espalda,
                brazos,
                piernas,
                carga,
                frecuencia,
                codigo,
                categoria,
                nivel: categorias[categoria].nivel,
                accion: categorias[categoria].accion
            };
        }

        function actualizarVistaPrevia() {
            const actual = obtenerActual();
            document.getElementById('preview-codigo').textContent = actual.codigo;
            document.getElementById('preview-categoria').textContent = actual.categoria;
            document.getElementById('preview-categoria').className = `badge bg-${categorias[actual.categoria].color} fs-6`;
            document.getElementById('preview-nivel').textContent = actual.nivel;
            document.getElementById('preview-accion').textContent = actual.accion;
        }

        function guardarObservacion() {
            const actual = obtenerActual();
            const editandoIndex = document.getElementById('editando-index').value;

            if (editandoIndex !== '') {
                observaciones[parseInt(editandoIndex)] = actual;
                salirModoEdicion();
            } else {
                observaciones.push(actual);
            }

            renderObservaciones();
            renderInputsOcultos();
            actualizarResumen();
            limpiarCaptura();
        }

        function editarObservacion(index) {
            const obs = observaciones[index];

            document.getElementById('espalda').value = obs.espalda;
            document.getElementById('brazos').value = obs.brazos;
            document.getElementById('piernas').value = obs.piernas;
            document.getElementById('carga').value = obs.carga;
            document.getElementById('frecuencia').value = obs.frecuencia;
            document.getElementById('editando-index').value = index;

            document.getElementById('modo-edicion-badge').classList.remove('d-none');
            document.getElementById('btn-cancelar-edicion').classList.remove('d-none');
            document.getElementById('btn-agregar').textContent = 'Guardar cambios';

            actualizarVistaPrevia();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function duplicarObservacion(index) {
            const obs = { ...observaciones[index] };
            observaciones.push(obs);
            renderObservaciones();
            renderInputsOcultos();
            actualizarResumen();
        }

        function eliminarObservacion(index) {
            observaciones.splice(index, 1);
            renderObservaciones();
            renderInputsOcultos();
            actualizarResumen();

            const editandoIndex = document.getElementById('editando-index').value;
            if (editandoIndex !== '' && parseInt(editandoIndex) === index) {
                salirModoEdicion();
                limpiarCaptura();
            }
        }

        function cancelarEdicion() {
            salirModoEdicion();
            limpiarCaptura();
        }

        function salirModoEdicion() {
            document.getElementById('editando-index').value = '';
            document.getElementById('modo-edicion-badge').classList.add('d-none');
            document.getElementById('btn-cancelar-edicion').classList.add('d-none');
            document.getElementById('btn-agregar').textContent = 'Agregar observación';
        }

        function limpiarCaptura() {
            document.getElementById('espalda').value = '1';
            document.getElementById('brazos').value = '1';
            document.getElementById('piernas').value = '1';
            document.getElementById('carga').value = '1';
            document.getElementById('frecuencia').value = '1';
            actualizarVistaPrevia();
        }

        function renderObservaciones() {
            const tbody = document.getElementById('tbody-observaciones');

            if (observaciones.length === 0) {
                tbody.innerHTML = `
                    <tr id="fila-vacia">
                        <td colspan="11" class="text-center text-muted py-4">
                            Aún no hay observaciones registradas.
                        </td>
                    </tr>
                `;
                return;
            }

            tbody.innerHTML = '';

            observaciones.forEach((obs, index) => {
                tbody.innerHTML += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${textos.espalda[obs.espalda]}</td>
                        <td>${textos.brazos[obs.brazos]}</td>
                        <td>${textos.piernas[obs.piernas]}</td>
                        <td>${textos.carga[obs.carga]}</td>
                        <td>${obs.frecuencia}</td>
                        <td><strong>${obs.codigo}</strong></td>
                        <td><span class="badge bg-${categorias[obs.categoria].color}">${obs.categoria}</span></td>
                        <td>${obs.nivel}</td>
                        <td>${obs.accion}</td>
                        <td>
                            <div class="d-flex flex-wrap gap-1">
                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="editarObservacion(${index})">Editar</button>
                                <button type="button" class="btn btn-sm btn-outline-success" onclick="duplicarObservacion(${index})">Duplicar</button>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="eliminarObservacion(${index})">Eliminar</button>
                            </div>
                        </td>
                    </tr>
                `;
            });
        }

        function renderInputsOcultos() {
            const contenedor = document.getElementById('inputs-ocultos');
            contenedor.innerHTML = '';

            observaciones.forEach((obs, index) => {
                contenedor.innerHTML += `
                    <input type="hidden" name="posturas[${index}][espalda]" value="${obs.espalda}">
                    <input type="hidden" name="posturas[${index}][brazos]" value="${obs.brazos}">
                    <input type="hidden" name="posturas[${index}][piernas]" value="${obs.piernas}">
                    <input type="hidden" name="posturas[${index}][carga]" value="${obs.carga}">
                    <input type="hidden" name="posturas[${index}][frecuencia]" value="${obs.frecuencia}">
                `;
            });
        }

        function actualizarResumen() {
            const total = observaciones.length;
            let frecuenciaTotal = 0;
            let categoriaMaxima = 0;

            observaciones.forEach(obs => {
                frecuenciaTotal += parseInt(obs.frecuencia);
                if (obs.categoria > categoriaMaxima) categoriaMaxima = obs.categoria;
            });

            document.getElementById('total-posturas').textContent = total;
            document.getElementById('frecuencia-total').textContent = frecuenciaTotal;
            document.getElementById('categoria-maxima').textContent = total > 0 ? categoriaMaxima : '-';
            document.getElementById('nivel-riesgo').textContent = total > 0 ? categorias[categoriaMaxima].nivel : '-';
            document.getElementById('accion-requerida').textContent = total > 0 ? categorias[categoriaMaxima].accion : '-';
        }

        actualizarVistaPrevia();
        renderObservaciones();
        actualizarResumen();
    </script>
</x-app-layout>