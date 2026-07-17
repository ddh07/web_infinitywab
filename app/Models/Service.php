<?php

namespace App\Models;

use App\Support\HtmlSanitizer;
use App\Support\ImagePath;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Service extends Model
{
    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('footer.composer.data'));
        static::deleted(fn () => Cache::forget('footer.composer.data'));
    }

    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'icon',
        'image',
        'is_active',
        'is_featured',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'order' => 'integer',
    ];

    public function setContentAttribute(?string $value): void
    {
        $this->attributes['content'] = HtmlSanitizer::sanitize($value);
    }

    public function getCoverUrlAttribute(): string
    {
        return ImagePath::resolve($this->image, 'images/services/defaukt_services_img.png');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}
