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
    ->withMiddleware(function (Middleware $middleware) {
        // 1. Configuración de seguridad (fuera del array alias)
        $middleware->trustProxies(at: '*');

        // 2. Alias de Middlewares (aquí van tus alias)
        $middleware->alias([
            'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
            'role' => \App\Http\Middleware\CheckRole::class,
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'checkUserApproved' => \App\Http\Middleware\CheckUserApproved::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

