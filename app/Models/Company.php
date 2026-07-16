<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'description',
        'vision',
        'mission',
        'email',
        'phone',
        'address',
        'website',
        'founded_year',
        'employees_count',
        'social_links',
        'stats',
        'is_active'
    ];

    protected $casts = [
        'social_links' => 'array',
        'stats' => 'array',
        'is_active' => 'boolean',
        'founded_year' => 'integer',
        'employees_count' => 'integer'
    ];

    /**
     * Scope pour récupérer uniquement les entreprises actives
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Obtenir une statistique spécifique
     */
    public function getStat($key, $default = null)
    {
        $stats = $this->stats ?? [];
        return $stats[$key] ?? $default;
    }

    /**
     * Obtenir un lien social spécifique
     */
    public function getSocialLink($platform, $default = null)
    {
        $links = $this->social_links ?? [];
        return $links[$platform] ?? $default;
    }
}
