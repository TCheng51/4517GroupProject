<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Fabel | Every game tells a story' }}</title>
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <script src="{{ asset('frontend/js/script.js') }}" defer></script>
</head>
<body>
    @include('partials.header')

    <main class="site-main">
        @yield('content')
    </main>

    @include('partials.footer')
</body>
</html>
