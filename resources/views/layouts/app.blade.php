<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Fable | Every game tells a story' }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://unpkg.com/lucide@latest" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
    <a href="#main" class="skip-link">Skip to content</a>

    @include('partials.header')

    <main id="main" class="site-main" tabindex="-1">
        @if (session('status'))
            <div class="shell" role="status" aria-live="polite">
                <p class="flash-message flash-success">{{ session('status') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="shell" role="alert">
                <p class="flash-message flash-error">{{ session('error') }}</p>
            </div>
        @endif

        @yield('content')
    </main>

    @include('partials.footer')
</body>
</html>
