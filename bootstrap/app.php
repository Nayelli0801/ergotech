<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withProviders([ // 👈 🔥 AGREGA ESTO
        App\Providers\EventServiceProvider::class,
    ])

    ->withMiddleware(function ($middleware) {
        $middleware->alias([
    'rol' => \App\Http\Middleware\RolMiddleware::class,

    // ✅ CORRECTO (sin la "s" en Middleware)
    'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
    'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
    'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
]);
    })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    
    ->create();