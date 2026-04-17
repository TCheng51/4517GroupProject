@extends('layouts.app')

@section('content')
<div class="shell page">
    <section class="panel">
        <p class="eyebrow">Member Reservations</p>
        <h2 class="section-title">My Reservations</h2>
        <p class="page-intro">Review upcoming and past sessions, update pending plans, or cancel a booking before the visit.</p>

        @if(session('success'))
            <p class="status-pill success">{{ session('success') }}</p>
        @endif
    </section>

    <section class="panel">
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Room</th>
                        <th>Status</th>
                        <th>Pre-order</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservations as $reservation)
                        <tr>
                            <td>{{ $reservation->confirmation_code }}</td>
                            <td>{{ optional($reservation->reservation_date)->format('Y-m-d') }}</td>
                            <td>{{ $reservation->time_slot_label }}</td>
                            <td>{{ $reservation->room_name }}</td>
                            <td><span class="status-pill {{ $reservation->status === 'cancelled' ? 'danger' : ($reservation->status === 'confirmed' ? 'success' : '') }}">{{ ucfirst($reservation->status) }}</span></td>
                            <td>HK$ {{ number_format($reservation->menu_total, 2) }}</td>
                            <td>
                                @if($reservation->status !== 'cancelled' && $reservation->isUpcoming())
                                    <a href="{{ route('my-reservations.edit', $reservation) }}" class="btn btn-secondary">Edit</a>
                                    <form action="{{ route('my-reservations.cancel', $reservation) }}" method="post" class="inline-form">
                                        @csrf
                                        <button type="submit" class="btn btn-outline">Cancel</button>
                                    </form>
                                @else
                                    <span class="story-meta">Closed</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No reservations yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-links">
            {{ $reservations->links() }}
        </div>
    </section>
</div>
@endsection
