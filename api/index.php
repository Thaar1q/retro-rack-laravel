<?php

// --- Static file passthrough ---
// vercel-php routes all requests here. Serve files from public/ directly
// without booting Laravel — faster and avoids 404s for CSS/JS/images.
$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$publicFile  = __DIR__ . '/../public' . $requestPath;

if ($requestPath !== '/' && is_file($publicFile)) {
    $ext  = strtolower(pathinfo($publicFile, PATHINFO_EXTENSION));
    $mime = [
        'css'   => 'text/css; charset=utf-8',
        'js'    => 'application/javascript; charset=utf-8',
        'ico'   => 'image/x-icon',
        'png'   => 'image/png',
        'jpg'   => 'image/jpeg',
        'jpeg'  => 'image/jpeg',
        'gif'   => 'image/gif',
        'svg'   => 'image/svg+xml',
        'woff'  => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf'   => 'font/ttf',
        'json'  => 'application/json',
        'txt'   => 'text/plain',
        'map'   => 'application/json',
    ][$ext] ?? 'application/octet-stream';

    header('Content-Type: ' . $mime);
    header('Cache-Control: public, max-age=31536000, immutable');
    readfile($publicFile);
    exit;
}

// --- Vercel /tmp setup ---
// /var/task filesystem is read-only. Bootstrap cache and storage must live in /tmp.
if (is_dir('/var/task')) {
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

    // providers.php must be readable from the /tmp bootstrap path.
    if (!file_exists('/tmp/bootstrap/providers.php')) {
        copy(__DIR__ . '/../bootstrap/providers.php', '/tmp/bootstrap/providers.php');
    }

    // Copy build-generated cache files so Laravel can read and update them.
    foreach (['packages.php', 'services.php'] as $file) {
        $src = __DIR__ . '/../bootstrap/cache/' . $file;
        $dst = '/tmp/bootstrap/cache/' . $file;
        if (!file_exists($dst) && file_exists($src)) {
            copy($src, $dst);
        }
    }

    // Runtime symlink: asset('storage/...') resolves to /tmp/storage/app/public.
    $link = __DIR__ . '/../public/storage';
    if (!file_exists($link) && !is_link($link)) {
        @symlink('/tmp/storage/app/public', $link);
    }
}

require __DIR__ . '/../public/index.php';
