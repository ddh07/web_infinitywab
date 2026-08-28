<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Chemins toujours accessibles même en mode maintenance : l'admin doit pouvoir
     * se connecter et désactiver le mode depuis /admin/parametres sans jamais se
     * retrouver bloqué dehors par son propre réglage.
     */
    private const ALWAYS_ALLOWED_PREFIXES = [
        'admin',
        'api/admin',
        'login',
        'logout',
        'register',
        'password',
        'email/verify',
        'verify-email',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if (! Setting::get('maintenance_enabled')) {
            return $next($request);
        }

        if ($this->isAlwaysAllowed($request) || $request->user()?->is_admin) {
            return $next($request);
        }

        return response()->view('maintenance', [
            'message' => Setting::get('maintenance_message', "Nous améliorons actuellement le site. Merci de revenir un peu plus tard."),
        ], 503);
    }

    private function isAlwaysAllowed(Request $request): bool
    {
        foreach (self::ALWAYS_ALLOWED_PREFIXES as $prefix) {
            if ($request->is($prefix) || $request->is($prefix . '/*')) {
                return true;
            }
        }

        return false;
    }
}
