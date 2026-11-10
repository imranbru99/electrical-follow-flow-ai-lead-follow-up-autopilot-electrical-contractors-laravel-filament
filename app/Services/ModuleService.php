<?php

namespace App\Services;

use App\Models\ModuleSetting;
use Illuminate\Support\Collection;

class ModuleService
{
    public function all(): Collection
    {
        $db = ModuleSetting::query()->get()->keyBy('key');
        $config = collect(config('modules', []));

        return $config->map(function (array $meta, string $key) use ($db) {
            $row = $db->get($key);

            return [
                'key' => $key,
                'label' => $row?->label ?? $meta['label'],
                'description' => $row?->description ?? ($meta['description'] ?? ''),
                'enabled' => $row ? (bool) $row->enabled : (bool) ($meta['enabled'] ?? false),
                'core' => $row ? (bool) $row->core : (bool) ($meta['core'] ?? false),
            ];
        })->values();
    }

    public function enabled(string $key): bool
    {
        return ModuleSetting::isEnabled($key);
    }

    public function syncFromConfig(): void
    {
        foreach (config('modules', []) as $key => $meta) {
            ModuleSetting::query()->updateOrCreate(
                ['key' => $key],
                [
                    'label' => $meta['label'],
                    'description' => $meta['description'] ?? null,
                    'enabled' => (bool) ($meta['enabled'] ?? false),
                    'core' => (bool) ($meta['core'] ?? false),
                ]
            );
        }
    }
}
