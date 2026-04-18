@extends('layouts.app')

@section('content')
<div class="shell page">

    {{-- Hero Section --}}
    <section class="panel">
        <p class="eyebrow">Member Account</p>
        <h2 class="section-title">Reservation History</h2>
        <p class="page-intro">Browse all your past and upcoming sessions at Fable. Use the filters to find a specific booking, or review your activity over time.</p>

        @if(session('success'))
            <p class="status-pill success">{{ session('success') }}</p>
        @endif
    </section>

    {{-- Summary Stats --}}
    <section class="panel">
        <p class="eyebrow">Overview</p>
        <h2 class="section-title">Your Booking Summary</h2>
        <div class="stats-grid">
            <article class="stat-card">
                <p class="stat-number">{{ $totalCount }}</p>
                <h3>Total Reservations</h3>
            </article>
            <article class="stat-card">
                <p class="stat-number">{{ $confirmedCount }}</p>
                <h3>Confirmed</h3>
            </article>
            <article class="stat-card">
                <p class="stat-number">{{ $pendingCount }}</p>
                <h3>Pending</h3>
            </article>
            <article class="stat-card">
                <p class="stat-number">{{ $cancelledCount }}</p>
                <h3>Cancelled</h3>
            </article>
        </div>
    </section>

    {{-- Filters --}}
    <section class="panel">
        <p class="eyebrow">Search &amp; Filter</p>
        <h2 class="section-title">Find a Reservation</h2>

        <form action="{{ route('reservation-history') }}" method="get" class="filter-bar">
            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status">
                    <option value="">All statuses</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div class="form-group">
                <label for="room">Room</label>
                <select id="room" name="room">
                    <option value="">All rooms</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->slug }}" {{ request('room') === $room->slug ? 'selected' : '' }}>
                            {{ $room->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="from">From</label>
                <input type="date" id="from" name="from" value="{{ request('from') }}">
            </div>

            <div class="form-group">
                <label for="to">To</label>
                <input type="date" id="to" name="to" value="{{ request('to') }}">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Apply Filters</button>
                <a href="{{ route('reservation-history') }}" class="btn btn-outline">Clear</a>
            </div>
        </form>
    </section>

    {{-- Results Table --}}
    <section class="panel">
        <p class="eyebrow">Results</p>
        <h2 class="section-title">Reservation Records</h2>

        <div class="table-wrap">
            <table class="data-table">
                <caption>Your reservation history at Fable</caption>
                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Room</th>
                        <th>Pre-order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservations as $reservation)
                        <tr>
                            <td>
                                <span class="reservation-reference">{{ $reservation->confirmation_code ?? '—' }}</span>
                            </td>
                            <td>
                                <strong>{{ optional($reservation->reservation_date)->format('Y-m-d') }}</strong>
                                @if($reservation->isUpcoming())
                                    <span class="status-pill success">Upcoming</span>
                                @endif
                            </td>
                            <td>{{ $reservation->time_slot_label }}</td>
                            <td><strong>{{ $reservation->room_name }}</strong></td>
                            <td>
                                @if($reservation->reservationMenuItems->isNotEmpty())
                                    {{ $reservation->reservationMenuItems->count() }}
                                    {{ Str::plural('item', $reservation->reservationMenuItems->count()) }}
                                    — HK$ {{ number_format($reservation->menu_total, 2) }}
                                @else
                                    <span class="story-meta">None</span>
                                @endif
                            </td>
                            <td>
                                <span class="status-pill {{ $reservation->status === 'cancelled' ? 'danger' : ($reservation->status === 'confirmed' ? 'success' : '') }}">
                                    {{ ucfirst($reservation->status) }}
                                </span>
                            </td>
                            <td>
                                @if($reservation->status !== 'cancelled' && $reservation->isUpcoming())
                                    <a href="{{ route('my-reservations.edit', $reservation) }}" class="btn btn-secondary btn-sm">Edit</a>
                                    <form action="{{ route('my-reservations.cancel', $reservation) }}" method="post" class="inline-form">
                                        @csrf
                                        <button type="submit" class="btn btn-outline btn-sm">Cancel</button>
                                    </form>
                                @else
                                    <span class="story-meta">Closed</span>
                                @endif
                            </td>
                        </tr>

                        {{-- Pre-order detail row --}}
                        @if($reservation->reservationMenuItems->isNotEmpty())
                            <tr>
                                <td colspan="7">
                                    <div class="menu-order-summary">
                                        <span class="story-meta">Pre-ordered:</span>
                                        @foreach($reservation->reservationMenuItems as $orderItem)
                                            <span class="tag-chip">
                                                {{ $orderItem->menuItem->name ?? 'Menu item' }} &times; {{ $orderItem->quantity }}
                                                (HK$ {{ number_format((float) $orderItem->line_total, 2) }})
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="7" class="empty-table-state">
                                No reservations match your filters. Try adjusting the criteria or book a new session.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-links">
            {{ $reservations->links() }}
        </div>
    </section>

    {{-- Info Cards --}}
    <section class="panel">
        <div class="cards-grid">
            <article class="info-box">
                <h3>Need to change a booking?</h3>
                <p>Use the Edit button on any upcoming reservation to update the room, date, or time slot. Changes return the booking to pending for staff to reconfirm.</p>
            </article>

            <article class="info-box">
                <h3>Cancellation policy</h3>
                <p>You may cancel any upcoming reservation before the session begins. Cancelled bookings remain visible in your history for reference.</p>
            </article>

            <article class="info-box">
                <h3>Contact Fable</h3>
                <p>Email: <a href="mailto:reservations@fabelcafe.com" class="contact-link">reservations@fabelcafe.com</a></p>
                <p>Phone: <a href="tel:+85212345678" class="contact-link">(852) 1234 5678</a></p>
            </article>
        </div>
    </section>

    {{-- Navigation Buttons --}}
    <section class="panel">
        <div class="navigation-buttons">
            <a href="{{ route('reservation') }}" class="btn btn-primary">Book a New Session</a>
            <a href="{{ route('my-reservations') }}" class="btn btn-outline">My Reservations</a>
            <a href="{{ route('index') }}" class="btn btn-outline">Back Home</a>
        </div>
    </section>

</div>
@endsection
