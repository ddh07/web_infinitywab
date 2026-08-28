<div id="media-picker-modal" class="fixed inset-0 z-60 hidden items-center justify-center bg-black/50 px-4 py-8" role="dialog" aria-modal="true" aria-labelledby="media-picker-title">
    <div class="w-full max-w-4xl max-h-[85vh] flex flex-col rounded-2xl border border-(--border-default) bg-surface-raised shadow-2xl">
        <div class="flex items-center justify-between px-6 py-4 border-b border-(--border-default)">
            <h3 id="media-picker-title" class="text-lg font-semibold text-ink-primary">Bibliothèque de fichiers</h3>
            <button type="button" data-role="close" class="p-1 rounded-lg text-ink-muted hover:bg-surface-sunken hover:text-ink-primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        @include('admin.partials.media-library-body')

        <div class="flex items-center justify-between px-6 py-4 border-t border-(--border-default)">
            <span data-role="selection-count" class="text-sm text-ink-muted"></span>
            <div class="flex gap-3">
                <button type="button" data-role="cancel" class="px-4 py-2 rounded-lg border border-(--border-default) text-sm font-medium text-ink-secondary hover:bg-surface-sunken">
                    Annuler
                </button>
                <button type="button" data-role="confirm" class="px-4 py-2 rounded-lg bg-azure-600 text-sm font-semibold text-white hover:bg-azure-700 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                    Choisir
                </button>
            </div>
        </div>
    </div>
</div>
