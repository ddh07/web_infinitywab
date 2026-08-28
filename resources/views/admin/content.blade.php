@extends('layouts.admin')

@section('title', 'Contenu - Admin Infinity WAB')
@section('page-title', 'Contenu')

@section('content')
<div class="space-y-6">
    <!-- Company Information -->
    <div class="bg-surface-raised rounded-lg border border-(--border-default) shadow-sm">
        <div class="px-6 py-4 border-b border-(--border-default)">
            <h2 class="text-lg font-semibold text-ink-primary">Informations de l'Entreprise</h2>
        </div>
        <div class="p-6">
            <div id="company-loading" class="text-center py-8">
                <svg class="w-12 h-12 text-ink-muted mx-auto mb-3 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <p class="text-ink-muted text-sm">Chargement des informations...</p>
            </div>
            <form id="companyForm" class="hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-ink-secondary mb-1">Nom de l'entreprise</label>
                        <input type="text" id="companyName" class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-ink-secondary mb-1">Email</label>
                        <input type="email" id="companyEmail" class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-ink-secondary mb-1">Téléphone</label>
                        <input type="tel" id="companyPhone" class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-ink-secondary mb-1">WhatsApp</label>
                        <input type="tel" id="companyWhatsapp" class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-ink-secondary mb-1">Adresse</label>
                        <input type="text" id="companyAddress" class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-ink-secondary mb-1">Description</label>
                    <textarea id="companyDescription" rows="4" class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-ink-secondary mb-2">Vision</label>
                    <div id="visionList" class="space-y-2"></div>
                    <button type="button" id="btnAddVision" class="mt-2 text-sm font-medium text-blue-600 hover:text-blue-700 inline-flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Ajouter un énoncé
                    </button>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-ink-secondary mb-2">Mission</label>
                    <div id="missionList" class="space-y-2"></div>
                    <button type="button" id="btnAddMission" class="mt-2 text-sm font-medium text-blue-600 hover:text-blue-700 inline-flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Ajouter un énoncé
                    </button>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-ink-secondary mb-2">Valeurs</label>
                    <div id="valuesList" class="space-y-3"></div>
                    <button type="button" id="btnAddValue" class="mt-2 text-sm font-medium text-blue-600 hover:text-blue-700 inline-flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Ajouter une valeur
                    </button>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-ink-secondary mb-1">Mode d'affichage sur le site public</label>
                    <p class="text-xs text-ink-muted mb-3">S'applique aux sections Mission, Vision et Valeurs de la page À propos.</p>
                    <input type="hidden" id="companyDisplayMode" value="list">
                    <div class="inline-flex flex-wrap rounded-lg border border-(--border-default) overflow-hidden">
                        <button type="button" data-display-mode="list" class="display-mode-btn px-4 py-2 text-sm font-medium transition-colors">Liste</button>
                        <button type="button" data-display-mode="cards" class="display-mode-btn px-4 py-2 text-sm font-medium border-l border-(--border-default) transition-colors">Cartes</button>
                        <button type="button" data-display-mode="timeline" class="display-mode-btn px-4 py-2 text-sm font-medium border-l border-(--border-default) transition-colors">Timeline</button>
                        <button type="button" data-display-mode="feature-cards" class="display-mode-btn px-4 py-2 text-sm font-medium border-l border-(--border-default) transition-colors">Cartes + icône</button>
                        <button type="button" data-display-mode="feature-centered" class="display-mode-btn px-4 py-2 text-sm font-medium border-l border-(--border-default) transition-colors">Icônes centrées</button>
                        <button type="button" data-display-mode="feature-image" class="display-mode-btn px-4 py-2 text-sm font-medium border-l border-(--border-default) transition-colors">Image</button>
                    </div>
                </div>

                @php
                    $companyStatFields = [
                        ['key' => 'projects_completed', 'label' => 'Projets réalisés', 'placeholder' => '250+'],
                        ['key' => 'years_experience', 'label' => "Années d'expérience", 'placeholder' => '7'],
                        ['key' => 'satisfied_clients', 'label' => 'Clients satisfaits', 'placeholder' => '150+'],
                        ['key' => 'support_availability', 'label' => 'Disponibilité support', 'placeholder' => '24/7'],
                    ];
                    $companySocialPlatforms = [
                        [
                            'key' => 'facebook',
                            'label' => 'Facebook',
                            'placeholder' => 'https://facebook.com/votre-page',
                            'icon' => 'M12 2C6.477 2 2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12c0-5.523-4.477-10-10-10z',
                        ],
                        [
                            'key' => 'twitter',
                            'label' => 'X (Twitter)',
                            'placeholder' => 'https://x.com/votre-compte',
                            'icon' => 'M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z',
                        ],
                        [
                            'key' => 'linkedin',
                            'label' => 'LinkedIn',
                            'placeholder' => 'https://linkedin.com/company/votre-entreprise',
                            'icon' => 'M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z',
                        ],
                        [
                            'key' => 'instagram',
                            'label' => 'Instagram',
                            'placeholder' => 'https://instagram.com/votre-compte',
                            'icon' => 'M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z',
                        ],
                    ];
                @endphp

                <div class="mt-6">
                    <label class="block text-sm font-medium text-ink-secondary mb-3">Statistiques</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach($companyStatFields as $stat)
                            <div>
                                <label for="stat_{{ $stat['key'] }}" class="block text-xs text-ink-muted mb-1">{{ $stat['label'] }}</label>
                                <input type="text" id="stat_{{ $stat['key'] }}" data-stat-key="{{ $stat['key'] }}" placeholder="{{ $stat['placeholder'] }}"
                                    class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-ink-secondary mb-3">Réseaux sociaux</label>
                    <div class="space-y-3">
                        @foreach($companySocialPlatforms as $platform)
                            <div class="flex items-center gap-3">
                                <span class="flex items-center justify-center w-9 h-9 rounded-lg bg-surface-sunken text-ink-secondary shrink-0" title="{{ $platform['label'] }}">
                                    <svg class="w-4.5 h-4.5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="{{ $platform['icon'] }}"/>
                                    </svg>
                                </span>
                                <input type="url" id="social_{{ $platform['key'] }}" data-social-key="{{ $platform['key'] }}" placeholder="{{ $platform['placeholder'] }}"
                                    class="flex-1 px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-6">
                    <label class="flex items-center">
                        <input type="checkbox" id="companyActive" class="mr-2">
                        <span class="text-sm text-ink-secondary">Entreprise active</span>
                    </label>
                </div>

                <div class="mt-6">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Legal Documents Management -->
    <div class="bg-surface-raised rounded-lg border border-(--border-default) shadow-sm">
        <div class="px-6 py-4 border-b border-(--border-default)">
            <h2 class="text-lg font-semibold text-ink-primary">Documents légaux</h2>
            <p class="text-sm text-ink-muted mt-1">Choisissez un fichier PDF ou Markdown (.md) depuis la bibliothèque de médias pour remplacer le texte par défaut de chaque page.</p>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach([
                'confidentialite' => 'Politique de confidentialité',
                'conditions-utilisation' => 'Conditions d\'utilisation',
                'accessibilite' => 'Déclaration d\'accessibilité',
            ] as $legalSlug => $legalLabel)
                <div class="rounded-lg border border-(--border-default) p-4 space-y-3" data-legal-card="{{ $legalSlug }}">
                    <div>
                        <h3 class="font-semibold text-ink-primary">{{ $legalLabel }}</h3>
                        <p class="text-xs text-ink-muted mt-1" data-legal-status>Chargement…</p>
                    </div>
                    <form data-legal-form="{{ $legalSlug }}" class="space-y-2">
                        <input type="text" name="title" placeholder="Titre du document" value="{{ $legalLabel }}" class="w-full px-3 py-2 text-sm border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <input type="hidden" data-legal-media-id>
                        <div class="flex items-center gap-3">
                            <button type="button" data-legal-pick class="px-3 py-2 text-sm font-medium border border-(--border-default) rounded-lg text-ink-secondary hover:bg-surface-sunken">
                                Choisir dans la bibliothèque
                            </button>
                            <span data-legal-picked class="text-xs text-ink-muted truncate"></span>
                        </div>
                        <div class="flex items-center gap-3">
                            <button type="submit" class="px-3 py-2 text-sm font-medium bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Importer</button>
                            <button type="button" data-legal-reset class="hidden px-3 py-2 text-sm font-medium text-rose-600 hover:text-rose-800 dark:text-rose-400 dark:hover:text-rose-300">Réinitialiser au texte par défaut</button>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Partners Management -->
    <div class="bg-surface-raised rounded-lg border border-(--border-default) shadow-sm">
        <div class="px-6 py-4 border-b border-(--border-default) flex items-center justify-between">
            <h2 class="text-lg font-semibold text-ink-primary">Partenaires</h2>
            <button type="button" id="btnAddPartner" class="bg-azure-600 text-white px-4 py-2 rounded-lg hover:bg-azure-700 text-sm font-medium">
                Ajouter un partenaire
            </button>
        </div>
        <div class="p-6">
            <div id="partners-loading" class="text-center py-8">
                <svg class="w-12 h-12 text-ink-muted mx-auto mb-3 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <p class="text-ink-muted text-sm">Chargement des partenaires...</p>
            </div>
            <div id="partners-grid" class="hidden">
                <!-- Partners will be loaded dynamically via JavaScript -->
            </div>
        </div>
    </div>
