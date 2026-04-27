<x-app-layout>
    <div class="max-w-5xl mx-auto py-8 px-6">
        <div class="bg-white shadow-lg rounded-2xl border border-gray-200 overflow-hidden">

            {{-- HEADER --}}
            <div class="bg-sky-600 text-white px-6 py-4">
                <h2 class="text-2xl font-bold">Detalle de la empresa</h2>
                <p class="text-sm text-blue-100">
                    Información registrada de la empresa
                </p>
            </div>

            <div class="p-6">

                {{-- LOGO RECTANGULAR --}}
                @if($empresa->logo)
                    <div class="flex justify-center mb-8">
                        <div class="w-full max-w-lg h-52 bg-white border rounded-xl shadow-sm flex items-center justify-center p-6">
                            
                            <img 
                                src="{{ asset('storage/' . $empresa->logo) }}"
                                alt="Logo de {{ $empresa->nombre }}"
                                class="max-w-full max-h-full object-contain"
                            >
                            
                        </div>
                    </div>
                @else
                    <div class="flex justify-center mb-8">
                        <div class="w-full max-w-lg h-52 flex items-center justify-center rounded-xl border bg-gray-100 text-gray-400 text-sm">
                            Sin logo
                        </div>
                    </div>
                @endif

                {{-- INFORMACIÓN --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <p class="text-sm text-gray-500">Nombre</p>
                        <p class="text-lg font-semibold text-gray-800">
                            {{ $empresa->nombre }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Razón social</p>
                        <p class="text-lg text-gray-800">
                            {{ $empresa->razon_social ?? 'N/A' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">RFC</p>
                        <p class="text-lg text-gray-800">
                            {{ $empresa->rfc ?? 'N/A' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Teléfono</p>
                        <p class="text-lg text-gray-800">
                            {{ $empresa->telefono ?? 'N/A' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Correo</p>
                        <p class="text-lg text-gray-800">
                            {{ $empresa->correo ?? 'N/A' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Estado</p>

                        @if($empresa->activo)
                            <span class="inline-block px-4 py-1 rounded-full bg-green-100 text-green-700 text-sm font-medium">
                                Activa
                            </span>
                        @else
                            <span class="inline-block px-4 py-1 rounded-full bg-red-100 text-red-700 text-sm font-medium">
                                Inactiva
                            </span>
                        @endif
                    </div>

                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-500">Dirección</p>
                        <p class="text-lg text-gray-800">
                            {{ $empresa->direccion ?? 'N/A' }}
                        </p>
                    </div>

                </div>

                {{-- BOTONES --}}
                <div class="mt-8 flex gap-3">
                    <a href="{{ route('empresas.edit', $empresa->id) }}"
                       class="bg-blue-700 hover:bg-blue-800 text-white px-5 py-2.5 rounded-lg transition">
                        Editar
                    </a>

                    <a href="{{ route('empresas.index') }}"
                       class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-5 py-2.5 rounded-lg transition">
                        Volver
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>