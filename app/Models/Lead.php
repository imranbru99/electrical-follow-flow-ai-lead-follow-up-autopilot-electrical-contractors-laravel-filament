<?php

namespace App\Models;

use App\Services\UniversalSlugService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lead extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'company', 'source', 'service_interest',
        'status', 'qualification', 'notes', 'slug', 'assigned_to', 'last_contacted_at',
    ];

    protected function casts(): array
    {
        return [
            'last_contacted_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Lead $lead) {
            if (blank($lead->slug)) {
                $lead->slug = app(UniversalSlugService::class)->unique(Lead::class, $lead->name);
            }
        });
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function consents(): HasMany
    {
        return $this->hasMany(ConsentRecord::class);
    }

    public function followUps(): HasMany
    {
        return $this->hasMany(FollowUp::class);
    }

    public function serviceRequests(): HasMany
    {
        return $this->hasMany(ServiceRequest::class);
    }

    public function escalations(): HasMany
    {
        return $this->hasMany(Escalation::class);
    }

    public function jobTickets(): HasMany
    {
        return $this->hasMany(JobTicket::class);
    }
}
