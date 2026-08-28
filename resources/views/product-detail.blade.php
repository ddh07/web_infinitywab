@extends('layouts.app')

@section('title', $product->title . ' - Infinity WAB')
@section('description', Str::limit(strip_tags($product->description ?? $product->content), 160))

@section('content')
@php
    $images = is_string($product->images) ? json_decode($product->images, true) : ($product->images ?? []);
    $specs = is_string($product->specifications) ? json_decode($product->specifications, true) : ($product->specifications ?? []);
    $gallery = is_string($product->gallery) ? json_decode($product->gallery, true) : ($product->gallery ?? []);
@endphp

<!-- Hero -->
<section class="relative overflow-hidden bg-gradient-to-br from-surface-raised via-surface-canvas to-surface-raised text-ink-primary pt-28 lg:pt-32 pb-20">
    <div class="absolute inset-0 pointer-events-none bg-[radial-gradient(circle_at_top,_rgba(107, 191, 160,0.3),_transparent_45%)]"></div>
    <x-ui.hero-shapes variant="orbit" />
    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 grid gap-10 lg:grid-cols-2 items-center">
        <div class="space-y-6">
            <p class="font-mono text-xs uppercase tracking-[0.5em] text-mint-400">Produit Infinity WAB</p>
            <h1 class="font-display text-4xl md:text-5xl font-bold leading-tight">
                {{ $product->title }}
            </h1>
            <p class="text-lg text-ink-secondary leading-relaxed">
                {{ $product->description }}
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('contact') }}" class="btn-animated inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-mint-500 to-azure-500 rounded-2xl text-white font-semibold shadow-xl shadow-mint-600/50">
                    Demander un devis
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
                <a href="{{ route('products') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl border border-(--border-default) text-ink-secondary hover:text-ink-primary">
                    Retour au catalogue
                </a>
            </div>
        </div>
        <div class="space-y-6">
            <div class="rounded-3xl border border-(--border-default) bg-surface-raised/70 p-8 shadow-2xl shadow-(--glow-accent) relative overflow-hidden">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(107, 191, 160,0.2),_transparent_60%)]"></div>
                <div class="relative z-10 space-y-4">
                    <p class="font-mono text-xs uppercase tracking-[0.5em] text-ink-muted">Prix</p>
                    <p class="font-display text-3xl font-semibold text-gradient">{{ $product->price ? number_format($product->price, 0, ',', ' ') . ' FCFA' : 'Sur devis' }}</p>
                    <p class="font-mono text-xs uppercase tracking-[0.4em] text-mint-400">Disponibilité</p>
                    <p class="text-sm text-ink-secondary">Stock limité · Livraison rapide</p>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-3">
                <div class="rounded-2xl bg-surface-raised/70 border border-(--border-default) p-4 text-center">
                    <p class="text-xs uppercase tracking-[0.4em] text-ink-muted">Catégorie</p>
                    <p class="text-sm font-semibold text-ink-primary">{{ $product->category }}</p>
                </div>
                <div class="rounded-2xl bg-surface-raised/70 border border-(--border-default) p-4 text-center">
                    <p class="text-xs uppercase tracking-[0.4em] text-ink-muted">Vedette</p>
                    <p class="text-sm font-semibold text-ink-primary">{{ $product->is_featured ? 'Oui' : 'Standard' }}</p>
                </div>
                <div class="rounded-2xl bg-surface-raised/70 border border-(--border-default) p-4 text-center">
                    <p class="text-xs uppercase tracking-[0.4em] text-ink-muted">Support</p>
                    <p class="text-sm font-semibold text-ink-primary">7j/7</p>
                </div>
            </div>
        </div>
    </div>
    <x-ui.shape-divider shape="angle" fill="text-surface-canvas" />
</section>

