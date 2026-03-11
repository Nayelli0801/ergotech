<x-app-layout>

<div class="max-w-3xl mx-auto mt-8">

```
<div class="bg-white rounded-xl shadow-lg overflow-hidden">

    <!-- Encabezado -->
    <div class="bg-blue-700 text-white px-6 py-4">
        <h2 class="text-xl font-bold">Editar usuario</h2>
        <p class="text-sm text-blue-100">Modificar el rol del usuario seleccionado.</p>
    </div>

    <!-- Contenido -->
    <div class="p-6">

        <div class="mb-6">
            <p class="text-gray-700 font-semibold">
                {{ $user->name }}
            </p>

            <p class="text-gray-500 text-sm">
                {{ $user->email }}
            </p>
        </div>

        <form action="{{ route('usuarios.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Selección de rol -->
            <div class="mb-6">

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Rol del usuario
                </label>

                <select name="rol_id"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">

                    @foreach($roles as $rol)

                    <option value="{{ $rol->id }}"
                    {{ $user->rol_id == $rol->id ? 'selected' : '' }}>
                        {{ ucfirst(strtolower($rol->nombre)) }}
                    </option>

                    @endforeach

                </select>

            </div>

            <!-- Botones -->
            <div class="flex gap-3">

                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow">
                    Guardar cambios
                </button>

                <a href="{{ route('usuarios.index') }}"
                   class="bg-gray-400 hover:bg-gray-500 text-white px-5 py-2 rounded-lg shadow">
                    Cancelar
                </a>

            </div>

        </form>

    </div>

</div>
```

</div>

</x-app-layout>
