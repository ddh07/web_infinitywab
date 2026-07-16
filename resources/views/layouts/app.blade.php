<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Infinity WAB - Technologie pour le Burkina Faso')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Meta Tags -->
    <meta name="description" content="@yield('description', 'Infinity WAB - Solutions technologiques innovantes pour le Burkina Faso')">
    <meta name="keywords" content="technologie, burkina faso, maintenance informatique, réseaux, développement, innovation">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
</head>
<body class="bg-slate-900 text-white">
    <!-- Alerts -->
    @include('partials.alerts')

    <!-- Navigation -->
    @include('partials.navigation')

    <!-- Main Content -->
    <main class="pt-16">
        <div id="app">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    @include('partials.footer')

    @stack('scripts')
</body>
</html>
