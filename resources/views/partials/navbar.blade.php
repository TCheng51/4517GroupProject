<nav class="navbar" id="site-nav" data-nav>
    <a href="{{ route('index') }}" class="nav-link {{ request()->routeIs('index') ? 'is-active' : '' }}">Home</a>
    <a href="{{ route('register') }}" class="nav-link {{ request()->routeIs('register', 'register.*') ? 'is-active' : '' }}">Membership</a>
    <a href="{{ route('login') }}" class="nav-link {{ request()->routeIs('login', 'login.*') ? 'is-active' : '' }}">Login</a>
    <a href="{{ route('reservation') }}" class="nav-cta {{ request()->routeIs('reservation', 'reservation.*') ? 'is-active' : '' }}">Reserve a Table</a>
</nav>
