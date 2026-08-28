@extends('layouts.app')

@section('title', 'Contact - Infinity WAB')
@section('description', 'Contactez Infinity WAB pour vos projets technologiques au Burkina Faso')

@section('content')
@php
    $heroContactSlides = [
        [
            'label' => 'Email',
            'value' => $company?->email ?? 'infinity-wab@infinity-wab.com',
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
<section class="relative overflow-hidden bg-gradient-to-br from-surface-raised via-surface-canvas to-surface-raised text-ink-primary pt-28 lg:pt-32">
    <x-ui.hero-background page="contact" />
    <!-- Signature visuelle de marque (tracé infini), en remplacement d'une image Unsplash
         chargée en dur : aucune dépendance externe, aucun poids réseau supplémentaire. -->
    <div class="absolute inset-0 pointer-events-none bg-[radial-gradient(circle_at_top,_rgba(107, 191, 160,0.16),_transparent_45%)]" aria-hidden="true"></div>

    <!-- Animated Particles -->
    <div class="absolute inset-0 overflow-hidden" aria-hidden="true">
        <div class="particle particle-1"></div>
        <div class="particle particle-2"></div>
        <div class="particle particle-3"></div>
        <div class="particle particle-4"></div>
        <div class="particle particle-5"></div>
    </div>

    <!-- Gradient Overlay -->
    <div class="absolute inset-0 opacity-30 bg-[radial-gradient(circle_at_top,_rgba(107, 191, 160,0.3),_transparent_50%)]"></div>
    <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_bottom,_rgba(91, 194, 217,0.2),_transparent_60%)]"></div>
    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
        <div class="flex flex-col gap-8 lg:flex-row lg:items-center">
            <div class="lg:w-2/3 space-y-6">
                <div class="inline-flex items-center gap-2 px-4 py-1 rounded-full bg-black/5 dark:bg-white/10 text-sm font-semibold uppercase tracking-[0.4em] text-mint-600 dark:text-mint-300">
                    <span class="h-2 w-2 rounded-full bg-mint-400 animate-pulse"></span>
                    Contactez-nous
                </div>
                <h1 class="text-4xl md:text-6xl font-bold">
                    <span class="text-gradient-animated">
                        Parlons de votre projet
                    </span>
                </h1>
                <p class="text-xl text-ink-secondary max-w-2xl">
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
                    @if($company?->whatsapp)
                    <x-ui.button href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $company->whatsapp) }}" variant="outline" as="a">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.04 2c-5.52 0-10 4.48-10 10 0 1.85.5 3.58 1.38 5.07L2 22l5.11-1.34A9.94 9.94 0 0012.04 22c5.52 0 10-4.48 10-10s-4.48-10-10-10zm5.6 14.15c-.24.67-1.4 1.28-1.93 1.36-.5.08-1.12.11-1.8-.11-.42-.13-.96-.31-1.66-.6-2.92-1.26-4.82-4.19-4.97-4.4-.15-.2-1.18-1.57-1.18-3 0-1.42.75-2.12 1.02-2.41.27-.29.58-.36.78-.36.2 0 .39.002.56.01.18.008.42-.07.66.5.24.58.83 2.02.9 2.16.07.15.12.32.02.51-.09.19-.15.31-.29.48-.14.17-.3.38-.43.5-.14.13-.28.28-.12.55.16.27.72 1.19 1.55 1.93 1.06.94 1.96 1.24 2.24 1.38.28.14.44.12.6-.05.17-.17.71-.83.9-1.11.19-.28.38-.23.63-.14.26.09 1.63.77 1.91.91.28.14.47.21.54.33.07.12.07.68-.17 1.35z"/>
                        </svg>
                        <span>WhatsApp</span>
                    </x-ui.button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <x-ui.shape-divider shape="zigzag" fill="text-surface-raised" />
</section>

