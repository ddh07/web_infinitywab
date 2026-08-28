@extends('layouts.error')

@section('title', 'Erreur serveur - Infinity WAB')
@section('description', 'Une erreur inattendue est survenue. Notre équipe a été notifiée, réessayez dans quelques instants.')

@section('content')
<section class="relative overflow-hidden bg-surface-canvas text-ink-primary py-28 lg:py-36">
    <div class="absolute inset-0 opacity-[0.12] pointer-events-none" style="background-image: radial-gradient(circle, #6bbfa0 1px, transparent 1px); background-size: 28px 28px;" aria-hidden="true"></div>
    <div class="absolute inset-0 pointer-events-none bg-[radial-gradient(circle_at_top,_rgba(91, 194, 217,0.16),_transparent_45%)]"></div>

    <div class="relative z-10 max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6">
        <p class="font-mono text-xs uppercase tracking-[0.5em] text-mint-400">Erreur 500</p>
        <h1 class="font-display text-5xl md:text-7xl font-semibold text-gradient">Un imprévu technique</h1>
        <p class="text-lg text-ink-secondary">
            Quelque chose s’est mal passé de notre côté. Notre équipe technique en a été informée automatiquement — réessayez dans quelques instants.
        </p>
        <div class="flex flex-wrap justify-center gap-4 pt-2">
            <x-ui.button href="{{ route('home') }}">
                Retour à l’accueil
            </x-ui.button>
            <x-ui.button href="{{ route('contact') }}" variant="outline">
                Signaler le problème
            </x-ui.button>
        </div>
    </div>
</section>
@endsection
