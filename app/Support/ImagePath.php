<?php

namespace App\Support;

class ImagePath
{
    /**
     * Résout un chemin d'image stocké en base (relatif ou non préfixé par
     * "images/") vers une URL publique, avec repli sur $fallback si le
     * fichier n'existe pas réellement sur le disque.
     */
    public static function resolve(?string $path, string $fallback): string
    {
        if (!$path) {
            return asset($fallback);
        }

        $normalized = ltrim($path, '/');
        if (!str_starts_with($normalized, 'images/')) {
            $normalized = 'images/' . $normalized;
        }

        return file_exists(public_path($normalized)) ? asset($normalized) : asset($fallback);
    }
}