</div>

    <!-- Content Items Management -->
    <div class="bg-surface-raised rounded-lg border border-(--border-default) shadow-sm">
        <div class="px-6 py-4 border-b border-(--border-default) flex items-center justify-between">
            <h2 class="text-lg font-semibold text-ink-primary">Contenus (Pages / Articles)</h2>
            <button type="button" id="btnAddContent" class="bg-azure-600 text-white px-4 py-2 rounded-lg hover:bg-azure-700 text-sm font-medium">
                Ajouter un contenu
            </button>
        </div>

        <div class="p-6">
            <div class="flex flex-wrap items-center gap-4 mb-5">
                <div class="relative flex-1 min-w-[260px]">
                    <input id="contentSearch" type="search" placeholder="Rechercher (titre / slug / excerpt)" class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500">
                </div>
                <div>
                    <select id="contentType" class="px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500">
                        <option value="">Tous les types</option>
                        <option value="page">Page</option>
                        <option value="post">Post</option>
                        <option value="article">Article</option>
                        <option value="announcement">Annonce</option>
                    </select>
                </div>
                <div>
                    <select id="contentStatus" class="px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500">
                        <option value="">Tous les statuts</option>
                        <option value="draft">Brouillon</option>
                        <option value="published">Publié</option>
                        <option value="archived">Archivé</option>
                    </select>
                </div>
            </div>

            <div class="overflow-hidden rounded-lg border border-(--border-default)">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-ink-secondary">
                        <thead class="bg-surface-sunken text-xs uppercase text-ink-muted">
                            <tr>
                                <th class="px-5 py-3">Titre</th>
                                <th class="px-5 py-3">Type</th>
                                <th class="px-5 py-3">Statut</th>
                                <th class="px-5 py-3">Publié</th>
                                <th class="px-5 py-3">Vitrine</th>
                                <th class="px-5 py-3">Ordre</th>
                                <th class="px-5 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="contentTableBody">
                            <tr>
                                <td colspan="7" class="px-5 py-12 text-center text-sm text-ink-muted">Chargement des contenus...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="contentEmptyState" class="hidden mt-6 text-center text-sm text-ink-muted">
                <p class="font-semibold text-ink-primary text-lg">Aucun contenu</p>
                <p>Créez un contenu ou ajustez les filtres.</p>
            </div>
        </div>
    </div>

<!-- Partner Modal -->
<div
    id="partnerModal"
    class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 px-4"
    role="dialog"
    aria-modal="true"
    aria-labelledby="partnerModalTitle"
