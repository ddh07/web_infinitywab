@extends('layouts.app')

@section('title', 'Nos Projets - Infinity WAB')
@section('description', 'Une sélection de réalisations concrètes et de solutions sur mesure développées par Infinity WAB.')

@section('content')
@php
    use Illuminate\Support\Str;

    $featured = $featuredProjects->isNotEmpty() ? $featuredProjects : collect($projects->items())->take(3);
@endphp

<!-- Hero -->
<section class="relative overflow-hidden bg-gradient-to-br from-surface-raised via-surface-canvas to-surface-raised text-ink-primary pt-28 lg:pt-32 pb-20">
    <x-ui.hero-background page="projects" />
    <div class="absolute inset-0 pointer-events-none bg-[radial-gradient(circle_at_top,_rgba(107, 191, 160,0.25),_transparent_45%)]"></div>
    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        <div class="space-y-4 max-w-3xl">
            <p class="font-mono text-xs uppercase tracking-[0.5em] text-mint-400">Projets</p>
            <h1 class="font-display text-4xl md:text-5xl font-bold">
                Nos missions concrètes pour doter le Burkina Faso d’un numérique souverain.
            </h1>
            <p class="text-lg text-ink-secondary leading-relaxed">
                Des plateformes de commerce en ligne aux infrastructures critiques, chaque projet raconte un partenariat durable
                entre nos équipes techniques et nos clients.
            </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <article class="rounded-3xl border border-(--border-default) bg-surface-raised/70 p-6 shadow-2xl shadow-(--glow-accent)">
                <p class="font-mono text-xs uppercase tracking-[0.5em] text-ink-muted mb-2">Projets publiés</p>
                <p class="font-display text-4xl font-bold text-gradient mb-1">{{ $projectStats['total'] }}</p>
                <p class="text-sm text-ink-muted">réalisations vérifiées</p>
            </article>
            <article class="rounded-3xl border border-(--border-default) bg-surface-raised/70 p-6 shadow-2xl shadow-(--glow-accent)">
                <p class="font-mono text-xs uppercase tracking-[0.5em] text-ink-muted mb-2">Clients impliqués</p>
                <p class="font-display text-4xl font-bold text-gradient mb-1">{{ $projectStats['clients'] }}</p>
                <p class="text-sm text-ink-muted">organisations accompagnées</p>
            </article>
            <article class="rounded-3xl border border-(--border-default) bg-surface-raised/70 p-6 shadow-2xl shadow-(--glow-accent)">
                <p class="font-mono text-xs uppercase tracking-[0.5em] text-ink-muted mb-2">Vedettes</p>
                <p class="font-display text-4xl font-bold text-gradient mb-1">{{ $projectStats['featured'] }}</p>
                <p class="text-sm text-ink-muted">projets phares</p>
            </article>
        </div>
        <div class="flex flex-wrap gap-3">
            @foreach($projectCategories as $category)
                <span class="px-4 py-2 text-xs font-semibold tracking-wide uppercase rounded-full bg-black/5 dark:bg-white/10 border border-(--border-default) text-ink-secondary">
                    {{ $category }}
                </span>
            @endforeach
        </div>
    </div>
    <x-ui.shape-divider shape="curve" fill="text-surface-canvas" />
</section>

