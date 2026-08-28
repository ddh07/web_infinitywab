<footer class="relative bg-surface-raised border-t border-(--border-default)">
    @php
        $companyName = $company->name ?? 'Infinity WAB';
        $companyDescription = $company->description ?? "L'excellence technologique africaine au service de l'innovation. Nous transformons les idées en solutions digitales puissantes.";
        $companySocialLinks = $company->social_links ?? [];
        $companyEmail = $company->email ?? 'infinity-wab@infinity-wab.com';
        $companyPhone = $company->phone ?? '+226 XX XX XX XX';
        $companyWhatsapp = $company->whatsapp ?? null;
        $companyAddress = $company->address ?? 'Ouagadougou, Burkina Faso';
        $companyWebsite = $company->website ?? 'https://infinity-wab.com';
        $companyPhoneLink = preg_replace('/[^0-9+]/', '', $companyPhone);

        // Mêmes tracés SVG que le formulaire admin (resources/views/admin/content.blade.php,
        // $companySocialPlatforms) : icônes de marque officielles, pas de dépendance externe.
        $socialIcons = [
            'facebook' => 'M12 2C6.477 2 2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12c0-5.523-4.477-10-10-10z',
            'twitter' => 'M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z',
            'linkedin' => 'M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z',
            'instagram' => 'M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z',
        ];
        // Repli générique pour une plateforme sans icône dédiée ci-dessus (lien externe).
        $socialIconFallback = 'M13.828 10.172a4 4 0 010 5.656l-3 3a4 4 0 01-5.656-5.656l1.5-1.5M10.172 13.828a4 4 0 010-5.656l3-3a4 4 0 015.656 5.656l-1.5 1.5';
    @endphp
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Brand Section -->
            <div class="md:col-span-2">
                <div class="flex items-center space-x-3 mb-6">
                    <img src="{{ asset('images/Infinity_WAB 2_1_NO BACK_whit.png') }}" alt="Infinity WAB" class="h-10 w-auto">
                </div>

                <p class="text-ink-secondary mb-6 leading-relaxed max-w-md">
                    {{ $companyDescription }}
                </p>

                <!-- Social Links -->
                <div class="flex flex-wrap gap-3">
                    @forelse($companySocialLinks as $platform => $link)
                        @php
                            $resolvedLink = is_array($link)
                                ? ($link['url'] ?? $link['link'] ?? (string) reset($link))
                                : (string) $link;
                        @endphp

                        @if(! empty($resolvedLink))
                            <a
                                href="{{ $resolvedLink }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex items-center justify-center w-10 h-10 rounded-lg bg-surface-sunken hover:bg-black/5 dark:hover:bg-white/10 transition-colors duration-300 text-ink-secondary"
                            >
                                <span class="sr-only">{{ ucfirst($platform) }}</span>
                                <svg class="w-4.5 h-4.5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    @if(isset($socialIcons[$platform]))
                                        <path d="{{ $socialIcons[$platform] }}"/>
                                    @else
                                        <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none" d="{{ $socialIconFallback }}"/>
                                    @endif
                                </svg>
                            </a>
                        @endif
                    @empty
                        <span class="text-sm text-ink-muted">Réseaux sociaux non renseignés.</span>
                    @endforelse
                </div>
            </div>

            <!-- Services -->
            <div>
                <h3 class="text-lg font-semibold text-ink-primary mb-6">Services</h3>
                <ul class="space-y-3">
                    @forelse($services ?? [] as $service)
                        @php
                            $serviceLink = $service->slug ? route('services.show', $service->slug) : route('services');
                        @endphp
                        <li>
                            <a href="{{ $serviceLink }}" class="text-ink-secondary hover:text-blue-500 dark:hover:text-blue-400 transition-colors duration-300">
                                {{ $service->title }}
                            </a>
                        </li>
                    @empty
                        <li>
                            <span class="text-ink-muted">Nos services seront bientôt disponibles.</span>
                        </li>
                    @endforelse
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h3 class="text-lg font-semibold text-ink-primary mb-6">Contact</h3>
                <div class="space-y-4">
                    <div class="flex items-center text-ink-muted">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <a href="mailto:{{ $companyEmail }}" class="text-ink-secondary hover:text-blue-500 dark:hover:text-blue-400 transition-colors duration-300">
                            {{ $companyEmail }}
                        </a>
                    </div>

                    <div class="flex items-center text-ink-muted">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <a href="tel:{{ $companyPhoneLink }}" class="text-ink-secondary hover:text-blue-500 dark:hover:text-blue-400 transition-colors duration-300">
                            {{ $companyPhone }}
                        </a>
                    </div>

                    @if($companyWhatsapp)
                    <div class="flex items-center text-ink-muted">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.04 2c-5.52 0-10 4.48-10 10 0 1.85.5 3.58 1.38 5.07L2 22l5.11-1.34A9.94 9.94 0 0012.04 22c5.52 0 10-4.48 10-10s-4.48-10-10-10zm5.6 14.15c-.24.67-1.4 1.28-1.93 1.36-.5.08-1.12.11-1.8-.11-.42-.13-.96-.31-1.66-.6-2.92-1.26-4.82-4.19-4.97-4.4-.15-.2-1.18-1.57-1.18-3 0-1.42.75-2.12 1.02-2.41.27-.29.58-.36.78-.36.2 0 .39.002.56.01.18.008.42-.07.66.5.24.58.83 2.02.9 2.16.07.15.12.32.02.51-.09.19-.15.31-.29.48-.14.17-.3.38-.43.5-.14.13-.28.28-.12.55.16.27.72 1.19 1.55 1.93 1.06.94 1.96 1.24 2.24 1.38.28.14.44.12.6-.05.17-.17.71-.83.9-1.11.19-.28.38-.23.63-.14.26.09 1.63.77 1.91.91.28.14.47.21.54.33.07.12.07.68-.17 1.35z"/>
                        </svg>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $companyWhatsapp) }}" target="_blank" rel="noopener noreferrer" class="text-ink-secondary hover:text-mint-400 transition-colors duration-300">
                            WhatsApp — {{ $companyWhatsapp }}
                        </a>
                    </div>
                    @endif

                    <div class="flex items-start text-ink-muted">
                        <svg class="w-5 h-5 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>{{ $companyAddress }}</span>
                    </div>

                </div>
            </div>
        </div>

        <!-- Bottom Section -->
        <div class="border-t border-(--border-default) mt-8 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div class="text-ink-muted text-sm">
                    Copyright &copy; {{ date('Y') }} {{ $companyName }} SARL. Tous droits réservés.
                </div>

                <div class="flex space-x-6">
                    <a href="{{ route('privacy') }}" class="text-ink-secondary hover:text-mint-500 transition-colors duration-300 text-sm">
                        Politique de Confidentialité
                    </a>
                    <a href="{{ route('terms') }}" class="text-ink-secondary hover:text-mint-500 transition-colors duration-300 text-sm">
                        Conditions d'Utilisation
                    </a>
                    <a href="{{ route('accessibility') }}" class="text-ink-secondary hover:text-mint-500 transition-colors duration-300 text-sm">
                        Accessibilité
                    </a>
                    @if(config('services.gtm.container_id'))
                        <button type="button" data-cookie-manage class="text-ink-secondary hover:text-mint-500 transition-colors duration-300 text-sm">
                            Gérer les cookies
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</footer>
