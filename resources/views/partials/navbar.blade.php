<nav class="navbar" id="site-nav" data-nav>
    <a href="{{ route('index') }}" class="nav-cta {{ request()->routeIs('index') ? 'is-active' : '' }}">Home</a>
    <a href="{{ route('menu') }}" class="nav-link {{ request()->routeIs('menu') ? 'is-active' : '' }}">Menu</a>
    <a href="{{ route('register') }}" class="nav-link {{ request()->routeIs('register', 'register.*') ? 'is-active' : '' }}">Membership</a>
    <a href="{{ route('reservation') }}" class="nav-link {{ request()->routeIs('reservation', 'reservation.*') ? 'is-active' : '' }}">Reservation</a>
    <a href="{{ route('room-status') }}" class="nav-link {{ request()->routeIs('room-status') ? 'is-active' : '' }}">Room Status</a>
    <a href="{{ route('login') }}" class="nav-cta {{ request()->routeIs('login', 'login.*') ? 'is-active' : '' }}">Login</a>
</nav>
