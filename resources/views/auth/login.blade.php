@extends('layouts.login')

@section('title', 'Connexion - Admin Infinity WAB')
@section('description', 'Page de connexion pour l\'administration du site Infinity WAB')

@section('content')
<section class="min-h-screen relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-surface-canvas via-surface-raised to-surface-canvas"></div>
    <div class="absolute inset-0 opacity-30 bg-[radial-gradient(circle_at_top,_rgba(59,130,246,0.25),_transparent_45%)]"></div>
    <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_bottom,_rgba(139,92,246,0.20),_transparent_55%)]"></div>

    <div class="relative z-10 min-h-screen flex items-center justify-center px-4 py-14">
        <div class="w-full max-w-md space-y-6">
            <div class="text-center space-y-3 animate-fade-in">
                <div class="mx-auto h-14 w-14 rounded-2xl bg-gradient-to-br from-blue-500 to-purple-500 shadow-2xl shadow-blue-900/40 flex items-center justify-center">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-semibold text-ink-primary">Connexion</h1>
                <p class="text-ink-muted">Accédez au panneau d’administration Infinity WAB.</p>
            </div>

            @if (session('error'))
                <div class="rounded-2xl border border-rose-500/30 bg-rose-500/10 p-4 text-sm text-rose-200">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('success'))
                <div class="rounded-2xl border border-emerald-500/30 bg-emerald-500/10 p-4 text-sm text-emerald-200">
                    {{ session('success') }}
                </div>
            @endif

            <div class="rounded-[28px] border border-(--border-default) bg-surface-raised/70 p-6 shadow-2xl shadow-(--glow-accent) backdrop-blur animate-fade-in-up">
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div class="space-y-2">
                        <label for="email" class="text-xs font-semibold uppercase tracking-[0.35em] text-ink-muted">Email</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                            autofocus
                            placeholder=""
                            @error('email') aria-invalid="true" aria-describedby="email-error" @enderror
                            class="w-full rounded-2xl border border-(--border-default) bg-surface-sunken px-4 py-3 text-sm text-ink-primary placeholder-ink-muted focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 @error('email') border-rose-400 @enderror"
                        >
                        @error('email')
                            <p id="email-error" class="text-sm text-rose-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="password" class="text-xs font-semibold uppercase tracking-[0.35em] text-ink-muted">Mot de passe</label>
                        <div class="relative">
                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="••••••••"
                                @error('password') aria-invalid="true" aria-describedby="password-error" @enderror
                                class="w-full rounded-2xl border border-(--border-default) bg-surface-sunken px-4 py-3 pr-24 text-sm text-ink-primary placeholder-ink-muted focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 @error('password') border-rose-400 @enderror"
                            >
                            <button
                                type="button"
                                data-password-toggle="#password"
                                aria-pressed="false"
                                class="absolute right-1.5 top-1/2 h-11 -translate-y-1/2 rounded-xl border border-(--border-default) bg-black/5 dark:bg-white/5 px-3 text-xs font-semibold text-ink-secondary hover:bg-black/10 dark:hover:bg-white/10"
                            >
                                <span data-password-toggle-label>Afficher</span>
                            </button>
                        </div>
                        @error('password')
                            <p id="password-error" class="text-sm text-rose-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="inline-flex items-center gap-2 text-sm text-ink-secondary">
                            <input id="remember" name="remember" type="checkbox" class="h-4 w-4 rounded border-(--border-default) bg-surface-sunken text-blue-500 focus:ring-blue-400">
                            Se souvenir de moi
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm font-semibold text-blue-300 hover:text-white">Mot de passe oublié ?</a>
                        @endif
                    </div>

                    <x-ui.button type="submit" class="w-full">
                        Se connecter
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </x-ui.button>
                </form>

                @if(config('app.debug'))
                <div class="mt-6 rounded-2xl border border-amber-500/30 bg-amber-500/10 p-4 text-sm text-amber-200">
                    <p class="font-semibold mb-1">Environnement de développement</p>
                    <p class="text-ink-secondary">Identifiants admin générés par <code>php artisan db:seed</code> (voir la sortie de la commande).</p>
                </div>
                @endif
            </div>

            <div class="text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-ink-secondary hover:text-ink-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Retour au site
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
