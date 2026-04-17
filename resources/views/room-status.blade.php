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
                    <i data-lucide="castle"></i>
                @elseif($roomTheme === 'scifi')
                    <i data-lucide="orbit"></i>
                @else
                    <i data-lucide="leaf"></i>
                @endif
            </div>
            <p class="story-meta">{{ $roomInfo['capacity'] }} players</p>
            <h3>{{ $roomInfo['name'] }}</h3>
            <p>{{ $roomInfo['description'] }}</p>

            <h4>Availability Status</h4>
            <ul class="check-list">
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
            </ul>
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
