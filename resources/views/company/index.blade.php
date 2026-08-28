@extends('layouts.app')

@section('title', 'Infinity WAB - Notre Entreprise')
@section('description', 'Découvrez Infinity WAB - Notre histoire, notre vision, notre mission et nos partenaires')

@section('content')
<!-- Hero Section -->
<section class="section section-dark relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <div class="animate-fade-in-up">
                <!-- Company Logo -->
                <div class="mb-8 animate-bounce-in">
                    <img src="{{ asset('images/logo_transparent.png') }}"
                         alt="Infinity WAB Logo"
                         class="w-24 h-24 md:w-32 md:h-32 mx-auto mb-6 animate-pulse-glow drop-shadow-2xl">
                </div>

                <h1 class="font-display heading-primary mb-6">
                    <span class="text-gradient">
                        Notre Entreprise
                    </span>
                </h1>
                <p class="text-xl text-secondary max-w-3xl mx-auto animate-fade-in-up animate-delay-200">
                    Découvrez l'histoire, la vision et les valeurs qui font d'Infinity WAB un leader technologique
                </p>
            </div>
        </div>
    </div>
</section>

@if($company)
<!-- Company Details Section -->
<section class="section section-dark">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
            <!-- Company Info -->
            <div class="animate-fade-in-left" data-reveal>
                <div class="card glass hover-lift">
                    <h2 class="font-display text-2xl font-bold text-primary mb-6">
                        {{ $company->name }}
                    </h2>

                    <div class="space-y-6">
                        <div>
                            <h3 class="font-display text-lg font-semibold text-mint-400 mb-3">Description</h3>
                            <p class="text-secondary leading-relaxed">
                                {{ $company->description }}
                            </p>
                        </div>

                        <div>
                            <h3 class="font-display text-lg font-semibold text-mint-400 mb-3">Notre Vision</h3>
                            <p class="text-secondary leading-relaxed">
                                {{ $company->vision }}
                            </p>
                        </div>

                        <div>
                            <h3 class="font-display text-lg font-semibold text-mint-400 mb-3">Notre Mission</h3>
                            <p class="text-secondary leading-relaxed">
                                {{ $company->mission }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Company Stats & Contact -->
            <div class="space-y-8 animate-fade-in-right">
                <!-- Stats -->
                <div class="card glass hover-lift">
                    <h3 class="font-display text-xl font-bold text-primary mb-6">Nos Réalisations</h3>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="text-center">
                            <div class="font-display text-4xl md:text-5xl font-bold bg-gradient-to-r from-mint-400 to-azure-400 bg-clip-text text-transparent mb-2 animate-pulse-glow">
                                {{ $company->getStat('years_experience', 0) }}+
                            </div>
                            <div class="text-secondary text-sm">Ans d'Expérience</div>
                        </div>
                        <div class="text-center">
                            <div class="font-display text-4xl md:text-5xl font-bold bg-gradient-to-r from-mint-400 to-azure-400 bg-clip-text text-transparent mb-2 animate-pulse-glow">
                                {{ $company->getStat('projects_completed', 0) }}+
                            </div>
                            <div class="text-secondary text-sm">Projets Réalisés</div>
                        </div>
                        <div class="text-center">
                            <div class="font-display text-4xl md:text-5xl font-bold bg-gradient-to-r from-mint-400 to-azure-400 bg-clip-text text-transparent mb-2 animate-pulse-glow">
                                {{ $company->getStat('satisfied_clients', 0) }}+
                            </div>
                            <div class="text-secondary text-sm">Clients Satisfaits</div>
                        </div>
                        <div class="text-center">
                            <div class="font-display text-4xl md:text-5xl font-bold bg-gradient-to-r from-mint-400 to-azure-400 bg-clip-text text-transparent mb-2 animate-pulse-glow">
                                {{ $company->getStat('support_availability', '24/7') }}
                            </div>
                            <div class="text-secondary text-sm">Support Technique</div>
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="card glass hover-lift">
                    <h3 class="font-display text-xl font-bold text-primary mb-6">Contactez-nous</h3>
                    <div class="space-y-4">
                        <div class="flex items-center text-secondary">
                            <svg class="w-5 h-5 mr-3 text-mint-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ $company->email }}
                        </div>

                            {{ $company->email }}
                        </div>

                        <div class="flex items-center text-secondary">
                            <svg class="w-5 h-5 mr-3 text-mint-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            {{ $company->phone }}
                        </div>

                        <div class="flex items-start text-secondary">
                            <svg class="w-5 h-5 mr-3 mt-1 text-mint-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $company->address }}
                        </div>

                        @if($company->website)
                        <div class="flex items-center text-secondary">
                            <svg class="w-5 h-5 mr-3 text-mint-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9 9m9 9H3m9 9a9 9 0 01-9-9m9 9c0 1.657-.356 3.242-.988 4.637l.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                            {{ $company->website }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@if($partners && $partners->count() > 0)
<!-- Partners Section -->
<section class="section section-dark">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-reveal>
            <h2 class="font-display heading-secondary mb-6 animate-fade-in-up">
                Nos <span class="text-gradient">Partenaires</span>
            </h2>
            <p class="text-xl text-secondary max-w-3xl mx-auto animate-fade-in-up animate-delay-200">
                Nous collaborons avec les meilleurs leaders technologiques et financiers pour vous offrir des solutions d'excellence
            </p>
        </div>

        <!-- Partners Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($partners as $partner)
            <div class="card glass hover-lift animate-fade-in-up animate-delay-{{ $loop->iteration * 100 }}" data-reveal style="--reveal-delay: {{ $loop->index * 100 }}ms">
                <div class="text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-mint-500 to-azure-500 rounded-xl flex items-center justify-center mx-auto mb-4 animate-float">
                        @if($partner->logo)
                            <img src="{{ asset($partner->logo) }}" alt="{{ $partner->name }}" class="w-16 h-16 object-contain">
                        @else
                            <span class="text-white font-bold text-xl">{{ substr($partner->name, 0, 2) }}</span>
                        @endif
                    </div>

                    <h3 class="font-display text-lg font-semibold text-primary mb-2">{{ $partner->name }}</h3>
                    <p class="text-secondary text-sm mb-4">{{ $partner->description }}</p>

                    @if($partner->website)
                    <a href="{{ $partner->website }}" target="_blank" class="btn-secondary">
                        <span>Visiter</span>
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-24 relative bg-animated">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative bg-gradient-to-br from-slate-800/50 to-slate-900/50 backdrop-blur-xl border border-slate-700 rounded-3xl p-12 overflow-hidden card-animated">
            <!-- Background Effects -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-mint-500/20 to-azure-500/20 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-br from-azure-500/20 to-mint-500/20 rounded-full blur-3xl animate-float-delayed"></div>

            <div class="relative z-10 text-center">
                <!-- Company Logo in CTA -->
                <div class="mb-8 animate-fade-in-up">
                    <img src="{{ asset('images/logov2_transparent.png') }}"
                         alt="Infinity WAB Logo"
                         class="w-20 h-20 mx-auto animate-pulse-glow drop-shadow-lg">
                </div>

                <div class="font-mono inline-flex items-center px-4 py-2 bg-mint-500/10 border border-mint-500/30 rounded-full text-mint-400 text-sm font-medium mb-6 animate-bounce-in animate-delay-200">
                    Rejoignez Notre Écosystème
                </div>
                <h2 class="font-display text-4xl md:text-5xl font-bold text-white mb-6 animate-fade-in-up animate-delay-300">
                    <span class="text-gradient-animated">
                        Infinity WAB
                    </span>
                </h2>
                <p class="text-xl text-white/70 mb-8 max-w-2xl mx-auto animate-fade-in-up animate-delay-400">
                    Devenez partenaire et développez votre activité avec des solutions technologiques de pointe
                </p>
                <div class="flex flex-col sm:flex-row gap-6 justify-center">
                    <a href="{{ route('contact') }}" class="btn-animated inline-flex items-center px-8 py-4 bg-gradient-to-r from-mint-500 to-azure-500 text-white font-semibold rounded-2xl transition-all duration-300 transform hover:scale-105 animate-fade-in-up animate-delay-500">
                        <span>Devenir Partenaire</span>
                        <svg class="w-5 h-5 ml-2 animate-heartbeat" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    <a href="{{ route('services') }}" class="btn-animated inline-flex items-center px-8 py-4 bg-white/10 backdrop-blur-md border border-white/30 text-white font-semibold rounded-2xl transition-all duration-300 transform hover:scale-105 hover:bg-white/20 animate-fade-in-up animate-delay-600">
                        <span>Découvrir nos Services</span>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
