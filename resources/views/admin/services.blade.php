@extends('layouts.admin')

@section('title', 'Services - Admin Infinity WAB')
@section('page-title', 'Services')

@section('content')
<div class="space-y-6">
    <section class="grid gap-4 grid-cols-2 lg:grid-cols-4">
        <div class="bg-surface-raised rounded-lg border border-(--border-default) p-4 shadow-sm">
            <p class="text-xs font-medium text-ink-muted uppercase">Total</p>
            <p class="mt-2 text-2xl font-semibold text-ink-primary" id="totalServices">0</p>
        </div>
        <div class="bg-surface-raised rounded-lg border border-(--border-default) p-4 shadow-sm">
            <p class="text-xs font-medium text-ink-muted uppercase">Actifs</p>
            <p class="mt-2 text-2xl font-semibold text-emerald-600 dark:text-emerald-400" id="activeServices">0</p>
        </div>
        <div class="bg-surface-raised rounded-lg border border-(--border-default) p-4 shadow-sm">
            <p class="text-xs font-medium text-ink-muted uppercase">Inactifs</p>
            <p class="mt-2 text-2xl font-semibold text-rose-600 dark:text-rose-400" id="inactiveServices">0</p>
        </div>
        <div class="bg-surface-raised rounded-lg border border-(--border-default) p-4 shadow-sm">
            <p class="text-xs font-medium text-ink-muted uppercase">Mis en avant</p>
            <p class="mt-2 text-2xl font-semibold text-amber-600 dark:text-amber-400" id="featuredServices">0</p>
        </div>
    </section>

    <section class="bg-surface-raised rounded-lg border border-(--border-default) p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-(--border-default) pb-4">
            <div>
                <h2 class="text-lg font-semibold text-ink-primary">Services</h2>
                <p class="text-xs text-ink-muted mt-0.5">Titre, description, ordre d'affichage</p>
            </div>
            <button type="button" id="btnAddService" class="rounded-lg bg-azure-600 px-4 py-2 text-sm font-medium text-white hover:bg-azure-700">
                Nouveau service
            </button>
        </div>

        <div class="mt-4 flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[200px]">
                <input id="serviceSearch" type="search" placeholder="Rechercher…" class="w-full rounded-lg border border-(--border-default) bg-surface-sunken px-3 py-2 text-sm text-ink-primary placeholder-ink-muted focus:border-azure-500 focus:ring-1 focus:ring-azure-500">
            </div>
            <select id="serviceStatus" class="min-w-[140px] rounded-lg border border-(--border-default) bg-surface-sunken px-3 py-2 text-sm text-ink-primary focus:border-azure-500">
                <option value="">Tous les statuts</option>
                <option value="active">Actifs</option>
                <option value="inactive">Inactifs</option>
                <option value="featured">Mis en avant</option>
            </select>
        </div>

        <div class="mt-4 overflow-hidden rounded-lg border border-(--border-default)">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-ink-secondary">
                    <thead class="bg-surface-sunken text-xs uppercase text-ink-muted">
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
                            <td colspan="5" class="px-5 py-12 text-center text-sm text-ink-muted">Chargement des services...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="servicesEmptyState" class="hidden px-5 py-10 text-center text-sm text-ink-muted">
                <p class="text-lg font-semibold text-ink-primary">Aucun service à afficher</p>
                <p>Ajoutez votre premier service ou ajustez vos filtres.</p>
            </div>
        </div>
    </section>
</div>

<div
    id="serviceModal"
    class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 px-4 py-10"
    role="dialog"
    aria-modal="true"
    aria-labelledby="serviceModalTitle"
