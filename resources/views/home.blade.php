@extends('layouts.app')

@section('title', 'Infinity WAB - Innovation Technologique pour le Burkina Faso')
@section('description', 'Infinity WAB crée des infrastructures, services et produits numériques sécurisés pour accompagner le Burkina Faso vers la transformation digitale.')

@section('content')
@php
    use Illuminate\Support\Str;

    $heroImage = \App\Models\Setting::get('hero_image_home');
@endphp

<!-- Hero -->
<section class="relative overflow-hidden bg-surface-canvas text-ink-primary pt-28 lg:pt-32 pb-40 lg:pb-48">
    @if($heroImage)
        {{-- Image personnalisée (admin > Paramètres > Personnalisation) : remplace la
             vidéo par défaut plutôt que de se superposer à elle. --}}
        <img src="{{ $heroImage }}" alt="" aria-hidden="true" class="absolute inset-0 h-full w-full scale-110 object-cover pointer-events-none opacity-50">
    @else
        <video
            class="absolute inset-0 h-full w-full scale-110 object-cover pointer-events-none opacity-50"
            data-parallax="0.08"
            data-autoplay-video
            autoplay
            muted
            loop
            playsinline
            aria-hidden="true"
        >
            <source src="{{ asset('images/Infinywab_video.mp4') }}" type="video/mp4">
            Votre navigateur ne supporte pas cette vidéo.
        </video>
    @endif
    <div class="absolute inset-0 bg-gradient-to-br from-[var(--hero-overlay-strong)] via-[var(--hero-overlay-soft)] to-[var(--hero-overlay-strong)] pointer-events-none"></div>

    <!-- Texture schématique : grille de points, écho des circuits imprimés / réseaux -->
    <div class="absolute inset-0 opacity-[0.12] pointer-events-none" style="background-image: radial-gradient(circle, #6bbfa0 1px, transparent 1px); background-size: 28px 28px;" data-parallax="0.03" aria-hidden="true"></div>

    <div class="absolute inset-0 pointer-events-none bg-[radial-gradient(circle_at_top,_rgba(107, 191, 160,0.16),_transparent_45%)]" data-parallax="0.05"></div>

    <div class="relative z-30 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl space-y-7 animate-fade-in-up">
            <p class="font-mono text-xs uppercase tracking-[0.5em] text-mint-400">Infinity WAB</p>
            <h1 class="font-display text-4xl md:text-6xl font-semibold leading-[1.05] tracking-tight">
                Innovation technologique <span class="text-gradient">à l’échelle du Burkina Faso</span>
            </h1>
            <p class="text-lg text-ink-secondary max-w-xl">
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
            <div class="flex flex-wrap gap-8 pt-2">
                @foreach($heroStats as $stat)
                    <div>
                        <p class="font-display text-2xl font-bold text-gradient">{{ $stat['value'] }}</p>
                        <p class="font-mono text-[0.65rem] uppercase tracking-[0.3em] text-ink-muted">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Cartes services en chevauchement, à l'intersection du hero et du reste de la page -->
<section class="relative z-40 -mt-24 lg:-mt-28">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-6 px-1" data-reveal>
            <p class="font-mono text-xs uppercase tracking-[0.4em] text-ink-secondary">Nos services</p>
            <a href="{{ route('services') }}" class="hidden sm:inline-flex items-center gap-2 text-sm font-semibold text-ink-secondary hover:text-ink-primary">
                Voir les 6 services
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($services->take(3) as $service)
                <article class="rounded-3xl bg-surface-raised border border-(--border-default) p-8 shadow-2xl shadow-(--glow-accent) hover:-translate-y-1 transition" data-reveal style="--reveal-delay: {{ $loop->index * 100 }}ms">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-mint-500 to-azure-500 flex items-center justify-center mb-5">
                        <x-ui.icon :name="$service->icon" class="w-7 h-7 text-white" />
                    </div>
                    <h3 class="font-display text-xl font-semibold text-ink-primary mb-2">{{ $service->title }}</h3>
                    <p class="text-sm text-ink-secondary leading-relaxed mb-5">{{ Str::limit($service->description, 110) }}</p>
                    <a href="{{ route('services.show', $service->slug) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-mint-500 hover:text-ink-primary">
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

