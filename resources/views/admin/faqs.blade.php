@extends('layouts.admin')

@section('title', 'FAQ - Admin Infinity WAB')
@section('page-title', 'FAQ')

@section('content')
<div class="space-y-6">
    <section class="grid gap-4 grid-cols-2 lg:grid-cols-3">
        <div class="bg-surface-raised rounded-lg border border-(--border-default) p-4 shadow-sm">
            <p class="text-xs font-medium text-ink-muted uppercase">Total</p>
            <p class="mt-2 text-2xl font-semibold text-ink-primary" id="totalFaqs">0</p>
        </div>
        <div class="bg-surface-raised rounded-lg border border-(--border-default) p-4 shadow-sm">
            <p class="text-xs font-medium text-ink-muted uppercase">Publiées</p>
            <p class="mt-2 text-2xl font-semibold text-emerald-600 dark:text-emerald-400" id="activeFaqs">0</p>
        </div>
        <div class="bg-surface-raised rounded-lg border border-(--border-default) p-4 shadow-sm">
            <p class="text-xs font-medium text-ink-muted uppercase">Masquées</p>
            <p class="mt-2 text-2xl font-semibold text-rose-600 dark:text-rose-400" id="inactiveFaqs">0</p>
        </div>
    </section>

    <section class="bg-surface-raised rounded-lg border border-(--border-default) p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-(--border-default) pb-4">
            <div>
                <h2 class="text-lg font-semibold text-ink-primary">Questions fréquentes</h2>
                <p class="text-xs text-ink-muted mt-0.5">Affichées sur la page Contact du site public</p>
            </div>
            <button type="button" id="btnAddFaq" class="rounded-lg bg-azure-600 px-4 py-2 text-sm font-medium text-white hover:bg-azure-700">
                Nouvelle question
            </button>
        </div>

        <div class="mt-4 flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[200px]">
                <input id="faqSearch" type="search" placeholder="Rechercher…" class="w-full rounded-lg border border-(--border-default) bg-surface-sunken px-3 py-2 text-sm text-ink-primary placeholder-ink-muted focus:border-azure-500 focus:ring-1 focus:ring-azure-500">
            </div>
            <select id="faqStatus" class="min-w-[140px] rounded-lg border border-(--border-default) bg-surface-sunken px-3 py-2 text-sm text-ink-primary focus:border-azure-500">
                <option value="">Tous les statuts</option>
                <option value="active">Publiées</option>
                <option value="inactive">Masquées</option>
            </select>
        </div>

        <div class="mt-4 overflow-hidden rounded-lg border border-(--border-default)">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-ink-secondary">
                    <thead class="bg-surface-sunken text-xs uppercase text-ink-muted">
                        <tr>
                            <th class="px-5 py-3">Question</th>
                            <th class="px-5 py-3">Réponse</th>
                            <th class="px-5 py-3">Statut</th>
                            <th class="px-5 py-3">Ordre</th>
                            <th class="px-5 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="faqsTableBody">
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-sm text-ink-muted">Chargement des questions...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="faqsEmptyState" class="hidden px-5 py-10 text-center text-sm text-ink-muted">
                <p class="text-lg font-semibold text-ink-primary">Aucune question à afficher</p>
                <p>Ajoutez votre première question ou ajustez vos filtres.</p>
            </div>
        </div>
    </section>
</div>

<div
    id="faqModal"
    class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 px-4 py-10"
    role="dialog"
    aria-modal="true"
    aria-labelledby="faqModalTitle"
