<?php

namespace App\Models;

use App\Support\HtmlSanitizer;
use App\Support\ImagePath;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'client',
        // Champs legacy présents en base (create_projects_table)
        'category',
        'status',
        'project_date',
        'technologies',
        'image',
        'completion_date',
        'project_url',
        'is_featured',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'order' => 'integer',
        'project_date' => 'date',
        'completion_date' => 'date',
        'technologies' => 'array',
    ];

    public function setContentAttribute(?string $value): void
    {
        $this->attributes['content'] = HtmlSanitizer::sanitize($value);
    }

    public function getCoverUrlAttribute(): string
    {
        return ImagePath::resolve($this->image, 'images/placeholder-project.jpg');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
