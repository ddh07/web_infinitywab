@extends('layouts.app')

@section('title', ($article->meta_title ?: $article->title) . ' - Infinity WAB')
@section('description', Str::limit(strip_tags($article->meta_description ?: ($article->excerpt ?: $article->content)), 160))
@section('og_image', $article->featured_image_url)

@section('content')
@php
    use Illuminate\Support\Str;

    $typeLabels = [
        'post' => 'Article',
        'article' => 'Article',
        'announcement' => 'Annonce',
        'page' => 'Page',
    ];
@endphp

<!-- Hero -->
<section class="relative overflow-hidden bg-gradient-to-br from-surface-raised via-surface-canvas to-surface-raised text-ink-primary pt-28 lg:pt-32 pb-20">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(107, 191, 160,0.35),_transparent_45%)] opacity-50 pointer-events-none"></div>
    <x-ui.hero-shapes variant="rings" />
    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="flex flex-wrap items-center gap-3">
            <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-mint-500/10 text-mint-600 dark:text-mint-300 border border-mint-500/30">
                {{ $typeLabels[$article->type] ?? ucfirst($article->type) }}
            </span>
            <span class="text-xs text-ink-muted">
                {{ $article->published_at?->format('d M Y') ?? $article->created_at->format('d M Y') }}
            </span>
        </div>
        <h1 class="font-display text-4xl md:text-5xl font-bold leading-tight">
            {{ $article->title }}
        </h1>
        @if($article->excerpt)
            <p class="text-lg text-ink-secondary max-w-3xl">{{ $article->excerpt }}</p>
        @endif
    </div>
    <x-ui.shape-divider shape="curve" fill="text-surface-raised" />
</section>

<!-- Content -->
<section class="py-16 bg-surface-raised">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 grid gap-10 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-8">
            <div class="rounded-3xl overflow-hidden border border-(--border-default) shadow-2xl shadow-(--glow-accent)">
                <img src="{{ $article->featured_image_url }}" alt="{{ $article->title }}" class="w-full h-96 object-cover">
            </div>

            <article class="bg-surface-canvas/70 rounded-3xl border border-(--border-default) p-8 shadow-2xl shadow-(--glow-accent)">
                <div class="prose dark:prose-invert max-w-none text-ink-secondary leading-relaxed">
                    {!! $article->content !!}
                </div>
            </article>
        </div>

        <aside class="space-y-6">
            <article class="bg-surface-canvas/70 rounded-3xl border border-(--border-default) p-6 shadow-2xl shadow-(--glow-accent) space-y-4">
                <h3 class="font-display text-xl font-semibold text-ink-primary">Détails</h3>
                <ul class="space-y-3 text-sm text-ink-secondary">
                    <li class="flex justify-between border-b border-(--border-default) pb-2">
                        <span class="text-ink-muted">Type</span>
                        <span class="text-ink-primary font-semibold">{{ $typeLabels[$article->type] ?? ucfirst($article->type) }}</span>
                    </li>
                    <li class="flex justify-between border-b border-(--border-default) pb-2">
                        <span class="text-ink-muted">Publié le</span>
                        <span class="text-ink-primary font-semibold">{{ $article->published_at?->format('d M Y') ?? $article->created_at->format('d M Y') }}</span>
                    </li>
                    @if($article->author)
                        <li class="flex justify-between">
                            <span class="text-ink-muted">Auteur</span>
                            <span class="text-ink-primary font-semibold">{{ $article->author->name }}</span>
                        </li>
                    @endif
                </ul>
            </article>

            <article class="bg-surface-canvas/70 rounded-3xl border border-(--border-default) p-6 shadow-2xl shadow-(--glow-accent) text-center">
                <p class="text-sm text-ink-muted mb-4">Une question, un projet en tête ?</p>
                <a href="{{ route('contact') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-mint-500 to-azure-500 rounded-2xl text-white font-semibold shadow-xl shadow-mint-600/50">
                    Discuter avec l’équipe
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </article>
        </aside>
    </div>
</section>

<!-- Related -->
@if($related->isNotEmpty())
    <section class="py-20 bg-surface-canvas">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <div class="text-center" data-reveal>
                <p class="font-mono text-xs uppercase tracking-[0.5em] text-mint-400 mb-2">À lire aussi</p>
                <h2 class="font-display text-3xl font-semibold text-ink-primary">Autres actualités</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($related as $item)
                    <article class="bg-surface-raised/70 rounded-3xl border border-(--border-default) p-6 shadow-2xl shadow-(--glow-accent) space-y-4" data-reveal style="--reveal-delay: {{ $loop->index * 100 }}ms">
                        <div class="h-40 w-full overflow-hidden rounded-2xl">
                            <img src="{{ $item->featured_image_url }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                        </div>
                        <h3 class="font-display text-xl font-semibold text-ink-primary">{{ $item->title }}</h3>
                        <p class="text-sm text-ink-secondary line-clamp-3">{{ Str::limit(strip_tags($item->excerpt ?? $item->content), 120) }}</p>
                        <a href="{{ route('news.show', $item->slug) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-mint-400 hover:text-ink-primary">
                            Découvrir
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endif
@endsection
