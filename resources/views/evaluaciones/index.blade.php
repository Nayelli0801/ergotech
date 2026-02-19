<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lista de Evaluaciones
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-4">
                <a href="{{ route('evaluaciones.create') }}"
                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Nueva Evaluación
                </a>
            </div>

            <div class="bg-white shadow rounded p-6">
                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th>ID</th>
                            <th>Empresa</th>
                            <th>Evaluador</th>
                            <th>Método</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($evaluaciones as $evaluacion)
                            <tr class="border-t">
                                <td>{{ $evaluacion->id }}</td>
                                <td>{{ $evaluacion->empresa->nombre ?? 'N/A' }}</td>
                                <td>{{ $evaluacion->evaluador->name ?? 'N/A' }}</td>
                                <td>{{ $evaluacion->metodo }}</td>
                                <td>{{ $evaluacion->fecha }}</td>

                                <td>
                                    <a href="{{ route('evaluaciones.edit', $evaluacion->id) }}"
                                       class="text-yellow-600">
                                        Editar
                                    </a>

                                    <form action="{{ route('evaluaciones.destroy', $evaluacion->id) }}"
                                          method="POST"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 ml-2">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    No hay evaluaciones registradas
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>
</x-app-layout>
