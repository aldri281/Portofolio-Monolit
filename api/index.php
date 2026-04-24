<?php

// Suppress deprecated notices from vendor/framework files in production
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
ini_set('display_errors', 1);

// Force LOG_CHANNEL to stderr for Vercel
$_ENV['LOG_CHANNEL'] = 'stderr';
$_SERVER['LOG_CHANNEL'] = 'stderr';

// On Vercel, only /tmp is writable. Create required Laravel directories there.
$storagePath = '/tmp/storage';
$dirs = [
    $storagePath . '/framework/cache/data',
    $storagePath . '/framework/sessions',
    $storagePath . '/framework/views',
    $storagePath . '/logs',
    $storagePath . '/app/public',
    $storagePath . '/bootstrap/cache',
];
foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        if (!mkdir($dir, 0755, true)) {
            die("Failed to create storage directory: $dir");
        }
    }
}

// Tell Laravel to use /tmp/storage as the storage path
$_ENV['APP_STORAGE'] = $storagePath;
$_SERVER['APP_STORAGE'] = $storagePath;

// Explicitly set cache paths to /tmp to avoid read-only filesystem errors
$cachePath = $storagePath . '/bootstrap/cache';
$_ENV['APP_SERVICES_CACHE'] = $cachePath . '/services.php';
$_ENV['APP_PACKAGES_CACHE'] = $cachePath . '/packages.php';
$_ENV['APP_CONFIG_CACHE'] = $cachePath . '/config.php';
$_ENV['APP_ROUTES_CACHE'] = $cachePath . '/routes-v7.php';
$_ENV['APP_EVENTS_CACHE'] = $cachePath . '/events.php';

try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    // If you need to debug later, you can re-enable detailed output here
    error_log($e->getMessage());
    echo "<h1>Internal Server Error</h1>";
}
