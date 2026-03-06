<x-app-layout>
    <div class="container py-4">
        <h2 class="mb-4">Cuestionario REBA</h2>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('reba.store') }}" method="POST">
            @csrf

            <input type="hidden" name="empresa_id" value="{{ $datosBase['empresa_id'] }}">
            <input type="hidden" name="sucursal_id" value="{{ $datosBase['sucursal_id'] }}">
            <input type="hidden" name="puesto_id" value="{{ $datosBase['puesto_id'] }}">
            <input type="hidden" name="trabajador_id" value="{{ $datosBase['trabajador_id'] }}">
            <input type="hidden" name="fecha" value="{{ $datosBase['fecha'] }}">
            <input type="hidden" name="observaciones" value="{{ $datosBase['observaciones'] }}">

            <div class="mb-3">
                <strong>Fecha:</strong> {{ $datosBase['fecha'] }}
            </div>

            <hr>
            <h4>Sección A</h4>

            <div class="row">
                <div class="col-md-3 mb-3">
                    <label>Cuello</label>
                    <select name="cuello" class="form-control" required>
                        <option value="">Seleccione</option>
                        <option value="1">1 - Cuello neutral</option>
                        <option value="2">2 - Cuello flexionado o extendido</option>
                        <option value="3">3 - Flexión/extensión con giro o inclinación</option>
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label>Tronco</label>
                    <select name="tronco" class="form-control" required>
                        <option value="">Seleccione</option>
                        <option value="1">1 - Tronco recto</option>
                        <option value="2">2 - Ligera flexión</option>
                        <option value="3">3 - Tronco flexionado</option>
                        <option value="4">4 - Muy flexionado o torcido</option>
                        <option value="5">5 - Postura severa</option>
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label>Piernas</label>
                    <select name="piernas" class="form-control" required>
                        <option value="">Seleccione</option>
                        <option value="1">1 - Apoyo estable</option>
                        <option value="2">2 - Apoyo inestable</option>
                        <option value="3">3 - Flexión importante</option>
                        <option value="4">4 - Postura severa</option>
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label>Carga</label>
                    <select name="carga" class="form-control" required>
                        <option value="">Seleccione</option>
                        <option value="0">0 - Sin carga</option>
                        <option value="1">1 - Ligera</option>
                        <option value="2">2 - Moderada</option>
                        <option value="3">3 - Alta</option>
                    </select>
                </div>
            </div>

            <hr>
            <h4>Sección B</h4>

            <div class="row">
                <div class="col-md-3 mb-3">
                    <label>Brazo</label>
                    <select name="brazo" class="form-control" required>
                        <option value="">Seleccione</option>
                        <option value="1">1 - Posición baja</option>
                        <option value="2">2 - Ligeramente elevado</option>
                        <option value="3">3 - Elevado</option>
                        <option value="4">4 - Muy elevado</option>
                        <option value="5">5 - Crítico</option>
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label>Antebrazo</label>
                    <select name="antebrazo" class="form-control" required>
                        <option value="">Seleccione</option>
                        <option value="1">1 - Entre 60° y 100°</option>
                        <option value="2">2 - Fuera del rango ideal</option>
                        <option value="3">3 - Muy comprometido</option>
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label>Muñeca</label>
                    <select name="muneca" class="form-control" required>
                        <option value="">Seleccione</option>
                        <option value="1">1 - Neutral</option>
                        <option value="2">2 - Flexionada o extendida</option>
                        <option value="3">3 - Desviada o girada</option>
                        <option value="4">4 - Severa</option>
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label>Tipo de agarre</label>
                    <select name="tipo_agarre" class="form-control" required>
                        <option value="">Seleccione</option>
                        <option value="0">0 - Bueno</option>
                        <option value="1">1 - Regular</option>
                        <option value="2">2 - Malo</option>
                        <option value="3">3 - Muy malo</option>
                    </select>
                </div>
            </div>

            <hr>
            <h4>Sección C</h4>

            <div class="row">
                <div class="col-md-3 mb-3">
                    <label>Actividad</label>
                    <select name="actividad" class="form-control" required>
                        <option value="">Seleccione</option>
                        <option value="0">0 - Sin repetición importante</option>
                        <option value="1">1 - Repetitiva leve</option>
                        <option value="2">2 - Repetitiva moderada</option>
                        <option value="3">3 - Repetitiva intensa</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Guardar evaluación REBA</button>
            <a href="{{ route('evaluaciones.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</x-app-layout>