<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    protected $fillable = [
        'disk',
        'path',
        'thumbnail_path',
        'original_filename',
        'mime_type',
        'size',
        'type',
        'width',
        'height',
        'uploaded_by',
    ];

    protected $casts = [
        'size' => 'integer',
        'width' => 'integer',
        'height' => 'integer',
    ];

    protected $appends = [
        'url',
        'thumbnail_url',
    ];

    public function getUrlAttribute(): string
    {
        return $this->resolveDiskUrl($this->path);
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        if (!$this->thumbnail_path) {
            return null;
        }

        return $this->resolveDiskUrl($this->thumbnail_path);
    }

    /**
     * Storage::disk('public')->url() construit l'URL à partir de APP_URL (config
     * figée), qui ne correspond pas forcément à l'hôte réellement utilisé pour
     * accéder au site (proxy local, domaine de dev, etc.). On préfère asset(), qui
     * se cale dynamiquement sur la requête en cours — le même choix que fait déjà
     * App\Support\ImagePath pour les images héritées sous public/images.
     */
    private function resolveDiskUrl(string $path): string
    {
        if ($this->disk !== 'public') {
            return Storage::disk($this->disk)->url($path);
        }

        return asset('storage/' . ltrim($path, '/'));
    }

    public function scopeOfType($query, ?string $type)
    {
        if (!$type || $type === 'all') {
            return $query;
        }

        return $query->where('type', $type);
    }

    public function scopeSearch($query, ?string $term)
    {
        if (!$term) {
            return $query;
        }

        return $query->where('original_filename', 'like', '%' . $term . '%');
    }
}
