@php $defaultTheme = \App\Models\Setting::get('default_theme', 'system'); @endphp
<script nonce="{{ $cspNonce }}">
    // Doit s'exécuter avant le premier paint pour éviter un flash du mauvais thème.
    // Priorité : choix explicite du visiteur (localStorage) > thème par défaut réglé
    // dans l'admin > préférence système.
    (function () {
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
    })();
</script>
