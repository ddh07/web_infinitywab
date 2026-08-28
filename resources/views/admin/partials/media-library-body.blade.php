<div class="flex flex-wrap items-center gap-3 px-6 py-3 border-b border-(--border-default)">
    <label data-role="dropzone" class="flex items-center gap-2 px-4 py-2 rounded-lg border-2 border-dashed border-(--border-default) text-sm font-medium text-ink-secondary hover:border-azure-500 hover:text-azure-600 cursor-pointer transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M12 12v9m0-9l-3 3m3-3l3 3"/>
        </svg>
        <span data-role="upload-label">Importer un fichier</span>
        <input type="file" data-role="file-input" class="hidden" multiple>
    </label>
    <div data-role="filters-wrap" class="flex items-center gap-1 ml-1">
        <button type="button" data-role="filter" data-type="all" class="px-3 py-1.5 rounded-lg text-sm font-medium bg-azure-100 text-azure-800 dark:bg-azure-500/10 dark:text-azure-400">Tous</button>
        <button type="button" data-role="filter" data-type="image" class="px-3 py-1.5 rounded-lg text-sm font-medium text-ink-secondary hover:bg-surface-sunken">Images</button>
        <button type="button" data-role="filter" data-type="file" class="px-3 py-1.5 rounded-lg text-sm font-medium text-ink-secondary hover:bg-surface-sunken">Documents</button>
    </div>
    <div class="relative ml-auto">
        <svg class="w-4 h-4 text-ink-muted absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/>
        </svg>
        <input type="text" data-role="search" placeholder="Rechercher…" class="pl-9 pr-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg text-sm w-48 focus:border-azure-500">
    </div>
</div>

<div data-role="body" class="flex-1 min-h-0 overflow-y-auto p-6">
    <div data-role="grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4"></div>
    <div data-role="empty" class="hidden text-center text-ink-muted py-12 text-sm">
        Aucun fichier pour le moment. Importez-en un pour commencer.
    </div>
    <div data-role="loadmore-wrap" class="hidden text-center pt-6">
        <button type="button" data-role="loadmore-btn" class="px-4 py-2 rounded-lg border border-(--border-default) text-sm font-medium text-ink-secondary hover:bg-surface-sunken">
            Charger plus
        </button>
    </div>
</div>

<!-- Aperçu image/PDF en plein écran, superposé au-dessus du reste (y compris le
     sélecteur modal en mode "pick") : voir MediaLibrary.handlePreview() dans
     resources/js/admin/media-library.js. -->
<div data-role="preview" class="hidden fixed inset-0 z-70 items-center justify-center bg-black/80 p-4 sm:p-8" role="dialog" aria-modal="true">
    <div class="w-full h-full max-w-5xl flex flex-col">
        <div class="flex items-center justify-between gap-4 pb-3 shrink-0">
            <p data-role="preview-title" class="text-sm font-medium text-white truncate"></p>
            <div class="flex items-center gap-2 shrink-0">
                <a data-role="preview-open" href="#" target="_blank" rel="noopener" class="px-3 py-1.5 rounded-lg bg-white/10 text-xs font-medium text-white hover:bg-white/20">
                    Ouvrir dans un nouvel onglet
                </a>
                <button type="button" data-role="preview-close" aria-label="Fermer l'aperçu" class="w-8 h-8 rounded-full bg-white/10 text-white flex items-center justify-center hover:bg-white/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        <div data-role="preview-body" class="flex-1 min-h-0 flex items-center justify-center overflow-auto rounded-lg bg-black/30"></div>
    </div>
</div>
