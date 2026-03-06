<x-app-layout>
    <div class="container py-4">
        <h2 class="mb-4">Nueva evaluación</h2>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
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

        <form action="{{ route('evaluaciones.seleccionarMetodo') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Empresa</label>
                    <select name="empresa_id" class="form-control" required>
                        <option value="">Seleccione</option>
                        @foreach($empresas as $empresa)
                            <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Sucursal</label>
                    <select name="sucursal_id" class="form-control" required>
                        <option value="">Seleccione</option>
                        @foreach($sucursales as $sucursal)
                            <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Puesto</label>
                    <select name="puesto_id" class="form-control" required>
                        <option value="">Seleccione</option>
                        @foreach($puestos as $puesto)
                            <option value="{{ $puesto->id }}">{{ $puesto->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Trabajador</label>
                    <select name="trabajador_id" class="form-control" required>
                        <option value="">Seleccione</option>
                        @foreach($trabajadores as $trabajador)
                            <option value="{{ $trabajador->id }}">{{ $trabajador->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Fecha</label>
                    <input type="date" name="fecha" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Método</label>
                    <select name="metodo" class="form-control" required>
                        <option value="">Seleccione</option>
                        <option value="REBA">REBA</option>
                        <option value="RULA">RULA</option>
                        <option value="OWAS">OWAS</option>
                        <option value="NIOSH">NIOSH</option>
                    </select>
                </div>

                <div class="col-md-12 mb-3">
                    <label>Observaciones generales</label>
                    <textarea name="observaciones" class="form-control" rows="3"></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Continuar</button>
            <a href="{{ route('evaluaciones.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</x-app-layout>