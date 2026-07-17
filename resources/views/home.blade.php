@extends('layouts.app')

@section('title', 'Infinity WAB - Innovation Technologique pour le Burkina Faso')
@section('description', 'Infinity WAB crée des infrastructures, services et produits numériques sécurisés pour accompagner le Burkina Faso vers la transformation digitale.')

@section('content')
@php
    use Illuminate\Support\Str;
@endphp

<!-- Hero -->
<section
    class="relative overflow-hidden text-white py-24"
    style="background-image: linear-gradient(to bottom right, rgba(2, 6, 23, 0.95), rgba(15, 23, 42, 0.85));"
>
    <video
        class="absolute inset-0 h-full w-full object-cover pointer-events-none opacity-90"
        autoplay
        muted
        loop
        playsinline
        aria-hidden="true"
    >
        <source src="{{ asset('images/Infinywab_video.mp4') }}" type="video/mp4">
        Votre navigateur ne supporte pas cette vidéo.
    </video>
    <div class="absolute inset-0 bg-slate-900/40 mix-blend-multiply pointer-events-none z-5"></div>
    <div class="shape-blob shape-blob-1 z-10"></div>
    <div class="shape-blob shape-blob-2 z-10"></div>
    <div class="shape-blob shape-blob-3 z-10"></div>
    <div class="absolute inset-0 pointer-events-none bg-[radial-gradient(circle_at_top,_rgba(14,165,233,0.25),_transparent_40%)] z-20"></div>
    <div class="relative z-30 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 grid gap-12 lg:grid-cols-2 items-center">
        <div class="space-y-6">
            <p class="text-xs uppercase tracking-[0.5em] text-blue-300">Infinity WAB</p>
            <h1 class="text-4xl md:text-5xl font-bold leading-tight">
                Innovation technologique <span class="text-gradient">à l’échelle du Burkina Faso</span>
            </h1>
            <p class="text-lg text-white/70">
                Nous bâtissons des services de maintenance, réseaux, développement web et produits digitaux pour rendre votre organisation résiliente,
                sécurisée et ambitieuse.
            </p>
            <div class="flex flex-wrap gap-4">
                <x-ui.button href="{{ route('services') }}">
                    Nos services
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </x-ui.button>
                <x-ui.button href="{{ route('contact') }}" variant="outline">
                    Discuter d’un projet
                </x-ui.button>
            </div>
        </div>
        <div class="space-y-6">
            <div class="rounded-3xl bg-slate-900/80 border border-white/10 p-8 shadow-2xl shadow-black/60 relative overflow-hidden">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(59,130,246,0.2),_transparent_60%)]"></div>
                <div class="relative z-10 space-y-4">
                    <p class="text-xs uppercase tracking-[0.5em] text-white/60">Performance</p>
                    <h2 class="text-3xl font-semibold text-white">#1 en innovation</h2>
                    <p class="text-white/70 text-sm">
                        Maintien de 24h/24 et déploiement de solutions hybrides pour les entreprises et institutions burkinabè.
                    </p>
                    <div class="text-xs uppercase tracking-[0.4em] text-blue-300">Dernier lancement</div>
                    <p class="text-sm text-white/70">
                        Accélérateur cloud & sécurité pour les administrations, en collaboration avec nos partenaires Cisco et AWS.
                    </p>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                @foreach($heroStats as $stat)
                    <div class="rounded-2xl bg-slate-900/70 border border-white/10 p-4 text-center">
                        <p class="text-2xl font-bold text-gradient">{{ $stat['value'] }}</p>
                        <p class="text-xs uppercase tracking-[0.4em] text-white/60">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

