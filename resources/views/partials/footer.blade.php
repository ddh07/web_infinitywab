<footer class="relative bg-slate-900 border-t border-slate-700">
    @php
        use Illuminate\Support\Str;

        $companyName = $company->name ?? 'Infinity WAB';
        $companyDescription = $company->description ?? "L'excellence technologique africaine au service de l'innovation. Nous transformons les idées en solutions digitales puissantes.";
        $companySocialLinks = $company->social_links ?? [];
        $companyEmail = $company->email ?? 'contact@infinity-wab.bf';
        $companyPhone = $company->phone ?? '+226 XX XX XX XX';
        $companyAddress = $company->address ?? 'Ouagadougou, Burkina Faso';
        $companyWebsite = $company->website ?? 'https://infinity-wab.bf';
        $companyPhoneLink = preg_replace('/[^0-9+]/', '', $companyPhone);
    @endphp
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Brand Section -->
            <div class="md:col-span-2">
                <div class="flex items-center space-x-3 mb-6">
                    <img src="{{ asset('images/Infinity_WAB 2_1_NO BACK_whit.png') }}" alt="Infinity WAB" class="w-250 h-20">
                </div>

                <p class="text-white/70 mb-6 leading-relaxed max-w-md">
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
                                class="flex items-center justify-center w-10 h-10 rounded-lg bg-slate-800 hover:bg-slate-700 transition-colors duration-300 text-white/80 font-semibold text-sm"
                            >
                                <span class="sr-only">{{ ucfirst($platform) }}</span>
                                {{ strtoupper(Str::substr($platform, 0, 2)) }}
                            </a>
                        @endif
                    @empty
                        <span class="text-sm text-white/50">Réseaux sociaux non renseignés.</span>
                    @endforelse
                </div>
            </div>

            <!-- Services -->
            <div>
                <h3 class="text-lg font-semibold text-white mb-6">Services</h3>
                <ul class="space-y-3">
                    @forelse($services ?? [] as $service)
                        @php
                            $serviceLink = $service->slug ? route('services.show', $service->slug) : route('services');
                        @endphp
                        <li>
                            <a href="{{ $serviceLink }}" class="text-white/60 hover:text-blue-400 transition-colors duration-300">
                                {{ $service->title }}
                            </a>
                        </li>
                    @empty
                        <li>
                            <span class="text-white/60">Nos services seront bientôt disponibles.</span>
                        </li>
                    @endforelse
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h3 class="text-lg font-semibold text-white mb-6">Contact</h3>
                <div class="space-y-4">
                    <div class="flex items-center text-white/60">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <a href="mailto:{{ $companyEmail }}" class="text-white/80 hover:text-blue-400 transition-colors duration-300">
                            {{ $companyEmail }}
                        </a>
                    </div>

                    <div class="flex items-center text-white/60">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <a href="tel:{{ $companyPhoneLink }}" class="text-white/80 hover:text-blue-400 transition-colors duration-300">
                            {{ $companyPhone }}
                        </a>
                    </div>

                    <div class="flex items-start text-white/60">
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
        <div class="border-t border-slate-700 mt-8 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div class="text-white/60 text-sm">
                    Copyright &copy; {{ date('Y') }} {{ $companyName }} - SoftDev. Tous droits réservés.
                </div>

                <div class="flex space-x-6">
                    <a href="#" class="text-white/60 hover:text-blue-400 transition-colors duration-300 text-sm">
                        Politique de Confidentialité
                    </a>
                    <a href="#" class="text-white/60 hover:text-blue-400 transition-colors duration-300 text-sm">
                        Conditions d'Utilisation
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>
