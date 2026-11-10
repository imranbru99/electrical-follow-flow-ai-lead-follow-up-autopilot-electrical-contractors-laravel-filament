<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobTicket extends Model
{
    protected $fillable = [
        'ticket_number', 'service_request_id', 'technician_id', 'lead_id',
        'title', 'notes', 'status', 'scheduled_for', 'completed_at', 'estimated_hours',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_for' => 'datetime',
            'completed_at' => 'datetime',
            'estimated_hours' => 'decimal:2',
        ];
    }

    public function serviceRequest(): BelongsTo
    {
        return $this->belongsTo(ServiceRequest::class);
    }

    public function technician(): BelongsTo
    {
        return $this->belongsTo(Technician::class);
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }
}
