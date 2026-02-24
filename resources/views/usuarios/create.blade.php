<x-app-layout>

<div class="p-6 max-w-xl mx-auto">

    <h2 class="text-2xl font-bold mb-6">Crear Usuario</h2>

    <form method="POST" action="{{ route('usuarios.store') }}">
        @csrf

        <div class="mb-4">
            <label>Nombre</label>
            <input type="text" name="name"
                class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label>Email</label>
            <input type="email" name="email"
                class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label>Password</label>
            <input type="password" name="password"
                class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label>Rol</label>
            <select name="rol_id"
                class="w-full border rounded p-2">
                @foreach($roles as $rol)
                    <option value="{{ $rol->id }}">
                        {{ $rol->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="bg-indigo-600 text-white px-4 py-2 rounded">
            Guardar
        </button>

    </form>

</div>

</x-app-layout>
