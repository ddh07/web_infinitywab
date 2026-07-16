@extends('layouts.app')

@section('title', 'Nos Services - Infinity WAB')
@section('description', 'Des services technologiques sur mesure pour la transformation digitale au Burkina Faso.')

@section('content')
@php
    use Illuminate\Support\Str;

    $heroSummary = $serviceSummary ?? ['total' => $services->count(), 'categories' => $services->pluck('icon')->filter()->unique()->count(), 'with_content' => $services->filter(fn($service) => filled($service->content))->count()];
    $featured = $featuredServices->isNotEmpty() ? $featuredServices : $services->take(3);
@endphp

<!-- Hero -->
<section class="relative overflow-hidden bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950 text-white">
    <div class="absolute inset-0 opacity-50 bg-[radial-gradient(circle_at_top,_rgba(59,130,246,0.25),_transparent_45%)]"></div>
    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="max-w-3xl">
            <p class="text-xs tracking-[0.4em] text-blue-300 uppercase mb-4">Services</p>
            <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-6">
                Des solutions technologiques <span class="text-gradient-animated">futuristes</span> et fiables.
            </h1>
            <p class="text-lg text-white/70 mb-10">
                Infinity WAB combine maintenance, réseaux, développement et innovation pour déployer des expériences numériques
                qui font rayonner les organisations burkinabè.
            </p>
            <div class="flex flex-wrap gap-4">
                <x-ui.button href="{{ route('contact') }}">
                    Discuter de mon projet
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </x-ui.button>
                <x-ui.button href="#catalogue" variant="ghost">
                    <span class="text-sm uppercase tracking-widest">Explorer les services</span>
                </x-ui.button>
            </div>
        </div>

        <div class="mt-14 grid grid-cols-1 md:grid-cols-3 gap-6 relative z-10">
            <article class="rounded-3xl border border-white/10 bg-slate-900/60 p-6 backdrop-blur-xl shadow-2xl shadow-slate-900/40">
                <div class="text-sm text-white/60 uppercase tracking-[0.35em] mb-3">Solutions actives</div>
                <p class="text-4xl font-bold text-gradient mb-2">{{ $heroSummary['total'] }}+</p>
                <p class="text-sm text-white/60">services validés et maintenus chaque jour.</p>
            </article>
            <article class="rounded-3xl border border-white/10 bg-slate-900/60 p-6 backdrop-blur-xl shadow-2xl shadow-slate-900/40">
                <div class="text-sm text-white/60 uppercase tracking-[0.35em] mb-3">Axes d'expertise</div>
                <p class="text-4xl font-bold text-gradient mb-2">{{ $heroSummary['categories'] }}</p>
                <p class="text-sm text-white/60">domaines techniques pour couvrir vos défis critiques.</p>
            </article>
            <article class="rounded-3xl border border-white/10 bg-slate-900/60 p-6 backdrop-blur-xl shadow-2xl shadow-slate-900/40">
                <div class="text-sm text-white/60 uppercase tracking-[0.35em] mb-3">Contenus premium</div>
                <p class="text-4xl font-bold text-gradient mb-2">{{ $heroSummary['with_content'] }}</p>
                <p class="text-sm text-white/60">services documentés et prêts à être déployés.</p>
            </article>
        </div>

        <div class="mt-10 flex flex-wrap gap-3">
            @foreach($categoryChips as $icon => $label)
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-500/10 border border-blue-500/30 text-sm font-semibold text-white">
                    <span class="w-4 h-4 text-blue-300">
                        @include('partials.icons.service-icon', ['icon' => $icon, 'class' => 'w-full h-full', 'strokeClass' => ''])
                    </span>
                    {{ $label }}
                </span>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Services -->
