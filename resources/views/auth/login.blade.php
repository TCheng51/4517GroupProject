@extends('layouts.app')

@section('content')
<div class="shell page">
    <section class="split-panel auth-panel">
        <div class="form-panel">
            <p class="eyebrow">Member Login</p>
            <h2 class="section-title">Sign in to reserve your next table.</h2>
            <p class="page-intro">Use your Fable membership to book themed rooms and manage your next visit.</p>

            <form action="{{ route('login.submit') }}" method="post">
                @csrf
                <div class="field-grid">
                    <div class="form-group form-span-2">
                        <label for="email">Email address</label>
                        <input type="email" id="email" name="email" required placeholder="your@email.com"
                               value="{{ old('email') }}"
                               autocomplete="email"
                               @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
                        @error('email')
                            <small id="email-error" class="text-danger" role="alert">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group form-span-2">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required placeholder="Enter your password"
                               autocomplete="current-password"
                               @error('password') aria-invalid="true" aria-describedby="password-error" @enderror>
                        @error('password')
                            <small id="password-error" class="text-danger" role="alert">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Enter Fable</button>
                    <p class="auth-switch">New here? <a href="{{ route('register') }}">Create a membership</a></p>
                </div>
            </form>
        </div>

        <aside class="side-panel">
            <div class="auth-note">
                <p class="story-meta">Before You Reserve</p>
                <h3>Your membership keeps the evening moving.</h3>
                <p>Choose the room that fits your game, review available times, and manage future bookings from one account.</p>
            </div>

            <ul class="auth-benefits" aria-label="Membership benefits">
                <li>Book themed rooms without re-entering contact details.</li>
                <li>Return to upcoming reservations when plans change.</li>
                <li>Keep cafe orders attached to each booking.</li>
            </ul>

            <div class="inline-links">
                <a href="{{ route('index') }}" class="btn btn-outline">Back Home</a>
            </div>
        </aside>
    </section>
</div>
@endsection
