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
    <meta name="description" content="Interface d'administration Infinity WAB">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    </head>
    <body class="min-h-screen font-sans antialiased bg-surface-canvas text-ink-primary">
        <div id="app" class="flex h-screen overflow-hidden">
            <!-- Sidebar Navigation -->
            <div class="hidden lg:flex lg:flex-shrink-0 fixed inset-y-0 left-0 z-40">
                @include('admin.partials.sidebar')
            </div>

            <!-- Main Content Area -->
            <div class="flex flex-1 flex-col min-h-0 lg:ml-64 bg-surface-canvas">
                <!-- Header / Top Navigation -->
                <div class="sticky top-0 z-30 admin-header bg-surface-raised border-b border-(--border-default) shadow-sm">
                    @include('admin.partials.topnav')
                </div>

                <!-- Alerts -->
                <div id="alert-container" class="hidden fixed top-24 left-1/2 transform -translate-x-1/2 z-50 max-w-md w-full">
                    <div id="alert-content" class="bg-surface-raised rounded-lg shadow-lg border border-(--border-default) p-4 flex items-center text-sm font-semibold">
                        <div id="alert-icon" class="flex-shrink-0 mr-3"></div>
                        <div id="alert-message" class="flex-1"></div>
                        <button type="button" id="btnHideAlert" class="ml-4 flex-shrink-0 text-ink-muted hover:text-ink-primary">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Boîte de confirmation stylée, remplace window.confirm() -->
                @include('admin.partials.confirm-dialog')

                <!-- Sélecteur de fichiers partagé (bibliothèque de médias), une seule instance
                     réutilisée par tous les champs image/fichier de l'admin -->
                @include('admin.partials.media-picker')

                <!-- Page Content Wrapper -->
                <main class="flex-1 min-h-0 overflow-y-auto">
                    <div class="p-6 max-w-7xl mx-auto">
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>

        <script nonce="{{ $cspNonce }}">
            // Admin pages use `fetch()` directly for CRUD. Since admin API routes live in `routes/web.php`,
            // they are still protected by CSRF => we attach X-CSRF-TOKEN automatically to avoid 419 errors.
            (function () {
                if (window.__fetchCsrfWrapped) return;

                function getCsrfTokenFromCookie() {
                    const match = document.cookie.match(/XSRF-TOKEN=([^;]+)/);
                    if (!match) return '';
                    try {
                        return decodeURIComponent(match[1]);
                    } catch (e) {
                        return match[1];
                    }
                }

                const originalFetch = window.fetch?.bind(window);
                if (typeof originalFetch !== 'function') return;

                window.fetch = function (input, init = {}) {
                    init = init || {};
                    const headers = new Headers(init.headers || {});
                    const csrfToken = getCsrfTokenFromCookie();
                    if (csrfToken) headers.set('X-CSRF-TOKEN', csrfToken);

                    if (!headers.has('Accept')) headers.set('Accept', 'application/json');
                    if (!init.credentials) init.credentials = 'same-origin';

                    return originalFetch(input, { ...init, headers });
                };

                window.__fetchCsrfWrapped = true;
            })();

            // Échappement HTML partagé pour tout rendu construit via innerHTML côté admin.
            function escapeHtml(value) {
                return String(value ?? '')
                    .replaceAll('&', '&amp;')
                    .replaceAll('<', '&lt;')
                    .replaceAll('>', '&gt;')
                    .replaceAll('"', '&quot;')
                    .replaceAll("'", '&#039;');
            }
        </script>

        @stack('scripts')

    <script nonce="{{ $cspNonce }}">
        function showAlert(message, type = 'success') {
            const alertContainer = document.getElementById('alert-container');
            const alertContent = document.getElementById('alert-content');
            const alertIcon = document.getElementById('alert-icon');
            const alertMessage = document.getElementById('alert-message');

            // Set message
            alertMessage.textContent = message;

            // Set type-specific styling and icon
            if (type === 'success') {
                alertContent.className = 'bg-green-50 dark:bg-green-500/10 border-green-200 dark:border-green-500/30 text-green-800 dark:text-green-400 rounded-lg shadow-lg border p-4 flex items-center';
                alertIcon.innerHTML = `
                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                `;
            } else if (type === 'error') {
                alertContent.className = 'bg-red-50 dark:bg-red-500/10 border-red-200 dark:border-red-500/30 text-red-800 dark:text-red-400 rounded-lg shadow-lg border p-4 flex items-center';
                alertIcon.innerHTML = `
                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                `;
            }

            // Show alert
            alertContainer.classList.remove('hidden');

            // Auto-hide after 5 seconds
            setTimeout(() => {
                hideAlert();
            }, 5000);
        }

        function hideAlert() {
            document.getElementById('alert-container').classList.add('hidden');
        }

        document.getElementById('btnHideAlert')?.addEventListener('click', hideAlert);
    </script>

    @include('partials.theme-toggle-script')
</body>
</html>
