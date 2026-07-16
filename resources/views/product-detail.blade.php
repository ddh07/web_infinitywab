@extends('layouts.app')

@section('title', $product->title . ' - Infinity WAB')
@section('description', Str::limit(strip_tags($product->description ?? $product->content), 160))

@section('content')
@php
    $images = is_string($product->images) ? json_decode($product->images, true) : ($product->images ?? []);
    $specs = is_string($product->specifications) ? json_decode($product->specifications, true) : ($product->specifications ?? []);
    $gallery = is_string($product->gallery) ? json_decode($product->gallery, true) : ($product->gallery ?? []);

    $defaultProductCover = asset('images/placeholder-product.png');
@endphp

<!-- Hero -->
<section class="relative overflow-hidden bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 text-white py-24">
    <div class="absolute inset-0 pointer-events-none bg-[radial-gradient(circle_at_top,_rgba(59,130,246,0.3),_transparent_45%)]"></div>
    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 grid gap-10 lg:grid-cols-2 items-center">
        <div class="space-y-6">
            <p class="text-xs uppercase tracking-[0.5em] text-blue-300">Produit Infinity WAB</p>
            <h1 class="text-4xl md:text-5xl font-bold leading-tight">
                {{ $product->title }}
            </h1>
            <p class="text-lg text-white/70 leading-relaxed">
                {{ $product->description }}
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('contact') }}" class="btn-animated inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-500 rounded-2xl text-white font-semibold shadow-xl shadow-blue-900/50">
                    Demander un devis
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
                <a href="{{ route('products') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl border border-white/30 text-white/80 hover:text-white">
                    Retour au catalogue
                </a>
            </div>
        </div>
        <div class="space-y-6">
            <div class="rounded-3xl border border-white/10 bg-slate-900/80 p-8 shadow-2xl shadow-black/60 relative overflow-hidden">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(14,165,233,0.2),_transparent_60%)]"></div>
                <div class="relative z-10 space-y-4">
                    <p class="text-xs uppercase tracking-[0.5em] text-white/60">Prix</p>
                    <p class="text-3xl font-semibold text-gradient">{{ $product->price ? number_format($product->price, 0, ',', ' ') . ' FCFA' : 'Sur devis' }}</p>
                    <p class="text-xs uppercase tracking-[0.4em] text-blue-300">Disponibilité</p>
                    <p class="text-sm text-white/70">Stock limité · Livraison rapide</p>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-3">
                <div class="rounded-2xl bg-slate-900/70 border border-white/10 p-4 text-center">
                    <p class="text-xs uppercase tracking-[0.4em] text-white/60">Catégorie</p>
                    <p class="text-sm font-semibold text-white">{{ $product->category }}</p>
                </div>
                <div class="rounded-2xl bg-slate-900/70 border border-white/10 p-4 text-center">
                    <p class="text-xs uppercase tracking-[0.4em] text-white/60">Vedette</p>
                    <p class="text-sm font-semibold text-white">{{ $product->is_featured ? 'Oui' : 'Standard' }}</p>
                </div>
                <div class="rounded-2xl bg-slate-900/70 border border-white/10 p-4 text-center">
                    <p class="text-xs uppercase tracking-[0.4em] text-white/60">Support</p>
                    <p class="text-sm font-semibold text-white">7j/7</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Details -->
