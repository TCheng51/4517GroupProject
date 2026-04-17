<header class="site-header">
    <div class="shell header-content">
        <a href="{{ route('index') }}" class="brand" aria-label="Fable home">
            <span class="brand-mark" aria-hidden="true">
                <i data-lucide="book-open"></i>
            </span>
            <span class="brand-copy">
                <p class="brand-kicker">Boardgame Cafe</p>
                <h1>Fable</h1>
                <p class="brand-tagline">Themed rooms, curated boardgames, and tavern service for unforgettable game nights.</p>
            </span>
        </a>
        <button class="nav-toggle" type="button" data-nav-toggle aria-expanded="false" aria-controls="site-nav" aria-label="Toggle navigation" data-no-loading>
            <i data-lucide="menu" aria-hidden="true"></i>
        </button>
        @include('partials.navbar')
    </div>
</header>