>
    <div class="bg-surface-raised rounded-lg p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-ink-primary" id="partnerModalTitle">Ajouter un Partenaire</h3>
            <button type="button" class="js-close-partner-modal rounded-lg bg-surface-sunken p-2 text-ink-secondary hover:bg-black/5 dark:hover:bg-white/10">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form id="partnerForm">
            <input type="hidden" id="partnerId">

            <div class="mb-4">
                <label class="block text-sm font-medium text-ink-secondary mb-1">Nom</label>
                <input type="text" id="partnerName" required class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-ink-secondary mb-1">Description</label>
                <textarea id="partnerDescription" rows="3" required class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500"></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-ink-secondary mb-1">Site web</label>
                <input type="url" id="partnerWebsite" class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-ink-secondary mb-1">Logo</label>
                <div class="flex items-center gap-3">
                    <div id="partnerLogoPreview" class="h-12 w-12 flex-shrink-0 overflow-hidden rounded-lg border border-(--border-default) bg-surface-sunken"></div>
                    <input type="text" id="partnerLogo" class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500">
                    <button type="button" id="partnerLogoPick" class="flex-shrink-0 rounded-lg border border-(--border-default) px-3 py-2 text-xs font-medium text-ink-secondary hover:bg-surface-sunken">
                        Choisir
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-ink-secondary mb-1">Catégorie</label>
                    <select id="partnerCategory" required class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500">
                        <option value="technology">Technologie</option>
                        <option value="financial">Financier</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink-secondary mb-1">Ordre</label>
                    <input type="number" id="partnerOrder" value="0" class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500">
                </div>
            </div>

            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" id="partnerActive" checked class="mr-2">
                    <span class="text-sm text-ink-secondary">Partenaire actif</span>
                </label>
            </div>

            <div class="flex justify-center space-x-3 pt-3 border-t border-(--border-default) bg-surface-raised/95 backdrop-blur sticky bottom-0 z-10">
                <button type="button" class="js-close-partner-modal px-4 py-2 border border-(--border-default) rounded-lg hover:bg-surface-sunken">Annuler</button>
                <button type="submit" class="px-4 py-2 bg-azure-600 text-white rounded-lg hover:bg-azure-700">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<!-- Content Modal -->
<div
    id="contentModal"
    class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 px-4 py-10"
    role="dialog"
    aria-modal="true"
    aria-labelledby="contentModalTitle"
>
    <div class="bg-surface-raised rounded-lg p-6 w-full max-w-4xl overflow-y-auto max-h-[90vh]">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-lg font-semibold text-ink-primary" id="contentModalTitle">Ajouter un contenu</h3>
                <p class="text-sm text-ink-muted">Gérez pages, posts, articles et annonces.</p>
            </div>
            <button type="button" class="js-close-content-modal rounded-lg bg-surface-sunken p-2 text-ink-secondary hover:bg-black/5 dark:hover:bg-white/10">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form id="contentForm">
            <input type="hidden" id="contentId">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-ink-secondary mb-1">Titre *</label>
                    <input type="text" id="contentTitle" required class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink-secondary mb-1">Type *</label>
                    <select id="contentTypeInput" required class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500">
                        <option value="page">Page</option>
                        <option value="post">Post</option>
                        <option value="article">Article</option>
                        <option value="announcement">Annonce</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-ink-secondary mb-1">Statut *</label>
                    <select id="contentStatusInput" required class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500">
                        <option value="draft">Brouillon</option>
                        <option value="published">Publié</option>
                        <option value="archived">Archivé</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink-secondary mb-1">Publié le</label>
                    <input type="date" id="contentPublishedAt" class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-ink-secondary mb-1">Excerpt</label>
                <textarea id="contentExcerpt" rows="3" class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500"></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-ink-secondary mb-1">Contenu *</label>
                <textarea id="contentContent" rows="6" required class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500"></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-ink-secondary mb-1">Meta title</label>
                    <input type="text" id="contentMetaTitle" class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink-secondary mb-1">Meta description</label>
                    <input type="text" id="contentMetaDescription" class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-ink-secondary mb-1">Featured image</label>
                    <div class="flex items-center gap-3">
                        <div id="contentFeaturedImagePreview" class="h-12 w-12 flex-shrink-0 overflow-hidden rounded-lg border border-(--border-default) bg-surface-sunken"></div>
                        <input type="text" id="contentFeaturedImage" class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500" placeholder="images/featured.jpg">
                        <button type="button" id="contentFeaturedImagePick" class="flex-shrink-0 rounded-lg border border-(--border-default) px-3 py-2 text-xs font-medium text-ink-secondary hover:bg-surface-sunken">
                            Choisir
                        </button>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink-secondary mb-1">Ordre</label>
                    <input type="number" id="contentOrder" class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500" value="0">
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-6 mb-5">
                <label class="flex items-center gap-2 text-sm text-ink-secondary">
                    <input type="checkbox" id="contentIsFeatured" class="h-4 w-4 rounded border-(--border-default) text-azure-600 focus:ring-azure-500">
                    Contenu en vedette
                </label>
            </div>

            <div class="flex justify-center space-x-3 border-t border-(--border-default) pt-4 pb-3 bg-surface-raised/95 backdrop-blur sticky bottom-0 z-10">
                <button type="button" class="js-close-content-modal px-4 py-2 border border-(--border-default) rounded-lg hover:bg-surface-sunken">
                    Annuler
                </button>
                <button type="submit" class="px-4 py-2 bg-azure-600 text-white rounded-lg hover:bg-azure-700">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script nonce="{{ $cspNonce }}">
let currentPartnerId = null;

// window.bindMediaField/initRichEditor viennent du module app.js, chargé en <script
// type="module"> donc différé : à ce point de l'analyse du HTML, le module n'a pas
// encore forcément exécuté. On ne peut les appeler qu'après DOMContentLoaded (les
// scripts différés s'exécutent avant cet événement, jamais après).
let partnerLogoField;
let contentFeaturedImageField;

