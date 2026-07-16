<?php

namespace App\Support;

class HtmlSanitizer
{
    /**
     * Balises autorisées pour le contenu riche saisi par les admins et affiché
     * sans échappement ({!! !!}) sur les pages publiques (service/projet/produit).
     */
    private const ALLOWED_TAGS = '<p><br><strong><b><em><i><u><ul><ol><li><h2><h3><h4><blockquote><a>';

    /**
     * Retire les balises non autorisées, les gestionnaires d'événements
     * (onclick, onerror, ...) et les URLs javascript:/data: sur les liens.
     */
    public static function sanitize(?string $html): ?string
    {
        if ($html === null || $html === '') {
            return $html;
        }

        $clean = strip_tags($html, self::ALLOWED_TAGS);

        // Supprime tout attribut on*="..." ou on*='...'
        $clean = preg_replace('/\s+on[a-z]+\s*=\s*("[^"]*"|\'[^\']*\')/i', '', $clean) ?? $clean;

        // Neutralise les href/src pointant vers javascript: ou data:
        $clean = preg_replace_callback(
            '/\s(href|src)\s*=\s*("([^"]*)"|\'([^\']*)\')/i',
            function (array $m) {
                $value = $m[3] !== '' ? $m[3] : $m[4];
                if (preg_match('/^\s*(javascript|data):/i', $value)) {
                    return '';
                }
                return $m[0];
            },
            $clean
        ) ?? $clean;

        return $clean;
    }
}
