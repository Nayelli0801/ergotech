<x-app-layout>
    <div class="container py-4">
        <h2>Nueva evaluación NOM-036</h2>
        <p>La vista NOM-036 ya está conectada correctamente.</p>
        <p><strong>Empresa:</strong> {{ $evaluacion->empresa->nombre ?? 'N/A' }}</p>
        <p><strong>Trabajador:</strong> {{ $evaluacion->trabajador->nombre ?? 'N/A' }}</p>
    </div>
</x-app-layout>