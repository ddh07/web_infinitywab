<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Administration - Infinity WAB')</title>

    @include('partials.theme-init')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Meta Tags -->
    <meta name="description" content="Interface de connexion Infinity WAB">

    <!-- Favicon -->
    <link rel="icon" href="{{ \App\Models\Setting::get('site_favicon_path') ?: asset('favicon.ico') }}">
    </head>
    <body class="min-h-screen bg-surface-canvas text-ink-primary font-sans antialiased">
        <div class="min-h-screen">
            @yield('content')
        </div>
        @include('partials.theme-toggle-script')
        @stack('scripts')
    </body>
</html>
