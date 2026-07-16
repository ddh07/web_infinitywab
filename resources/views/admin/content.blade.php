@extends('layouts.admin')

@section('title', 'Contenu - Admin Infinity WAB')
@section('page-title', 'Contenu')

@section('content')
<div class="space-y-6">
    <!-- Company Information -->
    <div class="bg-white rounded-lg border border-slate-200 shadow-sm">
        <div class="px-6 py-4 border-b border-slate-200">
            <h2 class="text-lg font-semibold text-slate-800">Informations de l'Entreprise</h2>
        </div>
        <div class="p-6">
            <div id="company-loading" class="text-center py-8">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <p class="text-gray-500 text-sm">Chargement des informations...</p>
            </div>
            <form id="companyForm" class="hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nom de l'entreprise</label>
                        <input type="text" id="companyName" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="companyEmail" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                        <input type="tel" id="companyPhone" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                        <input type="text" id="companyAddress" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea id="companyDescription" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Vision</label>
                    <textarea id="companyVision" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mission</label>
                    <textarea id="companyMission" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Statistiques (JSON)</label>
                    <textarea id="companyStats" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Réseaux Sociaux (JSON)</label>
                    <textarea id="companySocial" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <div class="mt-6">
                    <label class="flex items-center">
                        <input type="checkbox" id="companyActive" class="mr-2">
                        <span class="text-sm text-gray-700">Entreprise active</span>
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

    <!-- Partners Management -->
    <div class="bg-white rounded-lg border border-slate-200 shadow-sm">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-slate-800">Partenaires</h2>
            <button onclick="openPartnerModal()" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm font-medium">
                Ajouter un partenaire
            </button>
        </div>
        <div class="p-6">
            <div id="partners-loading" class="text-center py-8">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <p class="text-gray-500 text-sm">Chargement des partenaires...</p>
            </div>
            <div id="partners-grid" class="hidden">
                <!-- Partners will be loaded dynamically via JavaScript -->
            </div>
        </div>
    </div>
</div>

    <!-- Content Items Management -->
    <div class="bg-white rounded-lg border border-slate-200 shadow-sm">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-slate-800">Contenus (Pages / Articles)</h2>
            <button type="button" onclick="openContentModal()" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm font-medium">
                Ajouter un contenu
            </button>
        </div>

        <div class="p-6">
            <div class="flex flex-wrap items-center gap-4 mb-5">
                <div class="relative flex-1 min-w-[260px]">
                    <input id="contentSearch" type="search" placeholder="Rechercher (titre / slug / excerpt)" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <select id="contentType" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Tous les types</option>
                        <option value="page">Page</option>
                        <option value="post">Post</option>
                        <option value="article">Article</option>
                        <option value="announcement">Annonce</option>
                    </select>
                </div>
                <div>
                    <select id="contentStatus" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Tous les statuts</option>
                        <option value="draft">Brouillon</option>
                        <option value="published">Publié</option>
                        <option value="archived">Archivé</option>
                    </select>
                </div>
            </div>

            <div class="overflow-hidden rounded-lg border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-700">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-500">
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
                                <td colspan="7" class="px-5 py-12 text-center text-sm text-gray-500">Chargement des contenus...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="contentEmptyState" class="hidden mt-6 text-center text-sm text-gray-500">
                <p class="font-semibold text-gray-900 text-lg">Aucun contenu</p>
                <p>Créez un contenu ou ajustez les filtres.</p>
            </div>
        </div>
    </div>

<!-- Partner Modal -->
<div
    id="partnerModal"
    class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center"
    role="dialog"
    aria-modal="true"
    aria-labelledby="partnerModalTitle"
>
    <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900" id="partnerModalTitle">Ajouter un Partenaire</h3>
            <button onclick="closePartnerModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form id="partnerForm">
            <input type="hidden" id="partnerId">

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                <input type="text" id="partnerName" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="partnerDescription" rows="3" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Site web</label>
                <input type="url" id="partnerWebsite" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Logo</label>
                <input type="text" id="partnerLogo" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                    <select id="partnerCategory" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="technology">Technologie</option>
                        <option value="financial">Financier</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ordre</label>
                    <input type="number" id="partnerOrder" value="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
            </div>

            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" id="partnerActive" checked class="mr-2">
                    <span class="text-sm text-gray-700">Partenaire actif</span>
                </label>
            </div>

            <div class="flex justify-center space-x-3 pt-3 border-t border-gray-200 bg-white/95 backdrop-blur sticky bottom-0 z-10">
                <button type="button" onclick="closePartnerModal()" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Annuler</button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<!-- Content Modal -->
