@extends('layouts.login')

@section('title', 'Vérifier votre email - Infinity WAB')

@section('content')
<section class="min-h-screen relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950"></div>
    <div class="absolute inset-0 opacity-30 bg-[radial-gradient(circle_at_top,_rgba(59,130,246,0.25),_transparent_45%)]"></div>
    <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_bottom,_rgba(139,92,246,0.20),_transparent_55%)]"></div>

    <div class="relative z-10 min-h-screen flex items-center justify-center px-4 py-14">
        <div class="w-full max-w-md space-y-6">
            <div class="text-center space-y-3 animate-fade-in">
                <div class="mx-auto h-14 w-14 rounded-2xl bg-gradient-to-br from-blue-500 to-purple-500 shadow-2xl shadow-blue-900/40 flex items-center justify-center">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-semibold">Vérifiez votre email</h1>
                <p class="text-white/60">Un lien de confirmation a été envoyé à l’adresse associée à votre compte.</p>
            </div>

            @if (session('status'))
                <div class="rounded-2xl border border-emerald-500/30 bg-emerald-500/10 p-4 text-sm text-emerald-200">
                    {{ session('status') }}
                </div>
            @endif

            @if (session('resent'))
                <div class="rounded-2xl border border-emerald-500/30 bg-emerald-500/10 p-4 text-sm text-emerald-200">
                    Un nouveau lien de vérification vient d’être envoyé. Consultez votre boîte de réception et vos courriers indésirables.
                </div>
            @endif

            <div class="rounded-[28px] border border-white/10 bg-slate-900/60 p-6 shadow-2xl shadow-black/60 backdrop-blur animate-fade-in-up space-y-5">
                <div class="space-y-3 text-sm text-white/75 leading-relaxed">
                    <p>
                        Avant de continuer, ouvrez l’email que nous vous avons envoyé et cliquez sur le bouton
                        <span class="font-semibold text-white">Confirmer mon email</span>.
                    </p>
                    <p class="text-white/55 text-xs">
                        Si le message n’apparaît pas tout de suite, attendez quelques minutes ou vérifiez le dossier spam.
                    </p>
                </div>

                <div class="rounded-2xl border border-white/10 bg-slate-950/40 p-4 text-xs text-white/50">
                    <p class="font-semibold text-white/70 mb-1">Compte connecté</p>
                    <p class="text-white/90 truncate">{{ auth()->user()->email }}</p>
                </div>

                <form method="POST" action="{{ route('verification.resend') }}" class="space-y-4">
                    @csrf
                    <x-ui.button type="submit" class="w-full">
                        Renvoyer l’email de vérification
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </x-ui.button>
                </form>

                <p class="text-center text-xs text-white/45">
                    Vous n’êtes pas à l’origine de cette inscription ? Contactez l’administrateur du site.
                </p>
            </div>

            <div class="text-center flex flex-col sm:flex-row items-center justify-center gap-4">
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm font-semibold text-white/70 hover:text-white">
                        Se déconnecter
                    </button>
                </form>
                <span class="hidden sm:inline text-white/20">|</span>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-white/70 hover:text-white">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Retour au site
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
