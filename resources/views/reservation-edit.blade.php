@extends('layouts.app')

@section('content')
<div class="shell page">
    <section class="split-panel">
        <div class="form-panel">
            <p class="eyebrow">Update Reservation</p>
            <h2 class="section-title">Adjust your upcoming session.</h2>
            <p class="page-intro">Changing the room, date, or time returns the booking to pending so staff can reconfirm it.</p>

            <form action="{{ route('my-reservations.update', $reservation) }}" method="post" data-reservation-form data-availability-url="{{ route('reservation.availability') }}">
                @csrf
                @method('PATCH')

                <div class="field-grid">
                    <div class="form-group">
                        <label for="reservation_date">Reservation date</label>
                        <input type="date" id="reservation_date" name="reservation_date" data-reservation-date required
                               value="{{ old('reservation_date', optional($reservation->reservation_date)->format('Y-m-d')) }}"
                               @error('reservation_date') aria-invalid="true" aria-describedby="reservation_date-error" @enderror>
                        @error('reservation_date')
                            <small id="reservation_date-error" class="text-danger" role="alert">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="time_slot">Time slot</label>
                        <select id="time_slot" name="time_slot" required
                                @error('time_slot') aria-invalid="true" aria-describedby="time_slot-error" @enderror>
                            @foreach($timeSlots as $timeSlot)
                                <option value="{{ $timeSlot->label }}" {{ old('time_slot', $reservation->time_slot_label) == $timeSlot->label ? 'selected' : '' }}>
                                    {{ $timeSlot->label }}
                                </option>
                            @endforeach
                        </select>
                        @error('time_slot')
                            <small id="time_slot-error" class="text-danger" role="alert">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group form-span-2">
                        <label for="table_room">Table or room theme</label>
                        <select id="table_room" name="table_room" data-room-select required
                                @error('table_room') aria-invalid="true" aria-describedby="table_room-error" @enderror>
                            @foreach($rooms as $room)
                                <option
                                    value="{{ $room->slug }}"
                                    data-name="{{ $room->name }}"
                                    data-capacity="{{ $room->capacity }}"
                                    data-description="{{ $room->description }}"
                                    {{ old('table_room', $reservation->room?->slug ?? $reservation->table_room) == $room->slug ? 'selected' : '' }}
                                >
                                    {{ $room->name }} — {{ $room->capacity }} players
                                </option>
                            @endforeach
                        </select>
                        @error('table_room')
                            <small id="table_room-error" class="text-danger" role="alert">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <p class="availability-message" data-availability-message>Availability will update after choosing a date, time slot, and room.</p>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a href="{{ route('my-reservations') }}" class="btn btn-outline">Back</a>
                </div>
            </form>
        </div>

        <aside class="side-panel">
            <article class="table-preview">
                <span class="preview-badge">Room Preview</span>
                <h3 data-room-title>{{ $reservation->room_name }}</h3>
                <p data-room-mood>{{ $reservation->room?->description ?? 'Select a room to preview the atmosphere.' }}</p>
                <p class="story-meta" data-room-capacity>{{ $reservation->room?->capacity ? 'Best for ' . $reservation->room->capacity . ' players' : 'Capacity will appear here' }}</p>
                <p data-room-detail>Reference {{ $reservation->confirmation_code }}</p>
            </article>

            @if($reservation->reservationMenuItems->isNotEmpty())
                <article class="info-box">
                    <p class="story-meta">Current Pre-order</p>
                    <ul class="check-list">
                        @foreach($reservation->reservationMenuItems as $orderItem)
                            <li>{{ $orderItem->menuItem->name ?? 'Menu item' }} x {{ $orderItem->quantity }}</li>
                        @endforeach
                    </ul>
                </article>
            @endif
        </aside>
    </section>
</div>
@endsection
