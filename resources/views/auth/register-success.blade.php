@extends('layouts.app')

@section('content')
<div class="shell page">
    <section class="panel">
<<<<<<< HEAD
        <span class="status-pill success">Membership Created</span>
        <h2 class="section-title">Your place at Fabel is ready.</h2>
        <p class="page-intro">You can now sign in, choose a story room, and plan your first tavern session.</p>

        <div class="detail-grid">
            <article class="detail-item">
                <span>Member Number</span>
                <strong>{{ $member->member_number ?? '0000' }}</strong>
            </article>
            <article class="detail-item">
                <span>Name</span>
                <strong>{{ trim(($member->first_name ?? '').' '.($member->last_name ?? '')) ?: 'New member' }}</strong>
            </article>
            <article class="detail-item">
                <span>Email</span>
                <strong>{{ $member->email ?? 'example@email.com' }}</strong>
            </article>
        </div>

=======
        <span class="status-pill success">
            <i data-lucide="check-circle-2" aria-hidden="true"></i>
            Membership Created
        </span>
        <h2 class="section-title">Your place at Fable is ready.</h2>
        <p class="page-intro">You can now sign in, choose a story room, and plan your first tavern session.</p>

        @if(session('email_simulated'))
            <p class="status-pill success">{{ session('email_simulated') }}</p>
        @endif

        <div class="detail-grid">
            <article class="detail-item">
                <span>Member Number</span>
                <strong>{{ $member->member_number ?? '0000' }}</strong>
            </article>
            <article class="detail-item">
                <span>Name</span>
                <strong>{{ trim(($member->first_name ?? '').' '.($member->last_name ?? '')) ?: 'New member' }}</strong>
            </article>
            <article class="detail-item">
                <span>Email</span>
                <strong>{{ $member->email ?? 'example@email.com' }}</strong>
            </article>
        </div>

>>>>>>> cab9cfdee1c177ab35c534b66d3680996e16d5fb
        <div class="navigation-buttons">
            <a href="{{ route('login') }}" class="btn btn-primary">Login Now</a>
            <a href="{{ route('reservation') }}" class="btn btn-outline">View Reservation Options</a>
        </div>
    </section>
</div>
@endsection
