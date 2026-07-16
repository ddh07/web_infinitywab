@extends('layouts.app')

@section('title', 'Contact - Infinity WAB')
@section('description', 'Contactez Infinity WAB pour vos projets technologiques au Burkina Faso')

@section('content')
@php
    $heroContactSlides = [
        [
            'label' => 'Email',
            'value' => $company?->email ?? 'contact@infinity-wab.bf',
            'description' => 'Réponse sous 24h pour les projets et demandes de collaboration.',
            'icon_path' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
        ],
        [
            'label' => 'Téléphone',
            'value' => $company?->phone ?? '+226 XX XX XX XX',
            'description' => 'Disponibles du lundi au vendredi, de 8h à 18h.',
            'icon_path' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z',
        ],
        [
            'label' => 'Bureau',
            'value' => $company?->address ?? 'Ouagadougou, Burkina Faso',
            'description' => 'Nous opérons depuis le secteur 10 avec des équipes sur le terrain.',
            'icon_path' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314-11.314l4.243 4.243a8 8 0 010 11.314z',
        ],
    ];
@endphp
<!-- Hero Section -->
<section class="relative overflow-hidden bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 text-white">
    <!-- Animated Background Image -->
    <div class="absolute inset-0 opacity-50">
        <div class="hero-bg-image absolute inset-0 bg-cover bg-center bg-no-repeat animate-slow-zoom"
             style="background-image: url('https://images.unsplash.com/photo-1451187580459-43490279c0fa?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950/80 via-slate-900/60 to-slate-950/80"></div>
    </div>

    <!-- Animated Particles -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="particle particle-1"></div>
        <div class="particle particle-2"></div>
        <div class="particle particle-3"></div>
        <div class="particle particle-4"></div>
        <div class="particle particle-5"></div>
    </div>

    <!-- Gradient Overlay -->
    <div class="absolute inset-0 opacity-30 bg-[radial-gradient(circle_at_top,_rgba(79,70,229,0.3),_transparent_50%)]"></div>
    <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_bottom,_rgba(139,92,246,0.2),_transparent_60%)]"></div>
    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="flex flex-col gap-8 lg:flex-row lg:items-center">
            <div class="lg:w-2/3 space-y-6">
                <div class="inline-flex items-center gap-2 px-4 py-1 rounded-full bg-white/10 text-sm font-semibold uppercase tracking-[0.4em] text-blue-300">
                    <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Contactez-nous
                </div>
                <h1 class="text-4xl md:text-6xl font-bold">
                    <span class="text-gradient-animated">
                        Parlons de votre projet
                    </span>
                </h1>
                <p class="text-xl text-white/70 max-w-2xl">
                    Une question ? Une idée ? Notre équipe est prête à vous accompagner dans vos ambitions technologiques.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <x-ui.button href="#contact-form">
                        <span>Envoyer un message</span>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </x-ui.button>
                    @if($company?->phone)
                    <x-ui.button href="tel:{{ $company->phone }}" variant="outline">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span>Appeler maintenant</span>
                    </x-ui.button>
                    @endif
                </div>
            </div>
            <div class="lg:w-1/3">
                <div class="relative hero-contact-carousel rounded-3xl border border-white/10 overflow-hidden bg-slate-900/50 shadow-2xl">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(59,130,246,0.25),_transparent_70%)]"></div>
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom,_rgba(139,92,246,0.25),_transparent_70%)] opacity-40"></div>

                    <!-- Carousel Track -->
                    <div class="relative hero-carousel-track">
                        @foreach($heroContactSlides as $slide)
                            <article class="hero-carousel-slide flex flex-col justify-between bg-slate-950/60 border border-white/5 rounded-3xl p-6 backdrop-blur-xl">
                                <div class="flex items-center gap-4">
                                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500/80 to-purple-500/80 flex items-center justify-center shadow-lg shadow-black/60 animate-pulse-glow">
                                        <svg class="w-7 h-7 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $slide['icon_path'] }}"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs uppercase tracking-[0.4em] text-blue-300">{{ $slide['label'] }}</p>
                                        <p class="text-2xl font-semibold text-white leading-tight">{{ $slide['value'] }}</p>
                                    </div>
                                </div>
                                <p class="text-sm text-white/70 mt-6 leading-relaxed">{{ $slide['description'] }}</p>
                            </article>
                        @endforeach
                    </div>

                    <!-- Navigation Dots -->
                    <div class="carousel-dots">
                        <div class="carousel-dot active" data-slide="0"></div>
                        <div class="carousel-dot" data-slide="1"></div>
                        <div class="carousel-dot" data-slide="2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form & Info -->