>
    <div class="w-full max-w-4xl rounded-lg bg-surface-raised p-6 shadow-xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-ink-primary" id="serviceModalTitle">Ajouter un service</h3>
            </div>
            <button type="button" class="js-close-service-modal rounded-lg bg-surface-sunken p-2 text-ink-secondary hover:bg-black/5 dark:hover:bg-white/10">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form id="serviceForm" class="mt-6 space-y-5">
            <input type="hidden" id="serviceId">
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="block text-xs font-medium text-ink-secondary">Titre *</label>
                    <input type="text" id="serviceTitle" required class="mt-1 w-full rounded-lg border border-(--border-default) bg-surface-sunken px-3 py-2 text-sm text-ink-primary focus:border-azure-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-ink-secondary">Slug *</label>
                    <input type="text" id="serviceSlug" required class="mt-1 w-full rounded-lg border border-(--border-default) bg-surface-sunken px-3 py-2 text-sm text-ink-primary focus:border-azure-500">
                </div>
            </div>
            <div>
                <label class="block text-xs font-medium text-ink-secondary">Description *</label>
                <textarea id="serviceDescription" rows="3" required class="mt-1 w-full rounded-lg border border-(--border-default) bg-surface-sunken px-3 py-2 text-sm text-ink-primary focus:border-azure-500"></textarea>
            </div>
            <div>
                <label class="block text-xs font-medium text-ink-secondary">Contenu</label>
                <textarea id="serviceContent" rows="4" class="mt-1 w-full rounded-lg border border-(--border-default) bg-surface-sunken px-3 py-2 text-sm text-ink-primary focus:border-azure-500"></textarea>
            </div>
            <div class="grid gap-4 md:grid-cols-3">
                <div>
                    <label class="block text-xs font-medium text-ink-secondary">Icône</label>
                    <input type="text" id="serviceIcon" class="mt-1 w-full rounded-lg border border-(--border-default) bg-surface-sunken px-3 py-2 text-sm text-ink-primary focus:border-azure-500" placeholder="fas fa-tools">
                </div>
                <div>
                    <label class="block text-xs font-medium text-ink-secondary">Image</label>
                    <div class="mt-1 flex items-center gap-3">
                        <div id="serviceImagePreview" class="h-12 w-12 flex-shrink-0 overflow-hidden rounded-lg border border-(--border-default) bg-surface-sunken"></div>
                        <input type="text" id="serviceImage" class="w-full rounded-lg border border-(--border-default) bg-surface-sunken px-3 py-2 text-sm text-ink-primary focus:border-azure-500" placeholder="images/service-cover.jpg">
                        <button type="button" id="serviceImagePick" class="flex-shrink-0 rounded-lg border border-(--border-default) px-3 py-2 text-xs font-medium text-ink-secondary hover:bg-surface-sunken">
                            Choisir
                        </button>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-ink-secondary">Ordre</label>
                    <input type="number" id="serviceOrder" class="mt-1 w-full rounded-lg border border-(--border-default) bg-surface-sunken px-3 py-2 text-sm text-ink-primary focus:border-azure-500" value="0">
                </div>
            </div>
            <div class="flex flex-wrap gap-6">
                <label class="flex items-center gap-2 text-sm text-ink-secondary">
                    <input type="checkbox" id="serviceIsActive" checked class="h-4 w-4 rounded border-(--border-default) text-azure-600 focus:ring-azure-500">
                    Service actif
                </label>
                <label class="flex items-center gap-2 text-sm text-ink-secondary">
                    <input type="checkbox" id="serviceIsFeatured" class="h-4 w-4 rounded border-(--border-default) text-amber-500 focus:ring-amber-500">
                    Mis en avant
                </label>
            </div>
            <div class="flex justify-center gap-3 pt-4 border-t border-(--border-default) sticky bottom-0 bg-surface-raised">
                  <button type="button" class="js-close-service-modal rounded-lg border border-(--border-default) px-4 py-2 text-sm font-medium text-ink-secondary hover:bg-surface-sunken">
                      Annuler
                  </button>
                  <button type="submit" class="rounded-lg bg-azure-600 px-4 py-2 text-sm font-medium text-white hover:bg-azure-700">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script nonce="{{ $cspNonce }}">