document.addEventListener('DOMContentLoaded', function() {
    partnerLogoField = window.bindMediaField({
        input: document.getElementById('partnerLogo'),
        preview: document.getElementById('partnerLogoPreview'),
        button: document.getElementById('partnerLogoPick'),
    });
    contentFeaturedImageField = window.bindMediaField({
        input: document.getElementById('contentFeaturedImage'),
        preview: document.getElementById('contentFeaturedImagePreview'),
        button: document.getElementById('contentFeaturedImagePick'),
    });
    window.initRichEditor('contentContent');

    loadCompanyData();
    loadPartnersData();
    loadContentsData();
    initLegalDocuments();
});

function initLegalDocuments() {
    function formatDocStatus(doc) {
        if (!doc || !doc.id) return 'Aucun document importé — le texte par défaut est affiché sur le site.';
        const kind = doc.format === 'pdf' ? 'PDF' : 'Markdown';
        const date = doc.updated_at ? new Date(doc.updated_at).toLocaleDateString('fr-FR') : '';
        return `${kind} importé (${escapeHtml(doc.media?.original_filename || '')}) — mis à jour le ${date}`;
    }

    function loadLegalDocuments() {
        fetch('/api/admin/legal-documents')
            .then((response) => response.json())
            .then((docs) => {
                docs.forEach((doc) => {
                    const card = document.querySelector(`[data-legal-card="${doc.slug}"]`);
                    if (!card) return;
                    card.querySelector('[data-legal-status]').textContent = formatDocStatus(doc);
                    const resetBtn = card.querySelector('[data-legal-reset]');
                    resetBtn.classList.toggle('hidden', !doc.id);

                    if (doc.media) {
                        card.querySelector('[data-legal-media-id]').value = doc.media_id;
                        card.querySelector('[data-legal-picked]').textContent = doc.media.original_filename;
                    }
                });
            })
            .catch(() => {
                showAlert('Impossible de charger les documents légaux.', 'error');
            });
    }

    document.querySelectorAll('[data-legal-form]').forEach((form) => {
        const slug = form.dataset.legalForm;

        form.querySelector('[data-legal-pick]').addEventListener('click', () => {
            window.openMediaPicker({
                accept: 'file',
                onSelect(items) {
                    const item = items[0];
                    form.querySelector('[data-legal-media-id]').value = item.id;
                    form.querySelector('[data-legal-picked]').textContent = item.original_filename;
                },
            });
        });

        form.addEventListener('submit', (e) => {
            e.preventDefault();

            const mediaId = form.querySelector('[data-legal-media-id]').value;
            if (!mediaId) {
                showAlert('Choisissez un fichier dans la bibliothèque avant d’importer.', 'error');
                return;
            }

            fetch(`/api/admin/legal-documents/${slug}`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    title: form.querySelector('[name="title"]').value,
                    media_id: mediaId,
                }),
            })
                .then(async (response) => {
                    const payload = await response.json().catch(() => null);
                    if (!response.ok) {
                        const message = payload?.message || (payload?.errors ? Object.values(payload.errors).flat().join(' ') : 'Import impossible.');
                        throw new Error(message);
                    }
                    return payload;
                })
                .then(() => {
                    showAlert('Document importé avec succès.');
                    loadLegalDocuments();
                })
                .catch((err) => {
                    showAlert(err?.message || 'Erreur lors de l’import.', 'error');
                });
        });

        form.closest('[data-legal-card]').querySelector('[data-legal-reset]').addEventListener('click', async () => {
            const confirmed = await window.confirmDialog('Revenir au texte par défaut pour ce document ? Le fichier reste disponible dans la bibliothèque de médias, seule son association à cette page est supprimée.', {
                title: 'Réinitialiser le document',
                confirmLabel: 'Réinitialiser',
            });
            if (!confirmed) return;

            fetch(`/api/admin/legal-documents/${slug}`, { method: 'DELETE' })
                .then((response) => {
                    if (!response.ok) throw new Error();
                    return response.json();
                })
                .then(() => {
                    form.querySelector('[data-legal-media-id]').value = '';
                    form.querySelector('[data-legal-picked]').textContent = '';
                    showAlert('Document réinitialisé au texte par défaut.');
                    loadLegalDocuments();
                })
                .catch(() => {
                    showAlert('Réinitialisation impossible.', 'error');
                });
        });
    });

    loadLegalDocuments();
}

// --- Éléments Vision / Mission / Valeurs (titre + description + icône + image) ---
// Les trois listes partagent la même structure d'élément depuis la migration
// convert_company_vision_mission_items_to_objects (voir x-ui.content-list côté public).
const FEATURE_ICONS = [
    ['check', 'Coche'], ['star', 'Étoile'], ['shield', 'Bouclier'], ['rocket', 'Fusée'],
    ['target', 'Cible'], ['heart', 'Cœur'], ['users', 'Équipe'], ['globe', 'Monde'],
    ['trophy', 'Trophée'], ['handshake', 'Poignée de main'], ['chart', 'Graphique'],
    ['flag', 'Drapeau'], ['lightbulb', 'Ampoule'], ['sparkles', 'Étincelles'], ['lock', 'Cadenas'],
];

