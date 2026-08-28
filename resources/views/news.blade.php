@extends('layouts.app')

@section('title', 'Actualités - Infinity WAB')
@section('description', 'Les dernières actualités, annonces et retours d’expérience d’Infinity WAB au Burkina Faso.')

@section('content')
@php
    use Illuminate\Support\Str;

    $typeLabels = [
        'post' => 'Article',
        'article' => 'Article',
        'announcement' => 'Annonce',
    ];
@endphp


<!-- Hero -->
<section class="relative overflow-hidden bg-gradient-to-br from-surface-raised via-surface-canvas to-surface-raised text-ink-primary pt-28 lg:pt-32 pb-20">
    <x-ui.hero-background page="news" />
    <div class="absolute inset-0 pointer-events-none bg-[radial-gradient(circle_at_top,_rgba(107, 191, 160,0.25),_transparent_45%)]"></div>
    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <p class="font-mono text-xs uppercase tracking-[0.5em] text-mint-400">Actualités</p>
        <h1 class="font-display text-4xl md:text-5xl font-bold">
            Les dernières nouvelles d’Infinity WAB.
        </h1>
        <p class="text-lg text-ink-secondary leading-relaxed max-w-2xl">
            Annonces, retours d’expérience et actualités de nos équipes techniques au Burkina Faso.
        </p>
    </div>
    <x-ui.shape-divider shape="angle" fill="text-surface-canvas" />
</section>

<!-- Featured -->
@if($featured->isNotEmpty())
<section class="py-16 bg-surface-canvas">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <div data-reveal>
            <p class="font-mono text-xs uppercase tracking-[0.4em] text-mint-400 mb-2">À la une</p>
            <h2 class="font-display text-3xl font-semibold text-ink-primary">Contenus mis en avant</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($featured as $item)
                <article class="relative overflow-hidden rounded-3xl border border-(--border-default) bg-surface-raised/70 p-5 shadow-2xl shadow-(--glow-accent) group" data-reveal style="--reveal-delay: {{ $loop->index * 100 }}ms">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(107, 191, 160,0.25),_transparent_55%)] opacity-0 group-hover:opacity-100 transition"></div>
                    <div class="relative z-10 space-y-4">
                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-mint-500/10 text-mint-600 dark:text-mint-300 border border-mint-500/30">
                            {{ $typeLabels[$item->type] ?? ucfirst($item->type) }}
                        </span>
                        <h3 class="font-display text-xl font-semibold text-ink-primary">{{ $item->title }}</h3>
                        <p class="text-ink-secondary line-clamp-3">{{ Str::limit(strip_tags($item->excerpt ?? $item->content), 140) }}</p>
                        <a href="{{ route('news.show', $item->slug) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-mint-400 hover:text-ink-primary">
                            Lire la suite
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Grid -->
<section class="py-16 bg-surface-raised">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        <div class="flex items-center justify-between" data-reveal>
            <div>
                <p class="font-mono text-xs uppercase tracking-[0.4em] text-mint-400 mb-2">Toutes les actualités</p>
                <h2 class="font-display text-3xl font-semibold text-ink-primary">Le fil Infinity WAB</h2>
            </div>
            @if($articles->hasPages())
                <span class="text-sm text-ink-muted">Page {{ $articles->currentPage() }} sur {{ $articles->lastPage() }}</span>
            @endif
        </div>

        @if($articles->isEmpty())
            <div class="text-center py-16 rounded-3xl border border-(--border-default) bg-surface-canvas/70">
                <p class="text-ink-secondary">Aucune actualité publiée pour le moment. Revenez bientôt !</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($articles as $item)
                    <article class="flex flex-col rounded-3xl border border-(--border-default) bg-surface-canvas/70 shadow-2xl shadow-(--glow-accent) overflow-hidden transition hover:-translate-y-1" data-reveal style="--reveal-delay: {{ $loop->index * 80 }}ms">
                        <div class="h-48 bg-gradient-to-br from-mint-500/10 to-azure-500/10 relative">
                            <img src="{{ $item->featured_image_url }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                            <span class="absolute top-4 left-4 px-3 py-1 text-xs font-semibold rounded-full border border-white/20 bg-white/10 text-white">
                                {{ $typeLabels[$item->type] ?? ucfirst($item->type) }}
                            </span>
                        </div>
                        <div class="flex-1 flex flex-col p-6 space-y-4">
                            <h3 class="font-display text-xl font-semibold text-ink-primary">{{ $item->title }}</h3>
                            <p class="text-sm text-ink-secondary flex-1 leading-relaxed line-clamp-3">{{ Str::limit(strip_tags($item->excerpt ?? $item->content), 160) }}</p>
                            <div class="flex items-center justify-between text-xs text-ink-muted">
                                <span>{{ $item->published_at?->format('d M Y') ?? $item->created_at->format('d M Y') }}</span>
                                <a href="{{ route('news.show', $item->slug) }}" class="font-semibold text-mint-400 hover:text-ink-primary inline-flex items-center gap-1">
                                    Lire
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
            @if($articles->hasPages())
                <div class="text-center">
                    {{ $articles->links() }}
                </div>
            @endif
        @endif
    </div>
</section>

<!-- CTA -->
<section class="py-16 bg-gradient-to-r from-mint-700 via-azure-700 to-azure-600 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6" data-reveal>
        <p class="font-mono text-xs uppercase tracking-[0.6em] text-mint-300">Une question sur nos actualités ?</p>
        <h2 class="font-display text-3xl font-semibold">Discutons de votre prochain projet.</h2>
        <x-ui.button href="{{ route('contact') }}" variant="light">
            Nous contacter
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </x-ui.button>
    </div>
</section>
@endsection
