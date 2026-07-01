<?php
if (isset($_SERVER['VERCEL']) || isset($_ENV['VERCEL'])) {
    $storage = '/tmp/storage';
    $dirs = ['/framework/views', '/framework/cache', '/framework/sessions', '/logs'];
    foreach ($dirs as $dir) {
        if (!is_dir($storage . $dir)) {
            mkdir($storage . $dir, 0777, true);
        }
    }
}

// Forward Vercel requests to normal index.php
require __DIR__ . '/../public/index.php';
