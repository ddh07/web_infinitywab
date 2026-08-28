<?php

namespace App\Http\Controllers;

use App\Models\Setting;

class RobotsController extends Controller
{
    public function index()
    {
        $lines = ['User-agent: *'];

        if ((bool) Setting::get('seo_noindex')) {
            // Le site est en mode "ne pas indexer" (ex: environnement de recette) :
            // on bloque tout plutôt que de lister des exceptions qui n'ont plus de sens.
            $lines[] = 'Disallow: /';
        } else {
            $lines[] = 'Disallow: /admin';
            $lines[] = 'Disallow: /login';
            $lines[] = 'Disallow: /register';
            $lines[] = 'Disallow: /password';
            $lines[] = 'Disallow: /verify-email';
            $lines[] = 'Disallow: /email/verify';
            $lines[] = 'Disallow: /api';
            $lines[] = '';
            $lines[] = 'Sitemap: ' . route('sitemap');
        }

        return response(implode("\n", $lines) . "\n", 200)
            ->header('Content-Type', 'text/plain');
    }
}
