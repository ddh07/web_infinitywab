<?php

namespace App\Support;

use Mews\Purifier\Facades\Purifier;

class HtmlSanitizer
{
    /**
     * Nettoie une chaîne HTML pour la protéger contre les attaques XSS.
     * Utilise la bibliothèque HTML Purifier pour une sécurité robuste, en se basant
     * sur la configuration définie dans `config/purifier.php`.
     *
     * @param string|null $html Le code HTML à nettoyer.
     * @return string|null Le HTML nettoyé.
     */ 
    public static function sanitize(?string $html): ?string
    {
        if ($html === null) {
            return null;
        }
        // Utilise la configuration 'default' de config/purifier.php
        return Purifier::clean($html);
    }
}