function createFeatureItemRow(container, item, titlePlaceholder) {
    const row = document.createElement('div');
    row.className = 'border border-(--border-default) rounded-lg p-3 bg-surface-sunken space-y-2';

    const iconOptions = FEATURE_ICONS.map(([key, label]) =>
        `<option value="${key}" ${item?.icon === key ? 'selected' : ''}>${label}</option>`
    ).join('');

    row.innerHTML = `
        <div class="flex items-start gap-2">
            <div class="flex-1 space-y-2">
                <input type="text" value="${escapeHtml(item?.title ?? '')}" placeholder="${escapeHtml(titlePlaceholder)}" data-item-title
                    class="w-full px-3 py-2 border border-(--border-default) bg-surface-raised rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm font-medium">
                <textarea rows="2" placeholder="Description (optionnelle)" data-item-body
                    class="w-full px-3 py-2 border border-(--border-default) bg-surface-raised rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">${escapeHtml(item?.body ?? '')}</textarea>
            </div>
            <button type="button" data-remove-row title="Supprimer" class="shrink-0 mt-1 text-rose-500 hover:text-rose-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="flex flex-wrap items-center gap-4 pt-1">
            <label class="flex items-center gap-2 text-xs text-ink-muted">
                Icône
                <select data-item-icon class="px-2 py-1 border border-(--border-default) bg-surface-raised rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
                    ${iconOptions}
                </select>
            </label>
            <div class="flex items-center gap-2">
                <span class="text-xs text-ink-muted">Image</span>
                <div data-image-preview class="w-8 h-8 rounded-lg border border-(--border-default) bg-surface-raised overflow-hidden ${item?.image ? '' : 'hidden'}">
                    ${item?.image ? `<img src="${escapeHtml(item.image)}" class="w-full h-full object-cover">` : ''}
                </div>
                <button type="button" data-pick-image class="text-xs font-medium text-blue-600 hover:text-blue-700">Choisir</button>
                <button type="button" data-clear-image class="text-xs text-rose-500 hover:text-rose-700 ${item?.image ? '' : 'hidden'}">Retirer</button>
                <input type="hidden" data-item-image value="${escapeHtml(item?.image ?? '')}">
            </div>
        </div>
    `;

    row.querySelector('[data-remove-row]').addEventListener('click', () => row.remove());

    const imageInput = row.querySelector('[data-item-image]');
    const imagePreview = row.querySelector('[data-image-preview]');
    const clearBtn = row.querySelector('[data-clear-image]');

    row.querySelector('[data-pick-image]').addEventListener('click', () => {
        window.openMediaPicker({
            accept: 'image',
            onSelect(items) {
                const picked = items[0];
                if (!picked) return;
                imageInput.value = picked.url;
                imagePreview.innerHTML = `<img src="${picked.url}" class="w-full h-full object-cover">`;
                imagePreview.classList.remove('hidden');
                clearBtn.classList.remove('hidden');
            },
        });
    });
    clearBtn.addEventListener('click', () => {
        imageInput.value = '';
        imagePreview.innerHTML = '';
        imagePreview.classList.add('hidden');
        clearBtn.classList.add('hidden');
    });

    container.appendChild(row);
}

function setFeatureList(containerId, items, titlePlaceholder) {
    const container = document.getElementById(containerId);
    container.innerHTML = '';
    const normalized = Array.isArray(items) && items.length ? items : [{ title: '', body: '', icon: '', image: '' }];
    normalized.forEach((item) => createFeatureItemRow(container, item, titlePlaceholder));
}

function readFeatureList(containerId) {
    return Array.from(document.querySelectorAll(`#${containerId} > div`)).reduce((acc, row) => {
        const title = row.querySelector('[data-item-title]').value.trim();
        const body = row.querySelector('[data-item-body]').value.trim();
        const icon = row.querySelector('[data-item-icon]').value;
        const image = row.querySelector('[data-item-image]').value.trim();
        if (title || body || image) acc.push({ title, body, icon: icon || null, image: image || null });
        return acc;
    }, []);
}

document.getElementById('btnAddVision').addEventListener('click', () => {
    createFeatureItemRow(document.getElementById('visionList'), null, 'Nouvel énoncé de vision');
});
document.getElementById('btnAddMission').addEventListener('click', () => {
    createFeatureItemRow(document.getElementById('missionList'), null, 'Nouvel énoncé de mission');
});
document.getElementById('btnAddValue').addEventListener('click', () => {
    createFeatureItemRow(document.getElementById('valuesList'), null, 'Titre (ex: Excellence opérationnelle)');
});

// --- Mode d'affichage (Mission/Vision/Valeurs) ---
function setDisplayMode(mode) {
    document.getElementById('companyDisplayMode').value = mode;
    document.querySelectorAll('.display-mode-btn').forEach((btn) => {
        const active = btn.dataset.displayMode === mode;
        btn.classList.toggle('bg-azure-600', active);
        btn.classList.toggle('text-white', active);
        btn.classList.toggle('bg-surface-sunken', !active);
        btn.classList.toggle('text-ink-secondary', !active);
    });
}
document.querySelectorAll('.display-mode-btn').forEach((btn) => {
    btn.addEventListener('click', () => setDisplayMode(btn.dataset.displayMode));
});

function loadCompanyData() {
    fetch('/api/admin/company')
        .then(response => response.json())
        .then(data => {
            // Hide loading and show form
            document.getElementById('company-loading').classList.add('hidden');
            document.getElementById('companyForm').classList.remove('hidden');

            // Populate form fields
            document.getElementById('companyName').value = data.name || '';
            document.getElementById('companyEmail').value = data.email || '';
            document.getElementById('companyPhone').value = data.phone || '';
            document.getElementById('companyWhatsapp').value = data.whatsapp || '';
            document.getElementById('companyAddress').value = data.address || '';
            document.getElementById('companyDescription').value = data.description || '';
            setFeatureList('visionList', data.vision, 'Ex: Devenir la référence technologique en Afrique de l\'Ouest.');
            setFeatureList('missionList', data.mission, 'Ex: Rendre la technologie accessible à toutes les entreprises.');
            setFeatureList('valuesList', data.values, 'Titre (ex: Excellence opérationnelle)');
            setDisplayMode(data.display_mode || 'list');
            const stats = data.stats || {};
            document.querySelectorAll('[data-stat-key]').forEach((input) => {
                input.value = stats[input.dataset.statKey] ?? '';
            });
            const socialLinks = data.social_links || {};
            document.querySelectorAll('[data-social-key]').forEach((input) => {
                input.value = socialLinks[input.dataset.socialKey] ?? '';
            });
            document.getElementById('companyActive').checked = data.is_active || false;
        })
        .catch(error => {
            console.error('Error loading company data:', error);
            document.getElementById('company-loading').innerHTML = `
                <svg class="w-12 h-12 text-ink-muted mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-red-500 dark:text-red-400 text-sm">Erreur de chargement</p>
            `;
        });
}

