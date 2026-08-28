@extends('layouts.app')

@section('title', 'À propos - Infinity WAB')
@section('description', 'Découvrez la vision, les valeurs et l’équipe qui font d’Infinity WAB un leader technologique en Afrique.')

@section('content')
@php
    $company = \App\Models\Company::active()->first();
    $companyStats = $company ? $company->stats : [];
    $partners = \App\Models\Partner::active()->ordered()->get();

    $values = $company?->values ?: [
        ['title' => 'Excellence opérationnelle', 'body' => 'Des process certifiés et une gouvernance rigoureuse sur chaque projet.'],
        ['title' => 'Innovation continue', 'body' => 'Veille technologique constante et prototypage rapide pour garder une longueur d’avance.'],
        ['title' => 'Intégrité', 'body' => 'Transparence, honnêteté et volonté d’apprendre avec nos partenaires.'],
        ['title' => 'Engagement humain', 'body' => 'Accompagnement de proximité, formation et transfert de compétences.'],
    ];
    $missionItems = $company?->mission ?: ['Nous démocratisons les innovations numériques en assemblant expertise, maintenance de pointe et transformation digitale sur mesure.'];
    $visionItems = $company?->vision ?: ['Nous accompagnons les organisations à concevoir des services qui anticipent les besoins de demain, avec un impact économique et social positif.'];
    $displayMode = $company?->display_mode ?: 'list';
@endphp

<!-- Hero -->
<section class="relative overflow-hidden bg-gradient-to-br from-surface-raised via-surface-canvas to-surface-raised text-ink-primary pt-28 lg:pt-32 pb-24">
    <x-ui.hero-background page="about" />
    <!-- Animated Particles -->
    <div class="absolute inset-0 overflow-hidden" aria-hidden="true">
        <div class="particle particle-1"></div>
        <div class="particle particle-2"></div>
        <div class="particle particle-3"></div>
        <div class="particle particle-4"></div>
        <div class="particle particle-5"></div>
    </div>

    <!-- Gradient Overlay -->
    <div class="absolute inset-0 opacity-30 bg-[radial-gradient(circle_at_top,_rgba(107, 191, 160,0.2),_transparent_50%)]"></div>
    <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_bottom,_rgba(91, 194, 217,0.2),_transparent_60%)]"></div>
    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <div class="space-y-6">
                <p class="font-mono text-xs uppercase tracking-[0.4em] text-mint-400">À propos</p>
                <h1 class="font-display text-4xl md:text-5xl font-bold leading-tight">
                    {{ $company?->name ?? 'Infinity WAB' }} : la technologie au service d’un Burkina numérique.
                </h1>
                <p class="text-lg text-ink-secondary leading-relaxed">
                    {{ $company?->description ?? 'Nous concevons des systèmes hybrides, maintenons des infrastructures vitales et développons des solutions sur mesure pour les collectivités, entreprises et institutions du Burkina Faso.' }}
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('contact') }}" class="btn-animated inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-gradient-to-r from-mint-500 to-azure-500 text-white font-semibold shadow-2xl shadow-mint-600/40">
                        Rejoindre un projet
                    </a>
                    <a href="{{ route('services') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl border border-(--border-default) text-ink-secondary font-semibold">
                        Explorer les services
                    </a>
                </div>
            </div>
            <div class="rounded-3xl border border-(--border-default) bg-surface-raised/70 p-8 shadow-2xl shadow-(--glow-accent) space-y-4">
                <div>
                    <p class="font-mono text-xs uppercase tracking-[0.4em] text-ink-muted">Fondé en</p>
                    <p class="font-display text-3xl font-bold text-gradient">{{ $company?->founded_year ?? '2018' }}</p>
                </div>
                <div>
                    <p class="font-mono text-xs uppercase tracking-[0.4em] text-ink-muted">Équipe</p>
                    <p class="font-display text-3xl font-bold text-gradient">{{ $company?->employees_count ?? '45' }} experts</p>
                </div>
                <div>
                    <p class="font-mono text-xs uppercase tracking-[0.4em] text-ink-muted">Localisation</p>
                    <p class="text-sm text-ink-secondary">{{ $company?->address ?? 'Ouagadougou, Burkina Faso' }}</p>
                </div>

                <!-- Map Integration -->
                <div class="mt-6">
                    <div class="relative rounded-2xl overflow-hidden border border-(--border-default)" style="height: 200px;">
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
                        <div class="absolute inset-0 pointer-events-none bg-gradient-to-t from-surface-raised/20 to-transparent"></div>
                    </div>
                    <a href="https://maps.google.com/?q={{ urlencode($company?->address ?? 'Ouagadougou, Burkina Faso') }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 mt-3 text-sm text-mint-400 hover:text-ink-primary transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314-11.314l4.243 4.243a8 8 0 010 11.314z"/>
                        </svg>
                        Voir sur Google Maps
                    </a>
                </div>

            </div>
        </div>
    </div>
    <x-ui.shape-divider shape="arc" fill="text-surface-canvas" />
