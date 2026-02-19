<h2>Usuarios</h2>

<table border="1">
<tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Email</th>
    <th>Rol</th>
</tr>

@foreach($usuarios as $user)
<tr>
    <td>{{ $user->id }}</td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td>{{ $user->rol->nombre }}</td>
</tr>
@endforeach
</table>

<a href="{{ route('usuarios.edit', $user->id) }}">Editar</a>