<x-app-layout>
    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">

                <div class="bg-sky-600 text-white px-6 py-4">
                    <h2 class="text-2xl font-bold">Editar Usuario</h2>
                    <p class="text-sm text-blue-100">Modifica los datos del usuario</p>
                </div>

                <div class="p-6">
                    @if($errors->any())
                        <div class="mb-4 rounded-lg bg-red-100 border border-red-300 text-red-700 px-4 py-3">
                            <ul class="list-disc pl-5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('usuarios.update', $user->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                            <input type="text" name="name"
                                value="{{ old('name', $user->name) }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Apellido</label>
                            <input type="text" name="last_name"
                                value="{{ old('last_name', $user->last_name) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email"
                                value="{{ old('email', $user->email) }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Nueva contraseña (opcional)
                            </label>
                            <input type="password" name="password"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Confirmar contraseña
                            </label>
                            <input type="password" name="password_confirmation"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Rol</label>
                            <select name="rol_id" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                                @foreach($roles as $rol)
                                    <option value="{{ $rol->id }}"
                                        {{ old('rol_id', $user->rol_id) == $rol->id ? 'selected' : '' }}>
                                        {{ ucfirst(strtolower($rol->nombre)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2 flex flex-wrap justify-end gap-3 pt-2">

    {{-- CANCELAR --}}
    <a href="{{ route('sucursales.index') }}"
       class="inline-flex items-center justify-center w-[120px] h-[42px]
              bg-gray-200 hover:bg-gray-300 text-gray-800
              text-sm font-semibold rounded-lg transition">
        Cancelar
    </a>

    {{-- ACTUALIZAR --}}
    <button type="submit"
        class="inline-flex items-center justify-center w-[120px] h-[42px]
               bg-sky-600 hover:bg-sky-700 text-white
               text-sm font-semibold rounded-lg transition shadow-sm">
        Actualizar
    </button>

</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>