</section>

<!-- Stats -->
@if($companyStats)
    <section class="py-16 bg-surface-canvas">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <article class="rounded-3xl border border-(--border-default) bg-surface-raised/70 p-6 text-center shadow-2xl shadow-(--glow-accent)" data-reveal>
                    <p class="font-display text-3xl font-bold text-gradient">{{ $companyStats['projects_completed'] ?? '250+' }}</p>
                    <p class="font-mono text-xs uppercase tracking-[0.4em] text-ink-muted">Projets livrés</p>
                </article>
                <article class="rounded-3xl border border-(--border-default) bg-surface-raised/70 p-6 text-center shadow-2xl shadow-(--glow-accent)" data-reveal style="--reveal-delay: 80ms">
                    <p class="font-display text-3xl font-bold text-gradient">{{ $companyStats['years_experience'] ?? '7' }}+</p>
                    <p class="font-mono text-xs uppercase tracking-[0.4em] text-ink-muted">Ans d'expérience</p>
                </article>
                <article class="rounded-3xl border border-(--border-default) bg-surface-raised/70 p-6 text-center shadow-2xl shadow-(--glow-accent)" data-reveal style="--reveal-delay: 160ms">
                    <p class="font-display text-3xl font-bold text-gradient">{{ $companyStats['satisfied_clients'] ?? '150+' }}</p>
                    <p class="font-mono text-xs uppercase tracking-[0.4em] text-ink-muted">Clients satisfaits</p>
                </article>
                <article class="rounded-3xl border border-(--border-default) bg-surface-raised/70 p-6 text-center shadow-2xl shadow-(--glow-accent)" data-reveal style="--reveal-delay: 240ms">
                    <p class="font-display text-3xl font-bold text-gradient">{{ $companyStats['support_availability'] ?? '24/7' }}</p>
                    <p class="font-mono text-xs uppercase tracking-[0.4em] text-ink-muted">Support technique</p>
                </article>
            </div>
        </div>
    </section>
@endif

<!-- Mission/Vision -->
<section class="py-20 bg-surface-raised">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-10">
        <div data-reveal>
            <div class="font-mono inline-flex items-center gap-2 text-xs uppercase tracking-[0.5em] text-mint-400 mb-6">
                <span class="h-1 w-6 bg-gradient-to-r from-mint-400 to-azure-500"></span>
                Mission
            </div>
            <x-ui.content-list :items="$missionItems" :mode="$displayMode" accent="mint" />
        </div>
        <div data-reveal style="--reveal-delay: 100ms">
            <div class="font-mono inline-flex items-center gap-2 text-xs uppercase tracking-[0.5em] text-azure-400 mb-6">
                <span class="h-1 w-6 bg-gradient-to-r from-azure-400 to-mint-500"></span>
                Vision
            </div>
            <x-ui.content-list :items="$visionItems" :mode="$displayMode" accent="azure" />
        </div>
    </div>
</section>

<!-- Values -->
<section class="py-20 bg-surface-canvas">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12" data-reveal>
            <p class="font-mono text-xs uppercase tracking-[0.5em] text-mint-400">Valeurs</p>
            <h2 class="font-display text-3xl font-semibold text-ink-primary">Des principes qui guident chaque livrable</h2>
        </div>
        <x-ui.content-list :items="$values" :mode="$displayMode" accent="mint" />
    </div>
</section>

