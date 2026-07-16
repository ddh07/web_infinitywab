@extends('layouts.admin')

@section('title', 'Services - Admin Infinity WAB')
@section('page-title', 'Services')

@section('content')
<div class="space-y-6">
    <section class="grid gap-4 grid-cols-2 lg:grid-cols-4">
        <div class="bg-white rounded-lg border border-slate-200 p-4 shadow-sm">
            <p class="text-xs font-medium text-slate-500 uppercase">Total</p>
            <p class="mt-2 text-2xl font-semibold text-slate-800" id="totalServices">0</p>
        </div>
        <div class="bg-white rounded-lg border border-slate-200 p-4 shadow-sm">
            <p class="text-xs font-medium text-slate-500 uppercase">Actifs</p>
            <p class="mt-2 text-2xl font-semibold text-emerald-600" id="activeServices">0</p>
        </div>
        <div class="bg-white rounded-lg border border-slate-200 p-4 shadow-sm">
            <p class="text-xs font-medium text-slate-500 uppercase">Inactifs</p>
            <p class="mt-2 text-2xl font-semibold text-rose-600" id="inactiveServices">0</p>
        </div>
        <div class="bg-white rounded-lg border border-slate-200 p-4 shadow-sm">
            <p class="text-xs font-medium text-slate-500 uppercase">Mis en avant</p>
            <p class="mt-2 text-2xl font-semibold text-amber-600" id="featuredServices">0</p>
        </div>
    </section>

    <section class="bg-white rounded-lg border border-slate-200 p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-200 pb-4">
            <div>
                <h2 class="text-lg font-semibold text-slate-800">Services</h2>
                <p class="text-xs text-slate-500 mt-0.5">Titre, description, ordre d'affichage</p>
            </div>
            <button onclick="openServiceModal()" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                Nouveau service
            </button>
        </div>

        <div class="mt-4 flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[200px]">
                <input id="serviceSearch" type="search" placeholder="Rechercher…" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-700 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
            </div>
            <select id="serviceStatus" class="min-w-[140px] rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 focus:border-indigo-500">
                <option value="">Tous les statuts</option>
                <option value="active">Actifs</option>
                <option value="inactive">Inactifs</option>
                <option value="featured">Mis en avant</option>
            </select>
        </div>

        <div class="mt-4 overflow-hidden rounded-lg border border-slate-200">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                        <tr>
                            <th class="px-5 py-3">Service</th>
                            <th class="px-5 py-3">Description</th>
                            <th class="px-5 py-3">Visibilité</th>
                            <th class="px-5 py-3">Ordre</th>
                            <th class="px-5 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="servicesTableBody">
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-sm text-slate-400">Chargement des services...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="servicesEmptyState" class="hidden px-5 py-10 text-center text-sm text-slate-500">
                <p class="text-lg font-semibold text-slate-900">Aucun service à afficher</p>
                <p>Ajoutez votre premier service ou ajustez vos filtres.</p>
            </div>
        </div>
    </section>
</div>

<div
    id="serviceModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4 py-10"
    role="dialog"
    aria-modal="true"
    aria-labelledby="serviceModalTitle"
