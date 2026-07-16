<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier si l'utilisateur est authentifié
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        $user = Auth::user();

        // Vérifier si l'utilisateur est admin (flag en base, avec fallback historique sur l'email)
        $isAdmin = (bool) ($user->is_admin ?? false) || ($user->email === 'admin@infinity-wab.bf');

        if (!$isAdmin) {
            return redirect()->route('home')->with('error', 'Accès non autorisé. Réservé aux administrateurs.');
        }

        return $next($request);
    }
}
