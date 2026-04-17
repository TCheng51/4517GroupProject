@extends('layouts.app')

@section('content')
<div class="shell page">
    <section class="panel">
        <p class="eyebrow">Room Management</p>
        <h2 class="section-title">Coffee Shop Room Reservation Status</h2>
        <p class="page-intro">View room availability and manage reservations for the selected day.</p>

        @if(session('success'))
            <p class="status-pill success">{{ session('success') }}</p>
        @endif

        <form action="{{ route('room-status') }}" method="get" class="filter-bar">
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" id="date" name="date" value="{{ $selectedDate }}">
            </div>
            <div class="form-group">
                <label for="room">Room</label>
                <select id="room" name="room">
                    <option value="">All rooms</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->slug }}" {{ $selectedRoom === $room->slug ? 'selected' : '' }}>
                            {{ $room->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status">
                    <option value="">All statuses</option>
                    <option value="pending" {{ $selectedStatus === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ $selectedStatus === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="cancelled" {{ $selectedStatus === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Apply Filters</button>
                <a href="{{ route('room-status') }}" class="btn btn-outline">Today</a>
            </div>
        </form>
    </section>

    <div class="room-grid">
        @foreach($rooms as $room)
        @php
            $slug = strtolower($room->slug ?? '');
            if (str_contains($slug, 'fantasy') || str_contains($slug, 'hearth') || str_contains($slug, 'mythic')) {
                $roomIcon = 'castle';
            } elseif (str_contains($slug, 'sci') || str_contains($slug, 'orbit') || str_contains($slug, 'iron') || str_contains($slug, 'star') || str_contains($slug, 'clockwork')) {
                $roomIcon = 'orbit';
            } else {
                $roomIcon = 'leaf';
            }
        @endphp
        <article class="story-card">
            <div class="story-icon" aria-hidden="true">
                <i data-lucide="{{ $roomIcon }}"></i>
            </div>
            <p class="story-meta">{{ $room->capacity }} players</p>
            <h3>{{ $room->name }}</h3>
            <p>{{ $room->description }}</p>

            <h4>Availability Status</h4>
            <ul class="check-list">
                @foreach($timeSlots as $timeSlot)
                    <li>
                        <strong>{{ $timeSlot->label }}</strong>
                        @if(($roomAvailability[$room->slug][$timeSlot->label] ?? 0) > 0)
                            <span class="status-pill success">Available ({{ $roomAvailability[$room->slug][$timeSlot->label] }} spots)</span>
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
        <h2 class="section-title">Status Summary</h2>
        <div class="stats-grid">
            <article class="stat-card">
                <h3>Total Reservations</h3>
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

    <section class="panel">
        <p class="eyebrow">Reservations</p>
        <h2 class="section-title">Staff Reservation List</h2>

        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Customer</th>
                        <th>Contact</th>
                        <th>Room</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Pre-order</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($todayReservations as $reservation)
                        <tr>
                            <td>{{ $reservation->confirmation_code }}</td>
                            <td>{{ $reservation->customer_name }}</td>
                            <td>
                                <span>{{ $reservation->customer_email ?? 'N/A' }}</span>
                                <small>{{ $reservation->customer_phone ?? 'N/A' }}</small>
                            </td>
                            <td>{{ $reservation->room_name }}</td>
                            <td>{{ $reservation->time_slot_label }}</td>
                            <td><span class="status-pill {{ $reservation->status === 'cancelled' ? 'danger' : ($reservation->status === 'confirmed' ? 'success' : '') }}">{{ ucfirst($reservation->status) }}</span></td>
                            <td>HK$ {{ number_format($reservation->menu_total, 2) }}</td>
                            <td>
                                @if($reservation->status !== 'confirmed')
                                    <form action="{{ route('room-status.update', $reservation) }}" method="post" class="inline-form">
                                        @csrf
                                        <input type="hidden" name="status" value="confirmed">
                                        <input type="hidden" name="date" value="{{ $selectedDate }}">
                                        <input type="hidden" name="room" value="{{ $selectedRoom }}">
                                        <button type="submit" class="btn btn-secondary">Confirm</button>
                                    </form>
                                @endif
                                @if($reservation->status !== 'cancelled')
                                    <form action="{{ route('room-status.update', $reservation) }}" method="post" class="inline-form">
                                        @csrf
                                        <input type="hidden" name="status" value="cancelled">
                                        <input type="hidden" name="date" value="{{ $selectedDate }}">
                                        <input type="hidden" name="room" value="{{ $selectedRoom }}">
                                        <button type="submit" class="btn btn-outline">Cancel</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">No reservations match these filters.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-links">
            {{ $todayReservations->links() }}
        </div>
    </section>
</div>
@endsection