<!-- Contact Form & Info -->
<section id="contact-form" class="py-20 bg-surface-raised">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div class="relative rounded-3xl border border-(--border-default) bg-surface-canvas/70 p-8 shadow-2xl shadow-(--glow-accent) animate-fade-in-left">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-black/5 dark:bg-white/10 border border-(--border-default) rounded-full text-ink-secondary text-sm font-semibold mb-6">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Formulaire de contact
                </div>
                <div class="relative z-10">
                    <h2 class="text-3xl font-bold text-ink-primary mb-6">
                        <span class="text-gradient">Envoyez-nous un message</span>
                    </h2>
                    <form class="space-y-6" method="POST" action="{{ route('contact.store') }}" data-loading-submit novalidate>
                        @csrf

                        {{-- Piège anti-spam : champ invisible pour un humain, souvent rempli par les bots --}}
                        <div class="absolute -left-[9999px] top-auto" aria-hidden="true">
                            <label for="website">Laissez ce champ vide</label>
                            <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                        </div>
                        <input type="hidden" name="form_rendered_at" value="{{ now()->timestamp }}">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="form-group" >
                                <label for="name" class="block text-sm font-medium text-ink-secondary mb-2">Nom complet</label>
                                <input type="text" id="name" name="name" required
                                    class="w-full px-4 py-3 bg-surface-sunken border border-(--border-default) rounded-2xl focus:border-mint-400 focus:ring-2 focus:ring-mint-400/20 transition-all duration-300 text-ink-primary placeholder:text-ink-muted"
                                    placeholder="Votre nom">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-ink-secondary mb-2">Email</label>
                                <input type="email" id="email" name="email" required
                                    class="w-full px-4 py-3 bg-surface-sunken border border-(--border-default) rounded-2xl focus:border-mint-400 focus:ring-2 focus:ring-mint-400/20 transition-all duration-300 text-ink-primary placeholder:text-ink-muted"
                                    placeholder="votre@email.com">
                            </div>
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-ink-secondary mb-2">Téléphone (optionnel)</label>
                            <input type="tel" id="phone" name="phone"
                                class="w-full px-4 py-3 bg-surface-sunken border border-(--border-default) rounded-2xl focus:border-mint-400 focus:ring-2 focus:ring-mint-400/20 transition-all duration-300 text-ink-primary placeholder:text-ink-muted"
                                placeholder="+226 XX XX XX XX">
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-ink-secondary mb-2">Sujet</label>
                            <select id="subject" name="subject" required
                                class="w-full px-4 py-3 bg-surface-sunken border border-(--border-default) rounded-2xl focus:border-mint-400 focus:ring-2 focus:ring-mint-400/20 transition-all duration-300 text-ink-primary">
                                <option value="" class="bg-surface-canvas text-ink-secondary">Choisissez un sujet</option>
                                <option value="maintenance" class="bg-surface-canvas text-ink-secondary">Maintenance Informatique</option>
                                <option value="reseaux" class="bg-surface-canvas text-ink-secondary">Réseaux & Sécurité</option>
                                <option value="developpement" class="bg-surface-canvas text-ink-secondary">Développement d'Applications</option>
                                <option value="creation" class="bg-surface-canvas text-ink-secondary">Création Technologique</option>
                                <option value="innovation" class="bg-surface-canvas text-ink-secondary">Innovation & Domotique</option>
                                <option value="conseil" class="bg-surface-canvas text-ink-secondary">Conseil & Formation</option>
                                <option value="autre" class="bg-surface-canvas text-ink-secondary">Autre</option>
                            </select>
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-ink-secondary mb-2">Message</label>
                            <textarea id="message" name="message" rows="6" required
                                class="w-full px-4 py-3 bg-surface-sunken border border-(--border-default) rounded-2xl focus:border-mint-400 focus:ring-2 focus:ring-mint-400/20 transition-all duration-300 text-ink-primary placeholder:text-ink-muted resize-vertical"
                                placeholder="Décrivez votre projet ou votre question..."></textarea>
                        </div>

                        @if(config('services.turnstile.site_key'))
                            <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}"></div>
                        @endif

                        <x-ui.button type="submit" class="w-full justify-center" data-loading-submit-button>
                            <span class="flex items-center justify-center" data-loading-submit-label>
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
                <div class="relative rounded-3xl border border-(--border-default) bg-surface-canvas/70 p-8 shadow-2xl shadow-(--glow-accent)">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-black/5 dark:bg-white/10 border border-(--border-default) rounded-full text-ink-secondary text-sm font-semibold mb-6">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314-11.314l4.243 4.243a8 8 0 010 11.314z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Informations de contact
                    </div>
                    <h3 class="text-3xl font-bold text-ink-primary mb-6">
                        <span class="text-gradient">Restons connectés</span>
                    </h3>

                    <div class="space-y-6">
                            <!-- Email -->
                            <div class="flex items-start space-x-4 group">
                                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-mint-500 to-azure-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-ink-primary">Email</h4>
                                    <p class="text-ink-secondary">{{ $company?->email ?? 'infinity-wab@infinity-wab.com' }}</p>
                                    <p class="text-sm text-ink-muted">Réponse sous 24h</p>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="flex items-start space-x-4 group">
                                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-azure-500 to-mint-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-ink-primary">Téléphone</h4>
                                    <p class="text-ink-secondary">{{ $company?->phone ?? '+226 XX XX XX XX' }}</p>
                                    <p class="text-sm text-ink-muted">Lun-Ven: 8h-18h</p>
                                </div>
                            </div>

                            <!-- WhatsApp -->
                            @if($company?->whatsapp)
                            <div class="flex items-start space-x-4 group">
                                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12.04 2c-5.52 0-10 4.48-10 10 0 1.85.5 3.58 1.38 5.07L2 22l5.11-1.34A9.94 9.94 0 0012.04 22c5.52 0 10-4.48 10-10s-4.48-10-10-10zm5.6 14.15c-.24.67-1.4 1.28-1.93 1.36-.5.08-1.12.11-1.8-.11-.42-.13-.96-.31-1.66-.6-2.92-1.26-4.82-4.19-4.97-4.4-.15-.2-1.18-1.57-1.18-3 0-1.42.75-2.12 1.02-2.41.27-.29.58-.36.78-.36.2 0 .39.002.56.01.18.008.42-.07.66.5.24.58.83 2.02.9 2.16.07.15.12.32.02.51-.09.19-.15.31-.29.48-.14.17-.3.38-.43.5-.14.13-.28.28-.12.55.16.27.72 1.19 1.55 1.93 1.06.94 1.96 1.24 2.24 1.38.28.14.44.12.6-.05.17-.17.71-.83.9-1.11.19-.28.38-.23.63-.14.26.09 1.63.77 1.91.91.28.14.47.21.54.33.07.12.07.68-.17 1.35z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-ink-primary">WhatsApp</h4>
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $company->whatsapp) }}" target="_blank" rel="noopener noreferrer" class="text-ink-secondary hover:text-mint-400">{{ $company->whatsapp }}</a>
                                    <p class="text-sm text-ink-muted">Réponse rapide en journée</p>
                                </div>
                            </div>
                            @endif

                            <!-- Location -->
                            <div class="flex items-start space-x-4 group">
                                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-azure-500 to-mint-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314-11.314l4.243 4.243a8 8 0 010 11.314z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-ink-primary">Localisation</h4>
                                    <p class="text-ink-secondary">{{ $company?->address ?? 'Ouagadougou, Burkina Faso' }}</p>
                                    <p class="text-sm text-ink-muted">{{ $company?->address ?? 'Ouagadougou, secteur 10' }}</p>
                                </div>
                            </div>
                    </div>
                </div>

                <!-- Hours Card -->
                <div class="relative rounded-3xl border border-(--border-default) bg-surface-canvas/70 p-8 shadow-2xl shadow-(--glow-accent)">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-mint-500/10 border border-mint-500/30 rounded-full text-mint-600 dark:text-mint-300 text-sm font-semibold mb-6">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Horaires d'ouverture
                    </div>
                    <h3 class="text-2xl font-bold text-ink-primary mb-6">Disponibilité</h3>
                    <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 bg-surface-sunken rounded-xl">
                                <span class="text-ink-secondary">Lundi - Vendredi</span>
                                <span class="font-semibold text-mint-600 dark:text-mint-400">8h - 18h</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-surface-sunken rounded-xl">
                                <span class="text-ink-secondary">Samedi</span>
                                <span class="font-semibold text-azure-600 dark:text-azure-400">9h - 16h</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-surface-sunken rounded-xl">
                                <span class="text-ink-secondary">Dimanche</span>
                                <span class="font-semibold text-red-600 dark:text-red-400">Fermé</span>
                            </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="relative rounded-3xl border border-(--border-default) bg-surface-canvas/70 p-8 shadow-2xl shadow-(--glow-accent)">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-azure-500/10 border border-azure-500/30 rounded-full text-azure-600 dark:text-azure-300 text-sm font-semibold mb-6">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                        </svg>
                        Réseaux sociaux
                    </div>
                    <h3 class="text-2xl font-bold text-ink-primary mb-6">Suivez-nous</h3>
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
                            <p class="text-sm text-ink-muted">Réseaux sociaux non renseignés.</p>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ -->
