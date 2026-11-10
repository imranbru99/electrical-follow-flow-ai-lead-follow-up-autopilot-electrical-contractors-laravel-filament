<?php

namespace App\Services;

use App\Models\ConsentRecord;
use App\Models\Lead;

class ConsentService
{
    public function hasActiveConsent(Lead $lead, string $channel): bool
    {
        return ConsentRecord::query()
            ->where('lead_id', $lead->id)
            ->where('channel', $channel)
            ->where('granted', true)
            ->whereNull('revoked_at')
            ->exists();
    }

    public function grant(Lead $lead, string $channel, ?string $source = null, ?string $evidence = null): ConsentRecord
    {
        return ConsentRecord::query()->updateOrCreate(
            ['lead_id' => $lead->id, 'channel' => $channel],
            [
                'granted' => true,
                'source' => $source,
                'evidence' => $evidence,
                'granted_at' => now(),
                'revoked_at' => null,
            ]
        );
    }

    public function revoke(Lead $lead, string $channel): void
    {
        ConsentRecord::query()
            ->where('lead_id', $lead->id)
            ->where('channel', $channel)
            ->update([
                'granted' => false,
                'revoked_at' => now(),
            ]);
    }
}
