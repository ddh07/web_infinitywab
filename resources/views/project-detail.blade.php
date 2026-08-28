@extends('layouts.app')

@section('title', $project->title . ' - Infinity WAB')
@section('description', Str::limit(strip_tags($project->description ?? $project->content), 160))

@section('content')
@php
    $technologies = $project->technologies ? json_decode((string) $project->technologies, true) : [];
    $gallery = $project->gallery ? json_decode((string) $project->gallery, true) : [];
    $timeline = collect([
        ['label' => 'Début', 'value' => $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('M Y') : 'À définir'],
        ['label' => 'Fin', 'value' => $project->completion_date ? \Carbon\Carbon::parse($project->completion_date)->format('M Y') : 'En cours'],
        ['label' => 'Client', 'value' => $project->client ?? 'Confidentiel'],
        ['label' => 'Statut', 'value' => ucfirst(str_replace('_', ' ', $project->status ?? 'en_cours'))],
    ]);

    $projectCover = $project->cover_url;
@endphp

<!-- Hero -->
<section class="relative overflow-hidden bg-gradient-to-br from-surface-raised via-surface-canvas to-surface-raised text-ink-primary pt-28 lg:pt-32 pb-20">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(107, 191, 160,0.35),_transparent_45%)] opacity-50 pointer-events-none"></div>
    <x-ui.hero-shapes variant="beam" />
    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        <div class="space-y-3">
            <p class="font-mono text-xs uppercase tracking-[0.5em] text-mint-400">Projet</p>
            <h1 class="font-display text-4xl md:text-5xl font-bold leading-tight">
                {{ $project->title }}
            </h1>
            <p class="text-lg text-ink-secondary">{{ $project->description }}</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <article class="rounded-3xl border border-(--border-default) bg-surface-raised/70 p-6 shadow-2xl shadow-(--glow-accent)">
                <p class="font-mono text-xs uppercase tracking-[0.4em] text-ink-muted mb-1">Client</p>
                <h2 class="font-display text-2xl font-semibold text-ink-primary">{{ $project->client ?? 'Équipe Infinity WAB' }}</h2>
            </article>
            <article class="rounded-3xl border border-(--border-default) bg-surface-raised/70 p-6 shadow-2xl shadow-(--glow-accent)">
                <p class="font-mono text-xs uppercase tracking-[0.4em] text-ink-muted mb-1">Catégorie</p>
                <h2 class="font-display text-2xl font-semibold text-gradient">{{ $project->category ?? 'Solutions sur mesure' }}</h2>
            </article>
            <article class="rounded-3xl border border-(--border-default) bg-surface-raised/70 p-6 shadow-2xl shadow-(--glow-accent)">
                <p class="font-mono text-xs uppercase tracking-[0.4em] text-ink-muted mb-1">Statut</p>
                <h2 class="font-display text-2xl font-semibold text-ink-primary">{{ ucfirst(str_replace('_', ' ', $project->status ?? 'en_cours')) }}</h2>
            </article>
        </div>
        <div class="flex flex-wrap gap-3">
            @if($project->duration)
                <span class="text-xs font-semibold px-4 py-2 rounded-full border border-(--border-default) bg-black/5 dark:bg-white/10">
                    Durée : {{ $project->duration }}
                </span>
            @endif
            @if($project->team_size)
                <span class="text-xs font-semibold px-4 py-2 rounded-full border border-(--border-default) bg-black/5 dark:bg-white/10">
                    Équipe : {{ $project->team_size }} experts
                </span>
            @endif
            <span class="text-xs font-semibold px-4 py-2 rounded-full border border-(--border-default) bg-black/5 dark:bg-white/10">
                Livré en {{ $project->completion_date ? \Carbon\Carbon::parse($project->completion_date)->format('M Y') : 'à venir' }}
            </span>
        </div>
    </div>
    <x-ui.shape-divider shape="arc" fill="text-surface-raised" />
</section>

