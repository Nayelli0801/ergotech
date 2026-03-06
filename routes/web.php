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

/*
|--------------------------------------------------------------------------
| Inicio
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect('/login');
});

/*
|--------------------------------------------------------------------------
| 2FA
|--------------------------------------------------------------------------
*/
Route::get('/two-factor', [TwoFactorController::class, 'index'])->name('2fa.index');
Route::post('/two-factor', [TwoFactorController::class, 'store'])->name('2fa.store');

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Perfil
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Administración
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'rol:admin'])->group(function () {
    Route::resource('usuarios', UserController::class);
    Route::resource('empresas', EmpresaController::class);
    Route::resource('sucursales', SucursalController::class);
    Route::resource('puestos', PuestoController::class);
    Route::resource('trabajadores', TrabajadorController::class);
    Route::resource('evaluaciones', EvaluacionController::class);

    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
});

/*
|--------------------------------------------------------------------------
| Prueba rol
|--------------------------------------------------------------------------
*/
Route::get('/prueba-rol', function () {
    return Auth::user()->rol?->nombre;
})->middleware('auth');

require __DIR__ . '/auth.php';