<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Réglages système modifiables depuis l'admin (onglet Paramètres) sans passer par
 * .env : intégrations tierces (GTM, GA4) et configuration email. Les variables
 * d'infrastructure (APP_KEY, DB_*, APP_ENV...) restent volontairement hors de ce
 * système — voir AppServiceProvider::boot() pour la fusion avec la config Laravel.
 */
class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    protected $casts = [
        'value' => 'encrypted',
    ];

    protected static function booted(): void
    {
        static::saved(fn (Setting $setting) => Cache::forget("setting.{$setting->key}"));
        static::deleted(fn (Setting $setting) => Cache::forget("setting.{$setting->key}"));
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::rememberForever("setting.{$key}", function () use ($key, $default) {
            $row = static::where('key', $key)->first();

            return $row && $row->value !== null && $row->value !== '' ? $row->value : $default;
        });
    }

    public static function set(string $key, ?string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public static function has(string $key): bool
    {
        return filled(static::get($key));
    }
}
