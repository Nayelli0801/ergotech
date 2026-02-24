<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>ErgoTech</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-gray-100">

<div class="flex h-screen overflow-hidden">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-gray-950 border-r border-gray-800 flex flex-col h-screen overflow-y-auto">

        <!-- LOGO -->
        <div class="p-6 text-2xl font-bold text-indigo-400 tracking-wide">
            ERGOTECH
        </div>

        <nav class="flex-1 px-4 text-sm">

            <!-- PRINCIPAL -->
            <p class="menu-title">PRINCIPAL</p>
            <a href="{{ route('dashboard') }}" class="menu-link">🏠 Dashboard</a>


            <!-- GESTIÓN -->
            <p class="menu-title">GESTIÓN</p>
            <a href="{{ route('empresas.index') }}" class="menu-link">🏢 Empresas</a>
            <a href="#" class="menu-link">👷 Puestos / Trabajadores</a>


            <!-- SISTEMA -->
            <p class="menu-title">SISTEMA</p>
            <a href="{{ route('usuarios.index') }}" class="menu-link">👥 Usuarios</a>


            <!-- EVALUACIÓN -->
            <p class="menu-title">EVALUACIÓN</p>
            <a href="{{ route('evaluaciones.index') }}" class="menu-link">📋 Evaluaciones</a>
            <a href="#" class="menu-link">📝 Checklist</a>


            <!-- DOCUMENTACIÓN -->
            <p class="menu-title">DOCUMENTACIÓN</p>
            <a href="#" class="menu-link">📷 Evidencias</a>


            <!-- ANÁLISIS -->
            <p class="menu-title">ANÁLISIS</p>
            <a href="#" class="menu-link">⚠ Riesgos Ergonómicos</a>


            <!-- MEJORAS -->
            <p class="menu-title">MEJORAS</p>
            <a href="#" class="menu-link">🛠 Recomendaciones</a>


            <!-- REPORTES -->
            <p class="menu-title">REPORTES</p>
            <a href="#" class="menu-link">📄 Reportes</a>


            <!-- ESTADÍSTICAS -->
            <p class="menu-title">ESTADÍSTICAS</p>
            <a href="#" class="menu-link">📊 Estadísticas</a>


            <!-- CONFIGURACIÓN -->
            <p class="menu-title">CONFIGURACIÓN</p>
            <a href="#" class="menu-link">⚙ Configuración</a>


            <!-- CUENTA -->
            <p class="menu-title">CUENTA</p>
            <a href="{{ route('profile.edit') }}" class="menu-link">👤 Perfil</a>

        </nav>

        <!-- LOGOUT -->
        <div class="p-4 border-t border-gray-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full text-left menu-link text-red-400 hover:text-red-300">
                    🚪 Cerrar sesión
                </button>
            </form>
        </div>

    </aside>

    <!-- CONTENIDO -->
    <main class="flex-1 overflow-y-auto">

        <div class="bg-gray-900/60 backdrop-blur-lg p-8 rounded-2xl shadow-xl border border-gray-800 max-w-7xl mx-auto mt-10">
            {{ $slot }}
        </div>

    </main>

</div>

</body>
</html>