@extends('layouts.admin')

@section('title', 'Produits - Admin Infinity WAB')
@section('page-title', 'Produits')

@section('content')
<div class="space-y-6">
    <section class="grid gap-4 grid-cols-2 lg:grid-cols-4">
        <div class="bg-white rounded-lg border border-slate-200 p-4 shadow-sm">
            <p class="text-xs font-medium text-slate-500 uppercase">Total</p>
            <p class="mt-2 text-2xl font-semibold text-slate-800" id="totalProducts">0</p>
        </div>
        <div class="bg-white rounded-lg border border-slate-200 p-4 shadow-sm">
            <p class="text-xs font-medium text-slate-500 uppercase">Actifs</p>
            <p class="mt-2 text-2xl font-semibold text-emerald-600" id="activeProducts">0</p>
        </div>
        <div class="bg-white rounded-lg border border-slate-200 p-4 shadow-sm">
            <p class="text-xs font-medium text-slate-500 uppercase">Mis en avant</p>
            <p class="mt-2 text-2xl font-semibold text-amber-600" id="featuredProducts">0</p>
        </div>
        <div class="bg-white rounded-lg border border-slate-200 p-4 shadow-sm">
            <p class="text-xs font-medium text-slate-500 uppercase">Catégories</p>
            <p class="mt-2 text-2xl font-semibold text-slate-800" id="categoryProducts">0</p>
        </div>
    </section>

    <section class="bg-white rounded-lg border border-slate-200 p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-200 pb-4">
            <div>
                <h2 class="text-lg font-semibold text-slate-800">Produits</h2>
                <p class="text-xs text-slate-500 mt-0.5">Catalogue, prix, catégories</p>
            </div>
            <button onclick="openProductModal()" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                Ajouter un produit
            </button>
        </div>

        <div class="mt-4 flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[200px]">
                <input id="productSearch" type="search" placeholder="Rechercher…" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-700 focus:border-indigo-500">
            </div>
            <select id="productCategory" class="min-w-[140px] rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 focus:border-indigo-500">
                <option value="">Toutes catégories</option>
                <option value="software">Logiciels</option>
                <option value="hardware">Matériels</option>
                <option value="service">Services</option>
                <option value="other">Autre</option>
            </select>
            <select id="productStatus" class="min-w-[140px] rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 focus:border-indigo-500">
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
                            <th class="px-5 py-3">Produit</th>
                            <th class="px-5 py-3">Catégorie</th>
                            <th class="px-5 py-3">Prix</th>
                            <th class="px-5 py-3">Statut</th>
                            <th class="px-5 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="productsTableBody">
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-sm text-slate-400">Chargement des produits...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="productsEmptyState" class="hidden px-5 py-10 text-center text-sm text-slate-500">
                <p class="text-lg font-semibold text-slate-900">Aucun produit à afficher</p>
                <p>Créez votre première fiche produit ou ajustez les filtres.</p>
            </div>
        </div>
    </section>
</div>

<div
    id="productModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4 py-10"
    role="dialog"
    aria-modal="true"
    aria-labelledby="productModalTitle"