<!-- Nos 4 branches -->
<section class="relative py-20 bg-surface-canvas">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        <div class="text-center space-y-3" data-reveal>
            <p class="font-mono text-xs uppercase tracking-[0.3em] text-mint-500">Notre organisation</p>
            <h2 class="font-display text-3xl font-semibold text-ink-primary">4 branches, une seule ambition</h2>
            <p class="text-ink-secondary max-w-2xl mx-auto">Infinity WAB chapeaute quatre entités spécialisées, chacune experte dans son domaine.</p>
        </div>
        <div class="relative">
            <!-- Trait de connexion entre les 4 branches, écho du fil conducteur "une seule ambition" -->
            <div class="hidden lg:block absolute top-7 left-[12.5%] right-[12.5%] h-px bg-(--border-strong)" aria-hidden="true"></div>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 relative">
                @php
                    $branches = [
                        ['icon' => 'wifi', 'name' => 'Infinity Network', 'tagline' => 'Connecter. Sécuriser. Innover.'],
                        ['icon' => 'lock-closed', 'name' => 'Infinity SafeTech', 'tagline' => 'Cybersécurité et sécurité technique.'],
                        ['icon' => 'terminal', 'name' => 'Infinity Soft_dev', 'tagline' => 'Sites web et applications sur mesure.'],
                        ['icon' => 'puzzle', 'name' => 'Infinity Miriade', 'tagline' => 'Application modulaire en construction.'],
                    ];
                @endphp
                @foreach($branches as $branch)
                    <div class="text-center space-y-3" data-reveal style="--reveal-delay: {{ $loop->index * 80 }}ms">
                        <div class="mx-auto w-14 h-14 rounded-2xl bg-surface-raised border border-(--border-default) flex items-center justify-center text-mint-500 relative z-10">
                            <x-ui.icon :name="$branch['icon']" class="w-7 h-7" />
                        </div>
                        <h3 class="font-display text-base font-semibold text-ink-primary">{{ $branch['name'] }}</h3>
                        <p class="text-sm text-ink-secondary">{{ $branch['tagline'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <x-ui.shape-divider shape="curve" fill="text-surface-raised" />
</section>

<!-- Réalisations -->
@if($projects->isNotEmpty())
    <section class="py-20 bg-surface-raised">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <div class="text-center space-y-3" data-reveal>
                <p class="font-mono text-xs uppercase tracking-[0.5em] text-mint-400">Réalisations</p>
                <h2 class="font-display text-3xl font-semibold text-ink-primary">Ce que nous avons livré</h2>
                <p class="text-ink-secondary max-w-3xl mx-auto">Des plateformes conçues, développées et déployées par les équipes Infinity WAB.</p>
            </div>
            <div class="grid grid-cols-1 {{ $projects->count() > 1 ? 'md:grid-cols-2' : '' }} gap-6">
                @foreach($projects as $project)
                    @php
                        $projectCover = $project->cover_url;
                    @endphp
                    <article class="group rounded-3xl border border-(--border-default) bg-surface-canvas/60 overflow-hidden shadow-2xl shadow-(--glow-accent) hover:-translate-y-1 transition" data-reveal style="--reveal-delay: {{ $loop->index * 100 }}ms">
                        <div class="h-56 w-full overflow-hidden">
                            <img src="{{ $projectCover }}" alt="{{ $project->title }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                        </div>
                        <div class="p-8 space-y-3">
                            <div class="font-mono text-xs uppercase tracking-[0.4em] text-ink-muted">{{ $project->category ?? 'Projet' }}</div>
                            <h3 class="font-display text-2xl font-semibold text-ink-primary">{{ $project->title }}</h3>
                            <p class="text-sm text-ink-secondary leading-relaxed">{{ Str::limit($project->description, 160) }}</p>
                            <a href="{{ route('projects.show', $project->slug) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-mint-400 hover:text-ink-primary pt-2">
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
@endif


<!-- Products -->
<section class="py-20 bg-surface-canvas text-ink-primary">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 grid gap-8 lg:grid-cols-3">
        <div class="lg:col-span-1 space-y-4" data-reveal>
            <h2 class="font-display text-3xl font-semibold">Produits durables</h2>
            <p class="text-ink-secondary">Des configurations prêtes à déployer et un accompagnement matériel complet (licences, déploiement, support). </p>
            <a href="{{ route('products') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-mint-400 hover:text-ink-primary">
                Voir tous les produits
            </a>
        </div>
        <div class="lg:col-span-2 grid gap-6 sm:grid-cols-2">
            @foreach($featuredProducts as $product)
                @php
                    $thumb = $product->cover_url;
                @endphp
                <article class="rounded-3xl border border-(--border-default) bg-surface-raised/70 p-6 shadow-2xl shadow-(--glow-accent) space-y-3 hover:-translate-y-1 transition" data-reveal style="--reveal-delay: {{ $loop->index * 80 }}ms">
                    <div class="h-40 w-full overflow-hidden rounded-2xl border border-(--border-default)">
                        <img src="{{ $thumb }}" alt="{{ $product->title }}" class="h-full w-full object-cover transition-transform duration-500 hover:scale-105">
                    </div>
                    <div class="flex items-center justify-between">
                        <h3 class="font-display text-xl font-semibold text-ink-primary">{{ $product->title }}</h3>
                        <span class="text-xs text-ink-muted">{{ $product->category }}</span>
                    </div>
                    <p class="text-sm text-ink-secondary line-clamp-3">{{ Str::limit($product->description, 120) }}</p>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-ink-secondary">{{ number_format($product->price ?? 0, 0, ',', ' ') }} FCFA</span>
                        <a href="{{ route('products.show', $product->slug) }}" class="font-semibold text-mint-400 hover:text-ink-primary inline-flex items-center gap-1">
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
    <section class="py-20 bg-surface-raised">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <div class="text-center space-y-3" data-reveal>
                <p class="font-mono text-xs uppercase tracking-[0.5em] text-mint-400">Partenaires</p>
                <h2 class="font-display text-3xl font-semibold text-ink-primary">Nous accompagnons des organisations de confiance</h2>
                <p class="text-ink-muted max-w-3xl mx-auto">Collaborations durables dans la cybersécurité, le cloud et l'innovation digitale.</p>
            </div>
            <div class="partners-marquee-wrapper" role="region" aria-label="Logos des partenaires">
                <div class="partners-marquee-track">
                    @foreach(range(1, 2) as $iteration)
                        @foreach($partners as $partner)
                            <article class="partners-marquee-card snap-center min-w-[230px] rounded-3xl border border-(--border-default) bg-surface-canvas/60 p-6 flex flex-col items-center justify-center space-y-4 shadow-lg shadow-(--glow-accent) transition hover:border-mint-400/40">
                                @if($partner->logo)
                                    <img src="{{ asset($partner->logo) }}" alt="{{ $partner->name }}" class="partners-marquee-logo h-16 w-full object-contain">
                                @else
                                    <div class="w-16 h-16 bg-black/5 dark:bg-white/10 rounded-full flex items-center justify-center text-ink-muted font-semibold text-lg">
                                        {{ strtoupper(substr($partner->name, 0, 2)) }}
                                    </div>
                                @endif
                                <p class="text-sm text-center text-ink-secondary font-semibold">{{ $partner->name }}</p>
                            </article>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif

<!-- Avis clients -->
@if($testimonials->isNotEmpty())
    <section class="py-20 bg-surface-canvas">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <div class="text-center space-y-3" data-reveal>
                <p class="font-mono text-xs uppercase tracking-[0.5em] text-mint-400">Avis clients</p>
                <h2 class="font-display text-3xl font-semibold text-ink-primary">Ce que nos clients en disent</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($testimonials as $testimonial)
                    <article class="rounded-3xl border border-(--border-default) bg-surface-raised/70 p-6 shadow-2xl shadow-(--glow-accent) space-y-4" data-reveal style="--reveal-delay: {{ $loop->index * 100 }}ms">
                        <div class="flex text-amber-400" aria-hidden="true">
                            @for($i = 0; $i < 5; $i++)
                                <svg class="w-4 h-4 {{ $i < $testimonial->rating ? '' : 'opacity-25' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.958a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.367 2.447a1 1 0 00-.363 1.118l1.287 3.958c.3.921-.755 1.688-1.538 1.118l-3.367-2.448a1 1 0 00-1.176 0l-3.367 2.448c-.783.57-1.838-.197-1.538-1.118l1.287-3.958a1 1 0 00-.363-1.118L2.063 9.385c-.783-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69l1.286-3.958z"/>
                                </svg>
                            @endfor
                        </div>
                        <p class="text-sm text-ink-secondary leading-relaxed">« {{ $testimonial->content }} »</p>
                        <div class="flex items-center gap-3 pt-2">
                            @if($testimonial->photo)
                                <img src="{{ asset($testimonial->photo) }}" alt="{{ $testimonial->name }}" class="w-10 h-10 rounded-full object-cover">
                            @else
                                <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-mint-500 to-azure-500 text-slate-950 font-semibold text-sm">
                                    {{ strtoupper(substr($testimonial->name, 0, 2)) }}
                                </span>
                            @endif
                            <div>
                                <p class="text-sm font-semibold text-ink-primary">{{ $testimonial->name }}</p>
                                @if($testimonial->role)
                                    <p class="text-xs text-ink-muted">{{ $testimonial->role }}</p>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endif

<!-- CTA -->
<section class="relative py-20 bg-gradient-to-r from-mint-700 via-azure-700 to-azure-600 text-white">
    <x-ui.shape-divider shape="angle" position="top" fill="text-mint-700" />
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6" data-reveal>
        <p class="font-mono text-xs uppercase tracking-[0.6em] text-mint-300">Prêt à innover ?</p>
        <h2 class="font-display text-3xl md:text-4xl font-semibold">Construisons la prochaine génération de services numériques au Burkina Faso.</h2>
        <p class="text-white/70">Des workshops à la livraison, Infinity WAB reste un partenaire stratégique concrètement présent au quotidien.</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-white text-slate-900 font-semibold rounded-2xl shadow-xl shadow-mint-600/30">
                Parler à un expert
            </a>
            <a href="{{ route('projects') }}" class="inline-flex items-center gap-2 px-8 py-3 rounded-2xl border border-white/40 text-white font-semibold">
                Voir nos projets
            </a>
        </div>
    </div>
</section>
@endsection
