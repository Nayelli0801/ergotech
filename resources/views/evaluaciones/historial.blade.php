<x-app-layout>
    <h2 class="text-xl font-bold mb-4">Mis Evaluaciones</h2>

    @foreach($evaluaciones as $e)
        <div class="border p-2 mb-2">
            Empresa: {{ $e->empresa->nombre }} <br>
            Método: {{ $e->metodo }} <br>
            Fecha: {{ $e->fecha }}
        </div>
    @endforeach
</x-app-layout>
