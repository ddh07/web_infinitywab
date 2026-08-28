<div id="confirm-dialog" class="fixed inset-0 z-70 hidden items-center justify-center bg-black/50 px-4" role="alertdialog" aria-modal="true" aria-labelledby="confirm-dialog-title">
    <div class="w-full max-w-sm rounded-2xl border border-(--border-default) bg-surface-raised p-6 shadow-2xl transition-all">
        <h3 id="confirm-dialog-title" class="text-lg font-semibold text-ink-primary mb-2">Confirmer l’action</h3>
        <p id="confirm-dialog-message" class="text-sm text-ink-secondary mb-6"></p>
        <div class="flex justify-end gap-3">
            <button type="button" id="confirm-dialog-cancel" class="px-4 py-2 rounded-lg text-sm font-medium text-ink-secondary hover:bg-surface-sunken transition">
                Annuler
            </button>
            <button type="button" id="confirm-dialog-confirm" class="px-4 py-2 rounded-lg text-sm font-semibold text-white bg-rose-600 hover:bg-rose-700 transition">
                Confirmer
            </button>
        </div>
    </div>
</div>
