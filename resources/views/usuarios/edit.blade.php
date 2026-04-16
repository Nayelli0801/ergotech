<x-app-layout>
    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">

                <!-- Header -->
                <div class="bg-sky-600 text-white px-6 py-4 flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-white">Editar Usuario</h2>
                    <p class="text-sm text-blue-100">Modifica los datos del usuario</p>
                </div>

                <div class="p-6">
                    <form method="POST" action="{{ route('usuarios.update', $user->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Nombre -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                            <input type="text" name="name"
                                value="{{ old('name', $user->name) }}" required
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Apellido -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Apellido</label>
                            <input type="text" name="last_name"
                                value="{{ old('last_name', $user->last_name) }}"
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Email -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email"
                                value="{{ old('email', $user->email) }}" required
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Password -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Nueva contraseña (opcional)
                            </label>
                            <input type="password" name="password"
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Confirm -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Confirmar contraseña
                            </label>
                            <input type="password" name="password_confirmation"
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Rol -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Rol</label>
                            <select name="rol_id" required
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">

                                @foreach($roles as $rol)
                                    <option value="{{ $rol->id }}"
                                        {{ old('rol_id', $user->rol_id) == $rol->id ? 'selected' : '' }}>
                                        {{ ucfirst(strtolower($rol->nombre)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Botones -->
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('usuarios.index') }}"
                                class="px-6 py-2 border rounded-lg hover:bg-gray-100">
                                Cancelar
                            </a>

                            <button type="submit"
                                class="flex items-center gap-2 px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">

                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>

                                Actualizar
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>