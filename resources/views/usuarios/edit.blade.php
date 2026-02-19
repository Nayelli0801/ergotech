<h2>Editar Usuario</h2>

<form method="POST" action="{{ route('usuarios.update', $user->id) }}">
    @csrf
    @method('PUT')

    <p>{{ $user->name }} — {{ $user->email }}</p>

    <label>Rol:</label>

    <select name="rol_id">
        @foreach($roles as $rol)
            <option value="{{ $rol->id }}"
                {{ $user->rol_id == $rol->id ? 'selected' : '' }}>
                {{ $rol->nombre }}
            </option>
        @endforeach
    </select>

    <button>Guardar</button>
</form>