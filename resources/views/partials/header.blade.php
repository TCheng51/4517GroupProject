<header class="site-header">
    <div class="shell header-content">
        <a href="{{ route('index') }}" class="brand" aria-label="Fabel home">
            <span class="brand-mark" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 4.5h8.5a3.5 3.5 0 0 1 3.5 3.5v10.5H9.5A3.5 3.5 0 0 0 6 22V4.5Z" />
                    <path d="M18 4.5h-8.5A3.5 3.5 0 0 0 6 8v10.5h8.5A3.5 3.5 0 0 1 18 22V4.5Z" />
                    <path d="M9.5 8h4" />
                    <path d="M9.5 11.5h4" />
                </svg>
            </span>
            <span class="brand-copy">
                <p class="brand-kicker">Boardgame Cafe</p>
                <h1>Fabel</h1>
                <p class="brand-tagline">A storybook tavern for themed rooms, shared tables, and game nights that feel like worlds of their own.</p>
            </span>
        </a>
        <button class="nav-toggle" type="button" data-nav-toggle aria-expanded="false" aria-controls="site-nav" aria-label="Toggle navigation">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                <path d="M4 7h16" />
                <path d="M4 12h16" />
                <path d="M4 17h16" />
            </svg>
        </button>
        @include('partials.navbar')
    </div>
</header>