<!-- Content -->
<section class="py-16 bg-surface-raised">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 grid gap-10 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-8">
            <div class="rounded-3xl overflow-hidden border border-(--border-default) shadow-2xl shadow-(--glow-accent)">
                <img src="{{ $projectCover }}" alt="{{ $project->title }}" class="w-full h-96 object-cover">
            </div>

            @if($project->content)
                <article class="bg-surface-canvas/70 rounded-3xl border border-(--border-default) p-8 shadow-2xl shadow-(--glow-accent)">
                    <h2 class="font-display text-2xl font-semibold text-ink-primary mb-4">À propos du projet</h2>
                    <div class="prose prose-invert max-w-none text-ink-secondary leading-relaxed">
                        {!! $project->content !!}
                    </div>
                </article>
            @endif

            @if($technologies)
                <article class="bg-surface-canvas/70 rounded-3xl border border-(--border-default) p-8 shadow-2xl shadow-(--glow-accent)">
                    <h3 class="font-display text-xl font-semibold text-ink-primary mb-4">Technologies utilisées</h3>
                    <div class="flex flex-wrap gap-3">
                        @foreach($technologies as $tech)
                            <span class="px-4 py-2 rounded-full text-sm font-semibold bg-gradient-to-r from-mint-500 to-azure-500 text-white">
                                {{ $tech }}
                            </span>
                        @endforeach
                    </div>
                </article>
            @endif

            @if($gallery)
                <article class="bg-surface-canvas/70 rounded-3xl border border-(--border-default) p-8 shadow-2xl shadow-(--glow-accent)">
                    <h3 class="font-display text-xl font-semibold text-ink-primary mb-4">Galerie du projet</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($gallery as $image)
                            <div class="rounded-2xl overflow-hidden">
                                <img src="{{ asset($image) }}" alt="{{ $project->title }}" class="w-full h-52 object-cover transition-transform duration-500 hover:scale-105">
                            </div>
                        @endforeach
                    </div>
                </article>
            @endif
        </div>

        <aside class="space-y-6">
            <article class="bg-surface-canvas/70 rounded-3xl border border-(--border-default) p-6 shadow-2xl shadow-(--glow-accent) space-y-4">
                <h3 class="font-display text-xl font-semibold text-ink-primary">Fiche projet</h3>
                <ul class="space-y-3 text-sm text-ink-secondary">
                    @foreach($timeline as $entry)
                        <li class="flex justify-between border-b border-(--border-default) pb-2">
                            <span class="text-ink-muted">{{ $entry['label'] }}</span>
                            <span class="text-ink-primary font-semibold">{{ $entry['value'] }}</span>
                        </li>
                    @endforeach
                </ul>
            </article>

            @if($project->status)
                <article class="bg-surface-canvas/70 rounded-3xl border border-(--border-default) p-6 shadow-2xl shadow-(--glow-accent)">
                    <h3 class="font-display text-xl font-semibold text-ink-primary mb-3">Statut</h3>
                    <p class="text-ink-secondary">{{ ucfirst(str_replace('_', ' ', $project->status)) }}</p>
                </article>
            @endif

            <article class="bg-surface-canvas/70 rounded-3xl border border-(--border-default) p-6 shadow-2xl shadow-(--glow-accent) text-center">
                <p class="text-sm text-ink-muted mb-4">Besoin d’un projet similaire ?</p>
                <a href="{{ route('contact') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-mint-500 to-azure-500 rounded-2xl text-white font-semibold shadow-xl shadow-mint-600/50">
                    Planifier un entretien
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </article>
        </aside>
    </div>
</section>

<!-- Related -->
@php
    $relatedProjects = \App\Models\Project::where('id', '!=', $project->id)
        ->where('is_active', true)
        ->inRandomOrder()
        ->limit(3)
        ->get();
@endphp
@if($relatedProjects->isNotEmpty())
    <section class="py-20 bg-surface-canvas">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <div class="text-center" data-reveal>
                <p class="font-mono text-xs uppercase tracking-[0.5em] text-mint-400 mb-2">Autres réalisations</p>
                <h2 class="font-display text-3xl font-semibold text-ink-primary">Projets similaires</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedProjects as $related)
                    <article class="bg-surface-raised/70 rounded-3xl border border-(--border-default) p-6 shadow-2xl shadow-(--glow-accent) space-y-4" data-reveal style="--reveal-delay: {{ $loop->index * 100 }}ms">
                        <div class="h-40 w-full overflow-hidden rounded-2xl">
                            <img src="{{ $related->cover_url }}" alt="{{ $related->title }}" class="w-full h-full object-cover">
                        </div>
                        <h3 class="font-display text-xl font-semibold text-ink-primary">{{ $related->title }}</h3>
                        <p class="text-sm text-ink-secondary line-clamp-3">{{ Str::limit($related->description, 120) }}</p>
                        <a href="{{ route('projects.show', $related->slug) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-mint-400 hover:text-ink-primary">
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
