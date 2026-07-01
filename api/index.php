<?php
// bootstrap/cache/*.php is generated during Vercel's build phase with
// build-time absolute paths that differ from runtime paths.
// Delete them so Laravel always rediscovers providers fresh at runtime.
$cacheDir = __DIR__ . '/../bootstrap/cache';
foreach (['packages.php', 'services.php'] as $file) {
    $path = $cacheDir . '/' . $file;
    if (file_exists($path)) {
        @unlink($path);
    }
}

// Create required writable dirs in /tmp before Laravel boots.
// Only on Vercel (runtime root = /var/task).
if (is_dir('/var/task')) {
    $dirs = [
        '/tmp/storage/framework/views',
        '/tmp/storage/framework/cache/data',
        '/tmp/storage/framework/sessions',
        '/tmp/storage/logs',
    ];
    foreach ($dirs as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
    }
}

require __DIR__ . '/../public/index.php';