function loadPartnersData() {
    fetch('/api/admin/partners')
        .then(response => response.json())
        .then(data => {
            // Hide loading and show grid
            document.getElementById('partners-loading').classList.add('hidden');
            document.getElementById('partners-grid').classList.remove('hidden');

            const container = document.getElementById('partners-grid');

            if (data && data.length > 0) {
                const partnersHtml = `
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        ${data.map(partner => {
                            const name = escapeHtml(partner.name);
                            const logo = escapeHtml(partner.logo ?? '');
                            const website = escapeHtml(partner.website ?? '');
                            return `
                            <div class="border border-(--border-default) rounded-lg p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="font-medium text-ink-primary">${name}</h3>
                                    <span class="px-2 py-1 text-xs ${partner.category === 'technology' ? 'bg-blue-100 text-blue-800 dark:bg-blue-500/10 dark:text-blue-400' : 'bg-green-100 text-green-800 dark:bg-green-500/10 dark:text-green-400'} rounded-full">
                                        ${partner.category === 'technology' ? 'Tech' : 'Finance'}
                                    </span>
                                </div>
                                ${partner.logo ? `<img src="${logo}" alt="${name}" class="w-full h-24 object-contain mb-3">` : ''}
                                <p class="text-sm text-ink-secondary mb-3">${escapeHtml(partner.description)}</p>
                                ${partner.website ? `<a href="${website}" target="_blank" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm">Voir le site</a>` : ''}
                                <div class="mt-3 flex justify-end space-x-2">
                                    <button type="button" data-action="edit-partner" data-id="${partner.id}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm">Modifier</button>
                                    <button type="button" data-action="delete-partner" data-id="${partner.id}" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 text-sm">Supprimer</button>
                                </div>
                            </div>`;
                        }).join('')}
                    </div>
                `;
                container.innerHTML = partnersHtml;
            } else {
                container.innerHTML = `
                    <div class="text-center py-8">
                        <p class="text-ink-muted">Aucun partenaire trouvé</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error loading partners data:', error);
            document.getElementById('partners-loading').innerHTML = `
                <svg class="w-12 h-12 text-ink-muted mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-red-500 dark:text-red-400 text-sm">Erreur de chargement</p>
            `;
        });
}

function openPartnerModal(partnerId = null) {
    currentPartnerId = partnerId;
    const modal = document.getElementById('partnerModal');

    if (partnerId) {
        document.getElementById('partnerModalTitle').textContent = 'Modifier le Partenaire';
        // Load partner data
        fetch(`/api/admin/partners/${partnerId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('partnerName').value = data.name;
                document.getElementById('partnerDescription').value = data.description;
                document.getElementById('partnerWebsite').value = data.website || '';
                document.getElementById('partnerLogo').value = data.logo || '';
                partnerLogoField.renderPreview();
                document.getElementById('partnerCategory').value = data.category;
                document.getElementById('partnerOrder').value = data.order;
                document.getElementById('partnerActive').checked = data.is_active;
            });
    } else {
        document.getElementById('partnerModalTitle').textContent = 'Ajouter un Partenaire';
        document.getElementById('partnerForm').reset();
        partnerLogoField.renderPreview();
    }

    window.openAdminModal(modal);
}

function closePartnerModal() {
    window.closeAdminModal(document.getElementById('partnerModal'));
    document.getElementById('partnerForm').reset();
    partnerLogoField.renderPreview();
    currentPartnerId = null;
}

function editPartner(id) {
    openPartnerModal(id);
}

async function deletePartner(id) {
    const confirmed = await window.confirmDialog('Êtes-vous sûr de vouloir supprimer ce partenaire ? Cette action est irréversible.', {
        title: 'Supprimer le partenaire',
        confirmLabel: 'Supprimer',
    });
    if (!confirmed) return;

    fetch(`/api/admin/partners/${id}`, { method: 'DELETE' })
        .then(() => loadPartnersData());
}

// Company form submission
document.getElementById('companyForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const stats = {};
    document.querySelectorAll('[data-stat-key]').forEach((input) => {
        if (input.value.trim()) stats[input.dataset.statKey] = input.value.trim();
    });
    const social_links = {};
    document.querySelectorAll('[data-social-key]').forEach((input) => {
        if (input.value.trim()) social_links[input.dataset.socialKey] = input.value.trim();
    });

    const data = {
        name: document.getElementById('companyName').value,
        email: document.getElementById('companyEmail').value,
        phone: document.getElementById('companyPhone').value,
        whatsapp: document.getElementById('companyWhatsapp').value,
        address: document.getElementById('companyAddress').value,
        description: document.getElementById('companyDescription').value,
        vision: readFeatureList('visionList'),
        mission: readFeatureList('missionList'),
        values: readFeatureList('valuesList'),
        display_mode: document.getElementById('companyDisplayMode').value,
        stats,
        social_links,
        is_active: document.getElementById('companyActive').checked
    };

    fetch('/api/admin/company', {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    }).then(response => {
        if (response.ok) {
            showAlert('Informations mises à jour avec succès', 'success');
        } else {
            showAlert('Erreur lors de la mise à jour', 'error');
        }
    }).catch(error => {
        console.error('Error updating company:', error);
        showAlert('Erreur lors de la mise à jour', 'error');
    });
});

