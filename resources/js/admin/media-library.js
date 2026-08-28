// Bibliothèque de médias admin : un seul composant (MediaLibrary) piloté par des
// attributs data-role, monté soit dans la modale globale (#media-picker-modal, mode
// "pick" — utilisée par tous les champs image/fichier des formulaires admin), soit
// dans la page dédiée /admin/fichiers (mode "browse"). Voir admin/partials/media-picker.blade.php
// et admin/partials/media-library-body.blade.php pour le HTML correspondant.
import { openModal, closeModal } from './modal-utils';

const PER_PAGE = 24;

function escapeHtml(value) {
    return String(value ?? '')
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
}

function formatSize(bytes) {
    if (!bytes) return '';
    const units = ['o', 'Ko', 'Mo', 'Go'];
    let value = bytes;
    let unitIndex = 0;
    while (value >= 1024 && unitIndex < units.length - 1) {
        value /= 1024;
        unitIndex += 1;
    }
    return `${value.toFixed(unitIndex === 0 || value >= 10 ? 0 : 1)} ${units[unitIndex]}`;
}

function extensionOf(filename) {
    const parts = String(filename ?? '').split('.');
    return parts.length > 1 ? parts.pop().toUpperCase() : '';
}

class MediaLibrary {
    constructor(root, options = {}) {
        this.root = root;
        this.mode = options.mode ?? 'browse'; // 'browse' (page dédiée) | 'pick' (sélecteur modal)
        this.multiple = Boolean(options.multiple);
        this.accept = options.accept ?? 'all'; // 'all' | 'image' | 'file'
        this.onSelect = options.onSelect ?? null;
        this.onCancel = options.onCancel ?? null;

        this.items = [];
        this.selected = new Map();
        this.page = 1;
        this.hasMore = false;
        this.loading = false;
        this.filterType = this.accept !== 'all' ? this.accept : 'all';
        this.search = '';
        this.loaded = false;

        this.els = {
            grid: root.querySelector('[data-role="grid"]'),
            empty: root.querySelector('[data-role="empty"]'),
            loadMoreWrap: root.querySelector('[data-role="loadmore-wrap"]'),
            loadMoreBtn: root.querySelector('[data-role="loadmore-btn"]'),
            search: root.querySelector('[data-role="search"]'),
            filtersWrap: root.querySelector('[data-role="filters-wrap"]'),
            filters: Array.from(root.querySelectorAll('[data-role="filter"]')),
            fileInput: root.querySelector('[data-role="file-input"]'),
            uploadLabel: root.querySelector('[data-role="upload-label"]'),
            selectionCount: root.querySelector('[data-role="selection-count"]'),
            confirmBtn: root.querySelector('[data-role="confirm"]'),
            preview: root.querySelector('[data-role="preview"]'),
            previewTitle: root.querySelector('[data-role="preview-title"]'),
            previewBody: root.querySelector('[data-role="preview-body"]'),
            previewOpen: root.querySelector('[data-role="preview-open"]'),
            previewClose: root.querySelector('[data-role="preview-close"]'),
        };

        this.bind();

        if (this.accept !== 'all' && this.els.filtersWrap) {
            this.els.filtersWrap.classList.add('hidden');
        }
        this.updateFooter();
    }

    bind() {
        this.els.previewClose?.addEventListener('click', () => this.closePreview());
        this.els.preview?.addEventListener('click', (e) => {
            if (e.target === this.els.preview) this.closePreview();
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !this.els.preview?.classList.contains('hidden')) {
                this.closePreview();
            }
        });

        this.els.fileInput?.addEventListener('change', (e) => {
            this.handleUpload(e.target.files);
            e.target.value = '';
        });

        this.els.filters.forEach((btn) => {
            btn.addEventListener('click', () => {
                this.filterType = btn.dataset.type;
                this.els.filters.forEach((other) => {
                    const active = other === btn;
                    other.classList.toggle('bg-azure-100', active);
                    other.classList.toggle('text-azure-800', active);
                    other.classList.toggle('dark:bg-azure-500/10', active);
                    other.classList.toggle('dark:text-azure-400', active);
                    other.classList.toggle('text-ink-secondary', !active);
                });
                this.load(true);
            });
        });

