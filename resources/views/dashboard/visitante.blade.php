<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<title>ErgoTech</title>

@vite(['resources/css/app.css'])

</head>

<body class="bg-gray-100">

<!-- HERO -->
<section class="bg-blue-700 text-white py-24">

<div class="max-w-6xl mx-auto text-center px-6">

<h1 class="text-5xl font-bold mb-6">
Bienvenido a ErgoTech
</h1>

<p class="text-xl mb-8">
Plataforma de evaluación ergonómica para empresas.
</p>

<p class="text-lg opacity-80">
Tu cuenta está registrada pero aún no tiene permisos asignados.
</p>

</div>

</section>

<!-- INFO -->

<section class="py-16">

<div class="max-w-6xl mx-auto grid md:grid-cols-3 gap-8 px-6">

<div class="bg-white p-6 rounded-xl shadow">
<h3 class="text-xl font-bold mb-2">Evaluaciones</h3>
<p>Aplicación de métodos ergonómicos como REBA.</p>
</div>

<div class="bg-white p-6 rounded-xl shadow">
<h3 class="text-xl font-bold mb-2">Gestión</h3>
<p>Administración de empresas y trabajadores.</p>
</div>

<div class="bg-white p-6 rounded-xl shadow">
<h3 class="text-xl font-bold mb-2">Reportes</h3>
<p>Generación automática de reportes profesionales.</p>
</div>

</div>

</section>

<!-- CTA -->

<section class="bg-gray-900 text-white py-16 text-center">

<h2 class="text-2xl mb-4">
Esperando autorización de administrador
</h2>

<form method="POST" action="{{ route('logout') }}">
@csrf

<button class="bg-red-500 px-6 py-3 rounded-lg">
Cerrar sesión
</button>

</form>

</section>

</body>
</html>
