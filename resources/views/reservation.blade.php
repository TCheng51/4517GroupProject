@extends('layouts.app')

@section('content')
<div class="shell page">
    <section class="split-panel">
        <div class="form-panel">
            <p class="eyebrow">Reservations</p>
            <h2 class="section-title">Reserve a table or private room at Fabel.</h2>
            <p class="page-intro">Choose a date, session, and story-genre space that fits your boardgame and group size.</p>

            <form action="{{ route('reservation.submit') }}" method="post">
                @csrf
                <div class="field-grid">
                    <div class="form-group">
                        <label for="reservation_date">Reservation date</label>
                        <input type="date" id="reservation_date" name="reservation_date" data-reservation-date required value="{{ old('reservation_date') }}">
                        @error('reservation_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="time_slot">Time slot</label>
                        <select id="time_slot" name="time_slot" required>
                            <option value="">Select a time slot</option>
                            <option value="2:00-4:00" {{ old('time_slot') == '2:00-4:00' ? 'selected' : '' }}>2:00 PM to 4:00 PM</option>
                            <option value="6:00-9:00" {{ old('time_slot') == '6:00-9:00' ? 'selected' : '' }}>6:00 PM to 9:00 PM</option>
                            <option value="9:00-11:00" {{ old('time_slot') == '9:00-11:00' ? 'selected' : '' }}>9:00 PM to 11:00 PM</option>
                        </select>
                        @error('time_slot')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group form-span-2">
                        <label for="table_room">Table or room theme</label>
                        <select id="table_room" name="table_room" data-room-select required>
                            <option value="">Choose a story room</option>
                            <option value="fantasy-hearth" {{ old('table_room') == 'fantasy-hearth' ? 'selected' : '' }}>Fantasy Hearth — 4 players</option>
                            <option value="mythic-garden" {{ old('table_room') == 'mythic-garden' ? 'selected' : '' }}>Mythic Garden — 4 players</option>
                            <option value="iron-archive" {{ old('table_room') == 'iron-archive' ? 'selected' : '' }}>Iron Archive — 4 players</option>
                            <option value="starlight-orbit" {{ old('table_room') == 'starlight-orbit' ? 'selected' : '' }}>Starlight Orbit — 6 players</option>
                            <option value="clockwork-vault" {{ old('table_room') == 'clockwork-vault' ? 'selected' : '' }}>Clockwork Vault — 6 players</option>
                            <option value="storykeeper-suite" {{ old('table_room') == 'storykeeper-suite' ? 'selected' : '' }}>Storykeeper Suite — 8 players</option>
                        </select>
                        @error('table_room')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

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
                <p data-room-mood>Each space in Fabel is styled around a different genre so your table feels like part of the game.</p>
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
