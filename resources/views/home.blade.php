@extends('layouts.app')

@section('content')
<div class="shell page">
    <section class="hero">
        <div class="hero-inner">
            <div class="hero-copy">
                <p class="eyebrow">Storybook Tavern Experience</p>
                <h2 class="page-title">Fabel turns game night into a setting.</h2>
                <p class="lead">
                    Fabel is a boardgame cafe built like a welcoming tavern. Guests gather for modern boardgames,
                    comfort food, and thoughtfully themed spaces where the table, lighting, and atmosphere match the story
                    they want to play.
                </p>
                <div class="hero-actions">
                    <a href="{{ route('register') }}" class="btn btn-primary">Join Fabel</a>
                    <a href="{{ route('reservation') }}" class="btn btn-outline">Explore Rooms</a>
                </div>
            </div>

            <div class="hero-media">
                <article class="ambience-card">
                    <div class="ambient-orb" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2.5 8.5 6v5.5L12 15l3.5-3.5V6L12 2.5Z" />
                            <path d="M7 11.5h10" />
                            <path d="M8.5 18h7" />
                            <path d="M10 15v3" />
                            <path d="M14 15v3" />
                        </svg>
                    </div>
                    <p class="kicker">Inside Fabel</p>
                    <h3>Warm timber, amber light, and shelves full of worlds.</h3>
                    <ul class="ambient-list">
                        <li>Genre-inspired tables and private rooms for fantasy, sci-fi, mystery, and beyond.</li>
                        <li>A curated boardgame library paired with cafe service throughout your session.</li>
                        <li>Reserved spaces that strengthen the mood of the game you chose to bring.</li>
                    </ul>
                </article>

                <div class="stats-grid">
                    <article class="stat-card">
                        <p class="story-meta">Spaces</p>
                        <h3>6 themed rooms</h3>
                        <p>From cozy hearth tables to futuristic private lounges.</p>
                    </article>
                    <article class="stat-card">
                        <p class="story-meta">Sessions</p>
                        <h3>2 to 8 guests</h3>
                        <p>Flexible layouts for duos, family visits, and full party nights.</p>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <section class="highlight-strip">
        <div class="cards-grid">
            <article class="feature-card">
                <div class="feature-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 7.5h16" />
                        <path d="M6 4.5h12v15H6z" />
                        <path d="M9 12h6" />
                    </svg>
                </div>
                <h3>Reserve by genre</h3>
                <p>Match your game with a room that feels right, whether you want a fantasy hearth or a sci-fi archive.</p>
            </article>

            <article class="feature-card">
                <div class="feature-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 8h14l-1.5 9.5h-11z" />
                        <path d="M8 8V6.5A3.5 3.5 0 0 1 11.5 3h1A3.5 3.5 0 0 1 16 6.5V8" />
                        <path d="M9 13h6" />
                    </svg>
                </div>
                <h3>Cafe service at the table</h3>
                <p>Enjoy drinks and savory comfort food without leaving the flow of the story.</p>
            </article>

            <article class="feature-card">
                <div class="feature-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m4 16 8-10 8 10" />
                        <path d="M7 13.5V20h10v-6.5" />
                        <path d="M10 10.5h4" />
                    </svg>
                </div>
                <h3>Built for gathering</h3>
                <p>Every corner is designed for conversation, comfort, and nights worth retelling.</p>
            </article>
        </div>
    </section>

    <section class="panel">
        <p class="eyebrow">Choose A Setting</p>
        <h2 class="section-title">Story-genre rooms across the cafe</h2>
        <p class="page-intro">
            Each Fabel space carries its own visual language, so your group can choose an atmosphere that deepens the experience.
        </p>
        <div class="room-grid">
            <article class="story-card">
                <div class="story-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 20V9l6-5 6 5v11" />
                        <path d="M9.5 20v-6h5v6" />
                    </svg>
                </div>
                <p class="story-meta">Fantasy</p>
                <h3>The Hearth</h3>
                <p>Lantern glow, carved oak, and a fireside tone for adventure games, trading routes, and first campaigns.</p>
            </article>

            <article class="story-card">
                <div class="story-icon" aria-hidden="true">
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
                </div>
                <p class="story-meta">Sci-Fi</p>
                <h3>The Iron Archive</h3>
                <p>Brass details and structured lighting for strategy games, engine builders, and futuristic epics.</p>
            </article>

            <article class="story-card">
                <div class="story-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 18c2.5-4.5 5-6.5 7-6.5S16.5 13.5 19 18" />
                        <path d="M12 11.5V4" />
                        <path d="m9 7 3-3 3 3" />
                    </svg>
                </div>
                <p class="story-meta">Myth & Whimsy</p>
                <h3>The Mythic Garden</h3>
                <p>A lighter, playful nook for family titles, accessible favorites, and easygoing afternoons.</p>
            </article>
        </div>
    </section>

    <section class="split-panel">
        <div class="panel-section">
            <p class="eyebrow">How It Works</p>
            <h2 class="section-title">Reserve the table that fits the game.</h2>
            <ul class="check-list">
                <li>Create a member account so your visits and reservations stay in one place.</li>
                <li>Pick a session time, then choose the room whose genre best supports your boardgame.</li>
                <li>Arrive, settle in, and let the cafe team take care of the rest while you play.</li>
            </ul>
        </div>
        <aside class="status-card">
            <p class="story-meta">Recommended Evening</p>
            <h3>Fantasy table plus tavern menu</h3>
            <p>Bring a cooperative quest game, reserve The Hearth, and build the full atmosphere from the first turn.</p>
            <div class="hero-actions">
                <a href="{{ route('reservation') }}" class="btn btn-primary">Book A Session</a>
                <a href="{{ route('login') }}" class="btn btn-outline">Member Login</a>
            </div>
        </aside>
    </section>
</div>
@endsection
