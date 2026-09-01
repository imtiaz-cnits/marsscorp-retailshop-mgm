<?php

/**
 * Utility script to clear all Laravel route, config, cache, and view files on live hosting server.
 */

// Include Laravel Autoloader & Bootstrap
$bootstrapFile = __DIR__ . '/../bootstrap/app.php';
$autoloadFile  = __DIR__ . '/../vendor/autoload.php';

if (!file_exists($bootstrapFile) || !file_exists($autoloadFile)) {
    die("<h2 style='color:red;'>Error: Could not locate Laravel bootstrap or vendor directory.</h2>");
}

require $autoloadFile;
$app = require_once $bootstrapFile;

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

echo "<div style='font-family: Arial, sans-serif; padding: 30px; max-width: 600px; margin: 50px auto; border: 2px solid #10b981; border-radius: 12px; background: #f0fdf4;'>";
echo "<h2 style='color: #047857; margin-top: 0;'>⚡ MARSS CORPORATION Cache Cleaner</h2>";

try {
    // 1. Run Artisan Clear Commands
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    echo "<p style='color: #065f46;'>✔ Route Cache Cleared</p>";

    \Illuminate\Support\Facades\Artisan::call('config:clear');
    echo "<p style='color: #065f46;'>✔ Config Cache Cleared</p>";

    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    echo "<p style='color: #065f46;'>✔ Application Cache Cleared</p>";

    \Illuminate\Support\Facades\Artisan::call('view:clear');
    echo "<p style='color: #065f46;'>✔ View Cache Cleared</p>";

    // 2. Directly delete cache files if present
    $cacheFiles = [
        __DIR__ . '/../bootstrap/cache/routes-v7.php',
        __DIR__ . '/../bootstrap/cache/routes.php',
        __DIR__ . '/../bootstrap/cache/config.php',
        __DIR__ . '/../bootstrap/cache/services.php',
        __DIR__ . '/../bootstrap/cache/packages.php',
    ];

    foreach ($cacheFiles as $file) {
        if (file_exists($file)) {
            @unlink($file);
            echo "<p style='color: #065f46;'>✔ Removed cache file: " . basename($file) . "</p>";
        }
    }

    echo "<hr style='border: 0; border-top: 1px solid #a7f3d0; margin: 20px 0;'>";
    echo "<h3 style='color: #047857; margin-bottom: 10px;'>✅ All Live Server Caches Cleared Successfully!</h3>";
    echo "<p><a href='/' style='display: inline-block; padding: 10px 20px; background: #047857; color: white; text-decoration: none; border-radius: 6px; font-weight: bold;'>Return to Login Page</a></p>";
} catch (Exception $e) {
    echo "<h3 style='color: #dc2626;'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</h3>";
}

echo "</div>";
