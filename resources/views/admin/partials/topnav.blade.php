<header class="px-6 py-4">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold text-slate-800">@yield('page-title', 'Administration')</h1>
            <p class="text-xs text-slate-500">Infinity WAB</p>
        </div>

        <div class="flex items-center gap-3">
            <button id="themeToggle" class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 hover:text-slate-700 transition" title="Changer le thème">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="themeIcon">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </button>
            <a href="{{ url('/') }}" target="_blank" class="text-sm text-slate-600 hover:text-indigo-600">Voir le site</a>
            <div class="flex items-center gap-3 pl-3 border-l border-slate-200">
                <div class="flex items-center gap-2">
                    <div class="h-8 w-8 rounded-full bg-indigo-600 flex items-center justify-center text-xs font-semibold text-white">{{ substr(auth()->user()->name ?? 'A', 0, 2) }}</div>
                    <div class="text-xs">
                        <div class="font-medium text-slate-800">{{ auth()->user()->name ?? 'Admin' }}</div>
                        <div class="text-slate-500 truncate max-w-[140px]">{{ auth()->user()->email }}</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-slate-600 hover:bg-red-50 hover:text-red-600 transition" title="Se déconnecter">
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
