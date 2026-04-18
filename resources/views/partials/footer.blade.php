<footer class="site-footer">
    <div class="shell footer-grid">
        <p>&copy; 2026 Fable Boardgame Cafe. Story-led tables, genre rooms, and warm tavern service.</p>
        <div class="footer-links">
            <a href="{{ route('register') }}">Membership</a>
            <a href="{{ route('reservation') }}">Reservations</a>
            @auth
                <a href="{{ route('profile') }}">Profile</a>
            @endauth
            <a href="{{ route('login') }}">Member Login</a>
        </div>
    </div>
</footer>
