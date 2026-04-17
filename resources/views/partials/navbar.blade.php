<nav class="navbar" id="site-nav" data-nav>
    <a href="{{ route('index') }}" class="nav-cta {{ request()->routeIs('index') ? 'is-active' : '' }}">Home</a>
    <a href="{{ route('menu') }}" class="nav-link {{ request()->routeIs('menu') ? 'is-active' : '' }}">Menu</a>
    <a href="{{ route('reservation') }}" class="nav-link {{ request()->routeIs('reservation', 'reservation.*') ? 'is-active' : '' }}">Reservation</a>
    @auth
        <a href="{{ route('my-reservations') }}" class="nav-link {{ request()->routeIs('my-reservations', 'my-reservations.*') ? 'is-active' : '' }}">My Reservations</a>
        @if(Auth::user()->is_admin)
            <a href="{{ route('room-status') }}" class="nav-link {{ request()->routeIs('room-status') ? 'is-active' : '' }}">Room Status</a>
        @endif
        <form action="{{ route('logout') }}" method="post" class="nav-form">
            @csrf
            <button type="submit" class="nav-cta">Logout</button>
        </form>
    @else
        <a href="{{ route('register') }}" class="nav-link {{ request()->routeIs('register', 'register.*') ? 'is-active' : '' }}">Membership</a>
        <a href="{{ route('login') }}" class="nav-cta {{ request()->routeIs('login', 'login.*') ? 'is-active' : '' }}">Login</a>
    @endauth
</nav>
