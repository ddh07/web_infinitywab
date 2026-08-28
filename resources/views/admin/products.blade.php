@extends('layouts.admin')

@section('title', 'Produits - Admin Infinity WAB')
@section('page-title', 'Produits')

@section('content')
<div class="space-y-6">
    <section class="grid gap-4 grid-cols-2 lg:grid-cols-4">
        <div class="bg-surface-raised rounded-lg border border-(--border-default) p-4 shadow-sm">
            <p class="text-xs font-medium text-ink-muted uppercase">Total</p>
            <p class="mt-2 text-2xl font-semibold text-ink-primary" id="totalProducts">0</p>
        </div>
        <div class="bg-surface-raised rounded-lg border border-(--border-default) p-4 shadow-sm">
            <p class="text-xs font-medium text-ink-muted uppercase">Actifs</p>
            <p class="mt-2 text-2xl font-semibold text-emerald-600 dark:text-emerald-400" id="activeProducts">0</p>
        </div>
        <div class="bg-surface-raised rounded-lg border border-(--border-default) p-4 shadow-sm">
            <p class="text-xs font-medium text-ink-muted uppercase">Mis en avant</p>
            <p class="mt-2 text-2xl font-semibold text-amber-600 dark:text-amber-400" id="featuredProducts">0</p>
        </div>
        <div class="bg-surface-raised rounded-lg border border-(--border-default) p-4 shadow-sm">
            <p class="text-xs font-medium text-ink-muted uppercase">Catégories</p>
            <p class="mt-2 text-2xl font-semibold text-ink-primary" id="categoryProducts">0</p>
        </div>
    </section>

    <section class="bg-surface-raised rounded-lg border border-(--border-default) p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-(--border-default) pb-4">
            <div>
                <h2 class="text-lg font-semibold text-ink-primary">Produits</h2>
                <p class="text-xs text-ink-muted mt-0.5">Catalogue, prix, catégories</p>
            </div>
            <button type="button" id="btnAddProduct" class="rounded-lg bg-azure-600 px-4 py-2 text-sm font-medium text-white hover:bg-azure-700">
                Ajouter un produit
            </button>
        </div>

        <div class="mt-4 flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[200px]">
                <input id="productSearch" type="search" placeholder="Rechercher…" class="w-full rounded-lg border border-(--border-default) bg-surface-sunken px-3 py-2 text-sm text-ink-primary placeholder-ink-muted focus:border-azure-500">
            </div>
            <select id="productCategory" class="min-w-[140px] rounded-lg border border-(--border-default) bg-surface-sunken px-3 py-2 text-sm text-ink-primary focus:border-azure-500">
                <option value="">Toutes catégories</option>
                <option value="software">Logiciels</option>
                <option value="hardware">Matériels</option>
                <option value="service">Services</option>
                <option value="other">Autre</option>
            </select>
            <select id="productStatus" class="min-w-[140px] rounded-lg border border-(--border-default) bg-surface-sunken px-3 py-2 text-sm text-ink-primary focus:border-azure-500">
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
                            <th class="px-5 py-3">Produit</th>
                            <th class="px-5 py-3">Catégorie</th>
                            <th class="px-5 py-3">Prix</th>
                            <th class="px-5 py-3">Statut</th>
                            <th class="px-5 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="productsTableBody">
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-sm text-ink-muted">Chargement des produits...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="productsEmptyState" class="hidden px-5 py-10 text-center text-sm text-ink-muted">
                <p class="text-lg font-semibold text-ink-primary">Aucun produit à afficher</p>
                <p>Créez votre première fiche produit ou ajustez les filtres.</p>
            </div>
        </div>
    </section>
</div>

<div
    id="productModal"
    class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 px-4 py-10"
    role="dialog"
    aria-modal="true"
    aria-labelledby="productModalTitle"
