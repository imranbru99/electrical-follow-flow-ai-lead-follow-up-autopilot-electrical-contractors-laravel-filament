<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsentRecord extends Model
{
    protected $fillable = [
        'lead_id', 'channel', 'granted', 'source', 'granted_at', 'revoked_at', 'evidence',
    ];

    protected function casts(): array
    {
        return [
            'granted' => 'boolean',
            'granted_at' => 'datetime',
            'revoked_at' => 'datetime',
        ];
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function isActive(): bool
    {
        return $this->granted && $this->revoked_at === null;
    }
}