// Partner form submission
document.getElementById('partnerForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const data = {
        name: document.getElementById('partnerName').value,
        description: document.getElementById('partnerDescription').value,
        website: document.getElementById('partnerWebsite').value,
        logo: document.getElementById('partnerLogo').value,
        category: document.getElementById('partnerCategory').value,
        order: document.getElementById('partnerOrder').value,
        is_active: document.getElementById('partnerActive').checked
    };

    if (currentPartnerId) {
        fetch(`/api/admin/partners/${currentPartnerId}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        }).then(() => {
            closePartnerModal();
            loadPartnersData();
            showAlert('Partenaire modifié avec succès', 'success');
        });
    } else {
        fetch('/api/admin/partners', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        }).then(() => {
            closePartnerModal();
            loadPartnersData();
            showAlert('Partenaire ajouté avec succès', 'success');
        });
    }
});

// ---------- Content CRUD (admin/content) ----------
let contentsData = [];
let currentContentId = null;

const contentSearchInput = document.getElementById('contentSearch');
const contentTypeSelect = document.getElementById('contentType');
const contentStatusSelect = document.getElementById('contentStatus');

const contentTableBody = document.getElementById('contentTableBody');
const contentEmptyState = document.getElementById('contentEmptyState');

const contentModal = document.getElementById('contentModal');
const contentModalTitle = document.getElementById('contentModalTitle');
const contentForm = document.getElementById('contentForm');

const contentIdInput = document.getElementById('contentId');
const contentTitleInput = document.getElementById('contentTitle');
const contentTypeInput = document.getElementById('contentTypeInput');
const contentStatusInput = document.getElementById('contentStatusInput');
const contentPublishedAtInput = document.getElementById('contentPublishedAt');
const contentExcerptInput = document.getElementById('contentExcerpt');
const contentContentInput = document.getElementById('contentContent');
const contentMetaTitleInput = document.getElementById('contentMetaTitle');
const contentMetaDescriptionInput = document.getElementById('contentMetaDescription');
const contentFeaturedImageInput = document.getElementById('contentFeaturedImage');
const contentIsFeaturedInput = document.getElementById('contentIsFeatured');
const contentOrderInput = document.getElementById('contentOrder');

function formatDate(value) {
    if (!value) return '—';
    const date = new Date(value);
    if (Number.isNaN(date.getTime())) return '—';
    return new Intl.DateTimeFormat('fr-FR').format(date);
}

function renderContentRows() {
    if (!contentsData.length) {
        contentTableBody.innerHTML = '';
        contentEmptyState.classList.remove('hidden');
        return;
    }

    contentEmptyState.classList.add('hidden');

    const rows = contentsData
        .sort((a, b) => (a.order ?? 0) - (b.order ?? 0))
        .map((item) => {
            const statusLabel = item.status === 'published' ? 'Publié' : (item.status === 'archived' ? 'Archivé' : 'Brouillon');
            return `
                <tr class="border-b border-(--border-default) hover:bg-surface-sunken">
                    <td class="px-5 py-4 font-semibold text-ink-primary">${escapeHtml(item.title ?? '—')}</td>
                    <td class="px-5 py-4 text-ink-secondary">${escapeHtml(item.type ?? '—')}</td>
                    <td class="px-5 py-4">
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-[11px] font-semibold ${item.status === 'published' ? 'bg-green-100 text-green-800 dark:bg-green-500/10 dark:text-green-400' : (item.status === 'archived' ? 'bg-amber-100 text-amber-800 dark:bg-amber-500/10 dark:text-amber-400' : 'bg-surface-sunken text-ink-secondary')}">
                            ${statusLabel}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-ink-secondary">${item.published_at ? formatDate(item.published_at) : '—'}</td>
                    <td class="px-5 py-4">
                        ${item.is_featured ? '<span class="inline-flex items-center rounded-full bg-azure-100 text-azure-700 dark:bg-azure-500/10 dark:text-azure-400 px-3 py-1 text-[11px] font-semibold">Vedette</span>' : '—'}
                    </td>
                    <td class="px-5 py-4 text-ink-secondary">${item.order ?? 0}</td>
                    <td class="px-5 py-4 text-sm font-semibold text-ink-secondary">
                        <button type="button" data-action="edit-content" data-id="${item.id}" class="mr-3 text-azure-600 hover:text-azure-900 dark:text-azure-400 dark:hover:text-azure-300">Modifier</button>
                        <button type="button" data-action="delete-content" data-id="${item.id}" class="text-rose-600 hover:text-rose-900 dark:text-rose-400 dark:hover:text-rose-300">Supprimer</button>
                    </td>
                </tr>
            `;
        })
        .join('');

    contentTableBody.innerHTML = rows;
}

function loadContentsData() {
    const params = new URLSearchParams();
    if (contentTypeSelect?.value) params.set('type', contentTypeSelect.value);
    if (contentStatusSelect?.value) params.set('status', contentStatusSelect.value);
    if (contentSearchInput?.value?.trim()) params.set('search', contentSearchInput.value.trim());

    const url = `/api/admin/content${params.toString() ? `?${params.toString()}` : ''}`;

    fetch(url)
        .then((response) => response.json())
        .then((data) => {
            contentsData = Array.isArray(data?.data) ? data.data : [];
            renderContentRows();
        })
        .catch(() => {
            contentsData = [];
            contentTableBody.innerHTML = '';
            contentEmptyState.classList.remove('hidden');
            contentEmptyState.innerHTML = '<p class="font-semibold text-ink-primary text-lg">Erreur de chargement</p>';
        });
}

function resetContentForm() {
    contentForm.reset();
    currentContentId = null;
    contentIdInput.value = '';

    contentTypeInput.value = 'page';
    contentStatusInput.value = 'draft';
    contentPublishedAtInput.value = '';
    contentExcerptInput.value = '';
    window.setRichEditorValue('contentContent', '');
    contentMetaTitleInput.value = '';
    contentMetaDescriptionInput.value = '';
    contentFeaturedImageInput.value = '';
    contentFeaturedImageField.renderPreview();
    contentIsFeaturedInput.checked = false;
    contentOrderInput.value = 0;
}

function openContentModal(contentId = null) {
    currentContentId = contentId;
    window.openAdminModal(contentModal);
    contentModalTitle.textContent = contentId ? 'Modifier un contenu' : 'Ajouter un contenu';

    if (!contentId) {
        resetContentForm();
        return;
    }

    fetch(`/api/admin/content/${contentId}`)
        .then((response) => response.json())
        .then((item) => {
            contentIdInput.value = item.id;
            contentTitleInput.value = item.title ?? '';
            contentTypeInput.value = item.type ?? 'page';
            contentStatusInput.value = item.status ?? 'draft';
            contentPublishedAtInput.value = item.published_at ? String(item.published_at).split('T')[0] : '';
            contentExcerptInput.value = item.excerpt ?? '';
            window.setRichEditorValue('contentContent', item.content ?? '');
            contentMetaTitleInput.value = item.meta_title ?? '';
            contentMetaDescriptionInput.value = item.meta_description ?? '';
            contentFeaturedImageInput.value = item.featured_image ?? '';
            contentFeaturedImageField.renderPreview();
            contentIsFeaturedInput.checked = Boolean(item.is_featured);
            contentOrderInput.value = item.order ?? 0;
        })
        .catch(() => {
            showAlert('Impossible de charger ce contenu.', 'error');
            closeContentModal();
        });
}

function closeContentModal() {
    window.closeAdminModal(contentModal);
    resetContentForm();
}

// Close modals on background click + ESC
const partnerModalEl = document.getElementById('partnerModal');
const contentModalEl = document.getElementById('contentModal');

partnerModalEl?.addEventListener('click', (e) => {
    if (e.target === partnerModalEl) closePartnerModal();
});

contentModalEl?.addEventListener('click', (e) => {
    if (e.target === contentModalEl) closeContentModal();
});

document.addEventListener('keydown', (e) => {
    if (e.key !== 'Escape') return;

    if (contentModalEl && !contentModalEl.classList.contains('hidden')) {
        closeContentModal();
        return;
    }

    if (partnerModalEl && !partnerModalEl.classList.contains('hidden')) {
        closePartnerModal();
    }
});

async function deleteContent(contentId) {
    const confirmed = await window.confirmDialog('Êtes-vous sûr de vouloir supprimer ce contenu ? Cette action est irréversible.', {
        title: 'Supprimer le contenu',
        confirmLabel: 'Supprimer',
    });
    if (!confirmed) return;

    fetch(`/api/admin/content/${contentId}`, { method: 'DELETE' })
        .then(async (response) => {
            const payload = await response.json().catch(() => null);
            if (!response.ok) {
                throw new Error(payload?.message || 'Suppression impossible.');
            }
            return payload;
        })
        .then(() => {
            showAlert('Contenu supprimé avec succès.', 'success');
            loadContentsData();
            closeContentModal();
        })
        .catch((err) => {
            showAlert(err?.message || 'Erreur lors de la suppression.', 'error');
        });
}

function handleContentSubmit(event) {
    event.preventDefault();

    const payload = {
        title: contentTitleInput.value.trim(),
        content: contentContentInput.value.trim(),
        excerpt: contentExcerptInput.value.trim() || null,
        type: contentTypeInput.value,
        status: contentStatusInput.value,
        published_at: contentPublishedAtInput.value ? contentPublishedAtInput.value : null,
        meta_title: contentMetaTitleInput.value.trim() || null,
        meta_description: contentMetaDescriptionInput.value.trim() || null,
        featured_image: contentFeaturedImageInput.value.trim() || null,
        is_featured: Boolean(contentIsFeaturedInput.checked),
        order: contentOrderInput.value !== '' ? parseInt(contentOrderInput.value, 10) : null,
    };

    if (!payload.title || !payload.content) {
        showAlert('Titre et contenu sont requis.', 'error');
        return;
    }

    const url = currentContentId ? `/api/admin/content/${currentContentId}` : '/api/admin/content';
    const method = currentContentId ? 'PUT' : 'POST';

    fetch(url, {
        method,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload),
    })
        .then(async (response) => {
            const data = await response.json().catch(() => null);
            if (!response.ok) {
                const message = data?.message || (data?.errors ? Object.values(data.errors).flat().join(' ') : 'Erreur lors de la sauvegarde.');
                throw new Error(message);
            }
            return data;
        })
        .then(() => {
            showAlert(`Contenu ${currentContentId ? 'mis à jour' : 'créé'} avec succès.`, 'success');
            closeContentModal();
            loadContentsData();
        })
        .catch((err) => {
            showAlert(err?.message || 'Erreur lors de la sauvegarde.', 'error');
        });
}

let contentDebounceTimer = null;

if (contentSearchInput) {
    contentSearchInput.addEventListener('input', () => {
        clearTimeout(contentDebounceTimer);
        contentDebounceTimer = setTimeout(() => loadContentsData(), 400);
    });
}
contentTypeSelect?.addEventListener('change', loadContentsData);
contentStatusSelect?.addEventListener('change', loadContentsData);

contentForm?.addEventListener('submit', handleContentSubmit);

document.getElementById('btnAddPartner')?.addEventListener('click', () => openPartnerModal());
document.getElementById('btnAddContent')?.addEventListener('click', () => openContentModal());

document.querySelectorAll('.js-close-partner-modal').forEach((btn) => {
    btn.addEventListener('click', () => closePartnerModal());
});
document.querySelectorAll('.js-close-content-modal').forEach((btn) => {
    btn.addEventListener('click', () => closeContentModal());
});

document.getElementById('partners-grid')?.addEventListener('click', (e) => {
    const btn = e.target.closest('button[data-action]');
    if (!btn) return;
    const id = Number(btn.dataset.id);
    if (btn.dataset.action === 'edit-partner') editPartner(id);
    else if (btn.dataset.action === 'delete-partner') deletePartner(id);
});

contentTableBody.addEventListener('click', (e) => {
    const btn = e.target.closest('button[data-action]');
    if (!btn) return;
    const id = Number(btn.dataset.id);
    if (btn.dataset.action === 'edit-content') openContentModal(id);
    else if (btn.dataset.action === 'delete-content') deleteContent(id);
});
</script>
@endpush
@endsection
