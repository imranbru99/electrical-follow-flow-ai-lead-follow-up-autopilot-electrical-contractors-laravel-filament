@extends('layouts.public')

@section('title', 'Pricing — ElectricalFollowFlow Pilot Plans')

@section('content')
<section class="wrap section" style="padding-top:3rem;">
    <div class="eyebrow">Pilot pricing hypothesis</div>
    <h1>Simple plans for electrical shops</h1>
    <p class="lede">Target buyer: Electrical Contractors owner / operations lead. Pilot range $199–$799/mo.</p>
</section>

<section class="wrap section">
    <div class="grid">
        <div class="card">
            <h3>Pilot Starter — $199/mo</h3>
            <p>Lead follow-up autopilot, consent records, audit log, up to 3 users.</p>
        </div>
        <div class="card">
            <h3>Field Ops — $449/mo</h3>
            <p>Adds service requests, technicians, job tickets, escalations, PDF reports.</p>
        </div>
        <div class="card">
            <h3>Autopilot Pro — $799/mo</h3>
            <p>Full module suite, integration toggles, attendance hub, priority onboarding.</p>
        </div>
    </div>
</section>
@endsection
