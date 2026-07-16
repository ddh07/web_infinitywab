@extends('layouts.app')

@section('title', 'Nos Produits - Infinity WAB')
@section('description', 'Un catalogue curaté de solutions matérielles et numériques pour accompagner votre croissance.')

@section('content')
@php
    use Illuminate\Support\Str;

    $heroProducts = $featuredProducts->isNotEmpty() ? $featuredProducts : $products->take(3);
@endphp

<section class="relative overflow-hidden bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950 text-white">
    <div class="absolute inset-0 opacity-30 bg-[radial-gradient(circle_at_bottom,_rgba(14,165,233,0.2),_transparent_55%)]"></div>
    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="max-w-3xl space-y-6">
            <p class="text-xs uppercase tracking-[0.4em] text-blue-300">Produits</p>
            <h1 class="text-4xl md:text-5xl font-bold leading-tight">Matériels & solutions prêts pour vos équipes.</h1>
            <p class="text-lg text-white/70">
                Notre catalogue regroupe des équipements Cisco, des bornes Starlink, des stations de travail haut de gamme et des packs logiciels
                prêts à intégrer votre infrastructure sans compromis sur la sécurité ni la performance.
            </p>
            <div class="flex flex-wrap gap-4">
                <x-ui.button href="{{ route('contact') }}">
                    Demander un devis
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </x-ui.button>
                <x-ui.button href="#catalogue" variant="outline">
                    Explorer le catalogue
                </x-ui.button>
            </div>
        </div>
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="rounded-3xl border border-white/10 bg-slate-900/70 p-6 shadow-lg shadow-black/40">
                <p class="text-xs uppercase tracking-[0.4em] text-white/60">Produits disponibles</p>
                <p class="text-4xl font-bold text-gradient mb-1">{{ $productHighlights['total'] }}</p>
                <p class="text-xs uppercase text-white/50">références actives</p>
            </div>
            <div class="rounded-3xl border border-white/10 bg-slate-900/70 p-6 shadow-lg shadow-black/40">
                <p class="text-xs uppercase tracking-[0.4em] text-white/60">Produits vedettes</p>
                <p class="text-4xl font-bold text-gradient mb-1">{{ $productHighlights['featured'] }}</p>
                <p class="text-xs uppercase text-white/50">sélections récentes</p>
            </div>
            <div class="rounded-3xl border border-white/10 bg-slate-900/70 p-6 shadow-lg shadow-black/40">
                <p class="text-xs uppercase tracking-[0.4em] text-white/60">Prix moyen</p>
                <p class="text-4xl font-bold text-gradient mb-1">
                    {{ $productHighlights['avg_price'] ? number_format($productHighlights['avg_price'], 0, ',', ' ') : '—' }} FCFA
                </p>
                <p class="text-xs uppercase text-white/50">sur les stocks actuels</p>
            </div>
        </div>
        <div class="mt-10 flex flex-wrap gap-3">
            @foreach($categoryFilters as $category)
                <span class="px-4 py-2 rounded-full border border-white/20 text-sm font-semibold text-white/80 bg-slate-900/40">
                    {{ $category }}
                </span>
            @endforeach
        </div>
    </div>
</section>

<section id="catalogue" class="py-20 bg-slate-950">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        <div>
            <p class="text-xs uppercase tracking-[0.5em] text-blue-400 mb-2">Sélections</p>
            <h2 class="text-3xl font-semibold text-white">Produits en avant</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($heroProducts as $product)
                @php
                    $images = is_string($product->images) ? json_decode($product->images, true) : ($product->images ?? []);
                    $coverPath = $images[0] ?? 'images/placeholder-product.png';
                    $coverPath = ltrim($coverPath, '/');
                    if (!str_starts_with($coverPath, 'images/')) {
                        $coverPath = 'images/' . $coverPath;
                    }
                    $cover = file_exists(public_path($coverPath)) ? asset($coverPath) : asset('images/placeholder-product.png');
                @endphp
                <article class="relative rounded-3xl border border-white/10 bg-gradient-to-br from-slate-900/70 to-slate-950/30 p-6 overflow-hidden shadow-2xl shadow-black/50">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/20 via-transparent to-purple-500/10 opacity-0 transition-all group-hover:opacity-100"></div>
                    <div class="relative z-10 flex flex-col h-full">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-xs uppercase tracking-[0.3em] text-white/60">#{{ $product->category }}</p>
                                <h3 class="text-xl font-semibold text-white">{{ $product->title }}</h3>
                            </div>
                            @if($product->is_featured)
                                <span class="text-xs font-semibold px-3 py-1 rounded-full bg-rose-500/20 text-rose-200 border border-rose-500/30">Vedette</span>
                            @endif
                        </div>
                        <div class="mb-4 h-40 overflow-hidden rounded-2xl bg-slate-900">
                            <img src="{{ $cover }}" alt="{{ $product->title }}" class="w-full h-full object-cover transition-all duration-500 hover:scale-105">
                        </div>
                        <p class="text-sm text-white/70 mb-4 line-clamp-3">{{ Str::limit($product->description, 140) }}</p>
                        <div class="mt-auto flex items-center justify-between text-sm text-white/60">
                            <span>{{ number_format($product->price ?? 0, 0, ',', ' ') }} FCFA</span>
                            <a href="{{ route('products.show', $product->slug) }}" class="font-semibold text-blue-300 hover:text-white inline-flex items-center gap-1">
                                Détails
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="py-20 bg-slate-900">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-6">
                <div class="rounded-3xl border border-white/10 bg-slate-950/60 p-6">
                    <h3 class="text-2xl font-semibold text-white mb-3">Catalogue complet</h3>
                    <p class="text-white/70 leading-relaxed">
                        Chaque produit est vérifié, testé et accompagné d’un accompagnement technique Infinity WAB :
                        configuration, déploiement, gestion des licences et formation des équipes.
                    </p>
                </div>
                <div class="rounded-3xl border border-white/10 bg-gradient-to-br from-blue-500/20 to-purple-500/20 p-6 text-white">
                    <h3 class="text-2xl font-semibold mb-3">Support & maintenance</h3>
                    <ul class="space-y-3 text-sm text-white/80">
                        <li class="flex items-center gap-3">
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                            Assistance 24/7
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-2 h-2 rounded-full bg-blue-400"></span>
                            Livraison express sur Ouagadougou
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-2 h-2 rounded-full bg-purple-400"></span>
                            Garantie étendue et SLA
                        </li>
                    </ul>
                </div>
            </div>
            <div>
                <div class="rounded-3xl border border-white/10 bg-slate-950/70 p-6">
                    <h3 class="text-2xl font-semibold text-white mb-4">Filtres avancés</h3>
                    <p class="text-sm text-white/70 mb-4">
                        Utilisez les filtres pour voir les gammes en stock, détecter les nouveautés ou assembler des kits sur mesure.
                    </p>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['En stock', 'Personnalisable', 'Pack mobilité', 'Sécurité'] as $tag)
                            <span class="px-4 py-2 rounded-full border border-white/10 text-xs font-semibold text-white/70">{{ $tag }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if($products->isEmpty())
    <div class="text-center py-20 bg-slate-900 text-white">
        <p class="text-lg font-semibold">Aucun produit disponible pour le moment.</p>
        <p class="text-white/70">Contactez-nous pour être informé des prochaines vagues d’approvisionnement.</p>
    </div>
@endif
@endsection
