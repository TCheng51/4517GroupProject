@extends('layouts.app')

@section('content')
<div class="shell page">
    <section class="panel">
        <p class="eyebrow">Room Management</p>
        <h2 class="section-title">Coffee Shop Room Reservation Status</h2>
        <p class="page-intro">View and manage the current reservation status for all themed rooms at Fabel.</p>
    </section>

    <div class="room-grid">
        @foreach($roomThemes as $roomTheme => $roomInfo)
        <article class="story-card">
            <div class="story-icon" aria-hidden="true">
                @if($roomTheme === 'fantasy')
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 20V9l6-5 6 5v11" />
                        <path d="M9.5 20v-6h5v6" />
                    </svg>
                @elseif($roomTheme === 'scifi')
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="3.5" />
                        <path d="M19.5 12h1.5" />
                        <path d="M3 12h1.5" />
                        <path d="M12 3v1.5" />
                        <path d="M12 19.5V21" />
                        <path d="m17.3 6.7 1 1" />
                        <path d="m5.7 18.3 1 1" />
                        <path d="m18.3 18.3-1 1" />
                        <path d="m6.7 6.7-1 1" />
                    </svg>
                @else
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 18c2.5-4.5 5-6.5 7-6.5S16.5 13.5 19 18" />
                        <path d="M12 11.5V4" />
                        <path d="m9 7 3-3 3 3" />
                    </svg>
                @endif
            </div>
            <p class="story-meta">{{ $roomInfo['capacity'] }} players</p>
            <h3>{{ $roomInfo['name'] }}</h3>
            <p>{{ $roomInfo['description'] }}</p>

            <div class="check-list">
                <h4>Availability Status</h4>
                @foreach($timeSlots as $slot)
                    <li>
                        <strong>{{ $slot }}</strong>
                        @if(isset($roomAvailability[$roomTheme][$slot]) && $roomAvailability[$roomTheme][$slot] > 0)
                            <span class="status-pill success">Available ({{ $roomAvailability[$roomTheme][$slot] }} spots)</span>
                        @else
                            <span class="status-pill danger">Fully Booked</span>
                        @endif
                    </li>
                @endforeach
            </div>
        </article>
        @endforeach
    </div>

    <section class="panel">
        <p class="eyebrow">Summary</p>
        <h2 class="section-title">Overall Status Summary</h2>
        <div class="stats-grid">
            <article class="stat-card">
                <h3>Total Reservations Today</h3>
                <p>{{ $totalReservations }}</p>
            </article>
            <article class="stat-card">
                <h3>Pending Confirmation</h3>
                <p>{{ $pendingReservations }}</p>
            </article>
            <article class="stat-card">
                <h3>Confirmed</h3>
                <p>{{ $confirmedReservations }}</p>
            </article>
            <article class="stat-card">
                <h3>Available Rooms</h3>
                <p>{{ $availableRooms }}</p>
            </article>
        </div>
    </section>
</div>

@endsection
