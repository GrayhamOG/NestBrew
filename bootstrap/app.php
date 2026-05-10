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

        // ── Apply to every single request ──────────────────
        $middleware->append(\App\Http\Middleware\SecurityHeaders::class);
        $middleware->append(\App\Http\Middleware\SanitizeInput::class);

        // ── Apply only to web routes ───────────────────────
        $middleware->web(append: [
            \App\Http\Middleware\PreventBackHistory::class,
        ]);

    })

    ->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
        'prevent-back-history' => \App\Http\Middleware\PreventBackHistory::class,
    ]);
})
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();