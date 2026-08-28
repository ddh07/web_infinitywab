@extends('layouts.app')

@section('title', $service->title . ' - Infinity WAB')
@section('description', $service->description)

@section('content')
@php
    use Illuminate\Support\Str;

    $supportLabel = $service->is_active ? 'Support 24/7' : 'Phase d\'ingénierie';

    $serviceCover = $service->cover_url;
@endphp

<!-- Service hero -->
<section class="relative overflow-hidden bg-gradient-to-br from-surface-raised via-surface-canvas to-surface-raised text-ink-primary pt-28 lg:pt-32">
    <div class="absolute inset-0 opacity-30 bg-[radial-gradient(circle_at_top,_rgba(107, 191, 160,0.3),_transparent_50%)]"></div>
    <x-ui.hero-shapes variant="drift" />
    <div class="absolute inset-0">
        <img src="{{ $serviceCover }}" alt="" aria-hidden="true" class="h-full w-full object-cover opacity-20">
    </div>
    <div class="absolute inset-0 bg-surface-canvas/60"></div>
    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
        <div class="flex flex-col gap-8 lg:flex-row lg:items-center">
            <div class="lg:w-2/3 space-y-6">
                <div class="font-mono inline-flex items-center gap-2 px-4 py-1 rounded-full bg-black/5 dark:bg-white/10 text-sm font-semibold uppercase tracking-[0.4em] text-mint-400">
                    <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Service aligné
                </div>
                <h1 class="font-display text-4xl md:text-5xl font-bold leading-tight">
                    {{ $service->title }}
                </h1>
                <p class="text-xl text-ink-secondary leading-relaxed max-w-3xl">
                    {{ $service->description }}
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-gradient-to-r from-mint-500 to-azure-500 text-white font-semibold shadow-xl shadow-mint-600/40">
                        Besoin de ce service ?
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    <a href="{{ route('services') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl border border-(--border-default) text-ink-secondary font-semibold hover:border-(--border-strong)">
                        Revenir aux services
                    </a>
                </div>
            </div>
            <div class="lg:w-1/3">
                <div class="rounded-3xl border border-(--border-default) bg-surface-raised/70 p-6 shadow-2xl shadow-(--glow-accent) backdrop-blur-xl">
                    <div class="flex items-center justify-between mb-5">
                        <div class="text-sm text-ink-muted">Statut</div>
                        <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $service->is_active ? 'bg-emerald-500/20 text-emerald-200 border border-emerald-500/40' : 'bg-amber-500/20 text-amber-200 border border-amber-500/40' }}">
                            {{ $service->is_active ? 'Actif' : 'En étude' }}
                        </span>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-[0.4em] text-ink-muted">Catégorie</p>
                                <p class="text-sm text-ink-primary">{{ ucfirst($service->icon ?? 'service') }}</p>
                            </div>
                            <div class="rounded-2xl bg-mint-500/10 p-3">
                                @include('partials.icons.service-icon', ['icon' => $service->icon, 'class' => 'w-5 h-5', 'strokeClass' => 'text-mint-400'])
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-[0.4em] text-ink-muted">Livraison</p>
                                <p class="text-sm text-ink-primary">3 à 8 semaines</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs uppercase tracking-[0.4em] text-ink-muted">Equipe</p>
                                <p class="text-sm text-ink-primary">Equipe dédiée</p>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-(--border-default)">
                            <p class="text-xs uppercase tracking-[0.4em] text-ink-muted mb-2">Support</p>
                            <p class="text-sm text-ink-primary">{{ $supportLabel }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-ui.shape-divider shape="zigzag" fill="text-surface-canvas" />
</section>

<!-- Content & Details -->
<section class="py-20 bg-surface-canvas">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <article class="lg:col-span-2 space-y-8">
                <div class="rounded-3xl border border-(--border-default) bg-surface-raised/70 p-8 shadow-xl shadow-(--glow-accent)">
                    <h2 class="font-display text-2xl font-semibold text-ink-primary mb-6">Ce que comprend ce service</h2>
                    @if(filled($service->content))
                        <div class="prose prose-invert max-w-none text-ink-secondary leading-relaxed">
                            {!! $service->content !!}
                        </div>
                    @else
                        <p class="text-ink-secondary">
                            Nous construisons pour vous une feuille de route technique (audits, workshops, déploiement, support). Contactez-nous pour obtenir une version détaillée du plan d’action.
                        </p>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach([
                        ['title' => 'Ateliers Stratégiques', 'body' => 'Co-création avec vos équipes métiers.'],
                        ['title' => 'Architecture Solide', 'body' => 'Design et documentation évolutive.'],
                        ['title' => 'Déploiement Agile', 'body' => 'Pilote, tests, mise en production.'],
                        ['title' => 'Suivi & Mesure', 'body' => 'Rapports et tableaux de bord orientés ROI.'],
                    ] as $block)
                        <div class="rounded-3xl border border-(--border-default) bg-surface-raised/60 p-6" data-reveal style="--reveal-delay: {{ $loop->index * 80 }}ms">
                            <h3 class="font-display text-lg font-semibold text-ink-primary mb-2">{{ $block['title'] }}</h3>
                            <p class="text-sm text-ink-secondary">{{ $block['body'] }}</p>
                        </div>
                    @endforeach
                </div>
            </article>

            <aside class="space-y-6">
                <div class="rounded-3xl border border-(--border-default) bg-gradient-to-br from-mint-600 to-azure-600 p-6 text-white shadow-2xl shadow-mint-600/40">
                    <h3 class="font-display text-xl font-semibold mb-3">Prêt à démarrer ?</h3>
                    <p class="text-sm text-white/80 mb-4">
                        Chaque mission est accompagnée d’une stratégie d’adoption, d’un briefing des équipes et d’un point de contact dédié.
                    </p>
                    <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-4 py-3 rounded-xl bg-white/10 border border-white/30 text-sm font-semibold hover:bg-white/20">
                        Réserver un entretien
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
                <div class="rounded-3xl border border-(--border-default) bg-surface-raised/70 p-6">
                    <h3 class="font-display text-lg font-semibold text-ink-primary mb-4">En résumé</h3>
                    <ul class="space-y-3 text-ink-secondary text-sm">
                        <li class="flex justify-between border-b border-(--border-default) pb-3">
                            <span>Livraisons historiques</span>
                            <span>+12 projets</span>
                        </li>
                        <li class="flex justify-between border-b border-(--border-default) pb-3">
                            <span>Partenaires technos</span>
                            <span>Cisco, Microsoft, AWS</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Niveau d’engagement</span>
                            <span class="text-emerald-600 dark:text-emerald-300 font-semibold">Premium</span>
                        </li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</section>

<!-- Related services -->
@if($relatedServices->isNotEmpty())
<section class="py-20 bg-surface-raised">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-10" data-reveal>
            <p class="font-mono text-xs uppercase tracking-[0.5em] text-mint-400 mb-2">À découvrir</p>
            <h2 class="font-display text-3xl font-semibold text-ink-primary">Autres prestations recommandées</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($relatedServices as $related)
                <article class="relative overflow-hidden rounded-3xl border border-(--border-default) bg-surface-canvas/70 p-6 shadow-2xl shadow-(--glow-accent) hover:border-mint-400/60 transition" data-reveal style="--reveal-delay: {{ $loop->index * 100 }}ms">
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-sm text-ink-muted">{{ ucfirst($related->icon ?? 'service') }}</div>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-mint-500/15 text-mint-200 border border-mint-500/30">Focus</span>
                    </div>
                    <h3 class="font-display text-xl font-semibold text-ink-primary mb-4">{{ $related->title }}</h3>
                    <p class="text-ink-secondary mb-6 line-clamp-4">{{ Str::limit($related->description, 140) }}</p>
                    <a href="{{ route('services.show', $related->slug) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-mint-400 hover:text-ink-primary">
                        Voir le service
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
