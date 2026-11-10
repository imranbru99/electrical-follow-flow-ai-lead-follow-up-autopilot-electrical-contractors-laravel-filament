<?php

namespace App\Services;

/** Local equivalent of imrandevbd/drutogoti — lightweight timing / speed helpers */
class DrutogotiSpeedService
{
    protected array $marks = [];

    public function mark(string $key): void
    {
        $this->marks[$key] = microtime(true);
    }

    public function elapsedMs(string $key): ?float
    {
        if (! isset($this->marks[$key])) {
            return null;
        }

        return round((microtime(true) - $this->marks[$key]) * 1000, 2);
    }

    public function snapshot(): array
    {
        return collect($this->marks)->map(fn ($t) => round((microtime(true) - $t) * 1000, 2))->all();
    }
}