<!-- Details -->
<section class="py-16 bg-surface-canvas">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 grid gap-10 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-8">
            <div class="rounded-3xl border border-(--border-default) bg-surface-raised/70 overflow-hidden shadow-2xl shadow-(--glow-accent)">
                @if($images)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($images as $index => $image)
                            <div class="relative h-64">
                                @php
                                    $src = \App\Support\ImagePath::resolve($image, 'images/placeholder-product.png');
                                @endphp
                                <img src="{{ $src }}" alt="{{ $product->title }} - image {{ $index + 1 }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="h-64 bg-gradient-to-br from-mint-500/20 to-azure-500/20 flex items-center justify-center">
                        <svg class="w-16 h-16 text-ink-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                @endif
            </div>

            @if($product->content)
                <article class="rounded-3xl border border-(--border-default) bg-surface-raised/70 p-8 shadow-2xl shadow-(--glow-accent)">
                    <h2 class="font-display text-2xl font-semibold text-ink-primary mb-4">À propos du produit</h2>
                    <div class="prose prose-invert max-w-none text-ink-secondary leading-relaxed">
                        {!! $product->content !!}
                    </div>
                </article>
            @endif

            @if($specs)
                <article class="rounded-3xl border border-(--border-default) bg-surface-raised/70 p-8 shadow-2xl shadow-(--glow-accent)">
                    <h3 class="font-display text-xl font-semibold text-ink-primary mb-4">Spécifications essentielles</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($specs as $key => $value)
                            <div class="rounded-2xl bg-surface-canvas/60 border border-(--border-default) px-4 py-3 text-ink-secondary flex justify-between text-sm">
                                <span>{{ $key }}</span>
                                <span class="font-semibold text-ink-primary">{{ $value }}</span>
                            </div>
                        @endforeach
                    </div>
                </article>
            @endif

            @if($gallery)
                <article class="rounded-3xl border border-(--border-default) bg-surface-raised/70 p-8 shadow-2xl shadow-(--glow-accent)">
                    <h3 class="font-display text-xl font-semibold text-ink-primary mb-4">Galerie</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($gallery as $image)
                            <div class="rounded-2xl overflow-hidden h-48">
                                @php
                                    $src = \App\Support\ImagePath::resolve($image, 'images/placeholder-product.png');
                                @endphp
                                <img src="{{ $src }}" alt="{{ $product->title }} galerie" class="w-full h-full object-cover transition-all duration-500 hover:scale-105">
                            </div>
                        @endforeach
                    </div>
                </article>
            @endif
        </div>

        <aside class="space-y-6">
            <div class="rounded-3xl border border-(--border-default) bg-gradient-to-br from-mint-600 to-azure-600 p-6 shadow-2xl shadow-black/60 text-white space-y-3">
                <p class="font-mono text-xs uppercase tracking-[0.5em]">Support inclus</p>
                <p class="font-display text-lg font-semibold">Installation, configuration, formation & maintenance</p>
                <p class="text-sm text-white/80">Accompagnement dédié tout au long du déploiement.</p>
                <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-4 py-3 bg-white text-slate-900 font-semibold rounded-2xl shadow-lg shadow-mint-600/40">
                    Planifier un briefing
                </a>
            </div>
            <div class="rounded-3xl border border-(--border-default) bg-surface-raised/70 p-6 shadow-2xl shadow-(--glow-accent)">
                <h4 class="font-display text-lg font-semibold text-ink-primary mb-3">Charges supplémentaires</h4>
                <ul class="space-y-3 text-sm text-ink-secondary">
                    <li>📦 Livraison express Ouagadougou & régions</li>
                    <li>🛡️ Garantie 24 mois pièces et main d’œuvre</li>
                    <li>🔒 Assistance sécurité renforcée</li>
                </ul>
            </div>
        </aside>
    </div>
</section>

<!-- Related -->
@php
    $relatedProducts = \App\Models\Product::where('id', '!=', $product->id)
        ->where('is_active', true)
        ->inRandomOrder()
        ->limit(3)
        ->get();
@endphp
@if($relatedProducts->isNotEmpty())
    <section class="py-20 bg-surface-raised">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <div class="text-center" data-reveal>
                <p class="font-mono text-xs uppercase tracking-[0.5em] text-mint-400 mb-2">Produits similaires</p>
                <h2 class="font-display text-3xl font-semibold text-ink-primary">Complétez votre parc</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedProducts as $related)
                    <article class="rounded-3xl border border-(--border-default) bg-surface-canvas/70 p-6 shadow-2xl shadow-(--glow-accent) space-y-3" data-reveal style="--reveal-delay: {{ $loop->index * 100 }}ms">
                        <div class="h-40 w-full overflow-hidden rounded-2xl">
                            <img src="{{ $related->cover_url }}" alt="{{ $related->title }}" class="w-full h-full object-cover">
                        </div>
                        <h3 class="font-display text-xl font-semibold text-ink-primary">{{ $related->title }}</h3>
                        <p class="text-sm text-ink-secondary line-clamp-3">{{ Str::limit($related->description, 120) }}</p>
                        @if($related->price)
                            <p class="text-sm font-semibold text-ink-primary">{{ number_format($related->price, 0, ',', ' ') }} FCFA</p>
                        @endif
                        <a href="{{ route('products.show', $related->slug) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-mint-400 hover:text-ink-primary">
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