>
    <div class="w-full max-w-2xl rounded-lg bg-surface-raised p-6 shadow-xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-ink-primary" id="faqModalTitle">Ajouter une question</h3>
            </div>
            <button type="button" class="js-close-faq-modal rounded-lg bg-surface-sunken p-2 text-ink-secondary hover:bg-black/5 dark:hover:bg-white/10">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form id="faqForm" class="mt-6 space-y-5">
            <input type="hidden" id="faqId">
            <div>
                <label class="block text-xs font-medium text-ink-secondary">Question *</label>
                <input type="text" id="faqQuestion" required class="mt-1 w-full rounded-lg border border-(--border-default) bg-surface-sunken px-3 py-2 text-sm text-ink-primary focus:border-azure-500">
            </div>
            <div>
                <label class="block text-xs font-medium text-ink-secondary">Réponse *</label>
                <textarea id="faqAnswer" rows="4" required class="mt-1 w-full rounded-lg border border-(--border-default) bg-surface-sunken px-3 py-2 text-sm text-ink-primary focus:border-azure-500"></textarea>
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="block text-xs font-medium text-ink-secondary">Ordre</label>
                    <input type="number" id="faqOrder" class="mt-1 w-full rounded-lg border border-(--border-default) bg-surface-sunken px-3 py-2 text-sm text-ink-primary focus:border-azure-500" value="0">
                </div>
                <label class="flex items-center gap-2 text-sm text-ink-secondary self-end pb-2">
                    <input type="checkbox" id="faqIsActive" checked class="h-4 w-4 rounded border-(--border-default) text-azure-600 focus:ring-azure-500">
                    Publiée sur le site
                </label>
            </div>
            <div class="flex justify-center gap-3 pt-4 border-t border-(--border-default) sticky bottom-0 bg-surface-raised">
                <button type="button" class="js-close-faq-modal rounded-lg border border-(--border-default) px-4 py-2 text-sm font-medium text-ink-secondary hover:bg-surface-sunken">
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
    const faqsTableBody = document.getElementById('faqsTableBody');
    const faqIsActiveInput = document.getElementById('faqIsActive');
    const faqOrderInput = document.getElementById('faqOrder');

    function renderFaqRow(faq) {
        const question = escapeHtml(faq.question);
        return `
            <tr class="border-b border-(--border-default) hover:bg-surface-sunken transition-colors">
                <td class="px-5 py-4 text-sm font-semibold text-ink-primary">${question}</td>
                <td class="px-5 py-4 text-sm text-ink-secondary" style="-webkit-box-orient: vertical; -webkit-line-clamp: 2; display: -webkit-box; overflow: hidden;">
                    ${escapeHtml(faq.answer ?? '—')}
                </td>
                <td class="px-5 py-4">
                    <span class="inline-flex items-center rounded-full px-3 py-1 text-[11px] font-semibold ${faq.is_active ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400' : 'bg-rose-100 text-rose-700 dark:bg-rose-500/10 dark:text-rose-400'}">
                        ${faq.is_active ? 'Publiée' : 'Masquée'}
                    </span>
                </td>
                <td class="px-5 py-4 text-ink-secondary">${faq.order ?? 0}</td>
                <td class="px-5 py-4 text-sm font-semibold text-ink-secondary">
                    <button type="button" data-action="edit" data-id="${faq.id}" class="mr-3 text-azure-600 hover:text-azure-900 dark:text-azure-400 dark:hover:text-azure-300">Modifier</button>
                    <button type="button" data-action="delete" data-id="${faq.id}" class="text-rose-600 hover:text-rose-900 dark:text-rose-400 dark:hover:text-rose-300">Supprimer</button>
                </td>
            </tr>
        `;
    }

    const resource = createCrudResource({
        endpoint: '/api/admin/faqs',
        entityName: 'question',
        entityLabel: 'une question',
        entityLabelCapitalized: 'Question',
        elements: {
            search: 'faqSearch',
            statusFilter: 'faqStatus',
            tableBody: 'faqsTableBody',
            emptyState: 'faqsEmptyState',
            modal: 'faqModal',
            form: 'faqForm',
            modalTitle: 'faqModalTitle',
        },
        computeStats(data) {
            const total = data.length;
            const active = data.filter((faq) => faq.is_active).length;
            return {
                totalFaqs: total,
                activeFaqs: active,
                inactiveFaqs: total - active,
            };
        },
        matchesFilters(item, filters) {
            if (filters.status === 'active' && !item.is_active) return false;
            if (filters.status === 'inactive' && item.is_active) return false;
            if (!filters.term) return true;
            const haystack = [item.question, item.answer].filter(Boolean).join(' ').toLowerCase();
            return haystack.includes(filters.term);
        },
        renderRow: renderFaqRow,
        fillForm(faq) {
            document.getElementById('faqQuestion').value = faq.question ?? '';
            document.getElementById('faqAnswer').value = faq.answer ?? '';
            faqOrderInput.value = faq.order ?? 0;
            faqIsActiveInput.checked = Boolean(faq.is_active);
        },
        resetExtras() {
            faqIsActiveInput.checked = true;
            faqOrderInput.value = '0';
        },
        buildPayload() {
            return {
                question: document.getElementById('faqQuestion').value.trim(),
                answer: document.getElementById('faqAnswer').value.trim(),
                order: parseInt(faqOrderInput.value, 10) || 0,
                is_active: faqIsActiveInput.checked,
            };
        },
        validatePayload(payload) {
            if (!payload.question || !payload.answer) {
                return 'Veuillez remplir la question et la réponse.';
            }
            return null;
        },
    });

    document.getElementById('btnAddFaq')?.addEventListener('click', () => resource.openModal());
    document.querySelectorAll('.js-close-faq-modal').forEach((btn) => {
        btn.addEventListener('click', () => resource.closeModal());
    });
    faqsTableBody.addEventListener('click', (e) => {
        const btn = e.target.closest('button[data-action]');
        if (!btn) return;
        const id = Number(btn.dataset.id);
        if (btn.dataset.action === 'edit') resource.openModal(id);
        else if (btn.dataset.action === 'delete') resource.deleteItem(id);
    });
});
</script>
@endpush
