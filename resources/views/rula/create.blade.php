<x-app-layout>
    <div class="container py-4">
        <div class="mb-4">
            <h2 class="mb-1">Nueva evaluación RULA</h2>
            <p class="text-muted mb-0">
                Selecciona la postura observada. El sistema calculará automáticamente el resultado.
            </p>
        </div>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Se encontraron errores:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <style>
            .rula-card { border:1px solid #e9ecef; border-radius:16px; background:#fff; box-shadow:0 2px 8px rgba(0,0,0,.04); margin-bottom:1.25rem; overflow:hidden; }
            .rula-card-header { padding:14px 18px; font-weight:700; font-size:1rem; border-bottom:1px solid #edf2f7; }
            .rula-card-body { padding:18px; }
            .rula-header-main { background:#0d6efd; color:#fff; }
            .rula-header-a { background:#d9f2ff; color:#0b4f6c; }
            .rula-header-b { background:#fff3cd; color:#7a5a00; }
            .rula-header-extra { background:#e8f7ee; color:#146c43; }
            .rula-subblock { border:1px solid #eef2f7; border-radius:12px; padding:16px; background:#fafcff; margin-bottom:14px; }
            .rula-subblock:last-child { margin-bottom:0; }
            .rula-title { font-weight:700; font-size:1rem; margin-bottom:.25rem; }
            .rula-help { font-size:.88rem; color:#6c757d; margin-bottom:.9rem; }
            .rula-data-label { font-size:.85rem; color:#6b7280; margin-bottom:2px; }
            .rula-data-value { font-weight:600; color:#111827; }
            .rula-result-card { position:sticky; top:20px; }
            .rula-result-box { border:1px solid #dbeafe; border-radius:12px; background:#f8fbff; text-align:center; padding:12px; margin-bottom:12px; }
            .rula-result-label { font-size:.82rem; color:#6b7280; margin-bottom:4px; }
            .rula-result-value { font-size:1.2rem; font-weight:700; color:#111827; }
            .rula-summary { border:1px solid #d1fae5; border-radius:12px; background:#f0fdf4; padding:14px; }
            .rula-actions { border-top:1px solid #eef2f7; margin-top:1rem; padding-top:1rem; }
        </style>

        <form id="rulaForm" method="POST" action="{{ route('rula.store', $evaluacion->id) }}">
            @csrf

            <div class="row">
                <div class="col-lg-8">
                    <div class="rula-card">
                        <div class="rula-card-header rula-header-main">Datos de la evaluación</div>
                        <div class="rula-card-body">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <div class="rula-data-label">Empresa</div>
                                    <div class="rula-data-value">{{ $evaluacion->empresa->nombre ?? 'N/A' }}</div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="rula-data-label">Sucursal</div>
                                    <div class="rula-data-value">{{ $evaluacion->sucursal->nombre ?? 'N/A' }}</div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="rula-data-label">Puesto</div>
                                    <div class="rula-data-value">{{ $evaluacion->puesto->nombre ?? 'N/A' }}</div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="rula-data-label">Trabajador</div>
                                    <div class="rula-data-value">{{ $evaluacion->trabajador->nombre ?? 'N/A' }}</div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="rula-data-label">Fecha</div>
                                    <div class="rula-data-value">{{ $evaluacion->fecha_evaluacion }}</div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="rula-data-label">Área evaluada</div>
                                    <div class="rula-data-value">{{ $evaluacion->area_evaluada ?: 'No especificada' }}</div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="rula-data-label">Actividad general</div>
                                    <div class="rula-data-value">{{ $evaluacion->actividad ?: 'No especificada' }}</div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="rula-data-label">Observaciones</div>
                                    <div class="rula-data-value">{{ $evaluacion->observaciones ?: 'Sin observaciones' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rula-card">
                        <div class="rula-card-header rula-header-main">1. Información básica</div>
                        <div class="rula-card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><strong>Lado evaluado</strong></label>
                                    <select name="lado_evaluado" class="form-control calc">
                                        <option value="Derecho">Derecho</option>
                                        <option value="Izquierdo">Izquierdo</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><strong>Tarea evaluada</strong></label>
                                    <input type="text" name="tarea" class="form-control" placeholder="Ej. Ensamble de piezas">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rula-card">
                        <div class="rula-card-header rula-header-a">2. Grupo A: Brazo, antebrazo y muñeca</div>
                        <div class="rula-card-body">
                            <div class="rula-subblock">
                                <div class="rula-title">Brazo</div>
                                <div class="rula-help">Elige la opción que más se parezca a la postura observada del brazo.</div>

                                <div class="mb-3">
                                    <label class="form-label">Posición del brazo</label>
                                    <select name="brazo_base" class="form-control calc">
                                        <option value="1">Desde 20° de extensión a 20° de flexión</option>
                                        <option value="2">Extensión >20° o flexión >20° y <45°</option>
                                        <option value="3">Flexión >45° y 90°</option>
                                        <option value="4">Flexión >90°</option>
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input calc" type="checkbox" name="brazo_hombro_elevado" value="1" id="brazo_hombro_elevado">
                                            <label class="form-check-label" for="brazo_hombro_elevado">Hombro elevado o brazo rotado</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input calc" type="checkbox" name="brazo_abducido" value="1" id="brazo_abducido">
                                            <label class="form-check-label" for="brazo_abducido">Brazo separado del cuerpo</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input calc" type="checkbox" name="brazo_apoyo" value="1" id="brazo_apoyo">
                                            <label class="form-check-label" for="brazo_apoyo">Tiene punto de apoyo</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="rula-subblock">
                                <div class="rula-title">Antebrazo</div>
                                <div class="rula-help">Elige la posición del antebrazo y marca si trabaja fuera del rango normal.</div>

                                <div class="mb-3">
                                    <label class="form-label">Posición del antebrazo</label>
                                    <select name="antebrazo_base" class="form-control calc">
                                        <option value="1">Flexión entre 60° y 100°</option>
                                        <option value="2">Flexión <60° o >100°</option>
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input calc" type="checkbox" name="antebrazo_fuera_cuerpo" value="1" id="antebrazo_fuera_cuerpo">
                                            <label class="form-check-label" for="antebrazo_fuera_cuerpo">Trabaja a un lado del cuerpo</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input calc" type="checkbox" name="antebrazo_cruza_linea_media" value="1" id="antebrazo_cruza_linea_media">
                                            <label class="form-check-label" for="antebrazo_cruza_linea_media">Cruza la línea media</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="rula-subblock">
                                <div class="rula-title">Muñeca</div>
                                <div class="rula-help">Elige la postura de la muñeca y marca si está desviada.</div>

                                <div class="mb-3">
                                    <label class="form-label">Posición de la muñeca</label>
                                    <select name="muneca_base" class="form-control calc">
                                        <option value="1">Posición neutra</option>
                                        <option value="2">Flexión o extensión >0° y <15°</option>
                                        <option value="3">Flexión o extensión >15°</option>
                                    </select>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input calc" type="checkbox" name="muneca_desviacion" value="1" id="muneca_desviacion">
                                    <label class="form-check-label" for="muneca_desviacion">Desviación radial o cubital</label>
                                </div>
                            </div>

                            <div class="rula-subblock">
                                <div class="rula-title">Giro de muñeca</div>
                                <div class="rula-help">Selecciona el grado de giro observado.</div>

                                <div class="mb-0">
                                    <label class="form-label">Giro de muñeca</label>
                                    <select name="giro_muneca" class="form-control calc">
                                        <option value="1">Pronación o supinación media</option>
                                        <option value="2">Pronación o supinación extrema</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rula-card">
                        <div class="rula-card-header rula-header-b">3. Grupo B: Cuello, tronco y piernas</div>
                        <div class="rula-card-body">
                            <div class="rula-subblock">
                                <div class="rula-title">Cuello</div>
                                <div class="rula-help">Selecciona la postura principal del cuello y marca los ajustes si aplican.</div>

                                <div class="mb-3">
                                    <label class="form-label">Posición del cuello</label>
                                    <select name="cuello_base" class="form-control calc">
                                        <option value="1">Flexión entre 0° y 10°</option>
                                        <option value="2">Flexión >10° y ≤20°</option>
                                        <option value="3">Flexión >20°</option>
                                        <option value="4">Extensión en cualquier grado</option>
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input calc" type="checkbox" name="cuello_rotado" value="1" id="cuello_rotado">
                                            <label class="form-check-label" for="cuello_rotado">Cabeza rotada</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input calc" type="checkbox" name="cuello_inclinado" value="1" id="cuello_inclinado">
                                            <label class="form-check-label" for="cuello_inclinado">Inclinación lateral de la cabeza</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="rula-subblock">
                                <div class="rula-title">Tronco</div>
                                <div class="rula-help">Selecciona la postura del tronco y marca ajustes si existen.</div>

                                <div class="mb-3">
                                    <label class="form-label">Posición del tronco</label>
                                    <select name="tronco_base" class="form-control calc">
                                        <option value="1">Erguido o sentado bien apoyado</option>
                                        <option value="2">Flexión entre >0° y 20°</option>
                                        <option value="3">Flexión >20° y ≤60°</option>
                                        <option value="4">Flexión >60°</option>
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input calc" type="checkbox" name="tronco_rotado" value="1" id="tronco_rotado">
                                            <label class="form-check-label" for="tronco_rotado">Tronco rotado</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input calc" type="checkbox" name="tronco_inclinado" value="1" id="tronco_inclinado">
                                            <label class="form-check-label" for="tronco_inclinado">Inclinación lateral del tronco</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="rula-subblock">
                                <div class="rula-title">Piernas</div>
                                <div class="rula-help">Selecciona la condición de apoyo de piernas y pies.</div>

                                <div class="mb-0">
                                    <label class="form-label">Condición de piernas</label>
                                    <select name="piernas" class="form-control calc">
                                        <option value="1">Bien apoyadas / peso simétrico</option>
                                        <option value="2">Apoyo inestable / peso no simétrico</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rula-card">
                        <div class="rula-card-header rula-header-extra">4. Factores adicionales</div>
                        <div class="rula-card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><strong>Uso muscular</strong></label>
                                    <select name="uso_muscular" class="form-control calc">
                                        <option value="0">Sin incremento</option>
                                        <option value="1">Postura estática o repetida frecuentemente</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><strong>Fuerza / Carga</strong></label>
                                    <select name="carga_fuerza" class="form-control calc">
                                        <option value="0">Menor a 2 kg o sin carga adicional</option>
                                        <option value="1">Entre 2 y 10 kg, intermitente</option>
                                        <option value="2">Entre 2 y 10 kg repetitiva / mayor a 10 kg intermitente</option>
                                        <option value="3">Mayor a 10 kg repetitiva o esfuerzo brusco</option>
                                    </select>
                                </div>
                            </div>

                            <div class="rula-actions d-flex justify-content-end gap-2">
                                <a href="{{ route('evaluaciones.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary px-4">Guardar evaluación RULA</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="rula-result-card">
                        <div class="rula-card">
                            <div class="rula-card-header rula-header-main">Resultado en tiempo real</div>
                            <div class="rula-card-body">
                                <div class="row">
                                    <div class="col-4"><div class="rula-result-box"><div class="rula-result-label">Brazo</div><div class="rula-result-value" id="resBrazo">-</div></div></div>
                                    <div class="col-4"><div class="rula-result-box"><div class="rula-result-label">Antebrazo</div><div class="rula-result-value" id="resAntebrazo">-</div></div></div>
                                    <div class="col-4"><div class="rula-result-box"><div class="rula-result-label">Muñeca</div><div class="rula-result-value" id="resMuneca">-</div></div></div>
                                    <div class="col-4"><div class="rula-result-box"><div class="rula-result-label">Cuello</div><div class="rula-result-value" id="resCuello">-</div></div></div>
                                    <div class="col-4"><div class="rula-result-box"><div class="rula-result-label">Tronco</div><div class="rula-result-value" id="resTronco">-</div></div></div>
                                    <div class="col-4"><div class="rula-result-box"><div class="rula-result-label">Piernas</div><div class="rula-result-value" id="resPiernas">-</div></div></div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-3"><div class="rula-result-box"><div class="rula-result-label">A</div><div class="rula-result-value" id="resA">-</div></div></div>
                                    <div class="col-3"><div class="rula-result-box"><div class="rula-result-label">B</div><div class="rula-result-value" id="resB">-</div></div></div>
                                    <div class="col-3"><div class="rula-result-box"><div class="rula-result-label">C</div><div class="rula-result-value" id="resC">-</div></div></div>
                                    <div class="col-3"><div class="rula-result-box"><div class="rula-result-label">D</div><div class="rula-result-value" id="resD">-</div></div></div>
                                </div>

                                <div class="rula-summary mt-2">
                                    <div class="mb-2"><strong>Puntuación final:</strong> <span id="resFinal">-</span></div>
                                    <div class="mb-2"><strong>Nivel de riesgo:</strong><br><span id="resNivel" class="text-muted">-</span></div>
                                    <div><strong>Acción requerida:</strong><br><span id="resAccion" class="text-muted">-</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        async function calcularRula() {
            const form = document.getElementById('rulaForm');
            const formData = new FormData(form);

            try {
                const response = await fetch("{{ route('rula.calcular') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();

                document.getElementById('resBrazo').innerText = data.brazo ?? '-';
                document.getElementById('resAntebrazo').innerText = data.antebrazo ?? '-';
                document.getElementById('resMuneca').innerText = data.muneca ?? '-';
                document.getElementById('resCuello').innerText = data.cuello ?? '-';
                document.getElementById('resTronco').innerText = data.tronco ?? '-';
                document.getElementById('resPiernas').innerText = data.piernas ?? '-';

                document.getElementById('resA').innerText = data.puntuacion_a ?? '-';
                document.getElementById('resB').innerText = data.puntuacion_b ?? '-';
                document.getElementById('resC').innerText = data.puntuacion_c ?? '-';
                document.getElementById('resD').innerText = data.puntuacion_d ?? '-';
                document.getElementById('resFinal').innerText = data.puntuacion_final ?? '-';
                document.getElementById('resNivel').innerText = data.nivel_riesgo ?? '-';
                document.getElementById('resAccion').innerText = data.accion_requerida ?? '-';
            } catch (error) {
                console.error('Error al calcular RULA:', error);
            }
        }

        document.querySelectorAll('.calc').forEach(el => {
            el.addEventListener('change', calcularRula);
        });

        window.addEventListener('load', calcularRula);
    </script>
</x-app-layout>