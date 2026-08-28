<header class="px-6 py-4">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold text-ink-primary">@yield('page-title', 'Administration')</h1>
            <p class="text-xs text-ink-muted">Infinity WAB</p>
        </div>

        <div class="flex items-center gap-3">
            <x-ui.theme-toggle />
            <a href="{{ url('/') }}" target="_blank" class="text-sm text-ink-secondary hover:text-azure-600">Voir le site</a>
            <div class="flex items-center gap-3 pl-3 border-l border-(--border-default)">
                <div class="flex items-center gap-2">
                    <div class="h-8 w-8 rounded-full bg-azure-600 flex items-center justify-center text-xs font-semibold text-white">{{ substr(auth()->user()->name ?? 'A', 0, 2) }}</div>
                    <div class="text-xs">
                        <div class="font-medium text-ink-primary">{{ auth()->user()->name ?? 'Admin' }}</div>
                        <div class="text-ink-muted truncate max-w-[140px]">{{ auth()->user()->email }}</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-ink-secondary hover:bg-red-50 hover:text-red-600 transition" title="Se déconnecter">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
