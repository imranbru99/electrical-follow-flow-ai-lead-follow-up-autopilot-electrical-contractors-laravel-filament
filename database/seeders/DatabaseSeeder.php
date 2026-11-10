<?php

namespace Database\Seeders;

use App\Models\ConsentRecord;
use App\Models\Escalation;
use App\Models\FollowUp;
use App\Models\JobTicket;
use App\Models\Lead;
use App\Models\ServiceRequest;
use App\Models\Technician;
use App\Models\User;
use App\Services\FollowUpAutopilotService;
use App\Services\ModuleService;
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        app(ModuleService::class)->syncFromConfig();

        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@electricalfollowflow.test'],
            [
                'name' => 'Demo Admin',
                'password' => 'password',
                'role' => User::ROLE_ADMIN,
                'phone' => '555-0100',
                'title' => 'Platform Admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $owner = User::query()->updateOrCreate(
            ['email' => 'owner@electricalfollowflow.test'],
            [
                'name' => 'Alex Rivera',
                'password' => 'password',
                'role' => User::ROLE_OWNER,
                'phone' => '555-0101',
                'title' => 'Contractor Owner',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $staff = User::query()->updateOrCreate(
            ['email' => 'staff@electricalfollowflow.test'],
            [
                'name' => 'Jordan Lee',
                'password' => 'password',
                'role' => User::ROLE_STAFF,
                'phone' => '555-0102',
                'title' => 'Ops Lead',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $techUser = User::query()->updateOrCreate(
            ['email' => 'tech@electricalfollowflow.test'],
            [
                'name' => 'Sam Ortiz',
                'password' => 'password',
                'role' => User::ROLE_TECHNICIAN,
                'phone' => '555-0103',
                'title' => 'Licensed Electrician',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'customer@electricalfollowflow.test'],
            [
                'name' => 'Casey Morgan',
                'password' => 'password',
                'role' => User::ROLE_CUSTOMER,
                'phone' => '555-0104',
                'title' => 'Homeowner',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $tech = Technician::query()->updateOrCreate(
            ['email' => 'tech@electricalfollowflow.test'],
            [
                'user_id' => $techUser->id,
                'name' => 'Sam Ortiz',
                'phone' => '555-0103',
                'license_number' => 'EL-44219',
                'specialty' => 'Panel upgrades & EV chargers',
                'zone' => 'North Metro',
                'status' => 'available',
                'licensed' => true,
            ]
        );

        Technician::query()->updateOrCreate(
            ['email' => 'tech2@electricalfollowflow.test'],
            [
                'name' => 'Riley Chen',
                'phone' => '555-0105',
                'license_number' => 'EL-55102',
                'specialty' => 'Commercial lighting',
                'zone' => 'South Metro',
                'status' => 'on_job',
                'licensed' => true,
            ]
        );

        $lead1 = Lead::query()->updateOrCreate(
            ['email' => 'pat.homeowner@example.com'],
            [
                'name' => 'Pat Homeowner',
                'phone' => '555-2001',
                'company' => null,
                'source' => 'web',
                'service_interest' => 'EV charger install',
                'status' => 'new',
                'qualification' => 'unqualified',
                'notes' => 'Wants Level 2 EV charger in garage. Asked for estimate.',
                'assigned_to' => $staff->id,
            ]
        );

        $lead2 = Lead::query()->updateOrCreate(
            ['email' => 'facility@acme-shops.test'],
            [
                'name' => 'Acme Facility Manager',
                'phone' => '555-2002',
                'company' => 'Acme Shops',
                'source' => 'referral',
                'service_interest' => 'Emergency panel sparking',
                'status' => 'hot',
                'qualification' => 'qualified',
                'notes' => 'Emergency outage risk — sparking panel.',
                'assigned_to' => $owner->id,
            ]
        );

        $lead3 = Lead::query()->updateOrCreate(
            ['email' => 'lighting@retailpark.test'],
            [
                'name' => 'Retail Park Lighting Lead',
                'phone' => '555-2003',
                'company' => 'Retail Park LLC',
                'source' => 'partner',
                'service_interest' => 'Parking lot lighting upgrade',
                'status' => 'contacted',
                'qualification' => 'nurture',
                'notes' => 'Quote requested for LED retrofit.',
                'assigned_to' => $staff->id,
            ]
        );

        foreach ([$lead1, $lead2, $lead3] as $lead) {
            ConsentRecord::query()->updateOrCreate(
                ['lead_id' => $lead->id, 'channel' => 'email'],
                [
                    'granted' => true,
                    'source' => 'web_form_checkbox',
                    'granted_at' => now()->subDays(2),
                    'evidence' => 'Checked SMS/email consent on intake form.',
                ]
            );
        }

        ConsentRecord::query()->updateOrCreate(
            ['lead_id' => $lead1->id, 'channel' => 'sms'],
            [
                'granted' => true,
                'source' => 'web_form_checkbox',
                'granted_at' => now()->subDays(2),
                'evidence' => 'SMS opt-in captured.',
            ]
        );

        $sr1 = ServiceRequest::query()->updateOrCreate(
            ['reference' => 'SR-1001'],
            [
                'lead_id' => $lead1->id,
                'title' => 'Level 2 EV charger install',
                'description' => 'Garage circuit assessment and charger mount.',
                'priority' => 'normal',
                'status' => 'open',
                'address' => '12 Maple Ave',
                'city' => 'Austin',
                'state' => 'TX',
                'zip' => '78701',
                'service_type' => 'EV charger',
                'requested_at' => now()->subDay(),
            ]
        );

        ServiceRequest::query()->updateOrCreate(
            ['reference' => 'SR-1002'],
            [
                'lead_id' => $lead2->id,
                'title' => 'Emergency panel inspection',
                'description' => 'Sparking main panel — safety priority.',
                'priority' => 'emergency',
                'status' => 'scheduled',
                'address' => '800 Industrial Blvd',
                'city' => 'Austin',
                'state' => 'TX',
                'zip' => '78745',
                'service_type' => 'Panel repair',
                'requested_at' => now()->subHours(6),
            ]
        );

        JobTicket::query()->updateOrCreate(
            ['ticket_number' => 'JT-5001'],
            [
                'service_request_id' => $sr1->id,
                'technician_id' => $tech->id,
                'lead_id' => $lead1->id,
                'title' => 'EV charger site survey',
                'notes' => 'Confirm panel capacity and breaker space.',
                'status' => 'scheduled',
                'scheduled_for' => now()->addDay()->setHour(10),
                'estimated_hours' => 2.5,
            ]
        );

        JobTicket::query()->updateOrCreate(
            ['ticket_number' => 'JT-5002'],
            [
                'technician_id' => $tech->id,
                'lead_id' => $lead2->id,
                'title' => 'Emergency panel triage',
                'notes' => 'Lockout/tagout and temporary safety measures.',
                'status' => 'en_route',
                'scheduled_for' => now()->addHours(1),
                'estimated_hours' => 3.0,
            ]
        );

        if (FollowUp::query()->count() === 0) {
            $autopilot = app(FollowUpAutopilotService::class);
            $fu1 = $autopilot->intakeAndDraft($lead1, 'email', $staff);
            $autopilot->approve($fu1, $owner);
            $autopilot->send($fu1->fresh(), $staff);

            $fu2 = $autopilot->intakeAndDraft($lead2, 'email', $staff);
            $autopilot->handleInboundReply($lead2, 'Yes, please book tomorrow morning for the panel.', $fu2, $staff);

            $autopilot->intakeAndDraft($lead3, 'sms', $staff);
        }

        if (Escalation::query()->where('status', 'open')->count() === 0) {
            Escalation::query()->create([
                'lead_id' => $lead2->id,
                'assigned_to' => $owner->id,
                'reason' => 'Emergency qualified reply — same-day dispatch needed',
                'priority' => 'critical',
                'status' => 'open',
                'reply_excerpt' => 'Please come today — panel is sparking.',
            ]);
        }

        unset($admin);
    }
}
