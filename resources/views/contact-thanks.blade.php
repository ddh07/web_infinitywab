@extends('layouts.app')

@section('title', 'Message envoyé - Infinity WAB')
@section('description', 'Votre message a bien été reçu par Infinity WAB. Notre équipe vous répond sous 24h.')

@section('content')
<section class="relative overflow-hidden bg-surface-canvas text-ink-primary py-28 lg:py-36">
    <x-ui.hero-background page="contact-thanks" />
    <div class="absolute inset-0 opacity-[0.12] pointer-events-none" style="background-image: radial-gradient(circle, #6bbfa0 1px, transparent 1px); background-size: 28px 28px;" aria-hidden="true"></div>
    <div class="absolute inset-0 pointer-events-none bg-[radial-gradient(circle_at_top,_rgba(107, 191, 160,0.18),_transparent_45%)]"></div>

    <div class="relative z-10 max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6">
        <div class="mx-auto w-16 h-16 rounded-2xl bg-gradient-to-br from-mint-500 to-azure-500 flex items-center justify-center shadow-2xl shadow-(--glow-accent)">
            <svg class="w-8 h-8 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
            </svg>
        </div>
        <p class="font-mono text-xs uppercase tracking-[0.5em] text-mint-400">Message envoyé</p>
        <h1 class="font-display text-4xl md:text-5xl font-semibold">Merci, nous avons bien reçu votre message.</h1>
        <p class="text-lg text-ink-secondary">
            Notre équipe vous répond sous 24h à l’adresse que vous avez indiquée.
            @if($company?->whatsapp)
                Pour une réponse plus rapide, vous pouvez aussi nous écrire directement sur WhatsApp.
            @endif
        </p>
        <div class="flex flex-wrap justify-center gap-4 pt-2">
            @if($company?->whatsapp)
                <x-ui.button href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $company->whatsapp) }}" as="a">
                    Écrire sur WhatsApp
                </x-ui.button>
            @endif
            <x-ui.button href="{{ route('home') }}" variant="outline">
                Retour à l’accueil
            </x-ui.button>
        </div>

        <div class="pt-10 border-t border-(--border-default)">
            <p class="text-xs uppercase tracking-[0.3em] text-ink-muted mb-4">Pendant que vous patientez</p>
            <div class="flex flex-wrap justify-center gap-x-6 gap-y-2 text-sm font-mono uppercase tracking-[0.2em] text-ink-muted">
                <a href="{{ route('services') }}" class="hover:text-mint-400">Nos services</a>
                <a href="{{ route('projects') }}" class="hover:text-mint-400">Nos réalisations</a>
                <a href="{{ route('products') }}" class="hover:text-mint-400">Nos produits</a>
            </div>
        </div>
    </div>
    <x-ui.shape-divider shape="curve" fill="text-surface-raised" />
</section>
@endsection
