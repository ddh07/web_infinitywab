<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use League\CommonMark\CommonMarkConverter;

class LegalDocument extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'format',
        'body',
        'media_id',
    ];

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function isMarkdown(): bool
    {
        return $this->format === 'markdown';
    }

    public function isPdf(): bool
    {
        return $this->format === 'pdf';
    }

    public function fileUrl(): ?string
    {
        return $this->media?->url;
    }

    public function renderedHtml(): string
    {
        if (! $this->isMarkdown() || ! $this->body) {
            return '';
        }

        static $converter;
        $converter ??= new CommonMarkConverter([
            'html_input' => 'strip', // le HTML brut dans un .md importé n'est pas exécuté
            'allow_unsafe_links' => false,
        ]);

        return (string) $converter->convert($this->body);
    }
}