<section id="contact-form" class="py-20 bg-slate-900">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div class="relative rounded-3xl border border-white/10 bg-slate-900/60 p-8 shadow-2xl shadow-black/60 animate-fade-in-left">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 border border-white/20 rounded-full text-white/70 text-sm font-semibold mb-6">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Formulaire de contact
                </div>
                <div class="relative z-10">
                    <h2 class="text-3xl font-bold text-white mb-6">
                        <span class="text-gradient">Envoyez-nous un message</span>
                    </h2>
                    <form class="space-y-6" method="POST" action="{{ route('contact.store') }}" novalidate>
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="form-group" >
                                <label for="name" class="block text-sm font-medium text-white/90 mb-2">Nom complet</label>
                                <input type="text" id="name" name="name" required
                                    class="w-full px-4 py-3 bg-slate-950/30 border border-white/10 rounded-2xl focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all duration-300 text-white placeholder-white/40"
                                    placeholder="Votre nom">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-white/90 mb-2">Email</label>
                                <input type="email" id="email" name="email" required
                                    class="w-full px-4 py-3 bg-slate-950/30 border border-white/10 rounded-2xl focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all duration-300 text-white placeholder-white/40"
                                    placeholder="votre@email.com">
                            </div>
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-white/90 mb-2">Téléphone (optionnel)</label>
                            <input type="tel" id="phone" name="phone"
                                class="w-full px-4 py-3 bg-slate-950/30 border border-white/10 rounded-2xl focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all duration-300 text-white placeholder-white/40"
                                placeholder="+226 XX XX XX XX">
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-white/90 mb-2">Sujet</label>
                            <select id="subject" name="subject" required
                                class="w-full px-4 py-3 bg-slate-950/30 border border-white/10 rounded-2xl focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all duration-300 text-white">
                                <option value="" class="bg-slate-950 text-white/80">Choisissez un sujet</option>
                                <option value="maintenance" class="bg-slate-950 text-white/80">Maintenance Informatique</option>
                                <option value="reseaux" class="bg-slate-950 text-white/80">Réseaux & Sécurité</option>
                                <option value="developpement" class="bg-slate-950 text-white/80">Développement d'Applications</option>
                                <option value="creation" class="bg-slate-950 text-white/80">Création Technologique</option>
                                <option value="innovation" class="bg-slate-950 text-white/80">Innovation & Domotique</option>
                                <option value="conseil" class="bg-slate-950 text-white/80">Conseil & Formation</option>
                                <option value="autre" class="bg-slate-950 text-white/80">Autre</option>
                            </select>
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-white/90 mb-2">Message</label>
                            <textarea id="message" name="message" rows="6" required
                                class="w-full px-4 py-3 bg-slate-950/30 border border-white/10 rounded-2xl focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all duration-300 text-white placeholder-white/40 resize-vertical"
                                placeholder="Décrivez votre projet ou votre question..."></textarea>
                        </div>

                        <x-ui.button type="submit" class="w-full justify-center">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                                Envoyer le message
                            </span>
                        </x-ui.button>
                    </form>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="space-y-8 animate-fade-in-right">
                <!-- Contact Info Card -->
                <div class="relative rounded-3xl border border-white/10 bg-slate-900/60 p-8 shadow-2xl shadow-black/60">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 border border-white/20 rounded-full text-white/70 text-sm font-semibold mb-6">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314-11.314l4.243 4.243a8 8 0 010 11.314z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Informations de contact
                    </div>
                    <h3 class="text-3xl font-bold text-white mb-6">
                        <span class="text-gradient">Restons connectés</span>
                    </h3>

                    <div class="space-y-6">
                            <!-- Email -->
                            <div class="flex items-start space-x-4 group">
                                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-white">Email</h4>
                                    <p class="text-white/70">{{ $company?->email ?? 'contact@infinity-wab.bf' }}</p>
                                    <p class="text-sm text-white/50">Réponse sous 24h</p>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="flex items-start space-x-4 group">
                                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-purple-500 to-blue-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-white">Téléphone</h4>
                                    <p class="text-white/70">{{ $company?->phone ?? '+226 XX XX XX XX' }}</p>
                                    <p class="text-sm text-white/50">Lun-Ven: 8h-18h</p>
                                </div>
                            </div>

                            <!-- Location -->
                            <div class="flex items-start space-x-4 group">
                                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-pink-500 to-purple-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314-11.314l4.243 4.243a8 8 0 010 11.314z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-white">Localisation</h4>
                                    <p class="text-white/70">{{ $company?->address ?? 'Ouagadougou, Burkina Faso' }}</p>
                                    <p class="text-sm text-white/50">{{ $company?->address ?? 'Ouagadougou, secteur 10' }}</p>
                                </div>
                            </div>
                    </div>
                </div>

                <!-- Hours Card -->
                <div class="relative rounded-3xl border border-white/10 bg-slate-900/60 p-8 shadow-2xl shadow-black/60">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500/10 border border-emerald-500/30 rounded-full text-emerald-300 text-sm font-semibold mb-6">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Horaires d'ouverture
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-6">Disponibilité</h3>
                    <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 bg-slate-700/30 rounded-xl">
                                <span class="text-white/70">Lundi - Vendredi</span>
                                <span class="font-semibold text-emerald-400">8h - 18h</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-slate-700/30 rounded-xl">
                                <span class="text-white/70">Samedi</span>
                                <span class="font-semibold text-blue-400">9h - 16h</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-slate-700/30 rounded-xl">
                                <span class="text-white/70">Dimanche</span>
                                <span class="font-semibold text-red-400">Fermé</span>
                            </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="relative rounded-3xl border border-white/10 bg-slate-900/60 p-8 shadow-2xl shadow-black/60">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-pink-500/10 border border-pink-500/30 rounded-full text-pink-300 text-sm font-semibold mb-6">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                        </svg>
                        Réseaux sociaux
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-6">Suivez-nous</h3>
                    <div class="flex space-x-4">
                            @if($company && $company->getSocialLink('facebook'))
                            <a href="{{ $company->getSocialLink('facebook') }}" class="w-14 h-14 bg-gradient-to-br from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 rounded-2xl flex items-center justify-center transition-all duration-300 transform hover:scale-110 hover:shadow-lg hover:shadow-blue-500/30">
                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            @endif
                            @if($company && $company->getSocialLink('twitter'))
                            <a href="{{ $company->getSocialLink('twitter') }}" class="w-14 h-14 bg-gradient-to-br from-sky-500 to-sky-600 hover:from-sky-400 hover:to-sky-500 rounded-2xl flex items-center justify-center transition-all duration-300 transform hover:scale-110 hover:shadow-lg hover:shadow-sky-500/30">
                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                            </a>
                            @endif
                            @if($company && $company->getSocialLink('linkedin'))
                            <a href="{{ $company->getSocialLink('linkedin') }}" class="w-14 h-14 bg-gradient-to-br from-purple-600 to-purple-700 hover:from-purple-500 hover:to-purple-600 rounded-2xl flex items-center justify-center transition-all duration-300 transform hover:scale-110 hover:shadow-lg hover:shadow-purple-500/30">
                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                            @endif
                            @if(!$company || (!$company->getSocialLink('facebook') && !$company->getSocialLink('twitter') && !$company->getSocialLink('linkedin')))
                            <a href="#" class="w-14 h-14 bg-gradient-to-br from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 rounded-2xl flex items-center justify-center transition-all duration-300 transform hover:scale-110 hover:shadow-lg hover:shadow-blue-500/30">
                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            <a href="#" class="w-14 h-14 bg-gradient-to-br from-sky-500 to-sky-600 hover:from-sky-400 hover:to-sky-500 rounded-2xl flex items-center justify-center transition-all duration-300 transform hover:scale-110 hover:shadow-lg hover:shadow-sky-500/30">
                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                            </a>
                            <a href="#" class="w-14 h-14 bg-gradient-to-br from-purple-600 to-purple-700 hover:from-purple-500 hover:to-purple-600 rounded-2xl flex items-center justify-center transition-all duration-300 transform hover:scale-110 hover:shadow-lg hover:shadow-purple-500/30">
                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
