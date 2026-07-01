<?php

if (is_dir('/var/task')) {
    // 1. Create all writable directories in /tmp.
    foreach ([
        '/tmp/bootstrap/cache',
        '/tmp/storage/framework/views',
        '/tmp/storage/framework/cache/data',
        '/tmp/storage/framework/sessions',
        '/tmp/storage/logs',
        '/tmp/storage/app/public',
        '/tmp/storage/app/private',
    ] as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
    }

    // 2. Copy bootstrap/providers.php to /tmp/bootstrap so that
    //    useBootstrapPath('/tmp/bootstrap') can find it.
    if (!file_exists('/tmp/bootstrap/providers.php')) {
        copy(__DIR__ . '/../bootstrap/providers.php', '/tmp/bootstrap/providers.php');
    }

    // 3. Copy build-generated cache files to /tmp (writable).
    //    These are created by buildCommand with correct /var/task paths.
    //    Laravel will update them in /tmp on subsequent boots.
    foreach (['packages.php', 'services.php'] as $file) {
        $src = __DIR__ . '/../bootstrap/cache/' . $file;
        $dst = '/tmp/bootstrap/cache/' . $file;
        if (!file_exists($dst) && file_exists($src)) {
            copy($src, $dst);
        }
    }

    // 4. Create public/storage symlink so asset('storage/...') URLs resolve.
    $link = __DIR__ . '/../public/storage';
    if (!file_exists($link) && !is_link($link)) {
        @symlink('/tmp/storage/app/public', $link);
    }
}

require __DIR__ . '/../public/index.php';
