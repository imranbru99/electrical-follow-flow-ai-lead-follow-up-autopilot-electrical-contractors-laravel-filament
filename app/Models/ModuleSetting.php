<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ModuleSetting extends Model
{
    protected $fillable = [
        'key', 'label', 'description', 'enabled', 'core',
    ];

    protected function casts(): array
    {
        return [
            'enabled' => 'boolean',
            'core' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('eff.modules'));
        static::deleted(fn () => Cache::forget('eff.modules'));
    }

    public static function isEnabled(string $key): bool
    {
        $modules = Cache::remember('eff.modules', 60, function () {
            return static::query()->pluck('enabled', 'key')->all();
        });

        if (array_key_exists($key, $modules)) {
            return (bool) $modules[$key];
        }

        return (bool) (config("modules.$key.enabled") ?? false);
    }
}
