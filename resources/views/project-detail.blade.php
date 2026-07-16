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

    $projectImagePath = $project->image ? ltrim($project->image, '/') : null;
    if ($projectImagePath && !str_starts_with($projectImagePath, 'images/')) {
        $projectImagePath = 'images/' . $projectImagePath;
    }
    $projectCover = ($projectImagePath && file_exists(public_path($projectImagePath)))
        ? asset($projectImagePath)
        : asset('images/placeholder-project.jpg');
@endphp

<!-- Hero -->
<section class="relative overflow-hidden bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 text-white py-20">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(14,165,233,0.35),_transparent_45%)] opacity-50 pointer-events-none"></div>
    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        <div class="space-y-3">
            <p class="text-xs uppercase tracking-[0.5em] text-blue-300">Projet</p>
            <h1 class="text-4xl md:text-5xl font-bold leading-tight">
                {{ $project->title }}
            </h1>
            <p class="text-lg text-white/70">{{ $project->description }}</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <article class="rounded-3xl border border-white/10 bg-slate-900/70 p-6 shadow-2xl shadow-black/60">
                <p class="text-xs uppercase tracking-[0.4em] text-white/60 mb-1">Client</p>
                <h2 class="text-2xl font-semibold text-white">{{ $project->client ?? 'Équipe Infinity WAB' }}</h2>
            </article>
            <article class="rounded-3xl border border-white/10 bg-slate-900/70 p-6 shadow-2xl shadow-black/60">
                <p class="text-xs uppercase tracking-[0.4em] text-white/60 mb-1">Catégorie</p>
                <h2 class="text-2xl font-semibold text-gradient">{{ $project->category ?? 'Solutions sur mesure' }}</h2>
            </article>
            <article class="rounded-3xl border border-white/10 bg-slate-900/70 p-6 shadow-2xl shadow-black/60">
                <p class="text-xs uppercase tracking-[0.4em] text-white/60 mb-1">Statut</p>
                <h2 class="text-2xl font-semibold text-white">{{ ucfirst(str_replace('_', ' ', $project->status ?? 'en_cours')) }}</h2>
            </article>
        </div>
        <div class="flex flex-wrap gap-3">
            @if($project->duration)
                <span class="text-xs font-semibold px-4 py-2 rounded-full border border-white/20 bg-white/10">
                    Durée : {{ $project->duration }}
                </span>
            @endif
            @if($project->team_size)
                <span class="text-xs font-semibold px-4 py-2 rounded-full border border-white/20 bg-white/10">
                    Équipe : {{ $project->team_size }} experts
                </span>
            @endif
            <span class="text-xs font-semibold px-4 py-2 rounded-full border border-white/20 bg-white/10">
                Livré en {{ $project->completion_date ? \Carbon\Carbon::parse($project->completion_date)->format('M Y') : 'à venir' }}
            </span>
        </div>
    </div>
</section>

<!-- Content -->
<section class="py-16 bg-slate-900">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 grid gap-10 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-8">
            <div class="rounded-3xl overflow-hidden border border-white/10 shadow-2xl shadow-black/60">
                <img src="{{ $projectCover }}" alt="{{ $project->title }}" class="w-full h-96 object-cover">
            </div>

            @if($project->content)
                <article class="bg-slate-950/70 rounded-3xl border border-white/5 p-8 shadow-2xl shadow-black/60">
                    <h2 class="text-2xl font-semibold text-white mb-4">À propos du projet</h2>
                    <div class="prose prose-invert max-w-none text-white/80 leading-relaxed">
                        {!! $project->content !!}
                    </div>
                </article>
            @endif

            @if($technologies)
                <article class="bg-slate-950/70 rounded-3xl border border-white/5 p-8 shadow-2xl shadow-black/60">
                    <h3 class="text-xl font-semibold text-white mb-4">Technologies utilisées</h3>
                    <div class="flex flex-wrap gap-3">
                        @foreach($technologies as $tech)
                            <span class="px-4 py-2 rounded-full text-sm font-semibold bg-gradient-to-r from-blue-500 to-purple-500 text-white">
                                {{ $tech }}
                            </span>
                        @endforeach
                    </div>
                </article>
            @endif

            @if($gallery)
                <article class="bg-slate-950/70 rounded-3xl border border-white/5 p-8 shadow-2xl shadow-black/60">
                    <h3 class="text-xl font-semibold text-white mb-4">Galerie du projet</h3>
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
            <article class="bg-slate-950/70 rounded-3xl border border-white/5 p-6 shadow-2xl shadow-black/60 space-y-4">
                <h3 class="text-xl font-semibold text-white">Fiche projet</h3>
                <ul class="space-y-3 text-sm text-white/70">
                    @foreach($timeline as $entry)
                        <li class="flex justify-between border-b border-white/5 pb-2">
                            <span class="text-white/60">{{ $entry['label'] }}</span>
                            <span class="text-white font-semibold">{{ $entry['value'] }}</span>
                        </li>
                    @endforeach
                </ul>
            </article>

            @if($project->status)
                <article class="bg-slate-950/70 rounded-3xl border border-white/5 p-6 shadow-2xl shadow-black/60">
                    <h3 class="text-xl font-semibold text-white mb-3">Statut</h3>
                    <p class="text-white/70">{{ ucfirst(str_replace('_', ' ', $project->status)) }}</p>
                </article>
            @endif

            <article class="bg-slate-950/70 rounded-3xl border border-white/5 p-6 shadow-2xl shadow-black/60 text-center">
                <p class="text-sm text-white/60 mb-4">Besoin d’un projet similaire ?</p>
                <a href="{{ route('contact') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-500 rounded-2xl text-white font-semibold shadow-xl shadow-blue-900/50">
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
    <section class="py-20 bg-slate-900">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <div class="text-center">
                <p class="text-xs uppercase tracking-[0.5em] text-blue-400 mb-2">Autres réalisations</p>
                <h2 class="text-3xl font-semibold text-white">Projets similaires</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedProjects as $related)
                    <article class="bg-gradient-to-br from-slate-950/80 to-slate-900/60 rounded-3xl border border-white/10 p-6 shadow-2xl shadow-black/60 space-y-4">
                        <div class="h-40 w-full overflow-hidden rounded-2xl">
                            <img src="{{ asset($related->image ?? 'images/placeholder-project.jpg') }}" alt="{{ $related->title }}" class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-xl font-semibold text-white">{{ $related->title }}</h3>
                        <p class="text-sm text-white/70 line-clamp-3">{{ Str::limit($related->description, 120) }}</p>
                        <a href="{{ route('projects.show', $related->slug) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-blue-300 hover:text-white">
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
