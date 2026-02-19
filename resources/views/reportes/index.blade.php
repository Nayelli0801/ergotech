<x-app-layout>
    <h2 class="text-xl font-bold mb-4">Reportes</h2>

    <p class="mb-4">Total evaluaciones: <strong>{{ $total }}</strong></p>

    <table class="table-auto w-full">
        <thead>
            <tr>
                <th>Método</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($porMetodo as $m)
            <tr>
                <td>{{ $m->metodo }}</td>
                <td>{{ $m->total }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>
