<?php

// On Vercel the runtime root is /var/task and the filesystem is read-only.
// All writable paths must live under /tmp which is ephemeral but writable.
if (is_dir('/var/task')) {
    // 1. Create all required writable directories in /tmp.
    $dirs = [
        '/tmp/storage/framework/views',
        '/tmp/storage/framework/cache/data',
        '/tmp/storage/framework/sessions',
        '/tmp/storage/logs',
        '/tmp/storage/app/public',
        '/tmp/storage/app/private',
    ];
    foreach ($dirs as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
    }

    // 2. Create a runtime symlink so asset('storage/...') URLs resolve.
    //    public/storage -> /tmp/storage/app/public
    $link = __DIR__ . '/../public/storage';
    if (!file_exists($link) && !is_link($link)) {
        @symlink('/tmp/storage/app/public', $link);
    }

    // 3. Remove bootstrap cache files that contain hardcoded build-time paths.
    //    These are regenerated fresh by Laravel on each cold boot.
    $cacheDir = __DIR__ . '/../bootstrap/cache';
    foreach (['packages.php', 'services.php'] as $file) {
        $path = $cacheDir . '/' . $file;
        if (file_exists($path)) {
            @unlink($path);
        }
    }
}

require __DIR__ . '/../public/index.php';
