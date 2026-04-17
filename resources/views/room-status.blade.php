@extends('layouts.app')

@section('content')
<<<<<<< HEAD
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
=======
<div class="shell page status-dashboard">
    <section class="panel status-hero">
        <div class="status-hero-copy">
            <p class="eyebrow">Room Management</p>
            <h2 class="section-title">Room Reservation Status</h2>
            <p class="page-intro">Monitor room capacity and update bookings for the selected date.</p>
        </div>

        @if(session('success'))
            <p class="status-pill success">{{ session('success') }}</p>
        @endif

        <form action="{{ route('room-status') }}" method="get" class="filter-bar status-filter-bar">
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
            $slotAvailability = collect($roomAvailability[$room->slug] ?? []);
            $openSlotCount = $slotAvailability->filter(fn ($available) => $available > 0)->count();
            $availableSpotCount = $slotAvailability->sum();
            if (str_contains($slug, 'fantasy') || str_contains($slug, 'hearth') || str_contains($slug, 'mythic')) {
                $roomIcon = 'castle';
            } elseif (str_contains($slug, 'sci') || str_contains($slug, 'orbit') || str_contains($slug, 'iron') || str_contains($slug, 'star') || str_contains($slug, 'clockwork')) {
                $roomIcon = 'orbit';
            } else {
                $roomIcon = 'leaf';
            }
        @endphp
        <article class="story-card room-status-card">
            <div class="room-card-head">
                <div class="story-icon" aria-hidden="true">
                    <i data-lucide="{{ $roomIcon }}"></i>
                </div>
                <span class="status-pill {{ $openSlotCount > 0 ? 'success' : 'danger' }}">
                    {{ $openSlotCount > 0 ? $openSlotCount . ' slots open' : 'Fully booked' }}
                </span>
            </div>
            <p class="story-meta">{{ $room->capacity }} players</p>
            <h3>{{ $room->name }}</h3>
            <p>{{ $room->description }}</p>

            <div class="availability-heading">
                <h4>Availability</h4>
                <span>{{ $availableSpotCount }} spots open</span>
            </div>
            <ul class="availability-list">
                @foreach($timeSlots as $timeSlot)
                    <li>
                        <span class="slot-time">{{ $timeSlot->label }}</span>
                        @if(($roomAvailability[$room->slug][$timeSlot->label] ?? 0) > 0)
                            <span class="slot-status is-open">{{ $roomAvailability[$room->slug][$timeSlot->label] }} spots open</span>
                        @else
                            <span class="slot-status is-full">Fully booked</span>
                        @endif
                    </li>
                @endforeach
            </ul>
>>>>>>> cab9cfdee1c177ab35c534b66d3680996e16d5fb
        </article>
        @endforeach
    </div>

    <section class="panel">
        <p class="eyebrow">Summary</p>
<<<<<<< HEAD
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

=======
        <h2 class="section-title">Status Summary</h2>
        <div class="stats-grid status-summary-grid">
            <article class="stat-card">
                <p class="stat-number">{{ $totalReservations }}</p>
                <h3>Total Reservations</h3>
            </article>
            <article class="stat-card">
                <p class="stat-number">{{ $pendingReservations }}</p>
                <h3>Pending Confirmation</h3>
            </article>
            <article class="stat-card">
                <p class="stat-number">{{ $confirmedReservations }}</p>
                <h3>Confirmed</h3>
            </article>
            <article class="stat-card">
                <p class="stat-number">{{ $availableRooms }}</p>
                <h3>Available Rooms</h3>
            </article>
        </div>
    </section>

    <section class="panel">
        <p class="eyebrow">Reservations</p>
        <h2 class="section-title">Staff Reservation List</h2>

        <div class="table-wrap status-table-wrap">
            <table class="data-table">
                <caption>Reservations for {{ $selectedDate }}</caption>
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
                            <td><span class="reservation-reference">{{ $reservation->confirmation_code }}</span></td>
                            <td><strong>{{ $reservation->customer_name }}</strong></td>
                            <td class="contact-stack">
                                <span>{{ $reservation->customer_email ?? 'N/A' }}</span>
                                <small>{{ $reservation->customer_phone ?? 'N/A' }}</small>
                            </td>
                            <td><strong>{{ $reservation->room_name }}</strong></td>
                            <td><span class="slot-time">{{ $reservation->time_slot_label }}</span></td>
                            <td><span class="status-pill {{ $reservation->status === 'cancelled' ? 'danger' : ($reservation->status === 'confirmed' ? 'success' : '') }}">{{ ucfirst($reservation->status) }}</span></td>
                            <td>HK$ {{ number_format($reservation->menu_total, 2) }}</td>
                            <td class="actions-cell">
                                @if($reservation->status !== 'confirmed')
                                    <form action="{{ route('room-status.update', $reservation) }}" method="post" class="inline-form">
                                        @csrf
                                        <input type="hidden" name="status" value="confirmed">
                                        <input type="hidden" name="date" value="{{ $selectedDate }}">
                                        <input type="hidden" name="room" value="{{ $selectedRoom }}">
                                        <input type="hidden" name="status_filter" value="{{ $selectedStatus }}">
                                        <button type="submit" class="btn btn-secondary btn-sm">Confirm</button>
                                    </form>
                                @endif
                                @if($reservation->status !== 'cancelled')
                                    <form action="{{ route('room-status.update', $reservation) }}" method="post" class="inline-form">
                                        @csrf
                                        <input type="hidden" name="status" value="cancelled">
                                        <input type="hidden" name="date" value="{{ $selectedDate }}">
                                        <input type="hidden" name="room" value="{{ $selectedRoom }}">
                                        <input type="hidden" name="status_filter" value="{{ $selectedStatus }}">
                                        <button type="submit" class="btn btn-outline btn-sm">Cancel</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="empty-table-state">No reservations match these filters.</td>
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
>>>>>>> cab9cfdee1c177ab35c534b66d3680996e16d5fb
@endsection
