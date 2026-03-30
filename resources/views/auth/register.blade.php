@extends('layouts.app')

@section('content')
<div class="shell page">
    <section class="split-panel">
        <div class="form-panel">
            <p class="eyebrow">Membership</p>
            <h2 class="section-title">Join Fabel and start reserving story-led tables.</h2>
            <p class="page-intro">Create your member account to unlock reservations, smoother check-in, and a regular place at the tavern.</p>

            <form action="{{ route('register.store') }}" method="post">
                @csrf
                <div class="field-grid">
                    <div class="form-group">
                        <label for="last_name">Last name</label>
                        <input type="text" id="last_name" name="last_name" required placeholder="Chan" value="{{ old('last_name') }}">
                        @error('last_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="first_name">First name</label>
                        <input type="text" id="first_name" name="first_name" required placeholder="Alex" value="{{ old('first_name') }}">
                        @error('first_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group form-span-2">
                        <label for="address">Mailing address</label>
                        <input type="text" id="address" name="address" required placeholder="Flat, building, street, district" value="{{ old('address') }}">
                        @error('address')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">Contact phone</label>
                        <input type="tel" id="phone" name="phone" required placeholder="12345678" value="{{ old('phone') }}">
                        @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" id="email" name="email" required placeholder="your@email.com" value="{{ old('email') }}">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required placeholder="Choose a secure password" minlength="8">
                        <small class="form-hint">Use at least 8 characters.</small>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Repeat your password">
                        @error('password_confirmation')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Create Membership</button>
                    <button type="reset" class="btn btn-secondary">Clear Form</button>
                </div>
            </form>
        </div>

        <aside class="side-panel">
            <article class="info-box">
                <p class="story-meta">Member Benefits</p>
                <h3>What your Fabel account unlocks</h3>
                <ul class="check-list">
                    <li>Reserve specific story rooms for the atmosphere that suits your game.</li>
                    <li>Return faster for future visits with your member number already on file.</li>
                    <li>Move from sign-up to reservation in one smooth flow.</li>
                </ul>
            </article>

            <article class="info-box">
                <p class="story-meta">Best For</p>
                <h3>Groups who plan their evenings around the game.</h3>
                <p>Whether you are hosting a first visit or a regular campaign night, membership keeps your next session easy to book.</p>
            </article>

            <div class="inline-links">
                <a href="{{ route('index') }}" class="btn btn-outline">Back Home</a>
                <a href="{{ route('login') }}" class="btn btn-outline">Already A Member</a>
            </div>
        </aside>
    </section>
</div>
@endsection
