@extends('layouts.app')

@section('content')
<div class="shell page">
    <section class="panel">
        <p class="eyebrow">Registration Guide</p>
        <h2 class="section-title">Almost ready to join Fable.</h2>
        <p class="page-intro">Finish the membership form, then we will create your account and issue your unique member number for future reservations.</p>
        <div class="cards-grid">
            <article class="info-box">
                <h3>What happens next</h3>
                <ul class="check-list">
                    <li>Your member profile is created with a four-digit member number.</li>
                    <li>You can sign in immediately and start reserving rooms.</li>
                    <li>Your future visits become faster and easier to manage.</li>
                </ul>
            </article>
            <article class="info-box">
                <h3>Have your details ready</h3>
                <p>We only need your name, contact details, and a secure password to open your place at the tavern.</p>
            </article>
            <article class="info-box">
                <h3>Next step</h3>
                <p>Review your information below and confirm to create your account.</p>
            </article>
        </div>

        @if(isset($registrationData))
        <div class="member-confirmation">
            <h3>Review Your Information</h3>
            <div class="detail-grid">
                <article class="detail-item">
                    <span>First Name</span>
                    <strong>{{ $registrationData['first_name'] ?? 'N/A' }}</strong>
                </article>
                <article class="detail-item">
                    <span>Last Name</span>
                    <strong>{{ $registrationData['last_name'] ?? 'N/A' }}</strong>
                </article>
                <article class="detail-item">
                    <span>Email</span>
                    <strong>{{ $registrationData['email'] ?? 'N/A' }}</strong>
                </article>
                <article class="detail-item">
                    <span>Phone</span>
                    <strong>{{ $registrationData['phone'] ?? 'N/A' }}</strong>
                </article>
                <article class="detail-item form-span-2">
                    <span>Address</span>
                    <strong>{{ $registrationData['address'] ?? 'N/A' }}</strong>
                </article>
            </div>

            <form action="{{ route('register.confirm.submit') }}" method="post" class="confirmation-form">
                @csrf
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Confirm & Create Account</button>
                    <a href="{{ route('register') }}" class="btn btn-secondary">Edit Information</a>
                </div>
            </form>
        </div>
        @endif

        <div class="navigation-buttons">
            <a href="{{ route('register') }}" class="btn btn-outline">Back to Registration</a>
            <a href="{{ route('index') }}" class="btn btn-outline">Back Home</a>
        </div>
    </section>
</div>
@endsection