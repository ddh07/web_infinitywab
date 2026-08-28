<!DOCTYPE html>
<html lang="fr">
<head>
    @php
        $pageTitle = trim($__env->yieldContent('title', \App\Models\Setting::get('seo_default_title', 'Infinity WAB - Technologie pour le Burkina Faso')));
        $pageDescription = trim($__env->yieldContent('description', \App\Models\Setting::get('seo_default_description', 'Infinity WAB - Solutions technologiques innovantes pour le Burkina Faso')));
        $pageOgImage = trim($__env->yieldContent('og_image', \App\Models\Setting::get('seo_og_image_path') ?: asset('images/Infinity_logo.png')));
        $pageUrl = url()->current();
        $seoNoindex = (bool) \App\Models\Setting::get('seo_noindex');
    @endphp
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Google Tag Manager : le conteneur n'est plus chargé automatiquement ici. Seul
         l'identifiant est exposé à resources/js/pages/cookie-consent.js, qui n'injecte
         le script GTM qu'après consentement explicite de l'utilisateur (bandeau de
         cookies, voir partials/cookie-consent.blade.php) — conformité loi n°001-2021/AN. --}}
    @if($gtmId = config('services.gtm.container_id'))
    <script nonce="{{ $cspNonce }}">window.__GTM_ID = {!! json_encode($gtmId) !!};</script>
    @endif

    <title>{{ $pageTitle }}</title>
    <link rel="canonical" href="{{ $pageUrl }}">

    @include('partials.theme-init')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <!-- CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Meta Tags -->
    <meta name="description" content="{{ $pageDescription }}">
    <meta name="keywords" content="technologie, burkina faso, maintenance informatique, réseaux, développement, innovation">
    @if($seoNoindex)
        <meta name="robots" content="noindex,nofollow">
    @endif
    @if($verification = \App\Models\Setting::get('seo_search_console_verification'))
        <meta name="google-site-verification" content="{{ $verification }}">
    @endif
    @if($bingVerification = \App\Models\Setting::get('seo_bing_verification'))
        <meta name="msvalidate.01" content="{{ $bingVerification }}">
    @endif

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Infinity WAB">
    <meta property="og:locale" content="fr_FR">
    <meta property="og:url" content="{{ $pageUrl }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:image" content="{{ $pageOgImage }}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $pageDescription }}">
    <meta name="twitter:image" content="{{ $pageOgImage }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ \App\Models\Setting::get('site_favicon_path') ?: asset('favicon.ico') }}">

    <!-- Schema.org LocalBusiness -->
    @if($schemaCompany)
        <script type="application/ld+json" nonce="{{ $cspNonce }}">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            'name' => $schemaCompany->name,
            'description' => $schemaCompany->description,
            'url' => $schemaCompany->website ?? url('/'),
            'email' => $schemaCompany->email,
            'telephone' => $schemaCompany->phone,
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => 'Ouagadougou',
                'addressCountry' => 'BF',
                'streetAddress' => $schemaCompany->address,
            ],
            'image' => $pageOgImage,
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>
    @endif
</head>
<body class="bg-surface-canvas text-ink-primary">
    {{-- Le pixel <noscript> historique de GTM a été retiré : sans JavaScript, la
         bannière de consentement ne peut pas s'afficher, donc aucun consentement ne
         peut être recueilli — le déposer quand même reviendrait à suivre ces visiteurs
         sans leur accord. --}}

    @if((bool) \App\Models\Setting::get('a11y_force_reduced_motion'))
        <script nonce="{{ $cspNonce }}">window.__forceReducedMotion = true;</script>
    @endif

    <!-- Lien d'évitement : premier élément focusable de la page, invisible tant qu'il
         n'a pas le focus clavier, pour permettre de sauter la navigation. -->
    <a href="#main-content" class="skip-link">Aller au contenu principal</a>

    @if(($banner = \App\Models\Setting::get('banner_enabled')) && ($bannerText = \App\Models\Setting::get('banner_text')))
        <div data-site-banner class="relative z-40 bg-gradient-to-r from-mint-600 to-azure-600 text-white text-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2.5 flex items-center justify-center gap-3 text-center">
                <span>{{ $bannerText }}</span>
                @if($bannerLinkUrl = \App\Models\Setting::get('banner_link_url'))
                    <a href="{{ $bannerLinkUrl }}" class="font-semibold underline underline-offset-2 hover:no-underline whitespace-nowrap">
                        {{ \App\Models\Setting::get('banner_link_label') ?: 'En savoir plus' }}
                    </a>
                @endif
                <button type="button" data-dismiss-banner aria-label="Fermer" class="ml-2 shrink-0 opacity-80 hover:opacity-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
        <script nonce="{{ $cspNonce }}">
            (function () {
                // La navbar est en position fixe : sans ce décalage, elle recouvrirait
                // la bannière (toutes deux ancrées en haut de la page). --banner-height
                // est lue par partials/navigation.blade.php pour se repositionner.
                var key = 'banner-dismissed-{{ md5($bannerText) }}';
                var banner = document.querySelector('[data-site-banner]');
                if (!banner) return;

                function updateNavOffset() {
                    var height = banner.isConnected ? banner.offsetHeight : 0;
                    document.documentElement.style.setProperty('--banner-height', height + 'px');
                }

                if (sessionStorage.getItem(key)) {
                    banner.remove();
                    updateNavOffset();
                    return;
                }

                updateNavOffset();
                window.addEventListener('resize', updateNavOffset);

                banner.querySelector('[data-dismiss-banner]')?.addEventListener('click', function () {
                    sessionStorage.setItem(key, '1');
                    banner.remove();
                    updateNavOffset();
                });
            })();
        </script>
    @endif

    <!-- Barre de progression de lecture -->
    <div id="scroll-progress" class="fixed top-0 left-0 right-0 h-0.75 z-60 pointer-events-none" aria-hidden="true">
        <div id="scroll-progress-bar" class="h-full bg-linear-to-r from-mint-500 to-azure-500 origin-left scale-x-0 transition-transform duration-150 ease-out will-change-transform"></div>
    </div>

    <!-- Alerts -->
    @include('partials.alerts')

    <!-- Navigation -->
    @include('partials.navigation')

    <!-- Main Content -->
    <main id="main-content" class="">
        <div id="app">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    @include('partials.footer')

    <!-- CTA sticky mobile -->
    @unless(request()->routeIs('contact'))
        <div class="lg:hidden fixed bottom-0 left-0 right-0 z-40 border-t border-(--border-default) bg-surface-raised/95 backdrop-blur px-4 py-3 shadow-2xl" style="padding-bottom: max(0.75rem, env(safe-area-inset-bottom));">
            <a href="{{ route('contact') }}" class="flex items-center justify-center gap-2 w-full rounded-xl bg-linear-to-r from-mint-500 to-azure-500 text-slate-950 font-semibold py-3 text-sm">
                Discuter d’un projet
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
        <div class="lg:hidden h-20" aria-hidden="true"></div>
    @endunless

    @include('partials.theme-toggle-script')
    @include('partials.cookie-consent')

    @stack('scripts')
</body>
</html>
