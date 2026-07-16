<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Reverse proxy (Dokploy, Traefik, etc.) : sans cela, les URLs générées par
        // asset() / @vite restent en http → contenu mixte et CSS bloqués en HTTPS.
        // On fait confiance à tous les proxys pour Host/Port/Proto (topologie PaaS,
        // IP du proxy non fixe), mais PAS pour X-Forwarded-For : ce header est
        // client-spoofable et sert à journaliser l'IP réelle des visiteurs
        // (cf. Message::ip_address), donc on laisse Laravel utiliser l'IP de
        // connexion TCP réelle plutôt qu'un header falsifiable.
        $middleware->trustProxies(
            at: '*',
            headers: Request::HEADER_X_FORWARDED_HOST
                | Request::HEADER_X_FORWARDED_PORT
                | Request::HEADER_X_FORWARDED_PROTO,
        );

        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);

        $middleware->append(\App\Http\Middleware\SecurityHeaders::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