>
    <div class="w-full max-w-4xl rounded-lg bg-white p-6 shadow-xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-slate-800" id="serviceModalTitle">Ajouter un service</h3>
            </div>
            <button onclick="closeServiceModal()" class="rounded-lg bg-slate-100 p-2 text-slate-600 hover:bg-slate-200">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form id="serviceForm" class="mt-6 space-y-5">
            <input type="hidden" id="serviceId">
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="block text-xs font-medium text-slate-600">Titre *</label>
                    <input type="text" id="serviceTitle" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-700 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-600">Slug *</label>
                    <input type="text" id="serviceSlug" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-700 focus:border-indigo-500">
                </div>
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="block text-xs font-medium text-slate-600">Description *</label>
                    <textarea id="serviceDescription" rows="3" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-700 focus:border-indigo-500"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-600">Contenu</label>
                    <textarea id="serviceContent" rows="4" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-700 focus:border-indigo-500"></textarea>
                </div>
            </div>
            <div class="grid gap-4 md:grid-cols-3">
                <div>
                    <label class="block text-xs font-medium text-slate-600">Icône</label>
                    <input type="text" id="serviceIcon" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-700 focus:border-indigo-500" placeholder="fas fa-tools">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-600">Image</label>
                    <input type="text" id="serviceImage" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-700 focus:border-indigo-500" placeholder="images/service-cover.jpg">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-600">Ordre</label>
                    <input type="number" id="serviceOrder" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-700 focus:border-indigo-500" value="0">
                </div>
            </div>
            <div class="flex flex-wrap gap-6">
                <label class="flex items-center gap-2 text-sm text-slate-700">
                    <input type="checkbox" id="serviceIsActive" checked class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    Service actif
                </label>
                <label class="flex items-center gap-2 text-sm text-slate-700">
                    <input type="checkbox" id="serviceIsFeatured" class="h-4 w-4 rounded border-slate-300 text-amber-500 focus:ring-amber-500">
                    Mis en avant
                </label>
            </div>
            <div class="flex justify-center gap-3 pt-4 border-t border-slate-200 sticky bottom-0 bg-white">
                  <button type="button" onclick="closeServiceModal()" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">
                      Annuler
                  </button>
                  <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const serviceSearch = document.getElementById('serviceSearch');
    const serviceStatus = document.getElementById('serviceStatus');
    const servicesTableBody = document.getElementById('servicesTableBody');
    const servicesEmptyState = document.getElementById('servicesEmptyState');
    const serviceModal = document.getElementById('serviceModal');
    const serviceForm = document.getElementById('serviceForm');
    const serviceModalTitle = document.getElementById('serviceModalTitle');
    const totalServices = document.getElementById('totalServices');
    const activeServices = document.getElementById('activeServices');
    const inactiveServices = document.getElementById('inactiveServices');
    const featuredServices = document.getElementById('featuredServices');
    const serviceTitleInput = document.getElementById('serviceTitle');
    const serviceSlugInput = document.getElementById('serviceSlug');
    const serviceDescriptionInput = document.getElementById('serviceDescription');
    const serviceContentInput = document.getElementById('serviceContent');
    const serviceIconInput = document.getElementById('serviceIcon');
    const serviceImageInput = document.getElementById('serviceImage');
    const serviceOrderInput = document.getElementById('serviceOrder');
    const serviceIsActiveInput = document.getElementById('serviceIsActive');
    const serviceIsFeaturedInput = document.getElementById('serviceIsFeatured');

    let servicesData = [];
    let currentServiceId = null;

    function lockBodyScroll(lock) {
        document.body.style.overflow = lock ? 'hidden' : '';
    }

    function setServiceStats(data) {
        const total = data.length;
        const active = data.filter(service => service.is_active).length;
        const featured = data.filter(service => service.is_featured).length;
        totalServices.textContent = total;
        activeServices.textContent = active;
        inactiveServices.textContent = total - active;
        featuredServices.textContent = featured;
    }

    function renderServiceRows() {
        if (!servicesData.length) {
            servicesTableBody.innerHTML = '';
            servicesEmptyState.classList.remove('hidden');
            return;
        }

        const term = serviceSearch.value.trim().toLowerCase();
        const status = serviceStatus.value;
        const filtered = servicesData
            .filter(item => {
                if (status === 'active' && !item.is_active) return false;
                if (status === 'inactive' && item.is_active) return false;
                if (status === 'featured' && !item.is_featured) return false;
                if (!term) return true;
                const haystack = [item.title, item.slug, item.description].filter(Boolean).join(' ').toLowerCase();
                return haystack.includes(term);
            })
            .sort((a, b) => (a.order ?? 0) - (b.order ?? 0));

        if (!filtered.length) {
            servicesTableBody.innerHTML = '';
            servicesEmptyState.classList.remove('hidden');
            return;
        }

        servicesEmptyState.classList.add('hidden');
        const rows = filtered.map(service => `
            <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                        ${service.icon
                            ? `<i class="${service.icon} text-slate-500 text-lg"></i>`
                            : `<span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-100 text-slate-600">${service.title?.charAt(0) ?? 'S'}</span>`
                        }
                        <div>
                            <div class="text-sm font-semibold text-slate-900">${service.title}</div>
                            <div class="text-xs text-slate-500">${service.slug}</div>
                        </div>
                    </div>
                </td>
                <td class="px-5 py-4 text-sm text-slate-600" style="-webkit-box-orient: vertical; -webkit-line-clamp: 2; display: -webkit-box; overflow: hidden;">
                    ${service.description ?? '—'}
                </td>
                <td class="px-5 py-4">
                    <span class="inline-flex items-center rounded-full px-3 py-1 text-[11px] font-semibold ${service.is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700'}">
                        ${service.is_active ? 'Actif' : 'Inactif'}
                    </span>
                    ${service.is_featured ? '<span class="ml-2 inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-[11px] font-semibold text-amber-700">Mis en avant</span>' : ''}
                </td>
                <td class="px-5 py-4 text-slate-600">${service.order ?? 0}</td>
                <td class="px-5 py-4 text-sm font-semibold text-slate-700">
                    <button onclick="openServiceModal(${service.id})" class="mr-3 text-indigo-600 hover:text-indigo-900">Modifier</button>
                    <button onclick="deleteService(${service.id})" class="text-rose-600 hover:text-rose-900">Supprimer</button>
                </td>
            </tr>
        `).join('');

        servicesTableBody.innerHTML = rows;
    }

    function loadServices() {
        fetch('/api/admin/services')
            .then(response => response.json())
            .then(data => {
                servicesData = Array.isArray(data) ? data : [];
                setServiceStats(servicesData);
                renderServiceRows();
            })
            .catch(() => {
                showAlert('Impossible de charger les services.', 'error');
            });
    }

    function openServiceModal(serviceId = null) {
        currentServiceId = serviceId;
        serviceModal.classList.remove('hidden');
        lockBodyScroll(true);
        serviceModalTitle.textContent = serviceId ? 'Modifier un service' : 'Ajouter un service';

        if (serviceId) {
            fetch(`/api/admin/services/${serviceId}`)
                .then(response => response.json())
                .then(service => {
                    serviceTitleInput.value = service.title ?? '';
                    serviceSlugInput.value = service.slug ?? '';
                    serviceDescriptionInput.value = service.description ?? '';
                    serviceContentInput.value = service.content ?? '';
                    serviceIconInput.value = service.icon ?? '';
                    serviceImageInput.value = service.image ?? '';
                    serviceOrderInput.value = service.order ?? 0;
                    serviceIsActiveInput.checked = Boolean(service.is_active);
                    serviceIsFeaturedInput.checked = Boolean(service.is_featured);
                })
                .catch(() => {
                    showAlert('Impossible de charger ce service.', 'error');
                });
        } else {
            serviceForm.reset();
            serviceIsActiveInput.checked = true;
            serviceIsFeaturedInput.checked = false;
            serviceOrderInput.value = '0';
        }
    }

    function closeServiceModal() {
        serviceModal.classList.add('hidden');
        serviceForm.reset();
        serviceOrderInput.value = '0';
        currentServiceId = null;
        lockBodyScroll(false);
    }

    function deleteService(serviceId) {
        if (!confirm('Êtes-vous sûr de vouloir supprimer ce service ?')) {
            return;
        }
        fetch(`/api/admin/services/${serviceId}`, { method: 'DELETE' })
            .then(response => {
                if (!response.ok) {
                    throw new Error();
                }
                return response.json();
            })
            .then(() => {
                showAlert('Service supprimé avec succès.');
                loadServices();
            })
            .catch(() => {
                showAlert('Impossible de supprimer ce service.', 'error');
            });
    }

    function handleServiceFormSubmit(event) {
        event.preventDefault();
        const payload = {
            title: serviceTitleInput.value.trim(),
            slug: serviceSlugInput.value.trim(),
            description: serviceDescriptionInput.value.trim(),
            content: serviceContentInput.value.trim(),
            icon: serviceIconInput.value.trim() || null,
            image: serviceImageInput.value.trim() || null,
            order: parseInt(serviceOrderInput.value, 10) || 0,
            is_active: serviceIsActiveInput.checked,
            is_featured: serviceIsFeaturedInput.checked,
        };

        if (!payload.title || !payload.slug || !payload.description) {
            showAlert('Veuillez remplir les champs obligatoires.', 'error');
            return;
        }

        const url = currentServiceId ? `/api/admin/services/${currentServiceId}` : '/api/admin/services';
        const method = currentServiceId ? 'PUT' : 'POST';

        fetch(url, {
            method,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload),
        })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(() => {
                showAlert(`Service ${currentServiceId ? 'modifié' : 'créé'} avec succès.`);
                closeServiceModal();
                loadServices();
            })
            .catch(async error => {
                let message = 'Erreur lors de la sauvegarde.';
                if (error?.message) {
                    message = error.message;
                } else if (error?.errors) {
                    message = Object.values(error.errors).flat().join(' ');
                } else if (typeof error?.json === 'function') {
                    const payload = await error.json().catch(() => null);
                    if (payload?.message) {
                        message = payload.message;
                    }
                }
                showAlert(message, 'error');
            });
    }

    function generateSlug(value) {
        return value.toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');
    }

    serviceSearch.addEventListener('input', renderServiceRows);
    serviceStatus.addEventListener('change', renderServiceRows);
    serviceForm.addEventListener('submit', handleServiceFormSubmit);
    serviceTitleInput.addEventListener('input', () => {
        if (!currentServiceId) {
            serviceSlugInput.value = generateSlug(serviceTitleInput.value);
        }
    });

    window.openServiceModal = openServiceModal;
    window.closeServiceModal = closeServiceModal;
    window.deleteService = deleteService;

    // Close on background click + ESC
    serviceModal.addEventListener('click', (e) => {
        if (e.target === serviceModal) closeServiceModal();
    });
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && serviceModal && !serviceModal.classList.contains('hidden')) {
            closeServiceModal();
        }
    });

    loadServices();
});
</script>
@endpush
