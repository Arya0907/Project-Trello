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
        $middleware->alias([
            'isLogin' => \App\Http\Middleware\isLogin::class,
            'isAdmin' => \App\Http\Middleware\isAdmin::class,
            'isGuest' => \App\Http\Middleware\isGuest::class,
            'isKasir' => \App\Http\Middleware\isKasir::class,
            'isUser' => \App\Http\Middleware\isUser::class,
            'isAdminOrKasir' => \App\Http\Middleware\isAdminOrKasir::class,
            

        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
