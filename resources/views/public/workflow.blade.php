@extends('layouts.public')

@section('title', 'Lead Follow-Up Workflow — ElectricalFollowFlow')

@section('content')
<section class="wrap section" style="padding-top:3rem;">
    <div class="eyebrow">Sales operations</div>
    <h1 style="max-width:18ch;">Lead Follow-Up Autopilot workflow</h1>
    <p class="lede">Rank #5 USA opportunity: generate and send consent-aware follow-ups; escalate qualified replies to staff; operate on service requests, field technicians and job tickets.</p>
</section>

<section class="wrap section">
    <div class="steps">
        <div class="step"><div class="num">1</div><div><h3>Intake trigger</h3><p class="lede" style="margin:0;">Web lead, referral, or service request creates a tracked opportunity.</p></div></div>
        <div class="step"><div class="num">2</div><div><h3>AI draft + classify</h3><p class="lede" style="margin:0;">AI Hub drafts channel-specific copy and scores urgency (EV charger, panel, emergency).</p></div></div>
        <div class="step"><div class="num">3</div><div><h3>Consent gate</h3><p class="lede" style="margin:0;">Messages without active SMS/email consent are blocked with reason codes.</p></div></div>
        <div class="step"><div class="num">4</div><div><h3>Human approval</h3><p class="lede" style="margin:0;">Owner/staff review and approve before any send.</p></div></div>
        <div class="step"><div class="num">5</div><div><h3>Send + audit</h3><p class="lede" style="margin:0;">Approved messages send and write an immutable audit entry.</p></div></div>
        <div class="step"><div class="num">6</div><div><h3>Escalate hot replies</h3><p class="lede" style="margin:0;">Qualified replies create high-priority escalations for sales staff.</p></div></div>
    </div>
</section>
@endsection
