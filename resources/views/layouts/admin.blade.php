<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Administration - Infinity WAB')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [data-theme="dark"] body { background: #1e293b; color: #f1f5f9; }
        [data-theme="dark"] aside { background: #1e293b; border-color: #334155; }
        [data-theme="dark"] .admin-header { background: #1e293b; border-color: #334155; }
        [data-theme="dark"] .admin-header h1, [data-theme="dark"] .admin-header .text-slate-800 { color: #f1f5f9 !important; }
        [data-theme="dark"] .admin-header .text-slate-500 { color: #94a3b8 !important; }
    </style>

    <!-- Meta Tags -->
    <meta name="description" content="Interface d'administration Infinity WAB">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    </head>
    <body class="min-h-screen font-sans antialiased bg-slate-100 text-slate-800">
        <div id="app" class="flex h-screen overflow-hidden">
            <!-- Sidebar Navigation -->
            <div class="hidden lg:flex lg:flex-shrink-0 fixed inset-y-0 left-0 z-40">
                @include('admin.partials.sidebar')
            </div>

            <!-- Main Content Area -->
            <div class="flex flex-1 flex-col min-h-0 lg:ml-64 bg-slate-100">
                <!-- Header / Top Navigation -->
                <div class="sticky top-0 z-30 admin-header bg-white border-b border-slate-200 shadow-sm">
                    @include('admin.partials.topnav')
                </div>

                <!-- Alerts -->
                <div id="alert-container" class="hidden fixed top-24 left-1/2 transform -translate-x-1/2 z-50 max-w-md w-full">
                    <div id="alert-content" class="bg-white rounded-lg shadow-lg border border-slate-200 p-4 flex items-center text-sm font-semibold">
                        <div id="alert-icon" class="flex-shrink-0 mr-3"></div>
                        <div id="alert-message" class="flex-1"></div>
                        <button onclick="hideAlert()" class="ml-4 flex-shrink-0 text-slate-500 hover:text-slate-800 dark:hover:text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Page Content Wrapper -->
                <main class="flex-1 min-h-0 overflow-y-auto">
                    <div class="p-6 max-w-7xl mx-auto">
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>

        <script>
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

    <script>
        function showAlert(message, type = 'success') {
            const alertContainer = document.getElementById('alert-container');
            const alertContent = document.getElementById('alert-content');
            const alertIcon = document.getElementById('alert-icon');
            const alertMessage = document.getElementById('alert-message');

            // Set message
            alertMessage.textContent = message;

            // Set type-specific styling and icon
            if (type === 'success') {
                alertContent.className = 'bg-green-50 border-green-200 text-green-800 rounded-lg shadow-lg border p-4 flex items-center';
                alertIcon.innerHTML = `
                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                `;
            } else if (type === 'error') {
                alertContent.className = 'bg-red-50 border-red-200 text-red-800 rounded-lg shadow-lg border p-4 flex items-center';
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

        // Dark Mode Toggle Functionality
        function initTheme() {
            const theme = localStorage.getItem('theme') || 'light';
            setTheme(theme);

            const themeToggle = document.getElementById('themeToggle');
            if (themeToggle) {
                themeToggle.addEventListener('click', toggleTheme);
                updateThemeIcon(theme);
            }
        }

        function setTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
        }

        function toggleTheme() {
            const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            setTheme(newTheme);
            updateThemeIcon(newTheme);
        }

        function updateThemeIcon(theme) {
            const themeIcon = document.getElementById('themeIcon');
            if (themeIcon) {
                if (theme === 'dark') {
                    themeIcon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    `;
                } else {
                    themeIcon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    `;
                }
            }
        }

        // Initialize theme when DOM is loaded
        document.addEventListener('DOMContentLoaded', initTheme);
    </script>
</body>
</html>
