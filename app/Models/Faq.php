<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'question',
        'answer',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    // Les réponses FAQ sont du texte brut affiché via {{ }} (échappé automatiquement) :
    // pas besoin/pas de risque XSS à sanitiser du HTML ici, contrairement aux champs
    // "content" riches (Service, Project...) rendus avec {!! !!}.

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}
