@extends('layouts.app')

@section('title', 'Nos Projets - Infinity WAB')
@section('description', 'Une sélection de réalisations concrètes et de solutions sur mesure développées par Infinity WAB.')

@section('content')
@php
    use Illuminate\Support\Str;

    $featured = $featuredProjects->isNotEmpty() ? $featuredProjects : collect($projects->items())->take(3);
@endphp

<!-- Hero -->
<section class="relative overflow-hidden bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 text-white py-20">
    <div class="absolute inset-0 pointer-events-none bg-[radial-gradient(circle_at_top,_rgba(59,130,246,0.25),_transparent_45%)]"></div>
    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        <div class="space-y-4 max-w-3xl">
            <p class="text-xs uppercase tracking-[0.5em] text-blue-300">Projets</p>
            <h1 class="text-4xl md:text-5xl font-bold">
                Nos missions concrètes pour doter le Burkina Faso d’un numérique souverain.
            </h1>
            <p class="text-lg text-white/70 leading-relaxed">
                Des plateformes de commerce en ligne aux infrastructures critiques, chaque projet raconte un partenariat durable
                entre nos équipes techniques et nos clients.
            </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <article class="rounded-3xl border border-white/10 bg-slate-900/70 p-6 shadow-2xl shadow-black/40">
                <p class="text-xs uppercase tracking-[0.5em] text-white/60 mb-2">Projets publiés</p>
                <p class="text-4xl font-bold text-gradient mb-1">{{ $projectStats['total'] }}</p>
                <p class="text-sm text-white/60">réalisations vérifiées</p>
            </article>
            <article class="rounded-3xl border border-white/10 bg-slate-900/70 p-6 shadow-2xl shadow-black/40">
                <p class="text-xs uppercase tracking-[0.5em] text-white/60 mb-2">Clients impliqués</p>
                <p class="text-4xl font-bold text-gradient mb-1">{{ $projectStats['clients'] }}</p>
                <p class="text-sm text-white/60">organisations accompagnées</p>
            </article>
            <article class="rounded-3xl border border-white/10 bg-slate-900/70 p-6 shadow-2xl shadow-black/40">
                <p class="text-xs uppercase tracking-[0.5em] text-white/60 mb-2">Vedettes</p>
                <p class="text-4xl font-bold text-gradient mb-1">{{ $projectStats['featured'] }}</p>
                <p class="text-sm text-white/60">projets phares</p>
            </article>
        </div>
        <div class="flex flex-wrap gap-3">
            @foreach($projectCategories as $category)
                <span class="px-4 py-2 text-xs font-semibold tracking-wide uppercase rounded-full bg-white/10 border border-white/20 text-white/80">
                    {{ $category }}
                </span>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured projects -->
<section class="py-16 bg-slate-950">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.4em] text-blue-400 mb-2">Focus</p>
                <h2 class="text-3xl font-semibold text-white">Projets à la une</h2>
                <p class="text-white/70">Des partenariats complets qui combinent innovation, maintenance et transfert.</p>
            </div>
            <span class="text-xs text-white/60">{{ $featured->count() }} projets mis en avant</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($featured as $project)
                <article class="relative overflow-hidden rounded-3xl border border-white/10 bg-gradient-to-br from-slate-900/80 to-slate-950/40 p-5 shadow-2xl shadow-black/60 group">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(14,165,233,0.25),_transparent_55%)] opacity-0 group-hover:opacity-100 transition"></div>
                    <div class="relative z-10 space-y-4">
                        <div class="text-xs uppercase tracking-[0.4em] text-white/60">Client</div>
                        <h3 class="text-xl font-semibold text-white">{{ $project->client }}</h3>
                        <p class="text-white/70 line-clamp-3">{{ Str::limit($project->description, 140) }}</p>
                        <p class="text-xs text-white/60">Catégorie : {{ $project->category ?? 'Général' }}</p>
                        <a href="{{ route('projects.show', $project->slug) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-blue-300 hover:text-white">
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
<section class="py-16 bg-slate-900">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.4em] text-blue-400 mb-2">Catalogue complet</p>
                <h2 class="text-3xl font-semibold text-white">Tous les projets</h2>
            </div>
            <span class="text-sm text-white/60">Page {{ $projects->currentPage() }} sur {{ $projects->lastPage() }}</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($projects as $project)
                @php
                    $projectCover = $project->cover_url;
                @endphp
                <article class="flex flex-col rounded-3xl border border-white/10 bg-slate-950/50 shadow-2xl shadow-black/60 overflow-hidden transition hover:-translate-y-1">
                    <div class="h-48 bg-gradient-to-br from-blue-500/10 to-purple-500/10 relative">
                        <img src="{{ $projectCover }}" alt="{{ $project->title }}" class="w-full h-full object-cover">
                        <span class="absolute top-4 left-4 px-3 py-1 text-xs font-semibold rounded-full border border-white/20 bg-white/10">
                            {{ $project->category ?? 'Projet' }}
                        </span>
                    </div>
                    <div class="flex-1 flex flex-col p-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-semibold text-white">{{ $project->title }}</h3>
                                <p class="text-sm text-white/60">{{ $project->client }}</p>
                            </div>
                            <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $project->status === 'termine' ? 'bg-emerald-500/20 text-emerald-200 border border-emerald-500/40' : 'bg-blue-500/10 text-blue-200 border border-blue-500/30' }}">
                                {{ ucfirst(str_replace('_', ' ', $project->status ?? 'en_cours')) }}
                            </span>
                        </div>
                        <p class="text-sm text-white/70 flex-1 leading-relaxed line-clamp-3">{{ Str::limit($project->description, 160) }}</p>
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
                                    <span class="px-3 py-1 text-xs text-white/70 bg-slate-900/60 border border-white/10 rounded-full">{{ $tech }}</span>
                                @endforeach
                            </div>
                        @endif
                        <div class="flex items-center justify-between text-xs text-white/60">
                            <span>{{ $project->completion_date ? \Carbon\Carbon::parse($project->completion_date)->format('M Y') : 'En cours' }}</span>
                            <a href="{{ route('projects.show', $project->slug) }}" class="font-semibold text-blue-300 hover:text-white inline-flex items-center gap-1">
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
<section class="py-16 bg-gradient-to-r from-blue-500/20 to-purple-500/20 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6">
        <p class="text-xs uppercase tracking-[0.6em] text-blue-200">Prêt à collaborer</p>
        <h2 class="text-3xl font-semibold">Votre prochain projet mérite une équipe dédiée.</h2>
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