@if($carouselHighlights->isNotEmpty())
    <section class="py-16 bg-slate-950">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="space-y-2">
                    <p class="text-xs uppercase tracking-[0.5em] text-blue-300">Focus</p>
                    <h2 class="text-3xl font-semibold text-white">Nos signatures projet</h2>
                    <p class="text-white/70 max-w-2xl">Des plateformes stratégiques et des infrastructures sensibles pensées pour les organisations burkinabè.</p>
                </div>
                <div class="flex gap-3">
                    <button type="button" data-carousel-prev class="inline-flex items-center justify-center h-12 w-12 rounded-full border border-white/20 text-white hover:border-white/60 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400">
                        <span class="sr-only">Précédent</span>
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <button type="button" data-carousel-next class="inline-flex items-center justify-center h-12 w-12 rounded-full border border-white/20 text-white hover:border-white/60 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400">
                        <span class="sr-only">Suivant</span>
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="relative overflow-hidden rounded-3xl border border-white/10 bg-slate-900/60" data-carousel>
                <div class="flex transition-transform duration-500 ease-out" data-carousel-track>
                    @foreach($carouselHighlights as $highlight)
                        <article class="flex-shrink-0 w-full box-border px-6 py-10 sm:px-10" data-carousel-slide aria-hidden="true">
                            <div class="space-y-4">
                                <p class="text-xs uppercase tracking-[0.4em] text-white/60">{{ $highlight->category ?? 'Projet' }}</p>
                                <h3 class="text-3xl font-semibold leading-tight text-white">{{ $highlight->title }}</h3>
                                <p class="text-sm text-white/70 leading-relaxed line-clamp-4">{{ Str::limit($highlight->description, 200) }}</p>
                            </div>
                            <div class="mt-6 flex items-center justify-between text-sm font-semibold text-blue-300">
                                <span class="text-white/70">Livré par Infinity WAB</span>
                                <a href="{{ route('projects.show', $highlight->slug) }}" class="flex items-center gap-2 hover:text-white" aria-label="Voir le projet {{ $highlight->title }}">
                                    Découvrir
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
            <div class="flex justify-center gap-2" data-carousel-indicators>
                @foreach($carouselHighlights as $index => $highlight)
                    <button type="button" data-carousel-indicator data-slide-index="{{ $index }}" class="h-2.5 w-2.5 rounded-full bg-white/20 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400" aria-label="Aller au projet {{ $highlight->title }}"></button>
                @endforeach
            </div>
        </div>
    </section>
@endif

<!-- Services -->
<section class="py-20 bg-slate-950">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.5em] text-blue-400 mb-2">Services</p>
                <h2 class="text-3xl font-semibold text-white">Des équipes dédiées par discipline</h2>
                <p class="text-white/70 max-w-2xl">Maintenance, réseaux, développement ou innovation : chaque service est livré avec une gouvernance transparente.</p>
            </div>
            <a href="{{ route('services') }}" class="text-sm font-semibold text-blue-300 hover:text-white flex items-center gap-2">
                Tous les services
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
            @foreach($services as $service)
                @php
                    $serviceCover = $service->cover_url;
                @endphp
                <article class="rounded-3xl border border-white/5 bg-slate-900/60 p-6 shadow-2xl shadow-black/50 hover:border-white/20 transition">
                    <div class="mb-4 h-36 w-full overflow-hidden rounded-2xl border border-white/10">
                        <img src="{{ $serviceCover }}" alt="{{ $service->title }}" class="h-full w-full object-cover transition-transform duration-500 hover:scale-105">
                    </div>
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-xl font-semibold text-white">{{ $service->title }}</h3>
                        <span class="text-xs uppercase tracking-[0.4em] text-blue-300">Service</span>
                    </div>
                    <p class="text-sm text-white/70 leading-relaxed mb-4">{{ Str::limit($service->description, 140) }}</p>
                    <a href="{{ route('services.show', $service->slug) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-blue-300 hover:text-white">
                        En savoir plus
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </article>
            @endforeach
        </div>
    </div>
</section>

<!-- Projects highlight -->
<section class="py-20 bg-slate-900">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        <div class="text-center space-y-3">
            <p class="text-xs uppercase tracking-[0.5em] text-blue-400">Projets</p>
            <h2 class="text-3xl font-semibold text-white">Impact concret</h2>
            <p class="text-white/70 max-w-3xl mx-auto">Plateformes e-commerce, applications mobiles et infrastructures sécurisées livrées sur le terrain.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($projects as $project)
                <article class="rounded-3xl border border-white/5 bg-slate-950/40 p-6 shadow-2xl shadow-black/60 space-y-4">
                    <div class="h-40 w-full overflow-hidden rounded-2xl border border-white/10">
                        @php
                            $projectCover = $project->cover_url;
                        @endphp
                        <img src="{{ $projectCover }}" alt="{{ $project->title }}" class="h-full w-full object-cover transition-transform duration-500 hover:scale-105">
                    </div>
                    <div class="text-xs uppercase tracking-[0.4em] text-white/60">{{ $project->category ?? 'Projet' }}</div>
                    <h3 class="text-xl font-semibold text-white">{{ $project->title }}</h3>
                    <p class="text-sm text-white/70 line-clamp-3">{{ Str::limit($project->description, 120) }}</p>
                    <a href="{{ route('projects.show', $project->slug) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-blue-300 hover:text-white">
                        Voir le projet
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </article>
            @endforeach
        </div>
    </div>
