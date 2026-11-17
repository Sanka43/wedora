<?php
// Standalone Cache Cleaner & OPcache Reset for Wedora cPanel / LiteSpeed Host
header('Content-Type: text/plain; charset=utf-8');

$expectedSecret = 'wedora_sec_9f48a1c73e04b68e21908bf';
$token = $_GET['token'] ?? $_POST['token'] ?? '';

if ($token !== $expectedSecret) {
    http_response_code(403);
    die("ERROR: Unauthorized access.\n");
}

$results = [];

// 1. Reset PHP OPcache immediately
if (function_exists('opcache_reset')) {
    $ok = @opcache_reset();
    $results[] = 'OPcache reset: ' . ($ok ? 'SUCCESS' : 'FAILED');
} else {
    $results[] = 'OPcache: extension not active or function disabled';
}

// 2. Clear Laravel Bootstrap Caches (routes, config, events, services)
$bootstrapCacheDir = realpath(__DIR__ . '/../bootstrap/cache');
if ($bootstrapCacheDir && is_dir($bootstrapCacheDir)) {
    $files = glob($bootstrapCacheDir . '/*.php');
    $deleted = 0;
    foreach ($files as $f) {
        if (@unlink($f)) $deleted++;
    }
    $results[] = "Bootstrap Cache: Deleted $deleted cached files from $bootstrapCacheDir";
}

// 3. Clear Compiled Blade Views
$viewCacheDir = realpath(__DIR__ . '/../storage/framework/views');
if ($viewCacheDir && is_dir($viewCacheDir)) {
    $files = glob($viewCacheDir . '/*.php');
    $deleted = 0;
    foreach ($files as $f) {
        if (@unlink($f)) $deleted++;
    }
    $results[] = "Blade Views: Deleted $deleted compiled view files from $viewCacheDir";
}

// 4. Run Laravel Artisan optimize:clear
try {
    if (file_exists(__DIR__ . '/../vendor/autoload.php') && file_exists(__DIR__ . '/../bootstrap/app.php')) {
        require_once __DIR__ . '/../vendor/autoload.php';
        $app = require_once __DIR__ . '/../bootstrap/app.php';
        $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
        $kernel->bootstrap();
        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
        $output = \Illuminate\Support\Facades\Artisan::output();
        $results[] = "Artisan optimize:clear: " . trim($output);
    }
} catch (\Throwable $e) {
    $results[] = "Artisan optimize:clear note: " . $e->getMessage();
}

$results[] = "TIMESTAMP: " . date('Y-m-d H:i:s T');
$results[] = "STATUS: Wedora Cache Cleared Successfully!";

echo implode("\n", $results) . "\n";
