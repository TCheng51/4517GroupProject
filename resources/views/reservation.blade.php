@extends('layouts.app')

@section('content')
<div class="shell page">
    <section class="split-panel">
        <div class="form-panel">
            <p class="eyebrow">Room Reservations</p>
            <h2 class="section-title">Reserve a table or private room at Fable.</h2>
            <p class="page-intro">Choose a date, session, and story-genre space that fits your boardgame and group size.</p>

            <div class="login-status">
                <div class="login-content">
                    <p class="login-label">Login: 
                        @if(Auth::check())
                            <span class="member-info">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }} ({{ Auth::user()->email }})</span>
                        @else
                            <span class="guest-info">Guest</span>
                        @endif
                    </p>
                    @if(Auth::check())
                        <form action="{{ route('logout') }}" method="POST" class="logout-form">
                            @csrf
                            <button type="submit" class="btn btn-logout">Logout</button>
                        </form>
                    @endif
                </div>
            </div>

            <form action="{{ route('reservation.submit') }}" method="post" data-reservation-form data-availability-url="{{ route('reservation.availability') }}">
                @csrf
                @guest
                <div class="field-grid guest-fields">
                    <div class="form-group">
                        <label for="guest_name">Your Name</label>
                        <input type="text" id="guest_name" name="guest_name" required
                               value="{{ old('guest_name') }}" placeholder="Enter your full name"
                               autocomplete="name"
                               @error('guest_name') aria-invalid="true" aria-describedby="guest_name-error" @enderror>
                        @error('guest_name')
                            <small id="guest_name-error" class="text-danger" role="alert">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="guest_email">Email Address</label>
                        <input type="email" id="guest_email" name="guest_email" required
                               value="{{ old('guest_email') }}" placeholder="your@email.com"
                               autocomplete="email"
                               @error('guest_email') aria-invalid="true" aria-describedby="guest_email-error" @enderror>
                        @error('guest_email')
                            <small id="guest_email-error" class="text-danger" role="alert">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group form-span-2">
                        <label for="guest_phone">Phone Number</label>
                        <input type="tel" id="guest_phone" name="guest_phone" required
                               value="{{ old('guest_phone') }}" placeholder="(852) 1234 5678"
                               autocomplete="tel" inputmode="tel"
                               @error('guest_phone') aria-invalid="true" aria-describedby="guest_phone-error" @enderror>
                        @error('guest_phone')
                            <small id="guest_phone-error" class="text-danger" role="alert">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                @endguest

                <div class="field-grid">
                    <div class="form-group">
                        <label for="reservation_date">Reservation date</label>
                        <input type="date" id="reservation_date" name="reservation_date" data-reservation-date required
                               value="{{ old('reservation_date') }}"
                               @error('reservation_date') aria-invalid="true" aria-describedby="reservation_date-error" @enderror>
                        @error('reservation_date')
                            <small id="reservation_date-error" class="text-danger" role="alert">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="time_slot">Time slot</label>
                        <select id="time_slot" name="time_slot" required
                                @error('time_slot') aria-invalid="true" aria-describedby="time_slot-error" @enderror>
                            <option value="">Select a time slot</option>
                            @foreach($timeSlots as $timeSlot)
                                <option value="{{ $timeSlot->label }}" {{ old('time_slot') == $timeSlot->label ? 'selected' : '' }}>
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
                            <option value="">Choose a story room</option>
                            @foreach($rooms as $room)
                                <option
                                    value="{{ $room->slug }}"
                                    data-name="{{ $room->name }}"
                                    data-capacity="{{ $room->capacity }}"
                                    data-description="{{ $room->description }}"
                                    {{ old('table_room') == $room->slug ? 'selected' : '' }}
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

                <p class="availability-message" data-availability-message>Choose a date, time slot, and room to check availability.</p>

                @if($menuItemsByCategory->isNotEmpty())
                <section class="menu-order">
                    <p class="eyebrow">Pre-order Menu</p>
                    <h3>Add cafe items to your reservation.</h3>
                    <p class="form-hint">Quantities are optional. Staff will prepare your order estimate for arrival.</p>

                    @foreach($menuItemsByCategory as $category => $items)
                        <div class="menu-order-group">
                            <h4>{{ $category }}</h4>
                            <div class="menu-order-grid">
                                @foreach($items as $item)
                                    <label class="menu-order-item" for="menu_item_{{ $item->id }}">
                                        <span>
                                            <strong>{{ $item->name }}</strong>
                                            <small>HK$ {{ number_format((float) $item->price, 2) }}</small>
                                        </span>
                                        <input
                                            type="number"
                                            id="menu_item_{{ $item->id }}"
                                            name="menu_items[{{ $item->id }}]"
                                            min="0"
                                            max="9"
                                            value="{{ old('menu_items.' . $item->id, 0) }}"
                                        >
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </section>
                @endif

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Confirm Reservation</button>
                    <button type="reset" class="btn btn-secondary">Clear Selection</button>
                </div>
            </form>
        </div>

        <aside class="side-panel">
            <article class="table-preview">
                <span class="preview-badge">Room Preview</span>
                <h3 data-room-title>Choose a story room</h3>
                <p data-room-mood>Each space in Fable is styled around a different genre so your table feels like part of the game.</p>
                <p class="story-meta" data-room-capacity>Capacity will appear here</p>
                <p data-room-detail>Select a room to preview the atmosphere and the best fit for your session.</p>
            </article>

            <article class="info-box">
                <p class="story-meta">Reservation Notes</p>
                <ul class="check-list">
                    <li>Reservations must be placed for a future date.</li>
                    <li>Choose the setting that best matches your game for a stronger atmosphere.</li>
                    <li>Food and beverage service continues at the table throughout your session.</li>
                </ul>
            </article>

            <div class="inline-links">
                <a href="{{ route('login') }}" class="btn btn-outline">Member Login</a>
                <a href="{{ route('index') }}" class="btn btn-outline">Back Home</a>
            </div>
        </aside>
    </section>
</div>
@endsection
