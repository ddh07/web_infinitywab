@extends('layouts.error')

@section('title', 'Page introuvable - Infinity WAB')
@section('description', 'Cette page n’existe pas ou plus. Retrouvez nos services, projets et produits depuis l’accueil Infinity WAB.')

@section('content')
<section class="relative overflow-hidden bg-surface-canvas text-ink-primary py-28 lg:py-36">
    <div class="absolute inset-0 opacity-[0.12] pointer-events-none" style="background-image: radial-gradient(circle, #6bbfa0 1px, transparent 1px); background-size: 28px 28px;" aria-hidden="true"></div>
    <div class="absolute inset-0 pointer-events-none bg-[radial-gradient(circle_at_top,_rgba(107, 191, 160,0.16),_transparent_45%)]"></div>

    <div class="relative z-10 max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6">
        <p class="font-mono text-xs uppercase tracking-[0.5em] text-mint-400">Erreur 404</p>
        <h1 class="font-display text-5xl md:text-7xl font-semibold text-gradient">Page introuvable</h1>
        <p class="text-lg text-ink-secondary">
            La page que vous cherchez a été déplacée, renommée, ou n’a jamais existé. Repartons sur une piste connue.
        </p>
        <div class="flex flex-wrap justify-center gap-4 pt-2">
            <x-ui.button href="{{ route('home') }}">
                Retour à l’accueil
            </x-ui.button>
            <x-ui.button href="{{ route('contact') }}" variant="outline">
                Nous contacter
            </x-ui.button>
        </div>
        <div class="flex flex-wrap justify-center gap-x-6 gap-y-2 pt-6 text-sm font-mono uppercase tracking-[0.2em] text-ink-muted">
            <a href="{{ route('services') }}" class="hover:text-mint-400">Services</a>
            <a href="{{ route('projects') }}" class="hover:text-mint-400">Projets</a>
            <a href="{{ route('products') }}" class="hover:text-mint-400">Produits</a>
            <a href="{{ route('about') }}" class="hover:text-mint-400">À propos</a>
        </div>
    </div>
</section>
@endsection