@if($faqs->isNotEmpty())
<section class="py-20 bg-surface-canvas">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        <div class="text-center space-y-3" data-reveal>
            <p class="font-mono text-xs uppercase tracking-[0.5em] text-mint-400">FAQ</p>
            <h2 class="font-display text-3xl font-semibold text-ink-primary">Questions fréquentes</h2>
            <p class="text-ink-secondary">Ce qu'on nous demande le plus souvent avant de démarrer un projet.</p>
        </div>

        <div class="space-y-3" data-reveal>
            @foreach($faqs as $faq)
                <details class="group rounded-2xl border border-(--border-default) bg-surface-raised/70 px-6 py-4 [&_summary::-webkit-details-marker]:hidden">
                    <summary class="flex items-center justify-between gap-4 cursor-pointer list-none font-semibold text-ink-primary">
                        {{ $faq->question }}
                        <svg class="w-5 h-5 text-mint-400 flex-shrink-0 transition-transform duration-300 group-open:rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </summary>
                    <p class="mt-3 text-sm text-ink-secondary leading-relaxed">{{ $faq->answer }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>

<script type="application/ld+json" nonce="{{ $cspNonce }}">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => $faqs->map(fn ($faq) => [
        '@type' => 'Question',
        'name' => $faq->question,
        'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => $faq->answer,
        ],
    ])->all(),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endif

@if(config('services.turnstile.site_key'))
    @push('scripts')
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer nonce="{{ $cspNonce }}"></script>
    @endpush
@endif
@endsection