<section class="py-16 bg-slate-900">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 grid gap-10 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-8">
            <div class="rounded-3xl border border-white/5 bg-slate-950/40 overflow-hidden shadow-2xl shadow-black/60">
                @if($images)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($images as $index => $image)
                            <div class="relative h-64">
                                @php
                                    $imagePath = ltrim((string) $image, '/');
                                    if (!str_starts_with($imagePath, 'images/')) {
                                        $imagePath = 'images/' . $imagePath;
                                    }
                                    $src = file_exists(public_path($imagePath)) ? asset($imagePath) : $defaultProductCover;
                                @endphp
                                <img src="{{ $src }}" alt="{{ $product->title }} - image {{ $index + 1 }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="h-64 bg-gradient-to-br from-blue-500/20 to-purple-500/20 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                @endif
            </div>

            @if($product->content)
                <article class="rounded-3xl border border-white/5 bg-slate-950/50 p-8 shadow-2xl shadow-black/60">
                    <h2 class="text-2xl font-semibold text-white mb-4">À propos du produit</h2>
                    <div class="prose prose-invert max-w-none text-white/80 leading-relaxed">
                        {!! $product->content !!}
                    </div>
                </article>
            @endif

            @if($specs)
                <article class="rounded-3xl border border-white/5 bg-slate-950/50 p-8 shadow-2xl shadow-black/60">
                    <h3 class="text-xl font-semibold text-white mb-4">Spécifications essentielles</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($specs as $key => $value)
                            <div class="rounded-2xl bg-slate-900/60 border border-white/5 px-4 py-3 text-white/80 flex justify-between text-sm">
                                <span>{{ $key }}</span>
                                <span class="font-semibold text-white">{{ $value }}</span>
                            </div>
                        @endforeach
                    </div>
                </article>
            @endif

            @if($gallery)
                <article class="rounded-3xl border border-white/5 bg-slate-950/50 p-8 shadow-2xl shadow-black/60">
                    <h3 class="text-xl font-semibold text-white mb-4">Galerie</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($gallery as $image)
                            <div class="rounded-2xl overflow-hidden h-48">
                                @php
                                    $imagePath = ltrim((string) $image, '/');
                                    if (!str_starts_with($imagePath, 'images/')) {
                                        $imagePath = 'images/' . $imagePath;
                                    }
                                    $src = file_exists(public_path($imagePath)) ? asset($imagePath) : $defaultProductCover;
                                @endphp
                                <img src="{{ $src }}" alt="{{ $product->title }} galerie" class="w-full h-full object-cover transition-all duration-500 hover:scale-105">
                            </div>
                        @endforeach
                    </div>
                </article>
            @endif
        </div>

        <aside class="space-y-6">
            <div class="rounded-3xl border border-white/5 bg-gradient-to-br from-blue-500/20 to-purple-500/20 p-6 shadow-2xl shadow-black/60 text-white space-y-3">
                <p class="text-xs uppercase tracking-[0.5em]">Support inclus</p>
                <p class="text-lg font-semibold">Installation, configuration, formation & maintenance</p>
                <p class="text-sm text-white/80">Accompagnement dédié tout au long du déploiement.</p>
                <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-4 py-3 bg-white text-slate-900 font-semibold rounded-2xl shadow-lg shadow-blue-900/40">
                    Planifier un briefing
                </a>
            </div>
            <div class="rounded-3xl border border-white/5 bg-slate-950/50 p-6 shadow-2xl shadow-black/60">
                <h4 class="text-lg font-semibold text-white mb-3">Charges supplémentaires</h4>
                <ul class="space-y-3 text-sm text-white/70">
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
    <section class="py-20 bg-slate-900">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <div class="text-center">
                <p class="text-xs uppercase tracking-[0.5em] text-blue-400 mb-2">Produits similaires</p>
                <h2 class="text-3xl font-semibold text-white">Complétez votre parc</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedProducts as $related)
                    @php
                        $relatedImages = is_string($related->images) ? json_decode($related->images, true) : ($related->images ?? []);
                        $thumb = $relatedImages[0] ?? 'images/placeholder-product.jpg';
                    @endphp
                    <article class="rounded-3xl border border-white/10 bg-gradient-to-br from-slate-950/80 to-slate-900/60 p-6 shadow-2xl shadow-black/60 space-y-3">
                        <div class="h-40 w-full overflow-hidden rounded-2xl">
                            <img src="{{ asset($thumb) }}" alt="{{ $related->title }}" class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-xl font-semibold text-white">{{ $related->title }}</h3>
                        <p class="text-sm text-white/70 line-clamp-3">{{ Str::limit($related->description, 120) }}</p>
                        @if($related->price)
                            <p class="text-sm font-semibold text-white/90">{{ number_format($related->price, 0, ',', ' ') }} FCFA</p>
                        @endif
                        <a href="{{ route('products.show', $related->slug) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-blue-300 hover:text-white">
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
