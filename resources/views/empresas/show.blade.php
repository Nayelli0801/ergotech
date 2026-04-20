<x-app-layout>
    <div class="max-w-4xl mx-auto py-8 px-6">
        <div class="bg-white shadow-lg rounded-2xl border border-gray-200 overflow-hidden">

            <!-- Header -->
            <div class="bg-sky-600 text-white px-6 py-4">
                <h2 class="text-2xl font-bold">Detalle de la empresa</h2>
            </div>

            <div class="p-6">

                <!-- Logo -->
                @if($empresa->logo)
                    <div class="flex justify-center mb-6">
                        <img src="{{ asset('storage/' . $empresa->logo) }}" 
                             class="w-40 h-40 object-contain rounded-xl border shadow-sm">
                    </div>
                @endif

                <!-- Información -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div>
                        <p class="text-sm text-gray-500">Nombre</p>
                        <p class="text-lg font-semibold">{{ $empresa->nombre }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Razón social</p>
                        <p class="text-lg">{{ $empresa->razon_social ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">RFC</p>
                        <p class="text-lg">{{ $empresa->rfc ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Teléfono</p>
                        <p class="text-lg">{{ $empresa->telefono ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Correo</p>
                        <p class="text-lg">{{ $empresa->correo ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Estado</p>
                        <span class="inline-block px-3 py-1 text-sm rounded-full 
                            {{ $empresa->activo ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $empresa->activo ? 'Activa' : 'Inactiva' }}
                        </span>
                    </div>

                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-500">Dirección</p>
                        <p class="text-lg">{{ $empresa->direccion ?? 'N/A' }}</p>
                    </div>

                </div>

                <!-- Botones -->
                <div class="mt-6 flex gap-3">
                    <a href="{{ route('empresas.edit', $empresa->id) }}"
                       class="bg-blue-700 hover:bg-blue-800 text-white px-5 py-2.5 rounded-lg">
                        Editar
                    </a>

                    <a href="{{ route('empresas.index') }}"
                       class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-5 py-2.5 rounded-lg">
                        Volver
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>