document.addEventListener('DOMContentLoaded', () => {
    const servicesTableBody = document.getElementById('servicesTableBody');
    const serviceIsActiveInput = document.getElementById('serviceIsActive');
    const serviceIsFeaturedInput = document.getElementById('serviceIsFeatured');
    const serviceOrderInput = document.getElementById('serviceOrder');
    const serviceImageField = window.bindMediaField({
        input: document.getElementById('serviceImage'),
        preview: document.getElementById('serviceImagePreview'),
        button: document.getElementById('serviceImagePick'),
    });
    window.initRichEditor('serviceContent');

    function renderServiceRow(service) {
        const title = escapeHtml(service.title);
        return `
            <tr class="border-b border-(--border-default) hover:bg-surface-sunken transition-colors">
                <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                        ${service.icon
                            ? `<i class="${escapeHtml(service.icon)} text-ink-muted text-lg"></i>`
                            : `<span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-surface-sunken text-ink-secondary">${title.charAt(0) || 'S'}</span>`
                        }
                        <div>
                            <div class="text-sm font-semibold text-ink-primary">${title}</div>
                            <div class="text-xs text-ink-muted">${escapeHtml(service.slug)}</div>
                        </div>
                    </div>
                </td>
                <td class="px-5 py-4 text-sm text-ink-secondary" style="-webkit-box-orient: vertical; -webkit-line-clamp: 2; display: -webkit-box; overflow: hidden;">
                    ${escapeHtml(service.description ?? '—')}
                </td>
                <td class="px-5 py-4">
                    <span class="inline-flex items-center rounded-full px-3 py-1 text-[11px] font-semibold ${service.is_active ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400' : 'bg-rose-100 text-rose-700 dark:bg-rose-500/10 dark:text-rose-400'}">
                        ${service.is_active ? 'Actif' : 'Inactif'}
                    </span>
                    ${service.is_featured ? '<span class="ml-2 inline-flex items-center rounded-full bg-amber-100 dark:bg-amber-500/10 px-3 py-1 text-[11px] font-semibold text-amber-700 dark:text-amber-400">Mis en avant</span>' : ''}
                </td>
                <td class="px-5 py-4 text-ink-secondary">${service.order ?? 0}</td>
                <td class="px-5 py-4 text-sm font-semibold text-ink-secondary">
                    <button type="button" data-action="edit" data-id="${service.id}" class="mr-3 text-azure-600 hover:text-azure-900 dark:text-azure-400 dark:hover:text-azure-300">Modifier</button>
                    <button type="button" data-action="delete" data-id="${service.id}" class="text-rose-600 hover:text-rose-900 dark:text-rose-400 dark:hover:text-rose-300">Supprimer</button>
                </td>
            </tr>
        `;
    }

    const resource = createCrudResource({
        endpoint: '/api/admin/services',
        entityName: 'service',
        entityLabel: 'un service',
        entityLabelCapitalized: 'Service',
        elements: {
            search: 'serviceSearch',
            statusFilter: 'serviceStatus',
            tableBody: 'servicesTableBody',
            emptyState: 'servicesEmptyState',
            modal: 'serviceModal',
            form: 'serviceForm',
            modalTitle: 'serviceModalTitle',
            titleInput: 'serviceTitle',
            slugInput: 'serviceSlug',
        },
        computeStats(data) {
            const total = data.length;
            const active = data.filter((service) => service.is_active).length;
            const featured = data.filter((service) => service.is_featured).length;
            return {
                totalServices: total,
                activeServices: active,
                inactiveServices: total - active,
                featuredServices: featured,
            };
        },
        matchesFilters(item, filters) {
            if (filters.status === 'active' && !item.is_active) return false;
            if (filters.status === 'inactive' && item.is_active) return false;
            if (filters.status === 'featured' && !item.is_featured) return false;
            if (!filters.term) return true;
            const haystack = [item.title, item.slug, item.description].filter(Boolean).join(' ').toLowerCase();
            return haystack.includes(filters.term);
        },
        renderRow: renderServiceRow,
        fillForm(service) {
            document.getElementById('serviceTitle').value = service.title ?? '';
            document.getElementById('serviceSlug').value = service.slug ?? '';
            document.getElementById('serviceDescription').value = service.description ?? '';
            window.setRichEditorValue('serviceContent', service.content ?? '');
            document.getElementById('serviceIcon').value = service.icon ?? '';
            document.getElementById('serviceImage').value = service.image ?? '';
            serviceImageField.renderPreview();
            serviceOrderInput.value = service.order ?? 0;
            serviceIsActiveInput.checked = Boolean(service.is_active);
            serviceIsFeaturedInput.checked = Boolean(service.is_featured);
        },
        resetExtras() {
            serviceIsActiveInput.checked = true;
            serviceIsFeaturedInput.checked = false;
            serviceOrderInput.value = '0';
            serviceImageField.renderPreview();
            window.setRichEditorValue('serviceContent', '');
        },
        buildPayload() {
            return {
                title: document.getElementById('serviceTitle').value.trim(),
                slug: document.getElementById('serviceSlug').value.trim(),
                description: document.getElementById('serviceDescription').value.trim(),
                content: document.getElementById('serviceContent').value.trim(),
                icon: document.getElementById('serviceIcon').value.trim() || null,
                image: document.getElementById('serviceImage').value.trim() || null,
                order: parseInt(serviceOrderInput.value, 10) || 0,
                is_active: serviceIsActiveInput.checked,
                is_featured: serviceIsFeaturedInput.checked,
            };
        },
        validatePayload(payload) {
            if (!payload.title || !payload.slug || !payload.description) {
                return 'Veuillez remplir les champs obligatoires.';
            }
            return null;
        },
    });

    document.getElementById('btnAddService')?.addEventListener('click', () => resource.openModal());
    document.querySelectorAll('.js-close-service-modal').forEach((btn) => {
        btn.addEventListener('click', () => resource.closeModal());
    });
    servicesTableBody.addEventListener('click', (e) => {
        const btn = e.target.closest('button[data-action]');
        if (!btn) return;
        const id = Number(btn.dataset.id);
        if (btn.dataset.action === 'edit') resource.openModal(id);
        else if (btn.dataset.action === 'delete') resource.deleteItem(id);
    });
});
</script>
@endpush