<div
    id="contentModal"
    class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center"
    role="dialog"
    aria-modal="true"
    aria-labelledby="contentModalTitle"
>
    <div class="bg-white rounded-lg p-6 w-full max-w-4xl mx-4 my-6 overflow-y-auto max-h-[90vh]">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900" id="contentModalTitle">Ajouter un contenu</h3>
                <p class="text-sm text-gray-500">Gérez pages, posts, articles et annonces.</p>
            </div>
            <button type="button" onclick="closeContentModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form id="contentForm">
            <input type="hidden" id="contentId">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Titre *</label>
                    <input type="text" id="contentTitle" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Type *</label>
                    <select id="contentTypeInput" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="page">Page</option>
                        <option value="post">Post</option>
                        <option value="article">Article</option>
                        <option value="announcement">Annonce</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Statut *</label>
                    <select id="contentStatusInput" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="draft">Brouillon</option>
                        <option value="published">Publié</option>
                        <option value="archived">Archivé</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Publié le</label>
                    <input type="date" id="contentPublishedAt" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Excerpt</label>
                <textarea id="contentExcerpt" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Contenu *</label>
                <textarea id="contentContent" rows="6" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Meta title</label>
                    <input type="text" id="contentMetaTitle" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Meta description</label>
                    <input type="text" id="contentMetaDescription" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Featured image (URL / chemin)</label>
                    <input type="text" id="contentFeaturedImage" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="images/featured.jpg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ordre</label>
                    <input type="number" id="contentOrder" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" value="0">
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-6 mb-5">
                <label class="flex items-center gap-2 text-sm text-gray-700">
                    <input type="checkbox" id="contentIsFeatured" class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    Contenu en vedette
                </label>
            </div>

            <div class="flex justify-center space-x-3 border-t border-gray-200 pt-4 pb-3 bg-white/95 backdrop-blur sticky bottom-0 z-10">
                <button type="button" onclick="closeContentModal()" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Annuler
                </button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
let currentPartnerId = null;

document.addEventListener('DOMContentLoaded', function() {
    loadCompanyData();
    loadPartnersData();
    loadContentsData();
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
            document.getElementById('companyAddress').value = data.address || '';
            document.getElementById('companyDescription').value = data.description || '';
            document.getElementById('companyVision').value = data.vision || '';
            document.getElementById('companyMission').value = data.mission || '';
            document.getElementById('companyStats').value = JSON.stringify(data.stats || {}, null, 2);
            document.getElementById('companySocial').value = JSON.stringify(data.social_links || {}, null, 2);
            document.getElementById('companyActive').checked = data.is_active || false;
        })
        .catch(error => {
            console.error('Error loading company data:', error);
            document.getElementById('company-loading').innerHTML = `
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-red-500 text-sm">Erreur de chargement</p>
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

            if (data.data && data.data.length > 0) {
                const partnersHtml = `
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        ${data.data.map(partner => `
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="font-medium text-gray-900">${partner.name}</h3>
                                    <span class="px-2 py-1 text-xs ${partner.category === 'technology' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'} rounded-full">
                                        ${partner.category === 'technology' ? 'Tech' : 'Finance'}
                                    </span>
                                </div>
                                ${partner.logo ? `<img src="${partner.logo}" alt="${partner.name}" class="w-full h-24 object-contain mb-3">` : ''}
                                <p class="text-sm text-gray-600 mb-3">${partner.description}</p>
                                ${partner.website ? `<a href="${partner.website}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm">Voir le site</a>` : ''}
                                <div class="mt-3 flex justify-end space-x-2">
                                    <button onclick="editPartner(${partner.id})" class="text-blue-600 hover:text-blue-800 text-sm">Modifier</button>
                                    <button onclick="deletePartner(${partner.id})" class="text-red-600 hover:text-red-800 text-sm">Supprimer</button>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                `;
                container.innerHTML = partnersHtml;
            } else {
                container.innerHTML = `
                    <div class="text-center py-8">
                        <p class="text-gray-500">Aucun partenaire trouvé</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error loading partners data:', error);
            document.getElementById('partners-loading').innerHTML = `
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-red-500 text-sm">Erreur de chargement</p>
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
                document.getElementById('partnerCategory').value = data.category;
                document.getElementById('partnerOrder').value = data.order;
                document.getElementById('partnerActive').checked = data.is_active;
            });
    } else {
        document.getElementById('partnerModalTitle').textContent = 'Ajouter un Partenaire';
        document.getElementById('partnerForm').reset();
    }

    lockBodyScroll(true);
    modal.classList.remove('hidden');
}

