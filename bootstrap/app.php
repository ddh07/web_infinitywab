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
        // Reverse proxy (Dokploy, Traefik, etc.) : sans cela, les URLs générées par
        // asset() / @vite restent en http → contenu mixte et CSS bloqués en HTTPS.
        $middleware->trustProxies(at: '*');

        $middleware->validateCsrfTokens(except: [
            'api/admin/*',
        ]);

        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
