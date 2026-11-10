<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FollowUp extends Model
{
    protected $fillable = [
        'lead_id', 'created_by', 'approved_by', 'channel', 'status', 'subject', 'body',
        'ai_generated', 'ai_classification', 'ai_confidence', 'consent_checked', 'consent_ok',
        'scheduled_at', 'sent_at', 'approved_at', 'block_reason',
    ];

    protected function casts(): array
    {
        return [
            'ai_generated' => 'boolean',
            'consent_checked' => 'boolean',
            'consent_ok' => 'boolean',
            'ai_confidence' => 'decimal:2',
            'scheduled_at' => 'datetime',
            'sent_at' => 'datetime',
            'approved_at' => 'datetime',
        ];
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function escalations(): HasMany
    {
        return $this->hasMany(Escalation::class);
    }
}
