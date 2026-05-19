<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verificación 2FA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-2xl rounded-2xl p-8 w-full max-w-md">

        <h2 class="text-3xl font-bold text-center text-gray-800 mb-4">
            Verificación 🔐
        </h2>

        <p class="text-sm text-gray-600 text-center mb-6">
            Ingresa el código de verificación para continuar.
        </p>

        @if(session('codigo_demo'))
            <div class="mb-4 p-4 rounded-lg bg-yellow-100 text-yellow-800 font-bold text-center border border-yellow-300">
                Código demo: {{ session('codigo_demo') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-600 p-3 rounded-lg text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('2fa.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-gray-600 mb-1">Código de verificación</label>
                <input type="text" name="code" required autofocus
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 text-center text-lg tracking-widest focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="000000">
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white py-3 rounded-xl font-semibold hover:bg-blue-700 transition duration-300">
                Verificar
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('login') }}"
               class="text-blue-600 hover:underline text-sm">
                Cancelar e iniciar sesión nuevamente
            </a>
        </div>

    </div>

</body>
</html>