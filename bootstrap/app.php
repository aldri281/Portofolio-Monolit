<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
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
        // Intercept exceptions and print raw details to avoid "view class not found" secondary errors
        $exceptions->render(function (\Throwable $e) {
            echo "<h1>Primary Laravel Error</h1>";
            echo "<p><b>Message:</b> " . $e->getMessage() . "</p>";
            echo "<p><b>File:</b> " . $e->getFile() . " on line " . $e->getLine() . "</p>";
            echo "<pre>" . $e->getTraceAsString() . "</pre>";
            die();
        });
    })->create();

// Allow overriding storage path via env (e.g. /tmp on Vercel)
// Do NOT override bootstrapPath — it would break providers.php loading
if ($storagePath = $_ENV['APP_STORAGE'] ?? null) {
    $app->useStoragePath($storagePath);
}

return $app;
