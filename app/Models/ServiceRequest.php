<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceRequest extends Model
{
    protected $fillable = [
        'lead_id', 'reference', 'title', 'description', 'priority', 'status',
        'address', 'city', 'state', 'zip', 'service_type', 'requested_at',
    ];

    protected function casts(): array
    {
        return [
            'requested_at' => 'datetime',
        ];
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function jobTickets(): HasMany
    {
        return $this->hasMany(JobTicket::class);
    }
}
