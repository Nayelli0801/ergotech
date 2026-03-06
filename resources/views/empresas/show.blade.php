<x-app-layout>
    <div class="p-6 max-w-3xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Detalle de Empresa</h1>

        <div class="bg-white shadow rounded-lg p-6 space-y-3">
            <p><strong>Nombre:</strong> {{ $empresa->nombre }}</p>
            <p><strong>Razón social:</strong> {{ $empresa->razon_social }}</p>
            <p><strong>RFC:</strong> {{ $empresa->rfc }}</p>
            <p><strong>Teléfono:</strong> {{ $empresa->telefono }}</p>
            <p><strong>Correo:</strong> {{ $empresa->correo }}</p>
            <p><strong>Dirección:</strong> {{ $empresa->direccion }}</p>
            <p><strong>Estado:</strong> {{ $empresa->activo ? 'Activa' : 'Inactiva' }}</p>

            <div class="pt-4">
                <a href="{{ route('empresas.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                    Volver
                </a>
            </div>
        </div>
    </div>
</x-app-layout>