>
    <div class="w-full max-w-4xl rounded-lg bg-white p-6 shadow-xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Produit</p>
                <h3 class="text-2xl font-semibold text-slate-900" id="productModalTitle">Ajouter un produit</h3>
            </div>
            <button onclick="closeProductModal()" class="rounded-lg bg-slate-100 p-2 text-slate-600 hover:bg-slate-200">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form id="productForm" class="mt-6 space-y-5">
            <input type="hidden" id="productId">
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Titre *</label>
                    <input type="text" id="productTitle" required class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-2 text-sm text-slate-700 focus:border-purple-500 focus:ring-2 focus:ring-purple-200">
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Slug *</label>
                    <input type="text" id="productSlug" required class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-2 text-sm text-slate-700 focus:border-purple-500 focus:ring-2 focus:ring-purple-200">
                </div>
            </div>
            <div class="grid gap-4 md:grid-cols-3">
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Catégorie *</label>
                    <select id="productCategoryInput" required class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-2 text-sm text-slate-700 focus:border-purple-500 focus:ring-2 focus:ring-purple-200">
                        <option value="">Sélectionner</option>
                        <option value="software">Logiciels</option>
                        <option value="hardware">Matériels</option>
                        <option value="service">Services</option>
                        <option value="other">Autre</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Prix (FCFA)</label>
                    <input type="number" id="productPrice" step="0.01" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-2 text-sm text-slate-700 focus:border-purple-500 focus:ring-2 focus:ring-purple-200">
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Ordre</label>
                    <input type="number" id="productOrder" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-2 text-sm text-slate-700 focus:border-purple-500 focus:ring-2 focus:ring-purple-200" value="0">
                </div>
            </div>
            <div>
                <label class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Description *</label>
                <textarea id="productDescription" rows="3" required class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-2 text-sm text-slate-700 focus:border-purple-500 focus:ring-2 focus:ring-purple-200"></textarea>
            </div>
            <div>
                <label class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Contenu</label>
                <textarea id="productContent" rows="4" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-2 text-sm text-slate-700 focus:border-purple-500 focus:ring-2 focus:ring-purple-200"></textarea>
            </div>
            <div>
                <label class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Images (séparées par des sauts de ligne)</label>
                <textarea id="productImages" rows="3" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-2 text-sm text-slate-700 focus:border-purple-500 focus:ring-2 focus:ring-purple-200" placeholder="images/cover.jpg\nimages/feature-1.jpg"></textarea>
            </div>
            <div>
                <label class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Spécifications (clé: valeur)</label>
                <textarea id="productSpecifications" rows="4" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-2 text-sm text-slate-700 focus:border-purple-500 focus:ring-2 focus:ring-purple-200" placeholder="Processeur: Intel i7\nMémoire: 16GB RAM"></textarea>
            </div>
            <div class="flex flex-wrap gap-6">
                <label class="flex items-center gap-2 text-sm text-slate-700">
                    <input type="checkbox" id="productIsFeatured" class="h-4 w-4 rounded border-slate-300 text-amber-500 focus:ring-amber-500">
                    Mis en avant
                </label>
                <label class="flex items-center gap-2 text-sm text-slate-700">
                    <input type="checkbox" id="productIsActive" checked class="h-4 w-4 rounded border-slate-300 text-emerald-500 focus:ring-emerald-500">
                    Produit actif
                </label>
            </div>
            <div class="flex justify-center gap-3 pt-4 border-t border-slate-200 sticky bottom-0 bg-white">
                <button type="button" onclick="closeProductModal()" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">
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
    const productSearch = document.getElementById('productSearch');
    const productCategory = document.getElementById('productCategory');
    const productStatus = document.getElementById('productStatus');
    const productsTableBody = document.getElementById('productsTableBody');
    const productsEmptyState = document.getElementById('productsEmptyState');
    const productModal = document.getElementById('productModal');
    const productForm = document.getElementById('productForm');
    const productModalTitle = document.getElementById('productModalTitle');
    const totalProducts = document.getElementById('totalProducts');
    const activeProducts = document.getElementById('activeProducts');
    const featuredProducts = document.getElementById('featuredProducts');
    const categoryProducts = document.getElementById('categoryProducts');
    const productTitleInput = document.getElementById('productTitle');
    const productSlugInput = document.getElementById('productSlug');
    const productCategoryInput = document.getElementById('productCategoryInput');
    const productPriceInput = document.getElementById('productPrice');
    const productOrderInput = document.getElementById('productOrder');
    const productDescriptionInput = document.getElementById('productDescription');
    const productContentInput = document.getElementById('productContent');
    const productImagesInput = document.getElementById('productImages');
    const productSpecificationsInput = document.getElementById('productSpecifications');
    const productFeaturedInput = document.getElementById('productIsFeatured');
    const productActiveInput = document.getElementById('productIsActive');

    let productsData = [];
    let currentProductId = null;

    function lockBodyScroll(lock) {
        document.body.style.overflow = lock ? 'hidden' : '';
    }

    function formatPrice(value) {
        if (value == null) {
            return '—';
        }
        return `${Number(value).toLocaleString('fr-FR')} FCFA`;
    }

    function setProductStats(data) {
        const total = data.length;
        const active = data.filter(product => product.is_active).length;
        const featured = data.filter(product => product.is_featured).length;
        const categories = new Set(data.map(product => product.category).filter(Boolean)).size;
        totalProducts.textContent = total;
        activeProducts.textContent = active;
        featuredProducts.textContent = featured;
        categoryProducts.textContent = categories;
    }

    function renderProductRows() {
        if (!productsData.length) {
            productsTableBody.innerHTML = '';
            productsEmptyState.classList.remove('hidden');
            return;
        }

        const term = productSearch.value.trim().toLowerCase();
        const category = productCategory.value;
        const status = productStatus.value;
        const filtered = productsData
            .filter(item => {
                if (category && item.category !== category) {
                    return false;
                }
                if (status === 'active' && !item.is_active) return false;
                if (status === 'inactive' && item.is_active) return false;
                if (status === 'featured' && !item.is_featured) return false;
                if (!term) return true;
                const haystack = [item.title, item.slug, item.category, item.description].filter(Boolean).join(' ').toLowerCase();
                return haystack.includes(term);
            })
            .sort((a, b) => (a.order ?? 0) - (b.order ?? 0));

        if (!filtered.length) {
            productsTableBody.innerHTML = '';
            productsEmptyState.classList.remove('hidden');
            return;
        }

        productsEmptyState.classList.add('hidden');

        const rows = filtered.map(product => {
            const coverImage = Array.isArray(product.images) ? product.images[0] : product.images;
            const cleanCategory = product.category ? product.category.charAt(0).toUpperCase() + product.category.slice(1) : '—';
            const title = escapeHtml(product.title);
            return `
                <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            ${coverImage ? `<img src="${escapeHtml(coverImage)}" alt="${title}" class="h-12 w-12 rounded-2xl object-cover">` : `<span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-lg font-semibold text-slate-600">${title.charAt(0) || 'P'}</span>`}
                            <div>
                                <div class="text-sm font-semibold text-slate-900">${title}</div>
                                <div class="text-xs text-slate-500">${escapeHtml(product.slug)}</div>
                                <p class="text-xs text-slate-400">${escapeHtml(product.description ?? '—')}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4 text-sm text-slate-700">${escapeHtml(cleanCategory)}</td>
                    <td class="px-5 py-4 text-sm font-semibold text-slate-800">${formatPrice(product.price)}</td>
                    <td class="px-5 py-4">
                        <div class="flex flex-wrap items-center gap-2">
                            ${product.is_featured ? '<span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-[11px] font-semibold text-amber-700">Mis en avant</span>' : ''}
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-[11px] font-semibold ${product.is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700'}">
                                ${product.is_active ? 'Actif' : 'Inactif'}
                            </span>
                        </div>
                    </td>
                    <td class="px-5 py-4 text-sm font-semibold text-slate-700">
                        <button onclick="openProductModal(${product.id})" class="mr-3 text-purple-600 hover:text-purple-900">Modifier</button>
                        <button onclick="deleteProduct(${product.id})" class="text-rose-600 hover:text-rose-900">Supprimer</button>
                    </td>
                </tr>
            `;
        }).join('');

        productsTableBody.innerHTML = rows;
    }

    function loadProducts() {
        fetch('/api/admin/products')
            .then(response => response.json())
            .then(data => {
                productsData = Array.isArray(data) ? data : [];
                setProductStats(productsData);
                renderProductRows();
            })
            .catch(() => {
                showAlert('Impossible de charger les produits.', 'error');
            });
    }

    function openProductModal(productId = null) {
        currentProductId = productId;
        productModal.classList.remove('hidden');
        lockBodyScroll(true);
        productModalTitle.textContent = productId ? 'Modifier un produit' : 'Ajouter un produit';

        if (productId) {
            fetch(`/api/admin/products/${productId}`)
                .then(response => response.json())
                .then(product => {
                    productTitleInput.value = product.title ?? '';
                    productSlugInput.value = product.slug ?? '';
                    productCategoryInput.value = product.category ?? '';
                    productPriceInput.value = product.price ?? '';
                    productOrderInput.value = product.order ?? 0;
                    productDescriptionInput.value = product.description ?? '';
                    productContentInput.value = product.content ?? '';
                    productImagesInput.value = Array.isArray(product.images) ? product.images.join('\n') : product.images ?? '';
                    if (product.specifications && typeof product.specifications === 'object') {
                        productSpecificationsInput.value = Object.entries(product.specifications).map(([key, value]) => `${key}: ${value}`).join('\n');
                    } else {
                        productSpecificationsInput.value = product.specifications ?? '';
                    }
                    productFeaturedInput.checked = Boolean(product.is_featured);
                    productActiveInput.checked = Boolean(product.is_active);
                })
                .catch(() => {
                    showAlert('Impossible de charger ce produit.', 'error');
                });
        } else {
            productForm.reset();
            productActiveInput.checked = true;
            productOrderInput.value = '0';
        }
    }

    function closeProductModal() {
        productModal.classList.add('hidden');
        productForm.reset();
        productOrderInput.value = '0';
        currentProductId = null;
        lockBodyScroll(false);
    }

    function deleteProduct(productId) {
        if (!confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')) {
            return;
        }
        fetch(`/api/admin/products/${productId}`, { method: 'DELETE' })
            .then(response => {
                if (!response.ok) {
                    throw new Error();
                }
                return response.json();
            })
            .then(() => {
                showAlert('Produit supprimé avec succès.');
                loadProducts();
            })
            .catch(() => {
                showAlert('Impossible de supprimer ce produit.', 'error');
            });
    }

    function handleProductForm(event) {
        event.preventDefault();
        const imagesValue = productImagesInput.value
            ? productImagesInput.value.split(/[\r\n,]+/).map(url => url.trim()).filter(Boolean)
            : [];
        const specsInput = productSpecificationsInput.value
            ? productSpecificationsInput.value.split('\n').map(line => line.trim()).filter(Boolean)
            : [];
        const specs = {};
        specsInput.forEach(line => {
            const [key, ...rest] = line.split(':');
            if (!key || !rest.length) return;
            specs[key.trim()] = rest.join(':').trim();
        });

        const payload = {
            title: productTitleInput.value.trim(),
            slug: productSlugInput.value.trim(),
            category: productCategoryInput.value || null,
            price: productPriceInput.value ? Number(productPriceInput.value) : null,
            order: parseInt(productOrderInput.value, 10) || 0,
            description: productDescriptionInput.value.trim(),
            content: productContentInput.value.trim() || null,
            images: imagesValue,
            specifications: Object.keys(specs).length ? specs : null,
            is_featured: productFeaturedInput.checked,
            is_active: productActiveInput.checked,
        };

        if (!payload.title || !payload.slug || !payload.category || !payload.description) {
            showAlert('Remplissez les champs obligatoires.', 'error');
            return;
        }

        const url = currentProductId ? `/api/admin/products/${currentProductId}` : '/api/admin/products';
        const method = currentProductId ? 'PUT' : 'POST';

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
                showAlert(`Produit ${currentProductId ? 'modifié' : 'créé'} avec succès.`);
                closeProductModal();
                loadProducts();
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

    productSearch.addEventListener('input', renderProductRows);
    productCategory.addEventListener('change', renderProductRows);
    productStatus.addEventListener('change', renderProductRows);
    productForm.addEventListener('submit', handleProductForm);
    productTitleInput.addEventListener('input', () => {
        if (!currentProductId) {
            productSlugInput.value = generateSlug(productTitleInput.value);
        }
    });

    window.openProductModal = openProductModal;
    window.closeProductModal = closeProductModal;
    window.deleteProduct = deleteProduct;

    // Close on background click + ESC
    productModal.addEventListener('click', (e) => {
        if (e.target === productModal) closeProductModal();
    });
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && productModal && !productModal.classList.contains('hidden')) {
            closeProductModal();
        }
    });

    loadProducts();
});
</script>
@endpush