>
    <div class="w-full max-w-4xl rounded-lg bg-surface-raised p-6 shadow-xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.4em] text-ink-muted">Produit</p>
                <h3 class="text-2xl font-semibold text-ink-primary" id="productModalTitle">Ajouter un produit</h3>
            </div>
            <button type="button" class="js-close-product-modal rounded-lg bg-surface-sunken p-2 text-ink-secondary hover:bg-black/5 dark:hover:bg-white/10">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form id="productForm" class="mt-6 space-y-5">
            <input type="hidden" id="productId">
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-ink-muted">Titre *</label>
                    <input type="text" id="productTitle" required class="mt-2 w-full rounded-lg border border-(--border-default) bg-surface-sunken px-4 py-2 text-sm text-ink-primary focus:border-azure-500">
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-ink-muted">Slug *</label>
                    <input type="text" id="productSlug" required class="mt-2 w-full rounded-lg border border-(--border-default) bg-surface-sunken px-4 py-2 text-sm text-ink-primary focus:border-azure-500">
                </div>
            </div>
            <div class="grid gap-4 md:grid-cols-3">
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-ink-muted">Catégorie *</label>
                    <select id="productCategoryInput" required class="mt-2 w-full rounded-lg border border-(--border-default) bg-surface-sunken px-4 py-2 text-sm text-ink-primary focus:border-azure-500">
                        <option value="">Sélectionner</option>
                        <option value="software">Logiciels</option>
                        <option value="hardware">Matériels</option>
                        <option value="service">Services</option>
                        <option value="other">Autre</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-ink-muted">Prix (FCFA)</label>
                    <input type="number" id="productPrice" step="0.01" class="mt-2 w-full rounded-lg border border-(--border-default) bg-surface-sunken px-4 py-2 text-sm text-ink-primary focus:border-azure-500">
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-ink-muted">Ordre</label>
                    <input type="number" id="productOrder" class="mt-2 w-full rounded-lg border border-(--border-default) bg-surface-sunken px-4 py-2 text-sm text-ink-primary focus:border-azure-500" value="0">
                </div>
            </div>
            <div>
                <label class="text-xs font-semibold uppercase tracking-[0.3em] text-ink-muted">Description *</label>
                <textarea id="productDescription" rows="3" required class="mt-2 w-full rounded-lg border border-(--border-default) bg-surface-sunken px-4 py-2 text-sm text-ink-primary focus:border-azure-500"></textarea>
            </div>
            <div>
                <label class="text-xs font-semibold uppercase tracking-[0.3em] text-ink-muted">Contenu</label>
                <textarea id="productContent" rows="4" class="mt-2 w-full rounded-lg border border-(--border-default) bg-surface-sunken px-4 py-2 text-sm text-ink-primary focus:border-azure-500"></textarea>
            </div>
            <div>
                <label class="text-xs font-semibold uppercase tracking-[0.3em] text-ink-muted">Images</label>
                <div class="mt-2 flex items-start gap-3">
                    <div id="productImagesPreview" class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-lg border border-(--border-default) bg-surface-sunken"></div>
                    <textarea id="productImages" rows="3" class="w-full rounded-lg border border-(--border-default) bg-surface-sunken px-4 py-2 text-sm text-ink-primary focus:border-azure-500" placeholder="images/cover.jpg&#10;images/feature-1.jpg"></textarea>
                    <button type="button" id="productImagesPick" class="flex-shrink-0 rounded-lg border border-(--border-default) px-3 py-2 text-xs font-medium text-ink-secondary hover:bg-surface-sunken">
                        Choisir
                    </button>
                </div>
                <p class="mt-1 text-[11px] text-ink-muted">La première image est utilisée comme couverture. Choisir plusieurs fichiers dans la bibliothèque les ajoute tous à la galerie.</p>
            </div>
            <div>
                <label class="text-xs font-semibold uppercase tracking-[0.3em] text-ink-muted">Spécifications (clé: valeur)</label>
                <textarea id="productSpecifications" rows="4" class="mt-2 w-full rounded-lg border border-(--border-default) bg-surface-sunken px-4 py-2 text-sm text-ink-primary focus:border-azure-500" placeholder="Processeur: Intel i7\nMémoire: 16GB RAM"></textarea>
            </div>
            <div class="flex flex-wrap gap-6">
                <label class="flex items-center gap-2 text-sm text-ink-secondary">
                    <input type="checkbox" id="productIsFeatured" class="h-4 w-4 rounded border-(--border-default) text-amber-500 focus:ring-amber-500">
                    Mis en avant
                </label>
                <label class="flex items-center gap-2 text-sm text-ink-secondary">
                    <input type="checkbox" id="productIsActive" checked class="h-4 w-4 rounded border-(--border-default) text-azure-600 focus:ring-azure-500">
                    Produit actif
                </label>
            </div>
            <div class="flex justify-center gap-3 pt-4 border-t border-(--border-default) sticky bottom-0 bg-surface-raised">
                <button type="button" class="js-close-product-modal rounded-lg border border-(--border-default) px-4 py-2 text-sm font-medium text-ink-secondary hover:bg-surface-sunken">
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
    const productOrderInput = document.getElementById('productOrder');
    const productsTableBody = document.getElementById('productsTableBody');
    const productFeaturedInput = document.getElementById('productIsFeatured');
    const productActiveInput = document.getElementById('productIsActive');
    const productImagesField = window.bindMediaField({
        input: document.getElementById('productImages'),
        preview: document.getElementById('productImagesPreview'),
        button: document.getElementById('productImagesPick'),
        multiple: true,
    });
    window.initRichEditor('productContent');

    function formatPrice(value) {
        if (value == null) return '—';
        return `${Number(value).toLocaleString('fr-FR')} FCFA`;
    }

    function renderProductRow(product) {
        const coverImage = Array.isArray(product.images) ? product.images[0] : product.images;
        const cleanCategory = product.category ? product.category.charAt(0).toUpperCase() + product.category.slice(1) : '—';
        const title = escapeHtml(product.title);
        return `
            <tr class="border-b border-(--border-default) hover:bg-surface-sunken transition-colors">
                <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                        ${coverImage ? `<img src="${escapeHtml(coverImage)}" alt="${title}" class="h-12 w-12 rounded-2xl object-cover">` : `<span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-surface-sunken text-lg font-semibold text-ink-secondary">${title.charAt(0) || 'P'}</span>`}
                        <div>
                            <div class="text-sm font-semibold text-ink-primary">${title}</div>
                            <div class="text-xs text-ink-muted">${escapeHtml(product.slug)}</div>
                            <p class="text-xs text-ink-muted">${escapeHtml(product.description ?? '—')}</p>
                        </div>
                    </div>
                </td>
                <td class="px-5 py-4 text-sm text-ink-secondary">${escapeHtml(cleanCategory)}</td>
                <td class="px-5 py-4 text-sm font-semibold text-ink-primary">${formatPrice(product.price)}</td>
                <td class="px-5 py-4">
                    <div class="flex flex-wrap items-center gap-2">
                        ${product.is_featured ? '<span class="inline-flex items-center rounded-full bg-amber-100 dark:bg-amber-500/10 px-3 py-1 text-[11px] font-semibold text-amber-700 dark:text-amber-400">Mis en avant</span>' : ''}
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-[11px] font-semibold ${product.is_active ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400' : 'bg-rose-100 text-rose-700 dark:bg-rose-500/10 dark:text-rose-400'}">
                            ${product.is_active ? 'Actif' : 'Inactif'}
                        </span>
                    </div>
                </td>
                <td class="px-5 py-4 text-sm font-semibold text-ink-secondary">
                    <button type="button" data-action="edit" data-id="${product.id}" class="mr-3 text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300">Modifier</button>
                    <button type="button" data-action="delete" data-id="${product.id}" class="text-rose-600 hover:text-rose-900 dark:text-rose-400 dark:hover:text-rose-300">Supprimer</button>
                </td>
            </tr>
        `;
    }

    const resource = createCrudResource({
        endpoint: '/api/admin/products',
        entityName: 'produit',
        entityLabel: 'un produit',
        entityLabelCapitalized: 'Produit',
        elements: {
            search: 'productSearch',
            statusFilter: 'productStatus',
            extraFilters: ['productCategory'],
            tableBody: 'productsTableBody',
            emptyState: 'productsEmptyState',
            modal: 'productModal',
            form: 'productForm',
            modalTitle: 'productModalTitle',
            titleInput: 'productTitle',
            slugInput: 'productSlug',
        },
        computeStats(data) {
            const total = data.length;
            const active = data.filter((product) => product.is_active).length;
            const featured = data.filter((product) => product.is_featured).length;
            const categories = new Set(data.map((product) => product.category).filter(Boolean)).size;
            return {
                totalProducts: total,
                activeProducts: active,
                featuredProducts: featured,
                categoryProducts: categories,
            };
        },
        matchesFilters(item, filters) {
            if (filters.productCategory && item.category !== filters.productCategory) return false;
            if (filters.status === 'active' && !item.is_active) return false;
            if (filters.status === 'inactive' && item.is_active) return false;
            if (filters.status === 'featured' && !item.is_featured) return false;
            if (!filters.term) return true;
            const haystack = [item.title, item.slug, item.category, item.description].filter(Boolean).join(' ').toLowerCase();
            return haystack.includes(filters.term);
        },
        renderRow: renderProductRow,
        fillForm(product) {
            document.getElementById('productTitle').value = product.title ?? '';
            document.getElementById('productSlug').value = product.slug ?? '';
            document.getElementById('productCategoryInput').value = product.category ?? '';
            document.getElementById('productPrice').value = product.price ?? '';
            productOrderInput.value = product.order ?? 0;
            document.getElementById('productDescription').value = product.description ?? '';
            window.setRichEditorValue('productContent', product.content ?? '');
            document.getElementById('productImages').value = Array.isArray(product.images) ? product.images.join('\n') : product.images ?? '';
            productImagesField.renderPreview();
            const specsInput = document.getElementById('productSpecifications');
            if (product.specifications && typeof product.specifications === 'object') {
                specsInput.value = Object.entries(product.specifications).map(([key, value]) => `${key}: ${value}`).join('\n');
            } else {
                specsInput.value = product.specifications ?? '';
            }
            productFeaturedInput.checked = Boolean(product.is_featured);
            productActiveInput.checked = Boolean(product.is_active);
        },
        resetExtras() {
            productActiveInput.checked = true;
            productOrderInput.value = '0';
            productImagesField.renderPreview();
            window.setRichEditorValue('productContent', '');
        },
        buildPayload() {
            const imagesRaw = document.getElementById('productImages').value;
            const images = imagesRaw ? imagesRaw.split(/[\r\n,]+/).map((url) => url.trim()).filter(Boolean) : [];

            const specsRaw = document.getElementById('productSpecifications').value;
            const specLines = specsRaw ? specsRaw.split('\n').map((line) => line.trim()).filter(Boolean) : [];
            const specs = {};
            specLines.forEach((line) => {
                const [key, ...rest] = line.split(':');
                if (!key || !rest.length) return;
                specs[key.trim()] = rest.join(':').trim();
            });

            return {
                title: document.getElementById('productTitle').value.trim(),
                slug: document.getElementById('productSlug').value.trim(),
                category: document.getElementById('productCategoryInput').value || null,
                price: document.getElementById('productPrice').value ? Number(document.getElementById('productPrice').value) : null,
                order: parseInt(productOrderInput.value, 10) || 0,
                description: document.getElementById('productDescription').value.trim(),
                content: document.getElementById('productContent').value.trim() || null,
                images,
                specifications: Object.keys(specs).length ? specs : null,
                is_featured: productFeaturedInput.checked,
                is_active: productActiveInput.checked,
            };
        },
        validatePayload(payload) {
            if (!payload.title || !payload.slug || !payload.category || !payload.description) {
                return 'Remplissez les champs obligatoires.';
            }
            return null;
        },
    });

    document.getElementById('btnAddProduct')?.addEventListener('click', () => resource.openModal());
    document.querySelectorAll('.js-close-product-modal').forEach((btn) => {
        btn.addEventListener('click', () => resource.closeModal());
    });
    productsTableBody.addEventListener('click', (e) => {
        const btn = e.target.closest('button[data-action]');
        if (!btn) return;
        const id = Number(btn.dataset.id);
        if (btn.dataset.action === 'edit') resource.openModal(id);
        else if (btn.dataset.action === 'delete') resource.deleteItem(id);
    });
});
</script>
@endpush
