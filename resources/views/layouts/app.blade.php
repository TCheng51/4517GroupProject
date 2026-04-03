<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Fabel | Every game tells a story' }}</title>
    @vite(['resources/css/style.css', 'resources/js/app.js'])
</head>
<body>
    @include('partials.header')

    <main class="site-main">
        @yield('content')
    </main>

    @include('partials.footer')
</body>
</html>
