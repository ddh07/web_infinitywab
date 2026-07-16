@extends('layouts.app')

@section('title', 'À propos - Infinity WAB')
@section('description', 'Découvrez la vision, les valeurs et l’équipe qui font d’Infinity WAB un leader technologique en Afrique.')

@section('content')
@php
    $company = \App\Models\Company::active()->first();
    $companyStats = $company ? $company->stats : [];
    $partners = \App\Models\Partner::active()->ordered()->get();

    $values = [
        ['title' => 'Excellence opérationnelle', 'body' => 'Des process certifiés et une gouvernance rigoureuse sur chaque projet.'],
        ['title' => 'Innovation continue', 'body' => 'Veille technologique constante et prototypage rapide pour garder une longueur d’avance.'],
        ['title' => 'Intégrité', 'body' => 'Transparence, honnêteté et volonté d’apprendre avec nos partenaires.'],
        ['title' => 'Engagement humain', 'body' => 'Accompagnement de proximité, formation et transfert de compétences.'],
    ];
@endphp

<!-- Hero -->
<section class="relative overflow-hidden bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 text-white pt-20 pb-24">
    <!-- Animated Background Image -->
    <div class="absolute inset-0 opacity-50">
        <div class="hero-bg-image absolute inset-0 bg-cover bg-center bg-no-repeat animate-slow-zoom"
             style="background-image: url('https://images.unsplash.com/photo-1521791136064-7986c2920216?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950/80 via-slate-900/60 to-slate-950/80"></div>
    </div>

    <!-- Animated Particles -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="particle particle-1"></div>
        <div class="particle particle-2"></div>
        <div class="particle particle-3"></div>
        <div class="particle particle-4"></div>
        <div class="particle particle-5"></div>
    </div>

    <!-- Gradient Overlay -->
    <div class="absolute inset-0 opacity-30 bg-[radial-gradient(circle_at_top,_rgba(59,130,246,0.2),_transparent_50%)]"></div>
    <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_bottom,_rgba(139,92,246,0.2),_transparent_60%)]"></div>
    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <div class="space-y-6">
                <p class="text-xs uppercase tracking-[0.4em] text-blue-300">À propos</p>
                <h1 class="text-4xl md:text-5xl font-bold leading-tight">
                    {{ $company?->name ?? 'Infinity WAB' }} : la technologie au service d’un Burkina numérique.
                </h1>
                <p class="text-lg text-white/70 leading-relaxed">
                    {{ $company?->description ?? 'Nous concevons des systèmes hybrides, maintenons des infrastructures vitales et développons des solutions sur mesure pour les collectivités, entreprises et institutions du Burkina Faso.' }}
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('contact') }}" class="btn-animated inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-gradient-to-r from-blue-500 to-purple-500 text-white font-semibold shadow-2xl shadow-blue-900/40">
                        Rejoindre un projet
                    </a>
                    <a href="{{ route('services') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl border border-white/20 text-white/80 font-semibold">
                        Explorer les services
                    </a>
                </div>
            </div>
            <div class="rounded-3xl border border-white/10 bg-slate-900/60 p-8 shadow-2xl shadow-black/60 space-y-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.4em] text-white/50">Fondé en</p>
                    <p class="text-3xl font-bold text-gradient">{{ $company?->founded_year ?? '2018' }}</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-[0.4em] text-white/50">Équipe</p>
                    <p class="text-3xl font-bold text-gradient">{{ $company?->employees_count ?? '45' }} experts</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-[0.4em] text-white/50">Localisation</p>
                    <p class="text-sm text-white/80">{{ $company?->address ?? 'Ouagadougou, Burkina Faso' }}</p>
                </div>

                <!-- Map Integration -->
                <div class="mt-6">
                    <div class="relative rounded-2xl overflow-hidden border border-white/10" style="height: 200px;">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3888.7358746297!2d-1.5615935!3d12.3714287!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5m1!1f0!2f0!3f0!5f0.7820865974627469"
                            width="100%"
                            height="200"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            class="w-full h-full">
                        </iframe>
                        <div class="absolute inset-0 pointer-events-none bg-gradient-to-t from-slate-900/20 to-transparent"></div>
                    </div>
                    <a href="https://maps.google.com/?q={{ urlencode($company?->address ?? 'Ouagadougou, Burkina Faso') }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 mt-3 text-sm text-blue-300 hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314-11.314l4.243 4.243a8 8 0 010 11.314z"/>
                        </svg>
                        Voir sur Google Maps
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- Stats -->
@if($companyStats)
    <section class="py-16 bg-slate-950">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <article class="rounded-3xl border border-white/10 bg-slate-900/60 p-6 text-center shadow-2xl shadow-black/40">
                    <p class="text-3xl font-bold text-gradient">{{ $companyStats['projects_completed'] ?? '250+' }}</p>
                    <p class="text-xs uppercase tracking-[0.4em] text-white/50">Projets livrés</p>
                </article>
                <article class="rounded-3xl border border-white/10 bg-slate-900/60 p-6 text-center shadow-2xl shadow-black/40">
                    <p class="text-3xl font-bold text-gradient">{{ $companyStats['years_experience'] ?? '7' }}+</p>
                    <p class="text-xs uppercase tracking-[0.4em] text-white/50">Ans d'expérience</p>
                </article>
                <article class="rounded-3xl border border-white/10 bg-slate-900/60 p-6 text-center shadow-2xl shadow-black/40">
                    <p class="text-3xl font-bold text-gradient">{{ $companyStats['satisfied_clients'] ?? '150+' }}</p>
                    <p class="text-xs uppercase tracking-[0.4em] text-white/50">Clients satisfaits</p>
                </article>
                <article class="rounded-3xl border border-white/10 bg-slate-900/60 p-6 text-center shadow-2xl shadow-black/40">
                    <p class="text-3xl font-bold text-gradient">{{ $companyStats['support_availability'] ?? '24/7' }}</p>
                    <p class="text-xs uppercase tracking-[0.4em] text-white/50">Support technique</p>
                </article>
            </div>
        </div>
    </section>
