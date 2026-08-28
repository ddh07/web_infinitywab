@extends('layouts.admin')

@section('title', 'Projets - Admin Infinity WAB')
@section('page-title', 'Projets')

@section('content')
<div class="space-y-6">
    <section class="grid gap-4 grid-cols-2 lg:grid-cols-4">
        <div class="bg-surface-raised rounded-lg border border-(--border-default) p-4 shadow-sm">
            <p class="text-xs font-medium text-ink-muted uppercase">Total</p>
            <p class="mt-2 text-2xl font-semibold text-ink-primary" id="totalProjects">0</p>
        </div>
        <div class="bg-surface-raised rounded-lg border border-(--border-default) p-4 shadow-sm">
            <p class="text-xs font-medium text-ink-muted uppercase">Actifs</p>
            <p class="mt-2 text-2xl font-semibold text-emerald-600 dark:text-emerald-400" id="activeProjects">0</p>
        </div>
        <div class="bg-surface-raised rounded-lg border border-(--border-default) p-4 shadow-sm">
            <p class="text-xs font-medium text-ink-muted uppercase">Mis en avant</p>
            <p class="mt-2 text-2xl font-semibold text-amber-600 dark:text-amber-400" id="featuredProjects">0</p>
        </div>
        <div class="bg-surface-raised rounded-lg border border-(--border-default) p-4 shadow-sm">
            <p class="text-xs font-medium text-ink-muted uppercase">À venir</p>
            <p class="mt-2 text-2xl font-semibold text-sky-600 dark:text-sky-400" id="upcomingProjects">0</p>
        </div>
    </section>

    <section class="bg-surface-raised rounded-lg border border-(--border-default) p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-(--border-default) pb-4">
            <div>
                <h2 class="text-lg font-semibold text-ink-primary">Projets</h2>
                <p class="text-xs text-ink-muted mt-0.5">Portfolio, clients, technologies</p>
            </div>
            <button type="button" id="btnAddProject" class="rounded-lg bg-azure-600 px-4 py-2 text-sm font-medium text-white hover:bg-azure-700">
                Ajouter un projet
            </button>
        </div>

        <div class="mt-4 flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[200px]">
                <input id="projectSearch" type="search" placeholder="Rechercher…" class="w-full rounded-lg border border-(--border-default) bg-surface-sunken px-3 py-2 text-sm text-ink-primary placeholder-ink-muted focus:border-azure-500">
            </div>
            <select id="projectStatus" class="min-w-[140px] rounded-lg border border-(--border-default) bg-surface-sunken px-3 py-2 text-sm text-ink-primary focus:border-azure-500">
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
                            <th class="px-5 py-3">Projet</th>
                            <th class="px-5 py-3">Client</th>
                            <th class="px-5 py-3">Technologies</th>
                            <th class="px-5 py-3">Fin prévue</th>
                            <th class="px-5 py-3">Statut</th>
                            <th class="px-5 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="projectsTableBody">
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-sm text-ink-muted">Chargement des projets...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="projectsEmptyState" class="hidden px-5 py-10 text-center text-sm text-ink-muted">
                <p class="text-lg font-semibold text-ink-primary">Aucun projet à afficher</p>
                <p>Ajoutez un nouveau projet ou ajustez vos filtres de recherche.</p>
            </div>
        </div>
    </section>
</div>

<div
    id="projectModal"
    class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 px-4 py-10"
    role="dialog"
    aria-modal="true"
    aria-labelledby="projectModalTitle"
