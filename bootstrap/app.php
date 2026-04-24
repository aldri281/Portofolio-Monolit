<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

// Allow overriding storage and bootstrap paths via env (e.g. /tmp on Vercel)
if ($storagePath = $_ENV['APP_STORAGE'] ?? null) {
    app()->useStoragePath($storagePath);
    app()->useBootstrapPath($storagePath . '/bootstrap');
}

return app();
