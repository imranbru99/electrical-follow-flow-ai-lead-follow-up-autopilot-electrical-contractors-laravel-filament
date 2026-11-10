<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Technician extends Model
{
    protected $fillable = [
        'user_id', 'name', 'email', 'phone', 'license_number', 'specialty', 'zone', 'status', 'licensed',
    ];

    protected function casts(): array
    {
        return [
            'licensed' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function jobTickets(): HasMany
    {
        return $this->hasMany(JobTicket::class);
    }

    public function attendanceLogs(): HasMany
    {
        return $this->hasMany(AttendanceLog::class);
    }
}