        let searchTimer = null;
        this.els.search?.addEventListener('input', (e) => {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                this.search = e.target.value.trim();
                this.load(true);
            }, 250);
        });

        this.els.loadMoreBtn?.addEventListener('click', () => this.load(false));

        this.els.grid?.addEventListener('click', (e) => {
            const deleteBtn = e.target.closest('[data-action="delete"]');
            if (deleteBtn) {
                e.preventDefault();
                e.stopPropagation();
                this.handleDelete(deleteBtn.dataset.id);
                return;
            }

            const copyBtn = e.target.closest('[data-action="copy"]');
            if (copyBtn) {
                e.preventDefault();
                e.stopPropagation();
                this.handleCopy(copyBtn.dataset.url);
                return;
            }

            const previewBtn = e.target.closest('[data-action="preview"]');
            if (previewBtn) {
                e.preventDefault();
                e.stopPropagation();
                this.openPreview(previewBtn.dataset.id);
                return;
            }

            const card = e.target.closest('[data-media-card]');
            if (card) {
                this.handleCardClick(card.dataset.id);
            }
        });

        this.els.confirmBtn?.addEventListener('click', () => {
            const items = Array.from(this.selected.values());
            if (!items.length) return;
            this.finish(items);
        });
    }

    reset() {
        this.selected.clear();
        this.updateFooter();
        if (!this.loaded) {
            this.load(true);
        } else {
            this.render();
        }
    }

    async load(reset) {
        if (this.loading) return;
        this.loading = true;
        if (reset) this.page = 1;

        const params = new URLSearchParams({
            page: String(this.page),
            per_page: String(PER_PAGE),
            type: this.filterType,
        });
        if (this.search) params.set('search', this.search);

        try {
            const response = await fetch(`/api/admin/media?${params.toString()}`);
            const data = await response.json();
            this.items = reset ? (data.data ?? []) : [...this.items, ...(data.data ?? [])];
            this.hasMore = Boolean(data.next_page_url);
            this.loaded = true;
            this.render();
        } finally {
            this.loading = false;
        }
    }

    render() {
        if (!this.els.grid) return;

        this.els.empty.classList.toggle('hidden', this.items.length > 0);
        this.els.loadMoreWrap.classList.toggle('hidden', !this.hasMore);

        this.els.grid.innerHTML = this.items.map((item) => this.cardHtml(item)).join('');
    }

    cardHtml(item) {
        const isImage = item.type === 'image';
        const isSelected = this.selected.has(String(item.id));
        const name = escapeHtml(item.original_filename);
        const thumb = item.thumbnail_url ?? (isImage ? item.url : null);
        const ext = extensionOf(item.original_filename).toLowerCase();
        const isPreviewable = isImage || ext === 'pdf';

        const media = thumb
            ? `<img src="${escapeHtml(thumb)}" alt="${name}" class="w-full h-full object-cover" loading="lazy">`
            : `<div class="w-full h-full flex flex-col items-center justify-center gap-1 text-ink-muted">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span class="text-[10px] font-semibold uppercase">${escapeHtml(ext)}</span>
               </div>`;

        const overlay = this.mode === 'pick'
            ? `<div class="media-check absolute top-1.5 right-1.5 w-5 h-5 rounded-full border-2 border-white flex items-center justify-center transition ${isSelected ? 'bg-azure-600' : 'bg-black/30'}">
                    ${isSelected ? '<svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>' : ''}
               </div>`
            : `<div class="absolute top-1.5 right-1.5 hidden group-hover:flex items-center gap-1">
                    <button type="button" data-action="copy" data-url="${escapeHtml(item.url)}" title="Copier l'URL" class="w-6 h-6 rounded-full bg-black/50 text-white flex items-center justify-center hover:bg-azure-600">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    </button>
                    <button type="button" data-action="delete" data-id="${item.id}" title="Supprimer" class="w-6 h-6 rounded-full bg-black/50 text-white flex items-center justify-center hover:bg-red-600">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
               </div>`;

        const previewBtn = isPreviewable
            ? `<button type="button" data-action="preview" data-id="${item.id}" title="Aperçu" class="absolute top-1.5 left-1.5 w-6 h-6 rounded-full bg-black/50 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition hover:bg-azure-600">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
               </button>`
            : '';

        // Le bouton de sélection ne doit contenir QUE le média : un <button> ne peut
        // pas héberger d'autres <button> (copier/supprimer/aperçu) sans que le parseur
        // HTML ne le referme prématurément, ce qui décale visuellement ces actions hors
        // de la carte et casse le survol group-hover. Ces actions restent donc en frères
        // du bouton, à l'intérieur du même conteneur .group. Le nom de fichier est une
        // légende sous la vignette (donc toujours visible), plutôt qu'un bandeau affiché
        // seulement au survol.
        return `
            <div class="media-card group relative rounded-xl border-2 ${isSelected ? 'border-azure-500' : 'border-transparent'} overflow-hidden bg-surface-sunken">
                <div class="relative aspect-square">
                    <button type="button" data-media-card data-id="${item.id}" class="absolute inset-0 w-full h-full text-left focus:outline-none focus:ring-2 focus:ring-azure-500">
                        ${media}
                    </button>
                    ${previewBtn}
                    ${overlay}
                </div>
                <div class="px-2 py-1.5 text-[11px] leading-tight text-ink-secondary truncate" title="${name}">
                    ${name}${item.size ? ` · ${formatSize(item.size)}` : ''}
                </div>
            </div>
        `;
    }

    openPreview(id) {
        const item = this.items.find((i) => String(i.id) === String(id));
        if (!item || !this.els.preview) return;

        const ext = extensionOf(item.original_filename).toLowerCase();
        const isImage = item.type === 'image';
        const isPdf = ext === 'pdf';

        if (this.els.previewTitle) this.els.previewTitle.textContent = item.original_filename;
        if (this.els.previewOpen) this.els.previewOpen.href = item.url;

        if (this.els.previewBody) {
            if (isImage) {
                this.els.previewBody.innerHTML = `<img src="${escapeHtml(item.url)}" alt="${escapeHtml(item.original_filename)}" class="max-w-full max-h-full object-contain">`;
            } else if (isPdf) {
                this.els.previewBody.innerHTML = `<iframe src="${escapeHtml(item.url)}" class="w-full h-full" style="border:0;" title="${escapeHtml(item.original_filename)}"></iframe>`;
            } else {
                this.els.previewBody.innerHTML = `<div class="flex flex-col items-center justify-center gap-3 text-white/70 p-8 text-center">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <p class="text-sm">Aucun aperçu disponible pour ce type de fichier.</p>
                    </div>`;
            }
        }

        this.els.preview.classList.remove('hidden');
        this.els.preview.classList.add('flex');
    }

    closePreview() {
        if (!this.els.preview) return;
        this.els.preview.classList.add('hidden');
        this.els.preview.classList.remove('flex');
        if (this.els.previewBody) this.els.previewBody.innerHTML = '';
    }

    handleCardClick(id) {
        const item = this.items.find((i) => String(i.id) === String(id));
        if (!item) return;

        if (this.mode !== 'pick') return;

        if (!this.multiple) {
            this.finish([item]);
            return;
        }

        if (this.selected.has(String(id))) {
            this.selected.delete(String(id));
        } else {
            this.selected.set(String(id), item);
        }
        this.updateFooter();
        this.render();
    }

    updateFooter() {
        if (!this.els.confirmBtn) return;
        const count = this.selected.size;
        this.els.confirmBtn.disabled = count === 0;
        if (this.els.selectionCount) {
            this.els.selectionCount.textContent = count > 0 ? `${count} sélectionné(s)` : '';
        }
    }

    finish(items) {
        this.onSelect?.(items);
        if (this.modalEl) closeModal(this.modalEl);
        this.selected.clear();
        this.updateFooter();
    }

    async handleUpload(fileList) {
        const files = Array.from(fileList ?? []);
        if (!files.length) return;

        const originalLabel = this.els.uploadLabel?.textContent;
        if (this.els.uploadLabel) this.els.uploadLabel.textContent = 'Import en cours…';

        try {
            for (const file of files) {
                const formData = new FormData();
                formData.append('file', file);
                const response = await fetch('/api/admin/media', { method: 'POST', body: formData });
                if (response.ok) {
                    const item = await response.json();
                    this.items.unshift(item);
                }
            }
            this.render();
        } finally {
            if (this.els.uploadLabel) this.els.uploadLabel.textContent = originalLabel;
        }
    }

    async handleDelete(id) {
        const confirmed = await window.confirmDialog(
            "Supprimer ce fichier de la bibliothèque ? S'il est encore utilisé sur une page, l'image n'apparaîtra plus.",
            { title: 'Supprimer le fichier', confirmLabel: 'Supprimer' }
        );
        if (!confirmed) return;

        const response = await fetch(`/api/admin/media/${id}`, { method: 'DELETE' });
        if (response.ok) {
            this.items = this.items.filter((i) => String(i.id) !== String(id));
            this.selected.delete(String(id));
            this.updateFooter();
            this.render();
        }
    }

    handleCopy(url) {
        navigator.clipboard?.writeText(url).then(() => {
            window.showAlert?.('URL copiée dans le presse-papiers', 'success');
        }).catch(() => {});
    }
}

