<?php

namespace App\Services;

use App\Models\Lead;

/** Local equivalent of imrandevbd/laravel-ai-catalog — enrichment stubs */
class AiCatalogService
{
    public function enrichLead(Lead $lead): array
    {
        $signals = app(AiHubService::class)->extractServiceSignals(($lead->notes ?? '').' '.($lead->service_interest ?? ''));

        return [
            'lead_id' => $lead->id,
            'suggested_tags' => $signals ?: ['general-electrical'],
            'market_hint' => 'Residential / light commercial electrical services',
            'recommended_next_step' => 'Consent-aware follow-up within 15 minutes',
        ];
    }
}
