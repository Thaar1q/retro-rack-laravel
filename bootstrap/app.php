<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
    })->create();

if (isset($_SERVER['VERCEL']) || isset($_ENV['VERCEL'])) {
    $app->useStoragePath('/tmp/storage');
    $_ENV['APP_SERVICES_CACHE'] = '/tmp/storage/framework/cache/services.php';
    $_ENV['APP_PACKAGES_CACHE'] = '/tmp/storage/framework/cache/packages.php';
    $_ENV['APP_CONFIG_CACHE'] = '/tmp/storage/framework/cache/config.php';
    $_ENV['APP_ROUTES_CACHE'] = '/tmp/storage/framework/cache/routes.php';
    $_ENV['APP_EVENTS_CACHE'] = '/tmp/storage/framework/cache/events.php';
}

return $app;