<section class="py-20 bg-slate-950">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-10">
            <div>
                <p class="text-xs uppercase tracking-[0.5em] text-blue-400 mb-2">Focus</p>
                <h2 class="text-3xl font-semibold text-white">Services mis en lumière</h2>
                <p class="text-white/70">Des équipes dédiées, un accompagnement agile et une vision long terme pour chaque mission.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($featured as $service)
                @php
                    $serviceImagePath = $service->image ? ltrim($service->image, '/') : null;
                    if ($serviceImagePath && !str_starts_with($serviceImagePath, 'images/')) {
                        $serviceImagePath = 'images/' . $serviceImagePath;
                    }
                    $serviceCover = ($serviceImagePath && file_exists(public_path($serviceImagePath)))
                        ? asset($serviceImagePath)
                        : asset('images/services/defaukt_services_img.png');
                @endphp
                <article class="group relative overflow-hidden rounded-3xl border border-white/10 bg-slate-900/60 p-6 shadow-2xl shadow-black/40 transition-all duration-500 hover:translate-y-1 hover:bg-slate-900/80">
                    <div class="absolute inset-0">
                        <img src="{{ $serviceCover }}" alt="{{ $service->title }}" class="h-full w-full object-cover opacity-25 transition duration-500 group-hover:opacity-35">
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-br from-slate-950/40 via-slate-950/70 to-slate-950/40"></div>
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/20 via-transparent to-purple-500/10 opacity-0 transition duration-500 group-hover:opacity-100"></div>
                    <div class="relative z-10 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-500/20 text-blue-200 border border-blue-500/30">Vedette</span>
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-500 rounded-2xl flex items-center justify-center">
                                @include('partials.icons.service-icon', ['icon' => $service->icon, 'class' => 'w-4 h-4', 'strokeClass' => 'text-white'])
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-white">{{ $service->title }}</h3>
                        <p class="text-white/70 leading-relaxed line-clamp-4">
                            {{ Str::limit($service->description, 160) }}
                        </p>
                        <a href="{{ route('services.show', $service->slug) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-blue-300 hover:text-white">
                            Découvrir
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

<!-- Services Grid -->
<section id="catalogue" class="py-20 bg-slate-900">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.5em] text-blue-400 mb-2">Catalogue</p>
                <h2 class="text-3xl font-semibold text-white">Tous nos services</h2>
            </div>
            <div class="hidden md:flex items-center gap-3">
                <span class="text-white/60">Triés par ordre d'impact</span>
                <div class="h-px w-12 bg-gradient-to-r from-blue-500 to-purple-500"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($services as $service)
                @php
                    $serviceImagePath = $service->image ? ltrim($service->image, '/') : null;
                    if ($serviceImagePath && !str_starts_with($serviceImagePath, 'images/')) {
                        $serviceImagePath = 'images/' . $serviceImagePath;
                    }
                    $serviceCover = ($serviceImagePath && file_exists(public_path($serviceImagePath)))
                        ? asset($serviceImagePath)
                        : asset('images/services/defaukt_services_img.png');
                @endphp
                <article class="relative overflow-hidden rounded-3xl border border-white/10 bg-slate-950/30 p-6 shadow-2xl shadow-black/40 transition duration-500 hover:-translate-y-1 hover:border-white/30">
                    <div class="absolute inset-0">
                        <img src="{{ $serviceCover }}" alt="{{ $service->title }}" class="h-full w-full object-cover opacity-15">
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-br from-slate-950/30 via-slate-950/80 to-slate-950/30"></div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="p-3 rounded-2xl bg-gradient-to-br from-blue-500 to-purple-500">
                                @include('partials.icons.service-icon', ['icon' => $service->icon, 'class' => 'w-5 h-5', 'strokeClass' => 'text-white'])
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-white">{{ $service->title }}</h3>
                                <p class="text-xs uppercase tracking-[0.4em] text-blue-200">{{ ucfirst($service->icon ?? 'service') }}</p>
                            </div>
                        </div>
                        <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $service->is_active ? 'bg-emerald-500/20 text-emerald-200 border border-emerald-500/40' : 'bg-amber-500/20 text-amber-200 border border-amber-500/40' }}">
                            {{ $service->is_active ? 'Actif' : 'En préparation' }}
                        </span>
                    </div>
                    <p class="text-sm text-white/70 leading-relaxed mb-6 line-clamp-4">
                        {{ Str::limit($service->description, 180) }}
                    </p>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-white/60">{{ $service->content ? 'Documentation disponible' : 'Contenu en cours' }}</span>
                        <a href="{{ route('services.show', $service->slug) }}" class="text-sm font-semibold text-blue-300 hover:text-white inline-flex items-center gap-1">
                            En savoir plus
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
@endsection 
