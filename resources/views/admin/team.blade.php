@extends('layouts.admin')

@section('title', 'Équipe - Admin Infinity WAB')
@section('page-title', 'Équipe')

@section('content')
<div class="space-y-6">
    <section class="grid gap-4 grid-cols-2 lg:grid-cols-3">
        <div class="bg-surface-raised rounded-lg border border-(--border-default) p-4 shadow-sm">
            <p class="text-xs font-medium text-ink-muted uppercase">Total</p>
            <p class="mt-2 text-2xl font-semibold text-ink-primary" id="totalTeam">0</p>
        </div>
        <div class="bg-surface-raised rounded-lg border border-(--border-default) p-4 shadow-sm">
            <p class="text-xs font-medium text-ink-muted uppercase">Publiés</p>
            <p class="mt-2 text-2xl font-semibold text-emerald-600 dark:text-emerald-400" id="activeTeam">0</p>
        </div>
        <div class="bg-surface-raised rounded-lg border border-(--border-default) p-4 shadow-sm">
            <p class="text-xs font-medium text-ink-muted uppercase">Masqués</p>
            <p class="mt-2 text-2xl font-semibold text-rose-600 dark:text-rose-400" id="inactiveTeam">0</p>
        </div>
    </section>

    <section class="bg-surface-raised rounded-lg border border-(--border-default) p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-(--border-default) pb-4">
            <div>
                <h2 class="text-lg font-semibold text-ink-primary">Membres de l'équipe</h2>
                <p class="text-xs text-ink-muted mt-0.5">Affichés sur la page À propos du site public</p>
            </div>
            <button type="button" id="btnAddTeamMember" class="rounded-lg bg-azure-600 px-4 py-2 text-sm font-medium text-white hover:bg-azure-700">
                Nouveau membre
            </button>
        </div>

        <div class="mt-4 flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[200px]">
                <input id="teamSearch" type="search" placeholder="Rechercher…" class="w-full rounded-lg border border-(--border-default) bg-surface-sunken px-3 py-2 text-sm text-ink-primary placeholder-ink-muted focus:border-azure-500 focus:ring-1 focus:ring-azure-500">
            </div>
            <select id="teamStatus" class="min-w-[140px] rounded-lg border border-(--border-default) bg-surface-sunken px-3 py-2 text-sm text-ink-primary focus:border-azure-500">
                <option value="">Tous les statuts</option>
                <option value="active">Publiés</option>
                <option value="inactive">Masqués</option>
            </select>
        </div>

        <div class="mt-4 overflow-hidden rounded-lg border border-(--border-default)">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-ink-secondary">
                    <thead class="bg-surface-sunken text-xs uppercase text-ink-muted">
                        <tr>
                            <th class="px-5 py-3">Membre</th>
                            <th class="px-5 py-3">Rôle</th>
                            <th class="px-5 py-3">Statut</th>
                            <th class="px-5 py-3">Ordre</th>
                            <th class="px-5 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="teamTableBody">
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-sm text-ink-muted">Chargement de l'équipe...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="teamEmptyState" class="hidden px-5 py-10 text-center text-sm text-ink-muted">
                <p class="text-lg font-semibold text-ink-primary">Aucun membre à afficher</p>
                <p>Ajoutez votre premier membre ou ajustez vos filtres.</p>
            </div>
        </div>
    </section>
</div>

<div
    id="teamModal"
    class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 px-4 py-10"
    role="dialog"
    aria-modal="true"
    aria-labelledby="teamModalTitle"
