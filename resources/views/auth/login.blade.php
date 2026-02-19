<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login | ErgoTech</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">

    <h2 class="text-2xl font-bold text-center mb-6">
        Iniciar Sesión
    </h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="mb-4">
            <label class="block text-gray-700">Correo</label>
            <input type="email" name="email"
                   class="w-full border rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-300"
                   required autofocus>
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label class="block text-gray-700">Contraseña</label>
            <input type="password" name="password"
                   class="w-full border rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-300"
                   required>
        </div>

        <!-- Remember -->
        <div class="mb-4 flex items-center">
            <input type="checkbox" name="remember" class="mr-2">
            <label>Recordarme</label>
        </div>

        <button class="background:#2563eb; color:white; padding:10px; width:100%; border-radius:6px;">
            Entrar
        </button>

        <div class="text-center mt-4">
            <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">
                ¿Olvidaste tu contraseña?
            </a>
        </div>

    </form>

</div>

</body>
</html>
