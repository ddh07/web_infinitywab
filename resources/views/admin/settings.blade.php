@extends('layouts.admin')

@section('title', 'Paramètres - Admin Infinity WAB')
@section('page-title', 'Paramètres')

@section('content')
<div class="space-y-6 max-w-4xl">

    @php
        $settingsTabs = [
            ['key' => 'integrations', 'label' => 'Intégrations'],
            ['key' => 'email', 'label' => 'Email'],
            ['key' => 'seo', 'label' => 'SEO'],
            ['key' => 'a11y', 'label' => 'Accessibilité'],
            ['key' => 'customization', 'label' => 'Personnalisation'],
        ];
    @endphp

    <div class="flex flex-wrap gap-1 rounded-lg border border-(--border-default) bg-surface-raised p-1 shadow-sm" role="tablist">
        @foreach($settingsTabs as $index => $tab)
            <button type="button" data-settings-tab="{{ $tab['key'] }}" role="tab" aria-selected="{{ $index === 0 ? 'true' : 'false' }}"
                class="settings-tab-btn flex-1 min-w-32 px-4 py-2 rounded-lg text-sm font-medium transition {{ $index === 0 ? 'bg-azure-100 text-azure-800 dark:bg-azure-500/10 dark:text-azure-400' : 'text-ink-secondary hover:bg-surface-sunken' }}">
                {{ $tab['label'] }}
            </button>
        @endforeach
    </div>

    <form id="settingsForm" class="space-y-6">
        <section data-settings-panel="integrations" class="bg-surface-raised rounded-lg border border-(--border-default) p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-ink-primary mb-1">Intégrations</h2>
            <p class="text-xs text-ink-muted mb-5">Google Tag Manager et Google Analytics (GA4)</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-ink-secondary mb-1">Google Tag Manager — Container ID</label>
                    <input type="text" id="gtm_container_id" placeholder="GTM-XXXXXXX"
                        class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500">
                    <p class="text-xs text-ink-muted mt-1">GTM &gt; Admin &gt; Installer Google Tag Manager.</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink-secondary mb-1">GA4 — ID de propriété</label>
                    <input type="text" id="ga4_property_id" placeholder="123456789"
                        class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500">
                    <p class="text-xs text-ink-muted mt-1">Numérique — GA4 &gt; Admin &gt; Détails de la propriété (pas le G-XXXXXXX).</p>
                </div>
            </div>

            <div class="mt-6">
                <label class="block text-sm font-medium text-ink-secondary mb-1">GA4 — Clé du compte de service (JSON)</label>
                <div class="flex items-center gap-3 mb-2">
                    <input type="file" id="ga4_credentials_file" accept=".json" class="text-sm text-ink-secondary file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-azure-600 file:text-white file:text-sm file:font-medium hover:file:bg-azure-700">
                    <span id="ga4_credentials_status" class="text-xs text-ink-muted"></span>
                </div>
                <textarea id="ga4_credentials_json" rows="4" placeholder='{"type": "service_account", ...}'
                    class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500 font-mono text-xs"></textarea>
                <p class="text-xs text-ink-muted mt-1">
                    Compte de service Google Cloud avec le rôle "Lecteur" sur la propriété GA4, et l'API "Google Analytics Data API" activée.
                </p>
            </div>

            <div class="mt-6 pt-6 border-t border-(--border-default)">
                <h3 class="text-sm font-semibold text-ink-primary mb-1">Cloudflare Turnstile</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-ink-secondary mb-1">Clé de site (publique)</label>
                        <input type="text" id="turnstile_site_key" placeholder="0x4AAAAAAA..."
                            class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-ink-secondary mb-1">Clé secrète</label>
                        <input type="password" id="turnstile_secret_key" autocomplete="new-password"
                            class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500">
                        <p class="text-xs text-ink-muted mt-1" id="turnstile_secret_key_status"></p>
                    </div>
                </div>
                <p class="text-xs text-ink-muted mt-2">Clés à générer sur <a href="https://dash.cloudflare.com/?to=/:account/turnstile" target="_blank" rel="noopener" class="underline">dash.cloudflare.com &gt; Turnstile</a>.</p>
            </div>
        </section>

        <section data-settings-panel="email" class="hidden bg-surface-raised rounded-lg border border-(--border-default) p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-ink-primary mb-1">Email (SMTP)</h2>
            <p class="text-xs text-ink-muted mb-5">Serveur utilisé pour l'envoi des notifications (messages de contact, vérification de compte...)</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-ink-secondary mb-1">Hôte SMTP</label>
                    <input type="text" id="mail_host" placeholder="smtp.hostinger.com"
                        class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink-secondary mb-1">Port</label>
                    <input type="number" id="mail_port" placeholder="587"
                        class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink-secondary mb-1">Utilisateur</label>
                    <input type="text" id="mail_username" autocomplete="off"
                        class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink-secondary mb-1">Mot de passe</label>
                    <input type="password" id="mail_password" autocomplete="new-password"
                        class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500">
                    <p class="text-xs text-ink-muted mt-1" id="mail_password_status"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink-secondary mb-1">Chiffrement</label>
                    <select id="mail_encryption" class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500">
                        <option value="tls">TLS</option>
                        <option value="ssl">SSL</option>
                        <option value="none">Aucun</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink-secondary mb-1">Adresse d'expédition</label>
                    <input type="email" id="mail_from_address" placeholder="noreply@infinity-wab.com"
                        class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink-secondary mb-1">Nom d'expédition</label>
                    <input type="text" id="mail_from_name" placeholder="Infinity WAB"
                        class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500">
                </div>
            </div>
        </section>

        <section data-settings-panel="seo" class="hidden bg-surface-raised rounded-lg border border-(--border-default) p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-ink-primary mb-1">SEO</h2>
            <p class="text-xs text-ink-muted mb-5">Référencement — valeurs par défaut utilisées quand une page n'en définit pas les siennes</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-ink-secondary mb-1">Titre par défaut</label>
                    <input type="text" id="seo_default_title" placeholder="Infinity WAB - Technologie pour le Burkina Faso"
                        class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink-secondary mb-1">Description par défaut</label>
                    <input type="text" id="seo_default_description" placeholder="Infinity WAB - Solutions technologiques innovantes..."
                        class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink-secondary mb-1">Vérification Google Search Console</label>
                    <input type="text" id="seo_search_console_verification" placeholder="Contenu de la balise meta"
                        class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500">
                    <p class="text-xs text-ink-muted mt-1">Search Console &gt; Paramètres &gt; Propriété &gt; Balise HTML — copiez juste la valeur du content=.</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink-secondary mb-1">Vérification Bing Webmaster</label>
                    <input type="text" id="seo_bing_verification" placeholder="Contenu de la balise meta"
                        class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500">
                </div>
            </div>

            <div class="mt-6">
                <label class="block text-sm font-medium text-ink-secondary mb-1">Image de partage par défaut (Open Graph)</label>
                <div class="flex items-center gap-4">
                    <div class="w-24 h-14 rounded-lg border border-(--border-default) bg-surface-sunken overflow-hidden shrink-0">
                        <img id="seo_og_image_preview" src="" alt="" class="hidden w-full h-full object-cover">
                    </div>
                    <button type="button" id="seo_og_image_pick" class="text-sm font-medium text-azure-600 hover:text-azure-700">Choisir dans la bibliothèque</button>
                    <button type="button" id="seo_og_image_remove" class="hidden text-sm text-rose-600 dark:text-rose-400 hover:underline">Retirer</button>
                </div>
                <p class="text-xs text-ink-muted mt-1">Idéalement 1200×630px. Choisie immédiatement, sans passer par "Enregistrer".</p>
            </div>

            <label class="flex items-center gap-2 mt-6 text-sm text-ink-secondary">
                <input type="checkbox" id="seo_noindex" class="h-4 w-4 rounded border-(--border-default) text-azure-600 focus:ring-azure-500">
                Empêcher l'indexation du site par les moteurs de recherche (noindex)
            </label>
        </section>

        <section data-settings-panel="a11y" class="hidden bg-surface-raised rounded-lg border border-(--border-default) p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-ink-primary mb-1">Accessibilité</h2>

            <label class="flex items-center gap-2 text-sm text-ink-secondary">
                <input type="checkbox" id="a11y_force_reduced_motion" class="h-4 w-4 rounded border-(--border-default) text-azure-600 focus:ring-azure-500">
                Désactiver toutes les animations pour tous les visiteurs
            </label>

            <div class="mt-6">
                <label class="block text-sm font-medium text-ink-secondary mb-1">Déclaration d'accessibilité</label>
                <textarea id="a11y_statement_content" rows="4" placeholder="Laissez vide pour utiliser le texte par défaut"
                    class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500"></textarea>
                <p class="text-xs text-ink-muted mt-1">Affichée sur la page <a href="{{ route('accessibility') }}" target="_blank" class="underline">/accessibilite</a>, liée depuis le pied de page.</p>
            </div>
        </section>

        <section data-settings-panel="customization" class="hidden bg-surface-raised rounded-lg border border-(--border-default) p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-ink-primary mb-1">Personnalisation</h2>
            <p class="text-xs text-ink-muted mb-5">Identité visuelle, bannière d'annonce, thème par défaut</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-ink-secondary mb-1">Logo</label>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-lg border border-(--border-default) bg-surface-sunken p-1 overflow-hidden shrink-0">
                            <img id="site_logo_preview" src="" alt="" class="hidden w-full h-full object-contain">
                        </div>
                        <button type="button" id="site_logo_pick" class="text-sm font-medium text-azure-600 hover:text-azure-700">Choisir dans la bibliothèque</button>
                        <button type="button" id="site_logo_remove" class="hidden text-sm text-rose-600 dark:text-rose-400 hover:underline">Retirer</button>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink-secondary mb-1">Favicon</label>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded border border-(--border-default) bg-surface-sunken p-1 overflow-hidden shrink-0">
                            <img id="site_favicon_preview" src="" alt="" class="hidden w-full h-full object-contain">
                        </div>
                        <button type="button" id="site_favicon_pick" class="text-sm font-medium text-azure-600 hover:text-azure-700">Choisir dans la bibliothèque</button>
                        <button type="button" id="site_favicon_remove" class="hidden text-sm text-rose-600 dark:text-rose-400 hover:underline">Retirer</button>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink-secondary mb-1">Thème par défaut du site</label>
                    <select id="default_theme" class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500">
                        <option value="system">Suivre le système du visiteur</option>
                        <option value="light">Toujours clair</option>
                        <option value="dark">Toujours sombre</option>
                    </select>
                    <p class="text-xs text-ink-muted mt-1">Ignoré si le visiteur a déjà choisi un thème manuellement.</p>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-(--border-default)">
                <label class="flex items-center gap-2 text-sm text-ink-secondary">
                    <input type="checkbox" id="banner_enabled" class="h-4 w-4 rounded border-(--border-default) text-azure-600 focus:ring-azure-500">
                    Afficher une bannière d'annonce en haut du site
                </label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-ink-secondary mb-1">Texte</label>
                        <input type="text" id="banner_text" placeholder="Nous recrutons ! Rejoignez l'équipe Infinity WAB."
                            class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-ink-secondary mb-1">Libellé du lien</label>
                        <input type="text" id="banner_link_label" placeholder="En savoir plus"
                            class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500">
                    </div>
                    <div class="md:col-span-3">
                        <label class="block text-xs font-medium text-ink-secondary mb-1">URL du lien (optionnelle)</label>
                        <input type="text" id="banner_link_url" placeholder="https://... ou /contact"
                            class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500">
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-(--border-default)">
                <label class="flex items-center gap-2 text-sm font-semibold text-rose-600 dark:text-rose-400">
                    <input type="checkbox" id="maintenance_enabled" class="h-4 w-4 rounded border-(--border-default) text-rose-600 focus:ring-rose-500">
                    Activer le mode maintenance (rend le site inaccessible aux visiteurs)
                </label>
                <p class="text-xs text-ink-muted mt-1 ml-6">
                    L'espace admin reste accessible pour vous permettre de le désactiver — les visiteurs et Google verront une page de maintenance (HTTP 503).
                </p>
                <div class="mt-3">
                    <label class="block text-xs font-medium text-ink-secondary mb-1">Message affiché aux visiteurs</label>
                    <input type="text" id="maintenance_message" placeholder="Nous améliorons actuellement le site. Merci de revenir un peu plus tard."
                        class="w-full px-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg focus:outline-none focus:ring-2 focus:ring-azure-500">
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-(--border-default)">
                <h3 class="text-sm font-semibold text-ink-primary mb-1">Images de fond des sections héro</h3>
                <p class="text-xs text-ink-muted mb-4">Remplace le fond par défaut de chaque page par une image personnalisée. Laissez vide pour garder le rendu par défaut.</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="heroImageFields">
                    @foreach([
                        'home' => 'Accueil',
                        'services' => 'Services',
                        'projects' => 'Réalisations',
                        'products' => 'Produits',
                        'news' => 'Actualités',
                        'about' => 'À propos',
                        'contact' => 'Contact',
                        'contact-thanks' => 'Contact — Merci',
                    ] as $heroPage => $heroLabel)
                        @php($heroFieldKey = 'hero_image_' . str_replace('-', '_', $heroPage))
                        <div class="rounded-lg border border-(--border-default) p-3">
                            <label class="block text-xs font-medium text-ink-secondary mb-2">{{ $heroLabel }}</label>
                            <div class="h-20 rounded-lg bg-surface-sunken overflow-hidden mb-2 flex items-center justify-center">
                                <img id="{{ $heroFieldKey }}_preview" src="" alt="" class="hidden w-full h-full object-cover">
                                <span id="{{ $heroFieldKey }}_placeholder" class="text-xs text-ink-muted">Aucune image</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <button type="button" id="{{ $heroFieldKey }}_pick" data-hero-page="{{ $heroPage }}"
                                    class="text-xs font-medium text-azure-600 hover:text-azure-700 flex-1 text-left">Choisir</button>
                                <button type="button" id="{{ $heroFieldKey }}_remove" data-hero-page="{{ $heroPage }}"
                                    class="hidden text-xs font-medium text-rose-600 dark:text-rose-400 hover:underline shrink-0">Retirer</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <div class="flex justify-end">
            <button type="submit" id="btnSaveSettings" class="bg-azure-600 text-white px-6 py-2.5 rounded-lg hover:bg-azure-700 text-sm font-medium">
                Enregistrer les paramètres
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script nonce="{{ $cspNonce }}">
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-settings-tab]').forEach((btn) => {
        btn.addEventListener('click', function () {
            const target = btn.dataset.settingsTab;

            document.querySelectorAll('[data-settings-tab]').forEach((other) => {
                const active = other === btn;
                other.classList.toggle('bg-azure-100', active);
                other.classList.toggle('text-azure-800', active);
                other.classList.toggle('dark:bg-azure-500/10', active);
                other.classList.toggle('dark:text-azure-400', active);
                other.classList.toggle('text-ink-secondary', !active);
                other.setAttribute('aria-selected', active ? 'true' : 'false');
            });

            document.querySelectorAll('[data-settings-panel]').forEach((panel) => {
                panel.classList.toggle('hidden', panel.dataset.settingsPanel !== target);
            });
        });
    });

    const form = document.getElementById('settingsForm');
    const textFields = [
        'gtm_container_id', 'ga4_property_id', 'turnstile_site_key',
        'mail_host', 'mail_port', 'mail_username', 'mail_encryption',
        'mail_from_address', 'mail_from_name',
        'seo_default_title', 'seo_default_description',
        'seo_search_console_verification', 'seo_bing_verification',
        'a11y_statement_content',
        'banner_text', 'banner_link_url', 'banner_link_label',
        'default_theme', 'maintenance_message',
    ];
    const checkboxFields = [
        'seo_noindex', 'a11y_force_reduced_motion', 'banner_enabled', 'maintenance_enabled',
    ];
    const imageFields = [
        { key: 'site_logo_path', preview: 'site_logo_preview', pickBtn: 'site_logo_pick', removeBtn: 'site_logo_remove', endpoint: '/api/admin/settings/logo', removeConfirm: 'Retirer le logo ? Le logo par défaut sera utilisé à la place.' },
        { key: 'site_favicon_path', preview: 'site_favicon_preview', pickBtn: 'site_favicon_pick', removeBtn: 'site_favicon_remove', endpoint: '/api/admin/settings/favicon', removeConfirm: 'Retirer le favicon ? Le favicon par défaut sera utilisé à la place.' },
        { key: 'seo_og_image_path', preview: 'seo_og_image_preview', pickBtn: 'seo_og_image_pick', removeBtn: 'seo_og_image_remove', endpoint: '/api/admin/settings/og-image', removeConfirm: 'Retirer l\'image de partage ? L\'image par défaut sera utilisée à la place.' },
    ];
    const heroPages = ['home', 'services', 'projects', 'products', 'news', 'about', 'contact', 'contact-thanks'];
    const heroImageFields = heroPages.map((page) => {
        const heroKey = 'hero_image_' + page.replace(/-/g, '_');
        return {
            key: heroKey,
            preview: heroKey + '_preview',
            placeholder: heroKey + '_placeholder',
            pickBtn: heroKey + '_pick',
            removeBtn: heroKey + '_remove',
            endpoint: '/api/admin/settings/hero-image/' + page,
            removeConfirm: 'Retirer cette image ? La page reviendra à son fond par défaut.',
        };
    });

    function loadSettings() {
        return fetch('/api/admin/settings')
            .then((response) => response.json())
            .then((data) => {
                textFields.forEach((key) => {
                    const field = document.getElementById(key);
                    if (field && data[key] !== undefined && data[key] !== null && data[key] !== '') {
                        field.value = data[key];
                    }
                });

                checkboxFields.forEach((key) => {
                    const field = document.getElementById(key);
                    if (field) field.checked = data[key] === '1' || data[key] === true;
                });

                imageFields.forEach(({ key, preview, removeBtn }) => {
                    const img = document.getElementById(preview);
                    const hasImage = Boolean(data[key]);
                    if (img) {
                        img.src = hasImage ? data[key] : '';
                        img.classList.toggle('hidden', !hasImage);
                    }
                    document.getElementById(removeBtn).classList.toggle('hidden', !hasImage);
                });

                heroImageFields.forEach(({ key, preview, placeholder, removeBtn }) => {
                    const img = document.getElementById(preview);
                    const placeholderEl = document.getElementById(placeholder);
                    const btn = document.getElementById(removeBtn);
                    const hasImage = Boolean(data[key]);
                    if (img) {
                        img.src = hasImage ? data[key] : '';
                        img.classList.toggle('hidden', !hasImage);
                    }
                    if (placeholderEl) placeholderEl.classList.toggle('hidden', hasImage);
                    if (btn) btn.classList.toggle('hidden', !hasImage);
                });

                document.getElementById('mail_password_status').textContent = data.mail_password_set
                    ? 'Un mot de passe est déjà enregistré — laissez vide pour le conserver.'
                    : 'Aucun mot de passe enregistré.';

                document.getElementById('ga4_credentials_status').textContent = data.ga4_credentials_json_set
                    ? 'Une clé est déjà enregistrée — importez un fichier uniquement pour la remplacer.'
                    : 'Aucune clé enregistrée.';

                document.getElementById('turnstile_secret_key_status').textContent = data.turnstile_secret_key_set
                    ? 'Une clé secrète est déjà enregistrée — laissez vide pour la conserver.'
                    : 'Aucune clé secrète enregistrée.';
            })
            .catch(() => showAlert('Impossible de charger les paramètres.', 'error'));
    }

    loadSettings();

    document.getElementById('ga4_credentials_file').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = () => {
            document.getElementById('ga4_credentials_json').value = reader.result;
        };
        reader.onerror = () => showAlert('Impossible de lire ce fichier.', 'error');
        reader.readAsText(file);
    });

    // Logo, favicon, image OG et fonds héro sont choisis dans la bibliothèque de
    // médias partagée (window.openMediaPicker) plutôt qu'importés directement ici :
    // la sélection est envoyée immédiatement au réglage concerné, sans passer par
    // "Enregistrer" — comportement déjà en place avant cette bibliothèque commune.
    function bindImageSetting({ preview, placeholder, pickBtn, removeBtn, endpoint, removeConfirm }) {
        document.getElementById(pickBtn).addEventListener('click', function () {
            window.openMediaPicker({
                accept: 'image',
                onSelect(items) {
                    const picked = items[0];
                    if (!picked) return;

                    fetch(endpoint, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ url: picked.url }),
                    })
                        .then(async (response) => {
                            const data = await response.json();
                            if (!response.ok) throw new Error(data.message || 'Erreur lors de la sélection.');
                            const img = document.getElementById(preview);
                            img.src = data.url;
                            img.classList.remove('hidden');
                            if (placeholder) document.getElementById(placeholder).classList.add('hidden');
                            document.getElementById(removeBtn).classList.remove('hidden');
                            showAlert(data.message || 'Image mise à jour avec succès', 'success');
                        })
                        .catch((error) => showAlert(error.message, 'error'));
                },
            });
        });

        document.getElementById(removeBtn).addEventListener('click', async function () {
            const confirmed = await window.confirmDialog(
                removeConfirm,
                { title: 'Retirer l\'image', confirmLabel: 'Retirer' }
            );
            if (!confirmed) return;

            fetch(endpoint, { method: 'DELETE' })
                .then(async (response) => {
                    const data = await response.json();
                    if (!response.ok) throw new Error(data.message || 'Erreur lors de la suppression.');
                    const img = document.getElementById(preview);
                    img.src = '';
                    img.classList.add('hidden');
                    if (placeholder) document.getElementById(placeholder).classList.remove('hidden');
                    document.getElementById(removeBtn).classList.add('hidden');
                    showAlert(data.message || 'Image retirée avec succès', 'success');
                })
                .catch((error) => showAlert(error.message, 'error'));
        });
    }

    imageFields.forEach(bindImageSetting);
    heroImageFields.forEach(bindImageSetting);

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const maintenanceCheckbox = document.getElementById('maintenance_enabled');
        if (maintenanceCheckbox.checked) {
            const confirmed = await window.confirmDialog(
                "Le site deviendra inaccessible à tous les visiteurs (page de maintenance). Vous pourrez toujours vous connecter à l'admin pour le réactiver. Continuer ?",
                { title: 'Activer le mode maintenance', confirmLabel: 'Activer' }
            );
            if (!confirmed) return;
        }

        const payload = {};
        textFields.forEach((key) => {
            payload[key] = document.getElementById(key).value;
        });
        checkboxFields.forEach((key) => {
            payload[key] = document.getElementById(key).checked;
        });
        payload.mail_password = document.getElementById('mail_password').value;
        payload.ga4_credentials_json = document.getElementById('ga4_credentials_json').value;
        payload.turnstile_secret_key = document.getElementById('turnstile_secret_key').value;

        const btn = document.getElementById('btnSaveSettings');
        btn.disabled = true;
        btn.textContent = 'Enregistrement...';

        fetch('/api/admin/settings', {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload),
        })
            .then(async (response) => {
                const data = await response.json();
                if (!response.ok) {
                    throw new Error(data.message || 'Erreur lors de l\'enregistrement.');
                }
                showAlert(data.message || 'Paramètres mis à jour avec succès', 'success');
                document.getElementById('mail_password').value = '';
                document.getElementById('ga4_credentials_json').value = '';
                document.getElementById('ga4_credentials_file').value = '';
                document.getElementById('turnstile_secret_key').value = '';
            })
            .catch((error) => showAlert(error.message, 'error'))
            .finally(() => {
                btn.disabled = false;
                btn.textContent = 'Enregistrer les paramètres';
            });
    });
});
</script>
@endpush
