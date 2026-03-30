@extends('layouts.app')

@section('content')
<div class="shell page">
    <section class="panel">
        <span class="status-pill success">Reservation Confirmed</span>
        <h2 class="section-title">Your table at Fabel has been set.</h2>
        <p class="page-intro">We are ready to host your group with the room, atmosphere, and service that fits your session.</p>

        <div class="detail-grid">
            <article class="detail-item">
                <span>Reservation ID</span>
                <strong>{{ $reservation->id ?? 'N/A' }}</strong>
            </article>
            <article class="detail-item">
                <span>Date</span>
                <strong>{{ $reservation->reservation_date ?? 'N/A' }}</strong>
            </article>
            <article class="detail-item">
                <span>Time Slot</span>
                <strong>{{ $reservation->time_slot ?? 'N/A' }}</strong>
            </article>
            <article class="detail-item">
                <span>Story Room</span>
                <strong>{{ $reservation->table_room ?? 'N/A' }}</strong>
            </article>
        </div>

        <div class="cards-grid">
            <article class="info-box">
                <h3>Before you arrive</h3>
                <ul class="check-list">
                    <li>Plan to arrive around 10 minutes early.</li>
                    <li>Have your member details ready for check-in.</li>
                    <li>Bring the boardgame you booked the room around, or explore the cafe library on site.</li>
                </ul>
            </article>

            <article class="info-box">
                <h3>Need to update plans?</h3>
                <p>For changes to your booking, contact the cafe before the session so we can help rework the evening smoothly.</p>
            </article>

            <article class="info-box">
                <h3>Contact Fabel</h3>
                <p>Email: reservations@fabelcafe.com</p>
                <p>Phone: (852) 1234 5678</p>
            </article>
        </div>

        <div class="navigation-buttons">
            <a href="{{ route('reservation') }}" class="btn btn-primary">Book Another Session</a>
            <a href="{{ route('index') }}" class="btn btn-outline">Back Home</a>
        </div>
    </section>
</div>
@endsection
