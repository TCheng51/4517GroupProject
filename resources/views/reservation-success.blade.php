@extends('layouts.app')

@section('content')
<div class="shell page">
    <section class="panel">
        <span class="status-pill success">
            <i data-lucide="calendar-check" aria-hidden="true"></i>
            Reservation Confirmed
        </span>
        <h2 class="section-title">Your table at Fable has been set.</h2>
        <p class="page-intro">We are ready to host your group with the room, atmosphere, and service that fits your session.</p>

        @if(session('email_simulated'))
            <p class="status-pill success">{{ session('email_simulated') }}</p>
        @endif

        <div class="detail-grid">
            <article class="detail-item">
                <span>Booking Reference</span>
                <strong>{{ $reservation->confirmation_code ?? 'N/A' }}</strong>
            </article>
            <article class="detail-item">
                <span>Date</span>
                <strong>{{ optional($reservation->reservation_date)->format('Y-m-d') ?? 'N/A' }}</strong>
            </article>
            <article class="detail-item">
                <span>Time Slot</span>
                <strong>{{ $reservation->time_slot_label ?? 'N/A' }}</strong>
            </article>
            <article class="detail-item">
                <span>Story Room</span>
                <strong>{{ $reservation->room_name ?? 'N/A' }}</strong>
            </article>
            @if($reservation->is_guest)
            <article class="detail-item">
                <span>Guest Name</span>
                <strong>{{ $reservation->guest_name ?? 'N/A' }}</strong>
            </article>
            <article class="detail-item">
                <span>Guest Email</span>
                <strong>{{ $reservation->guest_email ?? 'N/A' }}</strong>
            </article>
            <article class="detail-item">
                <span>Guest Phone</span>
                <strong>{{ $reservation->guest_phone ?? 'N/A' }}</strong>
            </article>
            @endif
        </div>

        @if($reservation->reservationMenuItems->isNotEmpty())
        <section class="info-box">
            <h3>Pre-order Estimate</h3>
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservation->reservationMenuItems as $orderItem)
                            <tr>
                                <td>{{ $orderItem->menuItem->name ?? 'Menu item' }}</td>
                                <td>{{ $orderItem->quantity }}</td>
                                <td>HK$ {{ number_format((float) $orderItem->line_total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <p class="story-meta">Estimated total: HK$ {{ number_format($reservation->menu_total, 2) }}</p>
        </section>
        @endif

        <div class="cards-grid">
            <article class="info-box">
                <h3>Before you arrive</h3>
                <ul class="check-list">
                    <li>Plan to arrive around 10 minutes early.</li>
                    @if($reservation->is_guest)
                    <li>Have your reservation confirmation ready for check-in.</li>
                    @else
                    <li>Have your member details ready for check-in.</li>
                    @endif
                    <li>Bring the boardgame you booked the room around, or explore the cafe library on site.</li>
                </ul>
            </article>

            <article class="info-box">
                <h3>Need to update plans?</h3>
                <p>For changes to your booking, contact the cafe before the session so we can help rework the evening smoothly.</p>
            </article>

            <article class="info-box">
                <h3>Contact Fable</h3>
                <p>Email: reservations@fabelcafe.com</p>
                <p>Phone: (852) 1234 5678</p>
            </article>
        </div>

        <div class="navigation-buttons">
            <a href="{{ route('reservation') }}" class="btn btn-primary">Book Another Session</a>
            @auth
                <a href="{{ route('my-reservations') }}" class="btn btn-outline">My Reservations</a>
            @endauth
            <a href="{{ route('index') }}" class="btn btn-outline">Back Home</a>
        </div>
    </section>
</div>
@endsection