<!-- Featured projects -->
<section class="py-16 bg-surface-canvas">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <div class="flex items-center justify-between" data-reveal>
            <div>
                <p class="font-mono text-xs uppercase tracking-[0.4em] text-mint-400 mb-2">Focus</p>
                <h2 class="font-display text-3xl font-semibold text-ink-primary">Projets à la une</h2>
                <p class="text-ink-secondary">Des partenariats complets qui combinent innovation, maintenance et transfert.</p>
            </div>
            <span class="text-xs text-ink-muted">{{ $featured->count() }} projets mis en avant</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($featured as $project)
                <article class="relative overflow-hidden rounded-3xl border border-(--border-default) bg-surface-raised/70 p-5 shadow-2xl shadow-(--glow-accent) group" data-reveal style="--reveal-delay: {{ $loop->index * 100 }}ms">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(107, 191, 160,0.25),_transparent_55%)] opacity-0 group-hover:opacity-100 transition"></div>
                    <div class="relative z-10 space-y-4">
                        <div class="font-mono text-xs uppercase tracking-[0.4em] text-ink-muted">Client</div>
                        <h3 class="font-display text-xl font-semibold text-ink-primary">{{ $project->client }}</h3>
                        <p class="text-ink-secondary line-clamp-3">{{ Str::limit($project->description, 140) }}</p>
                        <p class="text-xs text-ink-muted">Catégorie : {{ $project->category ?? 'Général' }}</p>
                        <a href="{{ route('projects.show', $project->slug) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-mint-400 hover:text-ink-primary">
                            Voir le projet
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<!-- Projects grid -->
<section class="py-16 bg-surface-raised">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        <div class="flex items-center justify-between" data-reveal>
            <div>
                <p class="font-mono text-xs uppercase tracking-[0.4em] text-mint-400 mb-2">Catalogue complet</p>
                <h2 class="font-display text-3xl font-semibold text-ink-primary">Tous les projets</h2>
            </div>
            <span class="text-sm text-ink-muted">Page {{ $projects->currentPage() }} sur {{ $projects->lastPage() }}</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($projects as $project)
                @php
                    $projectCover = $project->cover_url;
                @endphp
                <article class="flex flex-col rounded-3xl border border-(--border-default) bg-surface-canvas/70 shadow-2xl shadow-(--glow-accent) overflow-hidden transition hover:-translate-y-1" data-reveal style="--reveal-delay: {{ $loop->index * 80 }}ms">
                    <div class="h-48 bg-gradient-to-br from-mint-500/10 to-azure-500/10 relative">
                        <img src="{{ $projectCover }}" alt="{{ $project->title }}" class="w-full h-full object-cover">
                        <span class="absolute top-4 left-4 px-3 py-1 text-xs font-semibold rounded-full border border-white/20 bg-white/10 text-white">
                            {{ $project->category ?? 'Projet' }}
                        </span>
                    </div>
                    <div class="flex-1 flex flex-col p-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-display text-xl font-semibold text-ink-primary">{{ $project->title }}</h3>
                                <p class="text-sm text-ink-muted">{{ $project->client }}</p>
                            </div>
                            <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $project->status === 'termine' ? 'bg-emerald-500/20 text-emerald-200 border border-emerald-500/40' : 'bg-mint-500/10 text-mint-200 border border-mint-500/30' }}">
                                {{ ucfirst(str_replace('_', ' ', $project->status ?? 'en_cours')) }}
                            </span>
                        </div>
                        <p class="text-sm text-ink-secondary flex-1 leading-relaxed line-clamp-3">{{ Str::limit($project->description, 160) }}</p>
                        @if($project->technologies)
                            <div class="flex flex-wrap gap-2">
                                @php
                                    $technologies = [];
                                    if (is_array($project->technologies)) {
                                        $technologies = $project->technologies;
                                    } elseif (is_string($project->technologies)) {
                                        $technologies = json_decode((string) $project->technologies, true) ?? [];
                                    }
                                @endphp
                                @foreach($technologies as $tech)
                                    <span class="px-3 py-1 text-xs text-ink-secondary bg-surface-raised/60 border border-(--border-default) rounded-full">{{ $tech }}</span>
                                @endforeach
                            </div>
                        @endif
                        <div class="flex items-center justify-between text-xs text-ink-muted">
                            <span>{{ $project->completion_date ? \Carbon\Carbon::parse($project->completion_date)->format('M Y') : 'En cours' }}</span>
                            <a href="{{ route('projects.show', $project->slug) }}" class="font-semibold text-mint-400 hover:text-ink-primary inline-flex items-center gap-1">
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
        @if($projects->hasPages())
            <div class="text-center">
                {{ $projects->links() }}
            </div>
        @endif
    </div>
</section>

<!-- CTA -->
<section class="py-16 bg-gradient-to-r from-mint-700 via-azure-700 to-azure-600 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6" data-reveal>
        <p class="font-mono text-xs uppercase tracking-[0.6em] text-mint-300">Prêt à collaborer</p>
        <h2 class="font-display text-3xl font-semibold">Votre prochain projet mérite une équipe dédiée.</h2>
        <p class="text-white/70">Rencontrons-nous pour co-construire la solution qui renforcera votre impact digital.</p>
        <x-ui.button href="{{ route('contact') }}" variant="light">
            Échanger avec un chef de projet
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </x-ui.button>
    </div>
</section>
@endsection
