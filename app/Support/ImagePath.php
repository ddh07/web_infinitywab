<?php

namespace App\Support;
use Illuminate\Support\Facades\Cache;

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

        // Fichiers choisis via la bibliothèque de médias (App\Support\ImagePath ne les
        // gère pas via public_path('images/...') : ce sont des URLs déjà résolues vers
        // le disque "public" de Laravel) — on les retourne telles quelles.
        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }
        if (str_starts_with(ltrim($path, '/'), 'storage/')) {
            return asset(ltrim($path, '/'));
        }

        $normalized = ltrim($path, '/');
        if (!str_starts_with($normalized, 'images/')) {
            $normalized = 'images/' . $normalized;
        }

        // Le cache évite les appels `file_exists` répétés sur le disque, ce qui peut
        // améliorer les performances sur les pages avec beaucoup d'images.
        $key = 'image_path_exists_' . md5($normalized);
        $duration = config('app.debug') ? 1 : 3600; // 1 seconde en dev, 1 heure en prod

        $exists = Cache::remember($key, $duration, fn() => file_exists(public_path($normalized)));

        return $exists ? asset($normalized) : asset($fallback);
    }
}
