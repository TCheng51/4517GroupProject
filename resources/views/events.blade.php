@extends('layouts.app')

@section('content')
<div class="shell page">

    {{-- Hero --}}
    <section class="hero">
        <div class="hero-inner">
            <div class="hero-copy">
                <p class="eyebrow">What's Happening at Fable</p>
                <h2 class="page-title">Events, tournaments, and nights worth showing up for.</h2>
                <p class="lead">
                    Fable hosts regular events that bring the community together around the table — from
                    competitive tournaments and D&amp;D one-shots to painting workshops and mystery dinners.
                    Browse what's coming up and register to save your seat.
                </p>
                <div class="hero-actions">
                    @auth
                        <a href="#upcoming" class="btn btn-primary">Browse Events</a>
                        <a href="{{ route('reservation') }}" class="btn btn-outline">Book a Room</a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary">Join Fable</a>
                        <a href="{{ route('login') }}" class="btn btn-outline">Member Login</a>
                    @endauth
                </div>
            </div>

            <div class="hero-media">
                <article class="ambience-card">
                    <div class="ambient-orb" aria-hidden="true">
                        <i data-lucide="sparkles"></i>
                    </div>
                    <p class="kicker">Community Calendar</p>
                    <h3>Themed nights, competitive play, and creative workshops every month.</h3>
                    <ul class="ambient-list">
                        <li>D&amp;D one-shot campaigns with experienced Dungeon Masters.</li>
                        <li>Swiss-format board game tournaments with prizes and bragging rights.</li>
                        <li>Hands-on workshops for miniature painting, game design, and more.</li>
                    </ul>
                </article>
            </div>
        </div>
    </section>

    {{-- Flash Messages --}}
    @if(session('success'))
        <section class="panel">
            <p class="status-pill success">
                <i data-lucide="check-circle" aria-hidden="true"></i>
                {{ session('success') }}
            </p>
        </section>
    @endif

    @if(session('error'))
        <section class="panel">
            <p class="status-pill danger">
                <i data-lucide="alert-circle" aria-hidden="true"></i>
                {{ session('error') }}
            </p>
        </section>
    @endif

    {{-- Featured Events --}}
    @if($featuredEvents->isNotEmpty())
    <section class="panel">
        <p class="eyebrow">Spotlight</p>
        <h2 class="section-title">Featured Events</h2>
        <p class="page-intro">Don't miss these highlighted sessions — they tend to fill up quickly.</p>

        <div class="room-grid">
            @foreach($featuredEvents as $event)
                <article class="story-card">
                    <div class="story-icon" aria-hidden="true">
                        <i data-lucide="{{ $event->type_icon }}"></i>
                    </div>
                    <p class="story-meta">
                        {{ $event->type_label }} &bull; {{ $event->event_date->format('M j, Y') }}
                    </p>
                    <h3>{{ $event->title }}</h3>
                    <p>{{ Str::limit($event->description, 140) }}</p>

                    <div class="availability-heading">
                        <h4>{{ $event->time_range }}</h4>
                        <span>
                            @if($event->max_participants > 0)
                                {{ $event->spots_left }} / {{ $event->max_participants }} spots left
                            @else
                                Open attendance
                            @endif
                        </span>
                    </div>

                    <ul class="availability-list">
                        <li>
                            <span class="slot-time">Room</span>
                            <span class="slot-status is-open">{{ $event->room?->name ?? 'TBA' }}</span>
                        </li>
                        <li>
                            <span class="slot-time">Entry fee</span>
                            <span class="slot-status is-open">
                                {{ $event->entry_fee > 0 ? 'HK$ ' . number_format((float) $event->entry_fee, 2) : 'Free' }}
                            </span>
                        </li>
                    </ul>

                    <div class="hero-actions">
                        <a href="{{ route('events.show', $event) }}" class="btn btn-primary">View Details</a>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Filter Bar --}}
    <section class="panel" id="upcoming">
        <p class="eyebrow">Browse</p>
        <h2 class="section-title">Upcoming Events</h2>

        <form action="{{ route('events') }}" method="get" class="filter-bar">
            <div class="form-group">
                <label for="type">Event Type</label>
                <select id="type" name="type">
                    <option value="">All types</option>
                    @foreach($eventTypes as $value => $label)
                        <option value="{{ $value }}" {{ $selectedType === $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('events') }}" class="btn btn-outline">Clear</a>
            </div>
        </form>
    </section>

    {{-- Upcoming Events List --}}
    <section class="panel">
        @if($upcomingEvents->isEmpty())
            <div class="cards-grid">
                <article class="info-box">
                    <h3>No events found</h3>
                    <p>There are no upcoming events matching your filter. Try a different category or check back soon — new events are added regularly.</p>
                </article>
            </div>
        @else
            <div class="table-wrap">
                <table class="data-table">
                    <caption>Upcoming events at Fable</caption>
                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Room</th>
                            <th>Fee</th>
                            <th>Spots</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($upcomingEvents as $event)
                            <tr>
                                <td><strong>{{ $event->title }}</strong></td>
                                <td>
                                    <span class="status-pill">{{ $event->type_label }}</span>
                                </td>
                                <td>{{ $event->event_date->format('M j, Y') }}</td>
                                <td><span class="slot-time">{{ $event->time_range }}</span></td>
                                <td>{{ $event->room?->name ?? 'TBA' }}</td>
                                <td>
                                    {{ $event->entry_fee > 0 ? 'HK$ ' . number_format((float) $event->entry_fee, 2) : 'Free' }}
                                </td>
                                <td>
                                    @if($event->max_participants > 0)
                                        @if($event->is_full)
                                            <span class="status-pill danger">Full</span>
                                        @else
                                            <span class="slot-status is-open">{{ $event->spots_left }} left</span>
                                        @endif
                                    @else
                                        <span class="story-meta">Open</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('events.show', $event) }}" class="btn btn-secondary btn-sm">Details</a>
                                    @auth
                                        @if(in_array($event->id, $memberRegistrations))
                                            <span class="status-pill success">Registered</span>
                                        @endif
                                    @endauth
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination-links">
                {{ $upcomingEvents->links() }}
            </div>
        @endif
    </section>

    {{-- Past Events --}}
    @if($pastEvents->isNotEmpty())
    <section class="panel">
        <p class="eyebrow">Archive</p>
        <h2 class="section-title">Recent Past Events</h2>
        <p class="page-intro">A look back at what happened recently. Similar events return on a regular cycle.</p>

        <div class="cards-grid">
            @foreach($pastEvents as $event)
                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true">
                        <i data-lucide="{{ $event->type_icon }}"></i>
                    </div>
                    <h3>{{ $event->title }}</h3>
                    <p>{{ Str::limit($event->description, 100) }}</p>
                    <p class="story-meta">
                        {{ $event->type_label }} &bull;
                        {{ $event->event_date->format('M j, Y') }} &bull;
                        {{ $event->registered_count }} attended
                    </p>
                </article>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Info Cards --}}
    <section class="panel">
        <div class="cards-grid">
            <article class="info-box">
                <h3>How registration works</h3>
                <ul class="check-list">
                    <li>Log in to your Fable member account.</li>
                    <li>Open an event and click Register.</li>
                    <li>Your spot is held until the event date. Cancel any time if plans change.</li>
                </ul>
            </article>

            <article class="info-box">
                <h3>Entry fees</h3>
                <p>Some events carry an entry fee to cover materials, prizes, or catering. Free events are first-come, first-served. Payment is collected at the door on event night.</p>
            </article>

            <article class="info-box">
                <h3>Suggest an event</h3>
                <p>Have an idea for a themed night or tournament? Tell us at
                    <a href="mailto:events@fabelcafe.com" class="contact-link">events@fabelcafe.com</a>
                    and we may feature it on the calendar.
                </p>
            </article>
        </div>
    </section>

    {{-- Bottom Navigation --}}
    <section class="panel">
        <div class="navigation-buttons">
            <a href="{{ route('reservation') }}" class="btn btn-primary">Book a Room</a>
            <a href="{{ route('menu') }}" class="btn btn-outline">Cafe Menu</a>
            <a href="{{ route('index') }}" class="btn btn-outline">Back Home</a>
        </div>
    </section>

</div>
@endsection
