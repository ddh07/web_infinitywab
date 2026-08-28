<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Infinity WAB')</title>

    {{-- Layout volontairement autonome (pas de layouts.app) : une page d'erreur, en
         particulier une 500, doit pouvoir s'afficher même si la base de données ou une
         autre dépendance qui alimente la nav/le footer normaux est en panne. Aucune
         requête DB ici, $cspNonce protégé par un repli au cas où le middleware qui le
         définit n'a pas eu l'occasion de s'exécuter avant l'exception. --}}
    @php $defaultTheme = \App\Models\Setting::get('default_theme', 'system'); @endphp
    <script nonce="{{ $cspNonce ?? '' }}">
        (function () {
            try {
                var stored = localStorage.getItem('theme');
                var siteDefault = '{{ $defaultTheme }}';
                var isDark;
                if (stored) {
                    isDark = stored === 'dark';
                } else if (siteDefault === 'dark') {
                    isDark = true;
                } else if (siteDefault === 'light') {
                    isDark = false;
                } else {
                    isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                }
                document.documentElement.classList.toggle('dark', isDark);
            } catch (e) {}
        })();
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <meta name="robots" content="noindex">
    <link rel="icon" type="image/x-icon" href="{{ \App\Models\Setting::get('site_favicon_path') ?: asset('favicon.ico') }}">
</head>
<body class="bg-surface-canvas text-ink-primary">
    <header class="fixed top-0 left-0 right-0 z-50 px-4 sm:px-6 lg:px-8 py-4">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-3">
            <img src="{{ \App\Models\Setting::get('site_logo_path') ?: asset('images/Infinity_logo.png') }}" alt="Infinity WAB" class="w-10 h-10 rounded-xl">
            <span class="text-ink-primary font-display font-bold tracking-tight">Infinity WAB</span>
        </a>
    </header>

    @yield('content')

    <footer class="py-6 text-center text-xs text-ink-muted">
        Copyright &copy; {{ date('Y') }} Infinity WAB SARL. Tous droits réservés.
    </footer>
</body>
</html>
