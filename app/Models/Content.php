<?php

namespace App\Models;

use App\Support\HtmlSanitizer;
use App\Support\ImagePath;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Content extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'type',
        'status',
        'author_id',
        'published_at',
        'meta_title',
        'meta_description',
        'featured_image',
        'is_featured',
        'order'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'order' => 'integer'
    ];

    public function setContentAttribute(?string $value): void
    {
        $this->attributes['content'] = HtmlSanitizer::sanitize($value);
    }

    public function getFeaturedImageUrlAttribute(): string
    {
        return ImagePath::resolve($this->featured_image, 'images/placeholder-project.jpg');
    }

    /**
     * Scope pour récupérer uniquement le contenu publié
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope pour récupérer le contenu par type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope pour récupérer le contenu en vedette
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Relation avec l'auteur
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Générer automatiquement le slug depuis le titre
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($content) {
            if (!$content->slug) {
                $content->slug = Str::slug($content->title);
            }
        });

        static::updating(function ($content) {
            if ($content->isDirty('title') && !$content->isDirty('slug')) {
                $content->slug = Str::slug($content->title);
            }
        });
    }
}