>
    <div class="w-full max-w-2xl rounded-lg bg-surface-raised p-6 shadow-xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-ink-primary" id="teamModalTitle">Ajouter un membre</h3>
            </div>
            <button type="button" class="js-close-team-modal rounded-lg bg-surface-sunken p-2 text-ink-secondary hover:bg-black/5 dark:hover:bg-white/10">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form id="teamForm" class="mt-6 space-y-5">
            <input type="hidden" id="teamId">
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="block text-xs font-medium text-ink-secondary">Nom *</label>
                    <input type="text" id="teamName" required class="mt-1 w-full rounded-lg border border-(--border-default) bg-surface-sunken px-3 py-2 text-sm text-ink-primary focus:border-azure-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-ink-secondary">Rôle *</label>
                    <input type="text" id="teamRole" required class="mt-1 w-full rounded-lg border border-(--border-default) bg-surface-sunken px-3 py-2 text-sm text-ink-primary focus:border-azure-500" placeholder="Fondateur & CEO">
                </div>
            </div>
            <div>
                <label class="block text-xs font-medium text-ink-secondary">Bio (courte)</label>
                <textarea id="teamBio" rows="3" class="mt-1 w-full rounded-lg border border-(--border-default) bg-surface-sunken px-3 py-2 text-sm text-ink-primary focus:border-azure-500"></textarea>
            </div>
            <div class="grid gap-4 md:grid-cols-3">
                <div>
                    <label class="block text-xs font-medium text-ink-secondary">Photo</label>
                    <div class="mt-1 flex items-center gap-3">
                        <div id="teamPhotoPreview" class="h-12 w-12 flex-shrink-0 overflow-hidden rounded-lg border border-(--border-default) bg-surface-sunken"></div>
                        <input type="text" id="teamPhoto" class="w-full rounded-lg border border-(--border-default) bg-surface-sunken px-3 py-2 text-sm text-ink-primary focus:border-azure-500" placeholder="images/team/nom.jpg">
                        <button type="button" id="teamPhotoPick" class="flex-shrink-0 rounded-lg border border-(--border-default) px-3 py-2 text-xs font-medium text-ink-secondary hover:bg-surface-sunken">
                            Choisir
                        </button>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-ink-secondary">LinkedIn</label>
                    <input type="text" id="teamLinkedin" class="mt-1 w-full rounded-lg border border-(--border-default) bg-surface-sunken px-3 py-2 text-sm text-ink-primary focus:border-azure-500" placeholder="https://linkedin.com/in/...">
                </div>
                <div>
                    <label class="block text-xs font-medium text-ink-secondary">Ordre</label>
                    <input type="number" id="teamOrder" class="mt-1 w-full rounded-lg border border-(--border-default) bg-surface-sunken px-3 py-2 text-sm text-ink-primary focus:border-azure-500" value="0">
                </div>
            </div>
            <label class="flex items-center gap-2 text-sm text-ink-secondary">
                <input type="checkbox" id="teamIsActive" checked class="h-4 w-4 rounded border-(--border-default) text-azure-600 focus:ring-azure-500">
                Publié sur le site
            </label>
            <div class="flex justify-center gap-3 pt-4 border-t border-(--border-default) sticky bottom-0 bg-surface-raised">
                <button type="button" class="js-close-team-modal rounded-lg border border-(--border-default) px-4 py-2 text-sm font-medium text-ink-secondary hover:bg-surface-sunken">
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
    const teamTableBody = document.getElementById('teamTableBody');
    const teamIsActiveInput = document.getElementById('teamIsActive');
    const teamOrderInput = document.getElementById('teamOrder');
    const teamPhotoField = window.bindMediaField({
        input: document.getElementById('teamPhoto'),
        preview: document.getElementById('teamPhotoPreview'),
        button: document.getElementById('teamPhotoPick'),
    });

    function renderTeamRow(item) {
        const name = escapeHtml(item.name);
        return `
            <tr class="border-b border-(--border-default) hover:bg-surface-sunken transition-colors">
                <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-surface-sunken text-ink-secondary font-semibold">${name.charAt(0) || 'M'}</span>
                        <div class="text-sm font-semibold text-ink-primary">${name}</div>
                    </div>
                </td>
                <td class="px-5 py-4 text-sm text-ink-secondary">${escapeHtml(item.role ?? '—')}</td>
                <td class="px-5 py-4">
                    <span class="inline-flex items-center rounded-full px-3 py-1 text-[11px] font-semibold ${item.is_active ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400' : 'bg-rose-100 text-rose-700 dark:bg-rose-500/10 dark:text-rose-400'}">
                        ${item.is_active ? 'Publié' : 'Masqué'}
                    </span>
                </td>
                <td class="px-5 py-4 text-ink-secondary">${item.order ?? 0}</td>
                <td class="px-5 py-4 text-sm font-semibold text-ink-secondary">
                    <button type="button" data-action="edit" data-id="${item.id}" class="mr-3 text-azure-600 hover:text-azure-900 dark:text-azure-400 dark:hover:text-azure-300">Modifier</button>
                    <button type="button" data-action="delete" data-id="${item.id}" class="text-rose-600 hover:text-rose-900 dark:text-rose-400 dark:hover:text-rose-300">Supprimer</button>
                </td>
            </tr>
        `;
    }

    const resource = createCrudResource({
        endpoint: '/api/admin/team',
        entityName: 'membre',
        entityLabel: 'un membre',
        entityLabelCapitalized: 'Membre',
        elements: {
            search: 'teamSearch',
            statusFilter: 'teamStatus',
            tableBody: 'teamTableBody',
            emptyState: 'teamEmptyState',
            modal: 'teamModal',
            form: 'teamForm',
            modalTitle: 'teamModalTitle',
        },
        computeStats(data) {
            const total = data.length;
            const active = data.filter((item) => item.is_active).length;
            return {
                totalTeam: total,
                activeTeam: active,
                inactiveTeam: total - active,
            };
        },
        matchesFilters(item, filters) {
            if (filters.status === 'active' && !item.is_active) return false;
            if (filters.status === 'inactive' && item.is_active) return false;
            if (!filters.term) return true;
            const haystack = [item.name, item.role, item.bio].filter(Boolean).join(' ').toLowerCase();
            return haystack.includes(filters.term);
        },
        renderRow: renderTeamRow,
        fillForm(item) {
            document.getElementById('teamName').value = item.name ?? '';
            document.getElementById('teamRole').value = item.role ?? '';
            document.getElementById('teamBio').value = item.bio ?? '';
            document.getElementById('teamPhoto').value = item.photo ?? '';
            teamPhotoField.renderPreview();
            document.getElementById('teamLinkedin').value = item.linkedin_url ?? '';
            teamOrderInput.value = item.order ?? 0;
            teamIsActiveInput.checked = Boolean(item.is_active);
        },
        resetExtras() {
            teamIsActiveInput.checked = true;
            teamOrderInput.value = '0';
            teamPhotoField.renderPreview();
        },
        buildPayload() {
            return {
                name: document.getElementById('teamName').value.trim(),
                role: document.getElementById('teamRole').value.trim(),
                bio: document.getElementById('teamBio').value.trim() || null,
                photo: document.getElementById('teamPhoto').value.trim() || null,
                linkedin_url: document.getElementById('teamLinkedin').value.trim() || null,
                order: parseInt(teamOrderInput.value, 10) || 0,
                is_active: teamIsActiveInput.checked,
            };
        },
        validatePayload(payload) {
            if (!payload.name || !payload.role) {
                return 'Veuillez remplir le nom et le rôle.';
            }
            return null;
        },
    });

    document.getElementById('btnAddTeamMember')?.addEventListener('click', () => resource.openModal());
    document.querySelectorAll('.js-close-team-modal').forEach((btn) => {
        btn.addEventListener('click', () => resource.closeModal());
    });
    teamTableBody.addEventListener('click', (e) => {
        const btn = e.target.closest('button[data-action]');
        if (!btn) return;
        const id = Number(btn.dataset.id);
        if (btn.dataset.action === 'edit') resource.openModal(id);
        else if (btn.dataset.action === 'delete') resource.deleteItem(id);
    });
});
</script>
@endpush