</section>

<!-- Products -->
<section class="py-20 bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 text-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 grid gap-8 lg:grid-cols-3">
        <div class="lg:col-span-1 space-y-4">
            <h2 class="text-3xl font-semibold">Produits durables</h2>
            <p class="text-white/70">Des configurations prêtes à déployer et un accompagnement matériel complet (licences, déploiement, support). </p>
            <a href="{{ route('products') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-blue-200 hover:text-white">
                Voir tous les produits
            </a>
        </div>
        <div class="lg:col-span-2 grid gap-6 sm:grid-cols-2">
            @foreach($featuredProducts as $product)
                @php
                    $thumb = $product->cover_url;
                @endphp
                <article class="rounded-3xl border border-white/10 bg-slate-900/60 p-6 shadow-2xl shadow-black/60 space-y-3">
                    <div class="h-40 w-full overflow-hidden rounded-2xl border border-white/10">
                        <img src="{{ $thumb }}" alt="{{ $product->title }}" class="h-full w-full object-cover transition-transform duration-500 hover:scale-105">
                    </div>
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold text-white">{{ $product->title }}</h3>
                        <span class="text-xs text-white/60">{{ $product->category }}</span>
                    </div>
                    <p class="text-sm text-white/70 line-clamp-3">{{ Str::limit($product->description, 120) }}</p>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-white/80">{{ number_format($product->price ?? 0, 0, ',', ' ') }} FCFA</span>
                        <a href="{{ route('products.show', $product->slug) }}" class="font-semibold text-blue-300 hover:text-white inline-flex items-center gap-1">
                            Découvrir
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<!-- Partners -->
@if($partners->isNotEmpty())
    <section class="py-20 bg-slate-900">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <div class="text-center space-y-3">
                <p class="text-xs uppercase tracking-[0.5em] text-blue-400">Partenaires</p>
                <h2 class="text-3xl font-semibold text-white">Nous accompagnons des organisations de confiance</h2>
                <p class="text-white/60 max-w-3xl mx-auto">Collaborations durables dans la cybersécurité, le cloud et l'innovation digitale.</p>
            </div>
            <div class="partners-marquee-wrapper" role="region" aria-label="Logos des partenaires">
                <div class="partners-marquee-track">
                    @foreach(range(1, 2) as $iteration)
                        @foreach($partners as $partner)
                            <article class="partners-marquee-card snap-center min-w-[230px] rounded-3xl border border-white/10 bg-slate-950/50 p-6 flex flex-col items-center justify-center space-y-4 shadow-lg shadow-black/60 transition hover:border-white/20">
                                @if($partner->logo)
                                    <img src="{{ asset($partner->logo) }}" alt="{{ $partner->name }}" class="partners-marquee-logo h-16 w-full object-contain">
                                @else
                                    <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center text-white/60 font-semibold text-lg">
                                        {{ strtoupper(substr($partner->name, 0, 2)) }}
                                    </div>
                                @endif
                                <p class="text-sm text-center text-white/80 font-semibold">{{ $partner->name }}</p>
                            </article>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif

<!-- CTA -->
<section class="py-20 bg-gradient-to-r from-blue-500/20 via-blue-600/40 to-purple-500/20 text-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6">
        <p class="text-xs uppercase tracking-[0.6em] text-blue-200">Prêt à innover ?</p>
        <h2 class="text-3xl font-semibold">Construisons la prochaine génération de services numériques au Burkina Faso.</h2>
        <p class="text-white/70">Des workshops à la livraison, Infinity WAB reste un partenaire stratégique concrètement présent au quotidien.</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-white text-slate-900 font-semibold rounded-2xl shadow-xl shadow-blue-900/30">
                Parler à un expert
            </a>
            <a href="{{ route('projects') }}" class="inline-flex items-center gap-2 px-8 py-3 rounded-2xl border border-white/40 text-white font-semibold">
                Voir nos projets
            </a>
        </div>
    </div>
</section>
@endsection
