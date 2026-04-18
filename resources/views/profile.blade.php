@extends('layouts.app')

@section('content')
<div class="shell page">

    {{-- Hero --}}
    <section class="panel">
        <p class="eyebrow">Member Account</p>
        <h2 class="section-title">Your Profile</h2>
        <p class="page-intro">Review and update your personal details, or change your password. Your member number and reservation history stay linked to this account.</p>

        @if(session('success'))
            <p class="status-pill success">
                <i data-lucide="check-circle" aria-hidden="true"></i>
                {{ session('success') }}
            </p>
        @endif
    </section>

    {{-- Account Summary --}}
    <section class="panel">
        <p class="eyebrow">Account Overview</p>
        <h2 class="section-title">Membership Details</h2>

        <div class="detail-grid">
            <article class="detail-item">
                <span>Member Number</span>
                <strong>{{ $member->member_number ?? '—' }}</strong>
            </article>
            <article class="detail-item">
                <span>Member Since</span>
                <strong>{{ $member->created_at?->format('F j, Y') ?? '—' }}</strong>
            </article>
            <article class="detail-item">
                <span>Account Type</span>
                <strong>{{ $member->is_admin ? 'Staff / Admin' : 'Member' }}</strong>
            </article>
        </div>

        <div class="stats-grid">
            <article class="stat-card">
                <p class="stat-number">{{ $totalReservations }}</p>
                <h3>Total Reservations</h3>
            </article>
            <article class="stat-card">
                <p class="stat-number">{{ $upcomingReservations }}</p>
                <h3>Upcoming</h3>
            </article>
            <article class="stat-card">
                <p class="stat-number">{{ $cancelledReservations }}</p>
                <h3>Cancelled</h3>
            </article>
        </div>
    </section>

    {{-- Edit Form --}}
    <section class="split-panel">
        <div class="form-panel">
            <p class="eyebrow">Edit Profile</p>
            <h2 class="section-title">Update your information.</h2>
            <p class="page-intro">Changes to your name, email, phone, or address take effect immediately.</p>

            <form action="{{ route('profile.update') }}" method="post" id="profile-form">
                @csrf
                @method('PATCH')

                <div class="field-grid">
                    <div class="form-group">
                        <label for="first_name">First name</label>
                        <input type="text" id="first_name" name="first_name" required
                               value="{{ old('first_name', $member->first_name) }}"
                               autocomplete="given-name"
                               @error('first_name') aria-invalid="true" aria-describedby="first_name-error" @enderror>
                        @error('first_name')
                            <small id="first_name-error" class="text-danger" role="alert">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="last_name">Last name</label>
                        <input type="text" id="last_name" name="last_name" required
                               value="{{ old('last_name', $member->last_name) }}"
                               autocomplete="family-name"
                               @error('last_name') aria-invalid="true" aria-describedby="last_name-error" @enderror>
                        @error('last_name')
                            <small id="last_name-error" class="text-danger" role="alert">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group form-span-2">
                        <label for="email">Email address</label>
                        <input type="email" id="email" name="email" required
                               value="{{ old('email', $member->email) }}"
                               autocomplete="email"
                               @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
                        @error('email')
                            <small id="email-error" class="text-danger" role="alert">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone number</label>
                        <input type="tel" id="phone" name="phone" required
                               value="{{ old('phone', $member->phone) }}"
                               autocomplete="tel" inputmode="tel"
                               @error('phone') aria-invalid="true" aria-describedby="phone-error" @enderror>
                        @error('phone')
                            <small id="phone-error" class="text-danger" role="alert">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="address">Mailing address</label>
                        <input type="text" id="address" name="address" required
                               value="{{ old('address', $member->address) }}"
                               autocomplete="street-address"
                               @error('address') aria-invalid="true" aria-describedby="address-error" @enderror>
                        @error('address')
                            <small id="address-error" class="text-danger" role="alert">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                {{-- Password Change Section --}}
                <section class="menu-order">
                    <p class="eyebrow">Security</p>
                    <h3>Change password</h3>
                    <p class="form-hint">Leave these fields blank to keep your current password.</p>

                    <div class="field-grid">
                        <div class="form-group">
                            <label for="current_password">Current password</label>
                            <input type="password" id="current_password" name="current_password"
                                   autocomplete="current-password"
                                   @error('current_password') aria-invalid="true" aria-describedby="current_password-error" @enderror>
                            @error('current_password')
                                <small id="current_password-error" class="text-danger" role="alert">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">New password</label>
                            <input type="password" id="password" name="password"
                                   autocomplete="new-password"
                                   @error('password') aria-invalid="true" aria-describedby="password-error" @enderror>
                            @error('password')
                                <small id="password-error" class="text-danger" role="alert">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group form-span-2">
                            <label for="password_confirmation">Confirm new password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   autocomplete="new-password">
                        </div>
                    </div>
                </section>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a href="{{ route('profile') }}" class="btn btn-outline">Discard</a>
                </div>
            </form>
        </div>

        <aside class="side-panel">
            <article class="table-preview">
                <span class="preview-badge">Account</span>
                <h3>{{ $member->first_name }} {{ $member->last_name }}</h3>
                <p>Member #{{ $member->member_number ?? '—' }} since {{ $member->created_at?->format('M Y') }}.</p>
                <p class="story-meta">{{ $member->email }}</p>
                <p>{{ $member->phone }}</p>
            </article>

            <article class="info-box">
                <p class="story-meta">Quick Links</p>
                <ul class="check-list">
                    <li><a href="{{ route('my-reservations') }}">View your upcoming reservations</a></li>
                    <li><a href="{{ route('reservation-history') }}">Browse full reservation history</a></li>
                    <li><a href="{{ route('reservation') }}">Book a new session</a></li>
                </ul>
            </article>

            <article class="info-box">
                <h3>Account Security</h3>
                <p>Your password is stored securely using bcrypt hashing. Fable staff cannot see or recover your password. If you forget it, use the login page to request a reset.</p>
            </article>
        </aside>
    </section>

    {{-- Info Cards --}}
    <section class="panel">
        <div class="cards-grid">
            <article class="info-box">
                <h3>Why keep details current?</h3>
                <p>Your email receives reservation confirmations, changes, and cancellation notices. An outdated address or phone number may delay communication about your session.</p>
            </article>

            <article class="info-box">
                <h3>Email changes</h3>
                <p>Updating your email here changes the address used for login and all future correspondence. Make sure you have access to the new inbox before saving.</p>
            </article>

            <article class="info-box">
                <h3>Need help?</h3>
                <p>Email: <a href="mailto:reservations@fabelcafe.com" class="contact-link">reservations@fabelcafe.com</a></p>
                <p>Phone: <a href="tel:+85212345678" class="contact-link">(852) 1234 5678</a></p>
            </article>
        </div>
    </section>

    {{-- Bottom Navigation --}}
    <section class="panel">
        <div class="navigation-buttons">
            <a href="{{ route('reservation') }}" class="btn btn-primary">Book a Session</a>
            <a href="{{ route('my-reservations') }}" class="btn btn-outline">My Reservations</a>
            <a href="{{ route('index') }}" class="btn btn-outline">Back Home</a>
        </div>
    </section>

</div>
@endsection