@endif

<!-- Mission/Vision -->
<section class="py-20 bg-slate-900">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-10">
        <article class="rounded-3xl border border-white/10 bg-slate-950/70 p-8 shadow-2xl shadow-black/60">
            <div class="inline-flex items-center gap-2 text-xs uppercase tracking-[0.5em] text-blue-300 mb-4">
                <span class="h-1 w-6 bg-gradient-to-r from-blue-400 to-purple-500"></span>
                Mission
            </div>
            <h3 class="text-2xl font-semibold text-white mb-4">Faire de la technologie un levier accessible.</h3>
            <p class="text-white/70 leading-relaxed">
                Nous démocratisons les innovations numériques en assemblant expertise, maintenance de pointe et transformation digitale sur mesure.
            </p>
        </article>
        <article class="rounded-3xl border border-white/10 bg-slate-950/70 p-8 shadow-2xl shadow-black/60">
            <div class="inline-flex items-center gap-2 text-xs uppercase tracking-[0.5em] text-blue-300 mb-4">
                <span class="h-1 w-6 bg-gradient-to-r from-blue-400 to-purple-500"></span>
                Vision
            </div>
            <h3 class="text-2xl font-semibold text-white mb-4">Un hub d’innovation durable en Afrique de l’Ouest.</h3>
            <p class="text-white/70 leading-relaxed">
                Nous accompagnons les organisations à concevoir des services qui anticipent les besoins de demain, avec un impact économique et social positif.
            </p>
        </article>
    </div>
</section>

<!-- Values -->
<section class="py-20 bg-slate-950">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <p class="text-xs uppercase tracking-[0.5em] text-blue-400">Valeurs</p>
            <h2 class="text-3xl font-semibold text-white">Des principes qui guident chaque livrable</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($values as $value)
                <article class="rounded-3xl border border-white/10 bg-slate-900/50 p-6 shadow-xl shadow-black/40">
                    <h3 class="text-xl font-semibold text-white mb-3">{{ $value['title'] }}</h3>
                    <p class="text-white/70 text-sm leading-relaxed">{{ $value['body'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<!-- Partners -->
@if($partners->isNotEmpty())
    <section class="py-20 bg-gradient-to-b from-slate-900 to-slate-950 overflow-hidden">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <div class="text-center">
                <p class="text-xs uppercase tracking-[0.5em] text-blue-400">Partenaires</p>
                <h2 class="text-3xl font-semibold text-white">Nous collaborons avec les meilleurs</h2>
            </div>

            <!-- Partners Carousel Container -->
            <div class="relative">
                <!-- Gradient Masks -->

                <!-- Scrolling Track -->
                <div class="partners-track">
                    <!-- First Set -->
                    @foreach($partners as $partner)
                        <article class="partner-card flex-shrink-0 rounded-3xl border border-white/10 bg-slate-900/50 p-6 space-y-4 hover:border-white/30 transition mx-3">
                            <div class="h-16 flex items-center justify-center">
                                @if($partner->logo)
                                    <img src="{{ asset($partner->logo) }}" alt="{{ $partner->name }}" class="max-h-16 object-contain">
                                @else
                                    <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-white/60">
                                        <span>{{ strtoupper(substr($partner->name, 0, 2)) }}</span>
                                    </div>
                                @endif
                            </div>
                            <h3 class="text-xl font-semibold text-white text-center">{{ $partner->name }}</h3>
                            @if($partner->website)
                                <div class="text-center">
                                    <a href="{{ $partner->website }}" target="_blank" rel="noreferrer" class="text-sm font-semibold text-blue-300 hover:text-white inline-flex items-center gap-1">
                                        Visiter le site
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            @endif
                        </article>
                    @endforeach

                    <!-- Duplicate Set for Infinite Scroll -->
                    @foreach($partners as $partner)
                        <article class="partner-card flex-shrink-0 rounded-3xl border border-white/10 bg-slate-900/50 p-6 space-y-4 hover:border-white/30 transition mx-3">
                            <div class="h-16 flex items-center justify-center">
                                @if($partner->logo)
                                    <img src="{{ asset($partner->logo) }}" alt="{{ $partner->name }}" class="max-h-16 object-contain">
                                @else
                                    <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-white/60">
                                        <span>{{ strtoupper(substr($partner->name, 0, 2)) }}</span>
                                    </div>
                                @endif
                            </div>
                            <h3 class="text-xl font-semibold text-white text-center">{{ $partner->name }}</h3>
                            <p class="text-sm text-white/70 text-center line-clamp-2">{{ $partner->description }}</p>
                            @if($partner->website)
                                <div class="text-center">
                                    <a href="{{ $partner->website }}" target="_blank" rel="noreferrer" class="text-sm font-semibold text-blue-300 hover:text-white inline-flex items-center gap-1">
                                        Visiter le site
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            @endif
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif

<!-- CTA -->
<section class="py-20 bg-gradient-to-r from-blue-500/20 to-purple-500/20 text-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6">
        <h2 class="text-3xl font-semibold">Prêt pour un accompagnement sur mesure ?</h2>
        <p class="text-white/70">
            Discutons de vos ambitions, dépassons les contraintes et industrialisons vos services numériques avec audace.
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-white text-slate-900 font-semibold shadow-lg shadow-blue-900/30">
                Échanger avec un expert
            </a>
            <a href="{{ route('services') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl border border-white/40 text-white font-semibold">
                Explorer nos services
            </a>
        </div>
    </div>
</section>

@endsection
