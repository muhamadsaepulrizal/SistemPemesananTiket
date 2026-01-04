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
        // Daftarkan middleware alias
        $middleware->alias([
            'admin' => \App\Http\Middleware\CekRoleAdmin::class,
            'user' => \App\Http\Middleware\CekRoleUser::class,
            'auth' => \App\Http\Middleware\CekSudahLogin::class,
            'tamu' => \App\Http\Middleware\CekTamu::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