let pickerInstance = null;

export function initMediaLibraryPage(root) {
    const library = new MediaLibrary(root, { mode: 'browse' });
    library.load(true);
    return library;
}

export function openMediaPicker({ multiple = false, accept = 'all', onSelect } = {}) {
    const modal = document.getElementById('media-picker-modal');
    if (!modal) return;

    if (!pickerInstance) {
        pickerInstance = new MediaLibrary(modal, { mode: 'pick' });
        pickerInstance.modalEl = modal;

        modal.querySelector('[data-role="close"]')?.addEventListener('click', () => {
            pickerInstance.onCancel?.();
            closeModal(modal);
        });
        modal.querySelector('[data-role="cancel"]')?.addEventListener('click', () => {
            pickerInstance.onCancel?.();
            closeModal(modal);
        });
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                pickerInstance.onCancel?.();
                closeModal(modal);
            }
        });
    }

    pickerInstance.multiple = multiple;
    pickerInstance.accept = accept;
    pickerInstance.filterType = accept !== 'all' ? accept : 'all';
    pickerInstance.onSelect = onSelect ?? null;
    pickerInstance.els.filtersWrap?.classList.toggle('hidden', accept !== 'all');
    pickerInstance.reset();

    openModal(modal);
}

// Résolution d'aperçu côté client, calquée sur App\Support\ImagePath::resolve() :
// une valeur déjà absolue (http(s) ou /storage/...) est utilisée telle quelle, un
// nom nu hérité (ancienne convention "tape le chemin à la main") est supposé vivre
// sous public/images/. Sert uniquement à l'aperçu — pas de vérification d'existence
// ni de repli, une image cassée reste silencieusement invisible (voir onerror).
function resolvePreviewSrc(value) {
    if (!value) return null;
    if (/^https?:\/\//i.test(value)) return value;
    const normalized = value.replace(/^\/+/, '');
    if (normalized.startsWith('storage/')) return `/${normalized}`;
    return `/${normalized.startsWith('images/') ? normalized : `images/${normalized}`}`;
}

/**
 * Relie un champ texte (input ou textarea) existant à la bibliothèque de médias :
 * un bouton ouvre le sélecteur, la valeur choisie est écrite dans le champ (inchangé
 * pour buildPayload/fillForm côté page), et une vignette d'aperçu se met à jour.
 * En mode `multiple`, les URLs choisies sont jointes par des retours à la ligne
 * (convention déjà utilisée par le champ "images" des produits).
 */
export function bindMediaField({ input, preview, button, multiple = false, accept = 'image' }) {
    function firstValue(raw) {
        return raw.split(/[\r\n,]+/).map((s) => s.trim()).filter(Boolean)[0] ?? null;
    }

    function renderPreview() {
        if (!preview) return;
        const raw = input?.value ?? '';
        const src = resolvePreviewSrc(multiple ? firstValue(raw) : raw.trim());
        preview.innerHTML = src
            ? `<img src="${src}" class="w-full h-full object-cover" onerror="this.remove()">`
            : '';
    }

    input?.addEventListener('input', renderPreview);
    button?.addEventListener('click', () => {
        openMediaPicker({
            multiple,
            accept,
            onSelect(items) {
                input.value = multiple ? items.map((i) => i.url).join('\n') : items[0].url;
                renderPreview();
            },
        });
    });

    renderPreview();

    return { renderPreview };
}
