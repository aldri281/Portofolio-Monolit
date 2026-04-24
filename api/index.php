<?php

// Suppress deprecated notices from vendor/framework files in production
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

// On Vercel, only /tmp is writable. Create required Laravel directories there.
$storagePath = '/tmp/storage';
$dirs = [
    $storagePath . '/framework/cache/data',
    $storagePath . '/framework/sessions',
    $storagePath . '/framework/views',
    $storagePath . '/logs',
    $storagePath . '/app/public',
];
foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Tell Laravel to use /tmp/storage as the storage path
$_ENV['APP_STORAGE'] = $storagePath;
$_SERVER['APP_STORAGE'] = $storagePath;

require __DIR__ . '/../public/index.php';