<!-- Équipe -->
@if($teamMembers->isNotEmpty())
    <section class="py-20 bg-surface-canvas">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <div class="text-center space-y-3" data-reveal>
                <p class="font-mono text-xs uppercase tracking-[0.5em] text-mint-400">Équipe</p>
                <h2 class="font-display text-3xl font-semibold text-ink-primary">Les personnes derrière Infinity WAB</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($teamMembers as $member)
                    <article class="rounded-3xl border border-(--border-default) bg-surface-raised/70 p-6 shadow-2xl shadow-(--glow-accent) text-center space-y-3" data-reveal style="--reveal-delay: {{ $loop->index * 100 }}ms">
                        @if($member->photo)
                            <img src="{{ asset($member->photo) }}" alt="{{ $member->name }}" class="mx-auto w-20 h-20 rounded-full object-cover">
                        @else
                            <span class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-gradient-to-br from-mint-500 to-azure-500 text-slate-950 font-semibold text-xl">
                                {{ strtoupper(substr($member->name, 0, 2)) }}
                            </span>
                        @endif
                        <div>
                            <h3 class="font-display text-lg font-semibold text-ink-primary">{{ $member->name }}</h3>
                            <p class="text-sm text-mint-500">{{ $member->role }}</p>
                        </div>
                        @if($member->bio)
                            <p class="text-sm text-ink-secondary leading-relaxed">{{ $member->bio }}</p>
                        @endif
                        @if($member->linkedin_url)
                            <a href="{{ $member->linkedin_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-sm font-semibold text-mint-500 hover:text-ink-primary">
                                LinkedIn
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                            </a>
                        @endif
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endif

<!-- Partners -->
@if($partners->isNotEmpty())
    <section class="py-20 bg-surface-raised overflow-hidden">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <div class="text-center" data-reveal>
                <p class="font-mono text-xs uppercase tracking-[0.5em] text-mint-400">Partenaires</p>
                <h2 class="font-display text-3xl font-semibold text-ink-primary">Nous collaborons avec les meilleurs</h2>
            </div>

            <!-- Partners Carousel Container -->
            <div class="relative">
                <!-- Gradient Masks -->

                <!-- Scrolling Track -->
                <div class="partners-track">
                    <!-- First Set -->
                    @foreach($partners as $partner)
                        <article class="partner-card flex-shrink-0 rounded-3xl border border-(--border-default) bg-surface-canvas/60 p-6 space-y-4 hover:border-mint-400/40 transition mx-3">
                            <div class="h-16 flex items-center justify-center">
                                @if($partner->logo)
                                    <img src="{{ asset($partner->logo) }}" alt="{{ $partner->name }}" class="max-h-16 object-contain">
                                @else
                                    <div class="w-12 h-12 bg-black/5 dark:bg-white/10 rounded-2xl flex items-center justify-center text-ink-muted">
                                        <span>{{ strtoupper(substr($partner->name, 0, 2)) }}</span>
                                    </div>
                                @endif
                            </div>
                            <h3 class="text-xl font-semibold text-ink-primary text-center">{{ $partner->name }}</h3>
                            @if($partner->website)
                                <div class="text-center">
                                    <a href="{{ $partner->website }}" target="_blank" rel="noreferrer" class="text-sm font-semibold text-mint-400 hover:text-ink-primary inline-flex items-center gap-1">
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
                        <article class="partner-card flex-shrink-0 rounded-3xl border border-(--border-default) bg-surface-canvas/60 p-6 space-y-4 hover:border-mint-400/40 transition mx-3">
                            <div class="h-16 flex items-center justify-center">
                                @if($partner->logo)
                                    <img src="{{ asset($partner->logo) }}" alt="{{ $partner->name }}" class="max-h-16 object-contain">
                                @else
                                    <div class="w-12 h-12 bg-black/5 dark:bg-white/10 rounded-2xl flex items-center justify-center text-ink-muted">
                                        <span>{{ strtoupper(substr($partner->name, 0, 2)) }}</span>
                                    </div>
                                @endif
                            </div>
                            <h3 class="text-xl font-semibold text-ink-primary text-center">{{ $partner->name }}</h3>
                            <p class="text-sm text-ink-secondary text-center line-clamp-2">{{ $partner->description }}</p>
                            @if($partner->website)
                                <div class="text-center">
                                    <a href="{{ $partner->website }}" target="_blank" rel="noreferrer" class="text-sm font-semibold text-mint-400 hover:text-ink-primary inline-flex items-center gap-1">
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
<section class="py-20 bg-gradient-to-r from-mint-700 via-azure-700 to-azure-600 text-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6" data-reveal>
        <h2 class="font-display text-3xl font-semibold">Prêt pour un accompagnement sur mesure ?</h2>
        <p class="text-white/70">
            Discutons de vos ambitions, dépassons les contraintes et industrialisons vos services numériques avec audace.
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-white text-slate-900 font-semibold shadow-lg shadow-mint-600/30">
                Échanger avec un expert
            </a>
            <a href="{{ route('services') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl border border-white/40 text-white font-semibold">
                Explorer nos services
            </a>
        </div>
    </div>
</section>

@endsection
