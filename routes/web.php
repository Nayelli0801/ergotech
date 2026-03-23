<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\PuestoController;
use App\Http\Controllers\TrabajadorController;
use App\Http\Controllers\EvaluacionController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\RebaController;
use App\Http\Controllers\RulaController;
use App\Http\Controllers\OwasController;
use App\Http\Controllers\Nom036Controller;
use App\Http\Controllers\NioshController;
use App\Http\Controllers\ConfiguracionController;

// Redirigir la raíz al login
Route::get('/', function () {
    return redirect('/login');
});

// Rutas de autenticación de dos factores
Route::get('/two-factor', [TwoFactorController::class, 'index'])->name('2fa.index');
Route::post('/two-factor', [TwoFactorController::class, 'store'])->name('2fa.store');

// Dashboard (accesible para cualquier usuario autenticado)
Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Perfil (accesible para cualquier usuario autenticado)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =========================================================================
// GRUPO PARA ADMIN Y EVALUADOR (compartidas) - SIN ESPACIOS EN LA COMA
// =========================================================================
Route::middleware(['auth', 'rol:admin,evaluador'])->group(function () {

    // Gestión (empresas, sucursales, puestos, trabajadores)
    Route::get('/empresas', [EmpresaController::class, 'index'])->name('empresas.index');
    Route::get('/empresas/create', [EmpresaController::class, 'create'])->name('empresas.create');
    Route::post('/empresas', [EmpresaController::class, 'store'])->name('empresas.store');
    Route::get('/empresas/{empresa}', [EmpresaController::class, 'show'])->name('empresas.show');
    Route::get('/empresas/{empresa}/edit', [EmpresaController::class, 'edit'])->name('empresas.edit');

    // Evaluaciones (recurso principal)
    Route::resource('evaluaciones', EvaluacionController::class);
    // Ruta adicional para seleccionar método en evaluación
    Route::post('/evaluaciones/seleccionar-metodo', [EvaluacionController::class, 'seleccionarMetodo'])
        ->name('evaluaciones.seleccionarMetodo');

    // Métodos REBA
    Route::get('/reba', [RebaController::class, 'index'])->name('reba.index');
    Route::get('/reba/create/{evaluacion}', [RebaController::class, 'create'])->name('reba.create');
    Route::post('/reba/store/{evaluacion}', [RebaController::class, 'store'])->name('reba.store');
    Route::get('/reba/{id}', [RebaController::class, 'show'])->name('reba.show');
    Route::get('/reba/{id}/pdf', [RebaController::class, 'pdf'])->name('reba.pdf');

    // Métodos RULA
    Route::get('/rula', [RulaController::class, 'index'])->name('rula.index');
    Route::get('/rula/create/{evaluacion}', [RulaController::class, 'create'])->name('rula.create');
    Route::post('/rula/calcular', [RulaController::class, 'calcular'])->name('rula.calcular');
    Route::post('/rula/store/{evaluacion}', [RulaController::class, 'store'])->name('rula.store');
    Route::get('/rula/{id}', [RulaController::class, 'show'])->name('rula.show');
    Route::get('/rula/{id}/pdf', [RulaController::class, 'pdf'])->name('rula.pdf');

    // Métodos OWAS
    Route::get('/owas', [OwasController::class, 'index'])->name('owas.index');
    Route::get('/owas/create/{evaluacion}', [OwasController::class, 'create'])->name('owas.create');
    Route::post('/owas/store/{evaluacion}', [OwasController::class, 'store'])->name('owas.store');
    Route::get('/owas/{id}', [OwasController::class, 'show'])->name('owas.show');
    Route::get('/owas/{id}/pdf', [OwasController::class, 'pdf'])->name('owas.pdf');

    // Métodos NIOSH
    Route::get('/niosh', [NioshController::class, 'index'])->name('niosh.index');
    Route::get('/niosh/create/{evaluacion}', [NioshController::class, 'create'])->name('niosh.create');
    Route::post('/niosh/store/{evaluacion}', [NioshController::class, 'store'])->name('niosh.store');
    Route::get('/niosh/{id}', [NioshController::class, 'show'])->name('niosh.show');
    Route::get('/niosh/{id}/pdf', [NioshController::class, 'pdf'])->name('niosh.pdf');

    // Métodos NOM-036
    Route::get('/nom036/{evaluacion}/create', [Nom036Controller::class, 'create'])->name('nom036.create');
    Route::post('/nom036/{evaluacion}/store', [Nom036Controller::class, 'store'])->name('nom036.store');
    Route::get('/nom036/{id}', [Nom036Controller::class, 'show'])->name('nom036.show');
    Route::get('/nom036/{id}/pdf', [Nom036Controller::class, 'pdf'])->name('nom036.pdf');

    // Reportes
    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
});

// =========================================================================
// GRUPO EXCLUSIVO PARA ADMIN (solo admin)
// =========================================================================
Route::middleware(['auth', 'rol:admin'])->group(function () {

    // Usuarios (CRUD completo)
    Route::resource('usuarios', UserController::class);

    // Configuración (solo admin)
    Route::get('/configuracion', [ConfiguracionController::class, 'index'])->name('configuracion.index');
});

// Ruta de prueba para ver el rol del usuario autenticado
Route::get('/prueba-rol', function () {
    return Auth::user()->rol?->nombre;
})->middleware('auth');

// Archivo de rutas de autenticación (login, registro, etc.)
require __DIR__ . '/auth.php';