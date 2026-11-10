@extends('layouts.public')

@section('title', 'Features & Modules — ElectricalFollowFlow')
@section('meta_description', 'Toggleable modules for lead follow-up, consent, escalations, technicians, job tickets, AI hub, attendance, PDF, integrations.')

@section('content')
<section class="wrap section" style="padding-top:3rem;">
    <div class="eyebrow">Everything included</div>
    <h1 style="max-width:20ch;">Features & modular capabilities</h1>
    <p class="lede">ElectricalFollowFlow ships with every relevant module. Core sales and field modules start ON; niche integrations can stay OFF until your contractor enables them.</p>
</section>

<section class="wrap section">
    <div class="grid">
        @foreach($modules as $module)
            <div class="card">
                <span class="pill {{ $module['enabled'] ? 'on' : 'off' }}">{{ $module['enabled'] ? 'ON' : 'OFF' }}{{ $module['core'] ? ' · CORE' : '' }}</span>
                <h3>{{ $module['label'] }}</h3>
                <p>{{ $module['description'] }}</p>
            </div>
        @endforeach
    </div>
</section>

<section class="wrap section">
    <h2>Integrations roadmap</h2>
    <div class="grid" style="margin-top:1rem;">
        <div class="card"><h3>Jobber</h3><p>Sync clients and jobs when the Jobber module is enabled.</p></div>
        <div class="card"><h3>ServiceTitan</h3><p>Pull schedules and push tickets for larger shops.</p></div>
        <div class="card"><h3>QuickBooks</h3><p>Connect estimate-to-invoice handoff for finance.</p></div>
        <div class="card"><h3>Google Calendar</h3><p>Book estimate windows directly for owners/staff.</p></div>
    </div>
</section>
@endsection