function closePartnerModal() {
    document.getElementById('partnerModal').classList.add('hidden');
    document.getElementById('partnerForm').reset();
    currentPartnerId = null;
    lockBodyScroll(false);
}

function editPartner(id) {
    openPartnerModal(id);
}

function deletePartner(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce partenaire ?')) {
        fetch(`/api/admin/partners/${id}`, { method: 'DELETE' })
            .then(() => loadPartnersData());
    }
}

// Company form submission
document.getElementById('companyForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const data = {
        name: document.getElementById('companyName').value,
        email: document.getElementById('companyEmail').value,
        phone: document.getElementById('companyPhone').value,
        address: document.getElementById('companyAddress').value,
        description: document.getElementById('companyDescription').value,
        vision: document.getElementById('companyVision').value,
        mission: document.getElementById('companyMission').value,
        stats: JSON.parse(document.getElementById('companyStats').value || '{}'),
        social_links: JSON.parse(document.getElementById('companySocial').value || '{}'),
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
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="px-5 py-4 font-semibold text-gray-900">${item.title ?? '—'}</td>
                    <td class="px-5 py-4 text-gray-700">${item.type ?? '—'}</td>
                    <td class="px-5 py-4">
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-[11px] font-semibold ${item.status === 'published' ? 'bg-green-100 text-green-800' : (item.status === 'archived' ? 'bg-amber-100 text-amber-800' : 'bg-slate-200 text-slate-700')}">
                            ${statusLabel}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-gray-700">${item.published_at ? formatDate(item.published_at) : '—'}</td>
                    <td class="px-5 py-4">
                        ${item.is_featured ? '<span class="inline-flex items-center rounded-full bg-indigo-100 text-indigo-700 px-3 py-1 text-[11px] font-semibold">Vedette</span>' : '—'}
                    </td>
                    <td class="px-5 py-4 text-gray-700">${item.order ?? 0}</td>
                    <td class="px-5 py-4 text-sm font-semibold text-gray-700">
                        <button type="button" onclick="openContentModal(${item.id})" class="mr-3 text-indigo-600 hover:text-indigo-900">Modifier</button>
                        <button type="button" onclick="deleteContent(${item.id})" class="text-rose-600 hover:text-rose-900">Supprimer</button>
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
            contentEmptyState.innerHTML = '<p class="font-semibold text-gray-900 text-lg">Erreur de chargement</p>';
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
    contentContentInput.value = '';
    contentMetaTitleInput.value = '';
    contentMetaDescriptionInput.value = '';
    contentFeaturedImageInput.value = '';
    contentIsFeaturedInput.checked = false;
    contentOrderInput.value = 0;
}

function openContentModal(contentId = null) {
    currentContentId = contentId;
    lockBodyScroll(true);
    contentModal.classList.remove('hidden');
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
            contentContentInput.value = item.content ?? '';
            contentMetaTitleInput.value = item.meta_title ?? '';
            contentMetaDescriptionInput.value = item.meta_description ?? '';
            contentFeaturedImageInput.value = item.featured_image ?? '';
            contentIsFeaturedInput.checked = Boolean(item.is_featured);
            contentOrderInput.value = item.order ?? 0;
        })
        .catch(() => {
            showAlert('Impossible de charger ce contenu.', 'error');
            closeContentModal();
        });
}

function closeContentModal() {
    contentModal.classList.add('hidden');
    resetContentForm();
    lockBodyScroll(false);
}

function lockBodyScroll(lock) {
    document.body.style.overflow = lock ? 'hidden' : '';
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

function deleteContent(contentId) {
    if (!confirm('Êtes-vous sûr de vouloir supprimer ce contenu ?')) return;

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

window.openContentModal = openContentModal;
window.closeContentModal = closeContentModal;
window.deleteContent = deleteContent;
</script>
@endpush
@endsection
