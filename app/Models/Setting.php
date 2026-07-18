<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value_type',
        'value',
        'autoload',
    ];

    protected function casts(): array
    {
        return [
            'value_type' => 'string',
            'autoload' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saved(fn (Setting $setting) => Cache::forget("setting.{$setting->key}"));
        static::deleted(fn (Setting $setting) => Cache::forget("setting.{$setting->key}"));
    }

    public static function value(string $key, ?string $default = null): ?string
    {
        return Cache::rememberForever("setting.{$key}", fn () => static::query()
            ->where('key', $key)
            ->value('value') ?? $default);
    }
}