>
    <div class="w-full max-w-4xl rounded-lg bg-surface-raised p-6 shadow-xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-ink-primary" id="projectModalTitle">Ajouter un projet</h3>
            </div>
            <button type="button" class="js-close-project-modal rounded-lg bg-surface-sunken p-2 text-ink-secondary hover:bg-black/5 dark:hover:bg-white/10">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form id="projectForm" class="mt-6 space-y-5">
            <input type="hidden" id="projectId">
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-ink-muted">Titre *</label>
                    <input type="text" id="projectTitle" required class="mt-2 w-full rounded-lg border border-(--border-default) bg-surface-sunken px-4 py-2 text-sm text-ink-primary focus:border-azure-500">
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-ink-muted">Slug *</label>
                    <input type="text" id="projectSlug" required class="mt-2 w-full rounded-lg border border-(--border-default) bg-surface-sunken px-4 py-2 text-sm text-ink-primary focus:border-azure-500">
                </div>
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-ink-muted">Client *</label>
                    <input type="text" id="projectClient" required class="mt-2 w-full rounded-lg border border-(--border-default) bg-surface-sunken px-4 py-2 text-sm text-ink-primary focus:border-azure-500">
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-ink-muted">Date de fin</label>
                    <input type="date" id="projectDate" class="mt-2 w-full rounded-lg border border-(--border-default) bg-surface-sunken px-4 py-2 text-sm text-ink-primary focus:border-azure-500">
                </div>
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-ink-muted">URL projet</label>
                    <input type="url" id="projectUrl" class="mt-2 w-full rounded-lg border border-(--border-default) bg-surface-sunken px-4 py-2 text-sm text-ink-primary focus:border-azure-500" placeholder="https://example.com">
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-ink-muted">Image</label>
                    <div class="mt-2 flex items-center gap-3">
                        <div id="projectImagePreview" class="h-12 w-12 flex-shrink-0 overflow-hidden rounded-lg border border-(--border-default) bg-surface-sunken"></div>
                        <input type="text" id="projectImage" class="w-full rounded-lg border border-(--border-default) bg-surface-sunken px-4 py-2 text-sm text-ink-primary focus:border-azure-500" placeholder="images/project-cover.jpg">
                        <button type="button" id="projectImagePick" class="flex-shrink-0 rounded-lg border border-(--border-default) px-3 py-2 text-xs font-medium text-ink-secondary hover:bg-surface-sunken">
                            Choisir
                        </button>
                    </div>
                </div>
            </div>
            <div>
                <label class="text-xs font-semibold uppercase tracking-[0.3em] text-ink-muted">Description *</label>
                <textarea id="projectDescription" rows="3" required class="mt-2 w-full rounded-lg border border-(--border-default) bg-surface-sunken px-4 py-2 text-sm text-ink-primary focus:border-azure-500"></textarea>
            </div>
            <div>
                <label class="text-xs font-semibold uppercase tracking-[0.3em] text-ink-muted">Contenu</label>
                <textarea id="projectContent" rows="4" class="mt-2 w-full rounded-lg border border-(--border-default) bg-surface-sunken px-4 py-2 text-sm text-ink-primary focus:border-azure-500"></textarea>
            </div>
            <div>
                <label class="text-xs font-semibold uppercase tracking-[0.3em] text-ink-muted">Technologies (virgule séparée)</label>
                <input type="text" id="projectTechnologies" class="mt-2 w-full rounded-lg border border-(--border-default) bg-surface-sunken px-4 py-2 text-sm text-ink-primary focus:border-azure-500" placeholder="Laravel, Vue.js">
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-ink-muted">Ordre</label>
                    <input type="number" id="projectOrder" class="mt-2 w-full rounded-lg border border-(--border-default) bg-surface-sunken px-4 py-2 text-sm text-ink-primary focus:border-azure-500" value="0">
                </div>
                <div class="flex items-center gap-6">
                    <label class="flex items-center gap-2 text-sm text-ink-secondary">
                        <input type="checkbox" id="projectIsFeatured" class="h-4 w-4 rounded border-(--border-default) text-amber-500 focus:ring-amber-500">
                        Mis en avant
                    </label>
                    <label class="flex items-center gap-2 text-sm text-ink-secondary">
                        <input type="checkbox" id="projectIsActive" checked class="h-4 w-4 rounded border-(--border-default) text-azure-600 focus:ring-azure-500">
                        Projet actif
                    </label>
                </div>
            </div>
            <div class="flex justify-center gap-3 pt-4 border-t border-(--border-default) sticky bottom-0 bg-surface-raised">
                <button type="button" class="js-close-project-modal rounded-lg border border-(--border-default) px-4 py-2 text-sm font-medium text-ink-secondary hover:bg-surface-sunken">
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
    const projectOrderInput = document.getElementById('projectOrder');
    const projectsTableBody = document.getElementById('projectsTableBody');
    const projectFeaturedInput = document.getElementById('projectIsFeatured');
    const projectActiveInput = document.getElementById('projectIsActive');
    const projectImageField = window.bindMediaField({
        input: document.getElementById('projectImage'),
        preview: document.getElementById('projectImagePreview'),
        button: document.getElementById('projectImagePick'),
    });
    window.initRichEditor('projectContent');

    function formatDate(value) {
        if (!value) return 'N/A';
        const date = new Date(value);
        if (Number.isNaN(date.getTime())) return 'N/A';
        return new Intl.DateTimeFormat('fr-FR').format(date);
    }

    function renderProjectRow(project) {
        const technologies = Array.isArray(project.technologies) ? project.technologies : [];
        const techLabels = technologies.slice(0, 3).map(tech => `<span class="inline-flex items-center rounded-full bg-surface-sunken px-2 py-0.5 text-[11px] font-semibold text-ink-secondary">${escapeHtml(tech)}</span>`).join(' ');
        const extra = technologies.length > 3 ? `<span class="inline-flex items-center rounded-full bg-surface-sunken px-2 py-0.5 text-[11px] font-semibold text-ink-secondary">+${technologies.length - 3}</span>` : '';
        const title = escapeHtml(project.title);
        return `
            <tr class="border-b border-(--border-default) hover:bg-surface-sunken transition-colors">
                <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                        ${project.image ? `<img src="${escapeHtml(project.image)}" alt="${title}" class="h-12 w-12 rounded-2xl object-cover">` : `<span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-surface-sunken text-lg font-semibold text-ink-secondary">${title.charAt(0) || 'P'}</span>`}
                        <div>
                            <div class="text-sm font-semibold text-ink-primary">${title}</div>
                            <div class="text-xs text-ink-muted">${escapeHtml(project.slug)}</div>
                        </div>
                    </div>
                </td>
                <td class="px-5 py-4 text-sm text-ink-secondary">${escapeHtml(project.client ?? '—')}</td>
                <td class="px-5 py-4 space-y-1 text-xs">${techLabels} ${extra}</td>
                <td class="px-5 py-4 text-sm text-ink-secondary">${formatDate(project.completion_date)}</td>
                <td class="px-5 py-4">
                    <div class="flex flex-wrap items-center gap-2">
                        ${project.is_featured ? '<span class="inline-flex items-center rounded-full bg-amber-100 dark:bg-amber-500/10 px-3 py-1 text-[11px] font-semibold text-amber-700 dark:text-amber-400">Mis en avant</span>' : ''}
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-[11px] font-semibold ${project.is_active ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400' : 'bg-rose-100 text-rose-700 dark:bg-rose-500/10 dark:text-rose-400'}">
                            ${project.is_active ? 'Actif' : 'Inactif'}
                        </span>
                    </div>
                </td>
                <td class="px-5 py-4 text-sm font-semibold text-ink-secondary">
                    <button type="button" data-action="edit" data-id="${project.id}" class="mr-3 text-emerald-600 hover:text-emerald-900 dark:text-emerald-400 dark:hover:text-emerald-300">Modifier</button>
                    <button type="button" data-action="delete" data-id="${project.id}" class="text-rose-600 hover:text-rose-900 dark:text-rose-400 dark:hover:text-rose-300">Supprimer</button>
                </td>
            </tr>
        `;
    }

    const resource = createCrudResource({
        endpoint: '/api/admin/projects',
        entityName: 'projet',
        entityLabel: 'un projet',
        entityLabelCapitalized: 'Projet',
        elements: {
            search: 'projectSearch',
            statusFilter: 'projectStatus',
            tableBody: 'projectsTableBody',
            emptyState: 'projectsEmptyState',
            modal: 'projectModal',
            form: 'projectForm',
            modalTitle: 'projectModalTitle',
            titleInput: 'projectTitle',
            slugInput: 'projectSlug',
        },
        computeStats(data) {
            const now = new Date();
            const total = data.length;
            const active = data.filter((project) => project.is_active).length;
            const featured = data.filter((project) => project.is_featured).length;
            const upcoming = data.filter((project) => project.completion_date && new Date(project.completion_date) > now).length;
            return {
                totalProjects: total,
                activeProjects: active,
                featuredProjects: featured,
                upcomingProjects: upcoming,
            };
        },
        matchesFilters(item, filters) {
            if (filters.status === 'active' && !item.is_active) return false;
            if (filters.status === 'inactive' && item.is_active) return false;
            if (filters.status === 'featured' && !item.is_featured) return false;
            if (!filters.term) return true;
            const haystack = [item.title, item.slug, item.client, item.description].filter(Boolean).join(' ').toLowerCase();
            return haystack.includes(filters.term);
        },
        renderRow: renderProjectRow,
        fillForm(project) {
            document.getElementById('projectTitle').value = project.title ?? '';
            document.getElementById('projectSlug').value = project.slug ?? '';
            document.getElementById('projectClient').value = project.client ?? '';
            document.getElementById('projectDate').value = project.completion_date ?? '';
            document.getElementById('projectUrl').value = project.project_url ?? '';
            document.getElementById('projectImage').value = project.image ?? '';
            projectImageField.renderPreview();
            document.getElementById('projectDescription').value = project.description ?? '';
            window.setRichEditorValue('projectContent', project.content ?? '');
            document.getElementById('projectTechnologies').value = Array.isArray(project.technologies) ? project.technologies.join(', ') : project.technologies ?? '';
            projectOrderInput.value = project.order ?? 0;
            projectFeaturedInput.checked = Boolean(project.is_featured);
            projectActiveInput.checked = Boolean(project.is_active);
        },
        resetExtras() {
            projectActiveInput.checked = true;
            projectOrderInput.value = '0';
            projectImageField.renderPreview();
            window.setRichEditorValue('projectContent', '');
        },
        buildPayload() {
            const technologies = document.getElementById('projectTechnologies').value;
            return {
                title: document.getElementById('projectTitle').value.trim(),
                slug: document.getElementById('projectSlug').value.trim(),
                client: document.getElementById('projectClient').value.trim(),
                completion_date: document.getElementById('projectDate').value || null,
                project_url: document.getElementById('projectUrl').value.trim() || null,
                image: document.getElementById('projectImage').value.trim() || null,
                description: document.getElementById('projectDescription').value.trim(),
                content: document.getElementById('projectContent').value.trim() || null,
                technologies: technologies ? technologies.split(',').map((item) => item.trim()).filter(Boolean) : [],
                order: parseInt(projectOrderInput.value, 10) || 0,
                is_featured: projectFeaturedInput.checked,
                is_active: projectActiveInput.checked,
            };
        },
        validatePayload(payload) {
            if (!payload.title || !payload.slug || !payload.client || !payload.description) {
                return 'Veuillez remplir tous les champs obligatoires.';
            }
            return null;
        },
    });

    document.getElementById('btnAddProject')?.addEventListener('click', () => resource.openModal());
    document.querySelectorAll('.js-close-project-modal').forEach((btn) => {
        btn.addEventListener('click', () => resource.closeModal());
    });
    projectsTableBody.addEventListener('click', (e) => {
        const btn = e.target.closest('button[data-action]');
        if (!btn) return;
        const id = Number(btn.dataset.id);
        if (btn.dataset.action === 'edit') resource.openModal(id);
        else if (btn.dataset.action === 'delete') resource.deleteItem(id);
    });
});
</script>
@endpush
