<nav class="fixed left-0 right-0 z-50" style="top: var(--banner-height, 0px);" data-nav>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="nav-shell relative mt-4 overflow-hidden rounded-3xl border border-(--border-default) bg-gradient-to-br from-surface-raised/70 to-surface-raised/30 px-4 py-3 shadow-2xl shadow-(--glow-accent) backdrop-blur-3xl lg:mt-3 lg:px-6">
            <div class="absolute inset-0 pointer-events-none bg-gradient-to-r from-blue-500/10 via-purple-500/10 to-transparent opacity-80 blur-3xl"></div>
            <div class="relative flex items-center justify-between gap-4">
                <!-- Logo -->
                <div class="flex items-center space-x-4 z-10">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-purple-500 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/30 transition-transform duration-500 group">
                        <img src="{{ \App\Models\Setting::get('site_logo_path') ?: asset('images/Infinity_logo.png') }}" alt="Infinity WAB Logo" class="w-15 h-15">
                    </div>
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 group z-10">
                        <span class="text-ink-primary text-lg font-bold tracking-tight transition-transform duration-300 group-hover:text-blue-400">Infinity WAB</span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex flex-grow items-center justify-between gap-6 z-10">
                    <div class="relative flex gap-8" data-nav-links>
                        <a href="{{ route('home') }}" class="nav-item-animated text-ink-secondary" data-nav-link data-active="{{ request()->routeIs('home') ? 'true' : 'false' }}">
                            Accueil
                        </a>
                        <a href="{{ route('services') }}" class="nav-item-animated text-ink-secondary" data-nav-link data-active="{{ request()->routeIs('services') || request()->routeIs('services.show') ? 'true' : 'false' }}">
                            Services
                        </a>
                        <a href="{{ route('projects') }}" class="nav-item-animated text-ink-secondary" data-nav-link data-active="{{ request()->routeIs('projects') || request()->routeIs('projects.show') ? 'true' : 'false' }}">
                            Projets
                        </a>
                        <a href="{{ route('products') }}" class="nav-item-animated text-ink-secondary" data-nav-link data-active="{{ request()->routeIs('products') || request()->routeIs('products.show') ? 'true' : 'false' }}">
                            Produits
                        </a>
                        <a href="{{ route('news') }}" class="nav-item-animated text-ink-secondary" data-nav-link data-active="{{ request()->routeIs('news') || request()->routeIs('news.show') ? 'true' : 'false' }}">
                            Actualités
                        </a>
                        <a href="{{ route('about') }}" class="nav-item-animated text-ink-secondary" data-nav-link data-active="{{ request()->routeIs('about') ? 'true' : 'false' }}">
                            À Propos
                        </a>
                        <a href="{{ route('contact') }}" class="nav-item-animated text-ink-secondary" data-nav-link data-active="{{ request()->routeIs('contact') ? 'true' : 'false' }}">
                            Contact
                        </a>
                        <span class="absolute bottom-0 h-0.5 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 transition-all duration-300" data-nav-indicator></span>
                    </div>

                    <div class="flex items-center gap-3">

                        <x-ui.theme-toggle />

                        @if(auth()->check() && auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 text-xs font-semibold tracking-wide text-ink-primary rounded-lg bg-black/5 dark:bg-white/10 backdrop-blur transition duration-300 hover:bg-black/10 dark:hover:bg-white/20">
                                Admin
                            </a>
                        @endif
                        <a href="{{ route('contact') }}" class="px-5 py-2 text-white font-semibold rounded-full bg-gradient-to-r from-blue-500 to-purple-500 shadow-lg shadow-purple-500/40 transition-transform duration-300 transform hover:-translate-y-0.5 hover:shadow-purple-600/50">
                            Commencer
                        </a>
                    </div>
                </div>

                <!-- Mobile Menu & CTA -->
                <div class="flex items-center gap-3 z-10">
                    <x-ui.theme-toggle class="lg:hidden" />
                    <button
                        type="button"
                        class="lg:hidden -m-2 p-2 text-ink-secondary hover:text-ink-primary"
                        data-mobile-menu-button
                        aria-controls="mobileMenu"
                        aria-expanded="false"
                        aria-label="Ouvrir le menu"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" data-mobile-menu class="mobile-menu lg:hidden hidden bg-surface-canvas/90 backdrop-blur-2xl border-t border-(--border-default) shadow-2xl shadow-black/40">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}" class="block px-3 py-2 text-ink-secondary hover:text-ink-primary hover:bg-black/5 dark:hover:bg-white/5 rounded-md transition-all duration-300 {{ request()->routeIs('home') ? 'text-blue-500 dark:text-blue-400 bg-black/5 dark:bg-white/5' : '' }}">
                Accueil
            </a>
            <a href="{{ route('services') }}" class="block px-3 py-2 text-ink-secondary hover:text-ink-primary hover:bg-black/5 dark:hover:bg-white/5 rounded-md transition-all duration-300 {{ request()->routeIs('services') || request()->routeIs('services.show') ? 'text-blue-500 dark:text-blue-400 bg-black/5 dark:bg-white/5' : '' }}">
                Services
            </a>
            <a href="{{ route('projects') }}" class="block px-3 py-2 text-ink-secondary hover:text-ink-primary hover:bg-black/5 dark:hover:bg-white/5 rounded-md transition-all duration-300 {{ request()->routeIs('projects') || request()->routeIs('projects.show') ? 'text-blue-500 dark:text-blue-400 bg-black/5 dark:bg-white/5' : '' }}">
                Projets
            </a>
            <a href="{{ route('products') }}" class="block px-3 py-2 text-ink-secondary hover:text-ink-primary hover:bg-black/5 dark:hover:bg-white/5 rounded-md transition-all duration-300 {{ request()->routeIs('products') || request()->routeIs('products.show') ? 'text-blue-500 dark:text-blue-400 bg-black/5 dark:bg-white/5' : '' }}">
                Produits
            </a>
            <a href="{{ route('news') }}" class="block px-3 py-2 text-ink-secondary hover:text-ink-primary hover:bg-black/5 dark:hover:bg-white/5 rounded-md transition-all duration-300 {{ request()->routeIs('news') || request()->routeIs('news.show') ? 'text-blue-500 dark:text-blue-400 bg-black/5 dark:bg-white/5' : '' }}">
                Actualités
            </a>
            <a href="{{ route('about') }}" class="block px-3 py-2 text-ink-secondary hover:text-ink-primary hover:bg-black/5 dark:hover:bg-white/5 rounded-md transition-all duration-300 {{ request()->routeIs('about') ? 'text-blue-500 dark:text-blue-400 bg-black/5 dark:bg-white/5' : '' }}">
                À Propos
            </a>
            <a href="{{ route('contact') }}" class="block px-3 py-2 text-ink-secondary hover:text-ink-primary hover:bg-black/5 dark:hover:bg-white/5 rounded-md transition-all duration-300 {{ request()->routeIs('contact') ? 'text-blue-500 dark:text-blue-400 bg-black/5 dark:bg-white/5' : '' }}">
                Contact
            </a>
        </div>
    </div>
</nav>
