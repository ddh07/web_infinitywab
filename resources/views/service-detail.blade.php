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
<section class="relative overflow-hidden bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 text-white">
    <div class="absolute inset-0 opacity-30 bg-[radial-gradient(circle_at_top,_rgba(79,70,229,0.3),_transparent_50%)]"></div>
    <div class="absolute inset-0">
        <img src="{{ $serviceCover }}" alt="" aria-hidden="true" class="h-full w-full object-cover opacity-20">
    </div>
    <div class="absolute inset-0 bg-slate-950/60"></div>
    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="flex flex-col gap-8 lg:flex-row lg:items-center">
            <div class="lg:w-2/3 space-y-6">
                <div class="inline-flex items-center gap-2 px-4 py-1 rounded-full bg-white/10 text-sm font-semibold uppercase tracking-[0.4em] text-blue-300">
                    <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Service aligné
                </div>
                <h1 class="text-4xl md:text-5xl font-bold leading-tight">
                    {{ $service->title }}
                </h1>
                <p class="text-xl text-white/70 leading-relaxed max-w-3xl">
                    {{ $service->description }}
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-gradient-to-r from-blue-500 to-purple-500 text-white font-semibold shadow-xl shadow-blue-800/40">
                        Besoin de ce service ?
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    <a href="{{ route('services') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl border border-white/15 text-white/90 font-semibold hover:border-white/40">
                        Revenir aux services
                    </a>
                </div>
            </div>
            <div class="lg:w-1/3">
                <div class="rounded-3xl border border-white/10 bg-slate-900/60 p-6 shadow-2xl shadow-black/50 backdrop-blur-xl">
                    <div class="flex items-center justify-between mb-5">
                        <div class="text-sm text-white/60">Statut</div>
                        <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $service->is_active ? 'bg-emerald-500/20 text-emerald-200 border border-emerald-500/40' : 'bg-amber-500/20 text-amber-200 border border-amber-500/40' }}">
                            {{ $service->is_active ? 'Actif' : 'En étude' }}
                        </span>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-[0.4em] text-white/50">Catégorie</p>
                                <p class="text-sm text-white">{{ ucfirst($service->icon ?? 'service') }}</p>
                            </div>
                            <div class="rounded-2xl bg-blue-500/10 p-3">
                                @include('partials.icons.service-icon', ['icon' => $service->icon, 'class' => 'w-5 h-5', 'strokeClass' => 'text-blue-300'])
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-[0.4em] text-white/50">Livraison</p>
                                <p class="text-sm text-white">3 à 8 semaines</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs uppercase tracking-[0.4em] text-white/50">Equipe</p>
                                <p class="text-sm text-white">Equipe dédiée</p>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-white/10">
                            <p class="text-xs uppercase tracking-[0.4em] text-white/50 mb-2">Support</p>
                            <p class="text-sm text-white">{{ $supportLabel }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Content & Details -->
<section class="py-20 bg-slate-950">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <article class="lg:col-span-2 space-y-8">
                <div class="rounded-3xl border border-white/10 bg-slate-900/70 p-8 shadow-xl shadow-black/50">
                    <h2 class="text-2xl font-semibold text-white mb-6">Ce que comprend ce service</h2>
                    @if(filled($service->content))
                        <div class="prose prose-invert max-w-none text-white/80 leading-relaxed">
                            {!! $service->content !!}
                        </div>
                    @else
                        <p class="text-white/70">
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
                        <div class="rounded-3xl border border-white/10 bg-slate-900/50 p-6">
                            <h3 class="text-lg font-semibold text-white mb-2">{{ $block['title'] }}</h3>
                            <p class="text-sm text-white/70">{{ $block['body'] }}</p>
                        </div>
                    @endforeach
                </div>
            </article>

            <aside class="space-y-6">
                <div class="rounded-3xl border border-white/10 bg-gradient-to-br from-blue-500/20 to-purple-500/20 p-6 text-white shadow-2xl shadow-blue-900/40">
                    <h3 class="text-xl font-semibold mb-3">Prêt à démarrer ?</h3>
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
                <div class="rounded-3xl border border-white/10 bg-slate-900/60 p-6">
                    <h3 class="text-lg font-semibold text-white mb-4">En résumé</h3>
                    <ul class="space-y-3 text-white/70 text-sm">
                        <li class="flex justify-between border-b border-white/10 pb-3">
                            <span>Livraisons historiques</span>
                            <span>+12 projets</span>
                        </li>
                        <li class="flex justify-between border-b border-white/10 pb-3">
                            <span>Partenaires technos</span>
                            <span>Cisco, Microsoft, AWS</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Niveau d’engagement</span>
                            <span class="text-emerald-300 font-semibold">Premium</span>
                        </li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</section>

<!-- Related services -->
@if($relatedServices->isNotEmpty())
<section class="py-20 bg-slate-900">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-10">
            <p class="text-xs uppercase tracking-[0.5em] text-blue-400 mb-2">À découvrir</p>
            <h2 class="text-3xl font-semibold text-white">Autres prestations recommandées</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($relatedServices as $related)
                <article class="relative overflow-hidden rounded-3xl border border-white/10 bg-slate-950/50 p-6 shadow-2xl shadow-black/40 hover:border-blue-500/60 transition">
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-sm text-white/60">{{ ucfirst($related->icon ?? 'service') }}</div>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-500/15 text-blue-200 border border-blue-500/30">Focus</span>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-4">{{ $related->title }}</h3>
                    <p class="text-white/70 mb-6 line-clamp-4">{{ Str::limit($related->description, 140) }}</p>
                    <a href="{{ route('services.show', $related->slug) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-blue-300 hover:text-white">
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
