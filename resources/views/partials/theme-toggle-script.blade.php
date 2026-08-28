<script nonce="{{ $cspNonce }}">
    (function () {
        function applyTheme(isDark) {
            document.documentElement.classList.toggle('dark', isDark);
        }

        document.querySelectorAll('[data-theme-toggle]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var isDark = !document.documentElement.classList.contains('dark');
                applyTheme(isDark);
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
            });
        });

        // Si l'utilisateur n'a jamais choisi explicitement, suit les changements système en direct.
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function (e) {
            if (!localStorage.getItem('theme')) {
                applyTheme(e.matches);
            }
        });
    })();
</script>
