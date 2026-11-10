<?php

return [
    /*
    |--------------------------------------------------------------------------
    | ElectricalFollowFlow Feature Modules
    | Toggle modules per contractor business needs.
    |--------------------------------------------------------------------------
    */
    'lead_follow_up_autopilot' => [
        'enabled' => true,
        'label' => 'Lead Follow-Up Autopilot',
        'description' => 'Consent-aware AI follow-ups with human approval and audit trail.',
        'core' => true,
    ],
    'service_requests' => [
        'enabled' => true,
        'label' => 'Service Requests',
        'description' => 'Intake electrical service requests from web, phone, and partner systems.',
        'core' => true,
    ],
    'field_technicians' => [
        'enabled' => true,
        'label' => 'Field Technicians',
        'description' => 'Manage licensed electricians, skills, zones, and availability.',
        'core' => true,
    ],
    'job_tickets' => [
        'enabled' => true,
        'label' => 'Job Tickets',
        'description' => 'Dispatch, track, and close field job tickets.',
        'core' => true,
    ],
    'consent_compliance' => [
        'enabled' => true,
        'label' => 'Consent & Compliance',
        'description' => 'TCPA-style messaging consent, opt-in/out, and compliance locks.',
        'core' => true,
    ],
    'escalations' => [
        'enabled' => true,
        'label' => 'Qualified Reply Escalations',
        'description' => 'Escalate hot replies to owners and sales staff.',
        'core' => true,
    ],
    'audit_log' => [
        'enabled' => true,
        'label' => 'Audit Log',
        'description' => 'Immutable trail of AI drafts, approvals, and sends.',
        'core' => true,
    ],
    'ai_hub' => [
        'enabled' => true,
        'label' => 'AI Hub',
        'description' => 'Draft, classify, and extract follow-up content (local AI hub equivalent).',
        'core' => true,
    ],
    'ai_catalog' => [
        'enabled' => false,
        'label' => 'AI Catalog / Lead Enrichment',
        'description' => 'Scrape and enrich contractor lead context from public sources.',
        'core' => false,
    ],
    'attendance_hub' => [
        'enabled' => false,
        'label' => 'Technician Attendance Hub',
        'description' => 'Clock-in devices and field attendance for crews.',
        'core' => false,
    ],
    'unicode_pdf' => [
        'enabled' => true,
        'label' => 'Unicode PDF Reports',
        'description' => 'Generate follow-up and job PDF reports in any language.',
        'core' => false,
    ],
    'universal_slug' => [
        'enabled' => true,
        'label' => 'Universal Slug',
        'description' => 'Multilingual URL slugs for public pages and tickets.',
        'core' => false,
    ],
    'drutogoti_speed' => [
        'enabled' => true,
        'label' => 'Drutogoti Speed Layer',
        'description' => 'Fast response helpers and queue-friendly automation shortcuts.',
        'core' => false,
    ],
    'admin_panel_extras' => [
        'enabled' => true,
        'label' => 'Admin Panel Extras',
        'description' => 'Dashboard widgets, KPI cards, and ops shortcuts.',
        'core' => false,
    ],
    'integrations_jobber' => [
        'enabled' => false,
        'label' => 'Jobber Integration',
        'description' => 'Sync jobs and clients with Jobber.',
        'core' => false,
    ],
    'integrations_servicetitan' => [
        'enabled' => false,
        'label' => 'ServiceTitan Integration',
        'description' => 'Push tickets and pull schedule from ServiceTitan.',
        'core' => false,
    ],
    'integrations_quickbooks' => [
        'enabled' => false,
        'label' => 'QuickBooks Integration',
        'description' => 'Sync invoices and payments with QuickBooks.',
        'core' => false,
    ],
    'integrations_google_calendar' => [
        'enabled' => false,
        'label' => 'Google Calendar Integration',
        'description' => 'Book estimate windows on Google Calendar.',
        'core' => false,
    ],
    'customer_portal' => [
        'enabled' => true,
        'label' => 'Customer / Demo Portal',
        'description' => 'Lightweight portal for customers and demo stakeholders.',
        'core' => false,
    ],
];
