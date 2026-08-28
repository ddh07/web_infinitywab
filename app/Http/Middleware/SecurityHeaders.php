<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        // Nonce cryptographique généré à chaque requête et partagé avec toutes les vues
        // Blade (via View::share, avant le rendu de la réponse) afin que les blocs
        // <script> inline puissent porter l'attribut nonce="{{ $cspNonce }}" et être
        // autorisés par la CSP sans recourir à 'unsafe-inline'.
        $nonce = base64_encode(random_bytes(16));
        View::share('cspNonce', $nonce);

        $response = $next($request);

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        if ($request->isSecure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        // script-src : plus de 'unsafe-inline', chaque <script> inline des vues Blade porte
        // désormais nonce="{{ $cspNonce }}" (généré ci-dessus, par requête).
        // style-src : 'unsafe-inline' est conservé car les attributs style="" inline dans
        // les vues ne peuvent pas porter de nonce (seuls <script> et <style> le peuvent) ;
        // une migration complète vers des classes CSS/Tailwind est un chantier séparé.
        // Google Tag Manager (voir config('services.gtm.container_id')) : le script de
        // chargement porte le même nonce que les autres <script> inline, et GTM le
        // propage automatiquement aux tags qu'il injecte ensuite (gtag.js, GA4...).
        // connect-src doit être explicite (sinon repli sur default-src 'self', qui
        // bloquerait les appels de mesure GA4) ; frame-src couvre l'iframe <noscript>.
        $response->headers->set(
            'Content-Security-Policy',
            "default-src 'self'; "
            . "script-src 'self' 'nonce-{$nonce}' https://www.googletagmanager.com https://challenges.cloudflare.com; "
            . "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; "
            . "font-src 'self' https://fonts.gstatic.com; "
            . "img-src 'self' data: https:; "
            . "connect-src 'self' https://www.googletagmanager.com https://www.google-analytics.com https://analytics.google.com https://challenges.cloudflare.com; "
            . "frame-src 'self' https://www.google.com https://www.googletagmanager.com https://challenges.cloudflare.com; "
            . "frame-ancestors 'self';"
        );

        return $response;
    }
}
