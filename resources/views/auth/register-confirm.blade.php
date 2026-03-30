@extends('layouts.app')

@section('content')
<div class="shell page">
    <section class="panel">
        <p class="eyebrow">Registration Guide</p>
        <h2 class="section-title">Almost ready to join Fabel.</h2>
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
                <p>Return to the membership form to complete sign-up and move into the reservation flow.</p>
            </article>
        </div>
        <div class="navigation-buttons">
            <a href="{{ route('register') }}" class="btn btn-primary">Open Registration Form</a>
            <a href="{{ route('index') }}" class="btn btn-outline">Back Home</a>
        </div>
    </section>
</div>
@endsection
