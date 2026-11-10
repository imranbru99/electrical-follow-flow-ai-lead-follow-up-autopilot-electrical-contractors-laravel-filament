<?php

namespace App\Services;

use App\Models\Lead;

/**
 * Local equivalent of imrandevbd/laravel-ai-hub — draft/classify/extract for electrical lead follow-ups.
 */
class AiHubService
{
    public function draftFollowUp(Lead $lead, string $channel = 'email'): array
    {
        $interest = $lead->service_interest ?: 'electrical service';
        $name = $lead->name;

        $subject = match ($channel) {
            'sms' => null,
            default => "Quick follow-up on your {$interest} request — ElectricalFollowFlow",
        };

        $body = match ($channel) {
            'sms' => "Hi {$name}, this is your electrical contractor following up on your {$interest} inquiry. Reply YES to book an estimate, or STOP to opt out.",
            default => "Hi {$name},\n\nThanks for reaching out about {$interest}. Our licensed electricians can help with panel upgrades, EV chargers, lighting, and emergency repairs.\n\nReply to this email or call us to schedule a convenient estimate window. If you prefer not to hear from us, reply STOP and we will remove you immediately.\n\n— Your ElectricalFollowFlow team",
        };

        $classification = $this->classifyLead($lead);

        return [
            'subject' => $subject,
            'body' => $body,
            'classification' => $classification['label'],
            'confidence' => $classification['confidence'],
        ];
    }

    public function classifyLead(Lead $lead): array
    {
        $text = strtolower(($lead->service_interest ?? '').' '.($lead->notes ?? '').' '.($lead->source ?? ''));

        if (str_contains($text, 'emergency') || str_contains($text, 'outage') || str_contains($text, 'sparking')) {
            return ['label' => 'urgent_qualified', 'confidence' => 96.5];
        }

        if (str_contains($text, 'ev') || str_contains($text, 'panel') || str_contains($text, 'rewire')) {
            return ['label' => 'high_value', 'confidence' => 91.0];
        }

        if (str_contains($text, 'quote') || str_contains($text, 'estimate')) {
            return ['label' => 'estimate_ready', 'confidence' => 88.0];
        }

        return ['label' => 'nurture', 'confidence' => 74.5];
    }

    public function classifyReply(string $reply): array
    {
        $text = strtolower($reply);

        if (preg_match('/\b(yes|interested|book|schedule|tomorrow|available)\b/', $text)) {
            return ['label' => 'qualified_hot', 'confidence' => 94.0, 'escalate' => true];
        }

        if (preg_match('/\b(stop|unsubscribe|remove|no)\b/', $text)) {
            return ['label' => 'opt_out', 'confidence' => 99.0, 'escalate' => false];
        }

        return ['label' => 'neutral', 'confidence' => 70.0, 'escalate' => false];
    }

    public function extractServiceSignals(string $text): array
    {
        $signals = [];
        foreach (['panel upgrade', 'EV charger', 'outlet', 'lighting', 'generator', 'rewire', 'inspection'] as $term) {
            if (stripos($text, $term) !== false) {
                $signals[] = $term;
            }
        }

        return $signals;
    }
}
