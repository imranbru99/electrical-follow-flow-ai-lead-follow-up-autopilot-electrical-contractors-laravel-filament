<?php

namespace App\Services;

use Illuminate\Support\Str;

/** Local equivalent of imrandevbd/laravel-universal-slug */
class UniversalSlugService
{
    public function make(string $value): string
    {
        $slug = Str::slug($value);
        if ($slug === '') {
            $slug = 'item-'.substr(md5($value), 0, 8);
        }

        return $slug;
    }

    public function unique(string $modelClass, string $value, string $column = 'slug'): string
    {
        $base = $this->make($value);
        $slug = $base;
        $i = 1;

        while ($modelClass::query()->where($column, $slug)->exists()) {
            $slug = $base.'-'.$i;
            $i++;
        }

        return $slug;
    }
}
