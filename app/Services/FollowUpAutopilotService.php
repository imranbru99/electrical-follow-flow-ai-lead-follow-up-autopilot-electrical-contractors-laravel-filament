<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\Escalation;
use App\Models\FollowUp;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * MVP: intake trigger → AI draft → human approval → send/audit log.
 */
class FollowUpAutopilotService
{
    public function __construct(
        protected AiHubService $ai,
        protected ConsentService $consent,
        protected ModuleService $modules,
        protected DrutogotiSpeedService $speed,
    ) {}

    public function intakeAndDraft(Lead $lead, string $channel = 'email', ?User $actor = null): FollowUp
    {
        $this->speed->mark('followup.intake');

        $draft = $this->ai->draftFollowUp($lead, $channel);
        $consentOk = $this->consent->hasActiveConsent($lead, $channel);

        $followUp = FollowUp::query()->create([
            'lead_id' => $lead->id,
            'created_by' => $actor?->id ?? Auth::id(),
            'channel' => $channel,
            'status' => $consentOk ? 'pending_approval' : 'blocked',
            'subject' => $draft['subject'],
            'body' => $draft['body'],
            'ai_generated' => true,
            'ai_classification' => $draft['classification'],
            'ai_confidence' => $draft['confidence'],
            'consent_checked' => true,
            'consent_ok' => $consentOk,
            'block_reason' => $consentOk ? null : "No active {$channel} consent for this lead.",
            'scheduled_at' => now()->addMinutes(15),
        ]);

        $this->audit('follow_up.drafted', $followUp, [
            'channel' => $channel,
            'consent_ok' => $consentOk,
            'classification' => $draft['classification'],
        ], $actor);

        return $followUp;
    }

    public function approve(FollowUp $followUp, User $approver): FollowUp
    {
        if (! $followUp->consent_ok) {
            $followUp->update([
                'status' => 'blocked',
                'block_reason' => 'Cannot approve without messaging consent.',
            ]);

            $this->audit('follow_up.blocked', $followUp, ['reason' => 'missing_consent'], $approver);

            return $followUp->fresh();
        }

        $followUp->update([
            'status' => 'approved',
            'approved_by' => $approver->id,
            'approved_at' => now(),
        ]);

        $this->audit('follow_up.approved', $followUp, [], $approver);

        return $followUp->fresh();
    }

    public function send(FollowUp $followUp, ?User $actor = null): FollowUp
    {
        if ($followUp->status !== 'approved') {
            $followUp->update([
                'status' => 'failed',
                'block_reason' => 'Follow-up must be approved before send.',
            ]);

            return $followUp->fresh();
        }

        if (! $this->consent->hasActiveConsent($followUp->lead, $followUp->channel)) {
            $followUp->update([
                'status' => 'blocked',
                'consent_ok' => false,
                'block_reason' => 'Consent revoked before send.',
            ]);
            $this->audit('follow_up.blocked', $followUp, ['reason' => 'consent_revoked'], $actor);

            return $followUp->fresh();
        }

        $followUp->update([
            'status' => 'sent',
            'sent_at' => now(),
        ]);

        $followUp->lead->update(['last_contacted_at' => now(), 'status' => 'contacted']);

        $this->audit('follow_up.sent', $followUp, ['channel' => $followUp->channel], $actor);

        return $followUp->fresh();
    }

    public function handleInboundReply(Lead $lead, string $reply, ?FollowUp $followUp = null, ?User $actor = null): ?Escalation
    {
        $result = $this->ai->classifyReply($reply);

        if ($result['label'] === 'opt_out') {
            foreach (['sms', 'email', 'voice'] as $channel) {
                $this->consent->revoke($lead, $channel);
            }
            $this->audit('consent.revoked_via_reply', $lead, ['reply' => $reply], $actor);

            return null;
        }

        if (! ($result['escalate'] ?? false)) {
            $this->audit('reply.classified', $lead, $result, $actor);

            return null;
        }

        $staff = User::query()->whereIn('role', [User::ROLE_OWNER, User::ROLE_STAFF, User::ROLE_ADMIN])->first();

        $escalation = Escalation::query()->create([
            'lead_id' => $lead->id,
            'follow_up_id' => $followUp?->id,
            'assigned_to' => $staff?->id,
            'reason' => 'Qualified hot reply detected by AI',
            'priority' => 'high',
            'status' => 'open',
            'reply_excerpt' => mb_substr($reply, 0, 500),
        ]);

        $lead->update(['qualification' => 'qualified', 'status' => 'hot']);
        $this->audit('escalation.created', $escalation, $result, $actor);

        return $escalation;
    }

    protected function audit(string $action, mixed $model, array $payload = [], ?User $actor = null): void
    {
        if (! $this->modules->enabled('audit_log')) {
            return;
        }

        AuditLog::query()->create([
            'user_id' => $actor?->id ?? Auth::id(),
            'action' => $action,
            'auditable_type' => $model::class,
            'auditable_id' => $model->id ?? null,
            'payload' => $payload,
            'ip_address' => request()?->ip(),
        ]);
    }
}
