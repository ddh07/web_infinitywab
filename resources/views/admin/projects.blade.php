@extends('layouts.admin')

@section('title', 'Projets - Admin Infinity WAB')
@section('page-title', 'Projets')

@section('content')
<div class="space-y-6">
    <section class="grid gap-4 grid-cols-2 lg:grid-cols-4">
        <div class="bg-white rounded-lg border border-slate-200 p-4 shadow-sm">
            <p class="text-xs font-medium text-slate-500 uppercase">Total</p>
            <p class="mt-2 text-2xl font-semibold text-slate-800" id="totalProjects">0</p>
        </div>
        <div class="bg-white rounded-lg border border-slate-200 p-4 shadow-sm">
            <p class="text-xs font-medium text-slate-500 uppercase">Actifs</p>
            <p class="mt-2 text-2xl font-semibold text-emerald-600" id="activeProjects">0</p>
        </div>
        <div class="bg-white rounded-lg border border-slate-200 p-4 shadow-sm">
            <p class="text-xs font-medium text-slate-500 uppercase">Mis en avant</p>
            <p class="mt-2 text-2xl font-semibold text-amber-600" id="featuredProjects">0</p>
        </div>
        <div class="bg-white rounded-lg border border-slate-200 p-4 shadow-sm">
            <p class="text-xs font-medium text-slate-500 uppercase">À venir</p>
            <p class="mt-2 text-2xl font-semibold text-sky-600" id="upcomingProjects">0</p>
        </div>
    </section>

    <section class="bg-white rounded-lg border border-slate-200 p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-200 pb-4">
            <div>
                <h2 class="text-lg font-semibold text-slate-800">Projets</h2>
                <p class="text-xs text-slate-500 mt-0.5">Portfolio, clients, technologies</p>
            </div>
            <button onclick="openProjectModal()" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                Ajouter un projet
            </button>
        </div>

        <div class="mt-4 flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[200px]">
                <input id="projectSearch" type="search" placeholder="Rechercher…" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-700 focus:border-indigo-500">
            </div>
            <select id="projectStatus" class="min-w-[140px] rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 focus:border-indigo-500">
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
                            <td colspan="6" class="px-5 py-12 text-center text-sm text-slate-400">Chargement des projets...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="projectsEmptyState" class="hidden px-5 py-10 text-center text-sm text-slate-500">
                <p class="text-lg font-semibold text-slate-900">Aucun projet à afficher</p>
                <p>Ajoutez un nouveau projet ou ajustez vos filtres de recherche.</p>
            </div>
        </div>
    </section>
</div>

<div
    id="projectModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4 py-10"
    role="dialog"
    aria-modal="true"
    aria-labelledby="projectModalTitle"
>
    <div class="w-full max-w-4xl rounded-lg bg-white p-6 shadow-xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-slate-800" id="projectModalTitle">Ajouter un projet</h3>
            </div>
            <button onclick="closeProjectModal()" class="rounded-lg bg-slate-100 p-2 text-slate-600 hover:bg-slate-200">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form id="projectForm" class="mt-6 space-y-5">
            <input type="hidden" id="projectId">
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Titre *</label>
                    <input type="text" id="projectTitle" required class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-2 text-sm text-slate-700 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200">
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Slug *</label>
                    <input type="text" id="projectSlug" required class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-2 text-sm text-slate-700 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200">
                </div>
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Client *</label>
                    <input type="text" id="projectClient" required class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-2 text-sm text-slate-700 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200">
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Date de fin</label>
                    <input type="date" id="projectDate" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-2 text-sm text-slate-700 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200">
                </div>
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">URL projet</label>
                    <input type="url" id="projectUrl" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-2 text-sm text-slate-700 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200" placeholder="https://example.com">
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Image</label>
                    <input type="text" id="projectImage" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-2 text-sm text-slate-700 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200" placeholder="images/project-cover.jpg">
                </div>
            </div>
            <div>
                <label class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Description *</label>
                <textarea id="projectDescription" rows="3" required class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-2 text-sm text-slate-700 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"></textarea>
            </div>
            <div>
                <label class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Contenu</label>
                <textarea id="projectContent" rows="4" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-2 text-sm text-slate-700 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"></textarea>
            </div>
            <div>
                <label class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Technologies (virgule séparée)</label>
                <input type="text" id="projectTechnologies" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-2 text-sm text-slate-700 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200" placeholder="Laravel, Vue.js">
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Ordre</label>
                    <input type="number" id="projectOrder" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-2 text-sm text-slate-700 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200" value="0">
                </div>
                <div class="flex items-center gap-6">
                    <label class="flex items-center gap-2 text-sm text-slate-700">
                        <input type="checkbox" id="projectIsFeatured" class="h-4 w-4 rounded border-slate-300 text-amber-500 focus:ring-amber-500">
                        Mis en avant
                    </label>
                    <label class="flex items-center gap-2 text-sm text-slate-700">
                        <input type="checkbox" id="projectIsActive" checked class="h-4 w-4 rounded border-slate-300 text-emerald-500 focus:ring-emerald-500">
                        Projet actif
                    </label>
                </div>
            </div>
            <div class="flex justify-center gap-3 pt-4 border-t border-slate-200 sticky bottom-0 bg-white">
                <button type="button" onclick="closeProjectModal()" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">
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
    const projectSearch = document.getElementById('projectSearch');
    const projectStatus = document.getElementById('projectStatus');
    const projectsTableBody = document.getElementById('projectsTableBody');
    const projectsEmptyState = document.getElementById('projectsEmptyState');
    const projectModal = document.getElementById('projectModal');
    const projectForm = document.getElementById('projectForm');
    const projectModalTitle = document.getElementById('projectModalTitle');
    const totalProjects = document.getElementById('totalProjects');
    const activeProjects = document.getElementById('activeProjects');
    const featuredProjects = document.getElementById('featuredProjects');
    const upcomingProjects = document.getElementById('upcomingProjects');
    const projectTitleInput = document.getElementById('projectTitle');
    const projectSlugInput = document.getElementById('projectSlug');
    const projectClientInput = document.getElementById('projectClient');
    const projectDateInput = document.getElementById('projectDate');
    const projectUrlInput = document.getElementById('projectUrl');
    const projectImageInput = document.getElementById('projectImage');
    const projectTechnologiesInput = document.getElementById('projectTechnologies');
    const projectDescriptionInput = document.getElementById('projectDescription');
    const projectContentInput = document.getElementById('projectContent');
    const projectOrderInput = document.getElementById('projectOrder');
    const projectFeaturedInput = document.getElementById('projectIsFeatured');
    const projectActiveInput = document.getElementById('projectIsActive');

    let projectsData = [];
    let currentProjectId = null;

    function lockBodyScroll(lock) {
        document.body.style.overflow = lock ? 'hidden' : '';
    }

    function formatDate(value) {
        if (!value) {
            return 'N/A';
        }
        const date = new Date(value);
        if (Number.isNaN(date.getTime())) {
            return 'N/A';
        }
        return new Intl.DateTimeFormat('fr-FR').format(date);
    }

    function setProjectStats(data) {
        const now = new Date();
        const total = data.length;
        const active = data.filter(project => project.is_active).length;
        const featured = data.filter(project => project.is_featured).length;
        const upcoming = data.filter(project => project.completion_date && new Date(project.completion_date) > now).length;
        totalProjects.textContent = total;
        activeProjects.textContent = active;
        featuredProjects.textContent = featured;
        upcomingProjects.textContent = upcoming;
    }

    function renderProjectRows() {
        if (!projectsData.length) {
            projectsTableBody.innerHTML = '';
            projectsEmptyState.classList.remove('hidden');
            return;
        }

        const term = projectSearch.value.trim().toLowerCase();
        const status = projectStatus.value;
        const filtered = projectsData
            .filter(item => {
                if (status === 'active' && !item.is_active) return false;
                if (status === 'inactive' && item.is_active) return false;
                if (status === 'featured' && !item.is_featured) return false;
                if (!term) return true;
                const haystack = [item.title, item.slug, item.client, item.description].filter(Boolean).join(' ').toLowerCase();
                return haystack.includes(term);
            })
            .sort((a, b) => (a.order ?? 0) - (b.order ?? 0));

        if (!filtered.length) {
            projectsTableBody.innerHTML = '';
            projectsEmptyState.classList.remove('hidden');
            return;
        }

        projectsEmptyState.classList.add('hidden');

        const rows = filtered.map(project => {
            const technologies = Array.isArray(project.technologies) ? project.technologies : [];
            const techLabels = technologies.slice(0, 3).map(tech => `<span class="inline-flex items-center rounded-full bg-slate-100 px-2 py-0.5 text-[11px] font-semibold text-slate-600">${escapeHtml(tech)}</span>`).join(' ');
            const extra = technologies.length > 3 ? `<span class="inline-flex items-center rounded-full bg-slate-100 px-2 py-0.5 text-[11px] font-semibold text-slate-600">+${technologies.length - 3}</span>` : '';
            const title = escapeHtml(project.title);
            return `
                <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            ${project.image ? `<img src="${escapeHtml(project.image)}" alt="${title}" class="h-12 w-12 rounded-2xl object-cover">` : `<span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-lg font-semibold text-slate-600">${title.charAt(0) || 'P'}</span>`}
                            <div>
                                <div class="text-sm font-semibold text-slate-900">${title}</div>
                                <div class="text-xs text-slate-500">${escapeHtml(project.slug)}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4 text-sm text-slate-700">${escapeHtml(project.client ?? '—')}</td>
                    <td class="px-5 py-4 space-y-1 text-xs">${techLabels} ${extra}</td>
                    <td class="px-5 py-4 text-sm text-slate-600">${formatDate(project.completion_date)}</td>
                    <td class="px-5 py-4">
                        <div class="flex flex-wrap items-center gap-2">
                            ${project.is_featured ? '<span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-[11px] font-semibold text-amber-700">Mis en avant</span>' : ''}
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-[11px] font-semibold ${project.is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700'}">
                                ${project.is_active ? 'Actif' : 'Inactif'}
                            </span>
                        </div>
                    </td>
                    <td class="px-5 py-4 text-sm font-semibold text-slate-700">
                        <button onclick="openProjectModal(${project.id})" class="mr-3 text-emerald-600 hover:text-emerald-900">Modifier</button>
                        <button onclick="deleteProject(${project.id})" class="text-rose-600 hover:text-rose-900">Supprimer</button>
                    </td>
                </tr>
            `;
        }).join('');

        projectsTableBody.innerHTML = rows;
    }

    function loadProjects() {
        fetch('/api/admin/projects')
            .then(response => response.json())
            .then(data => {
                projectsData = Array.isArray(data) ? data : [];
                setProjectStats(projectsData);
                renderProjectRows();
            })
            .catch(() => {
                showAlert('Impossible de charger les projets.', 'error');
            });
    }

    function openProjectModal(projectId = null) {
        currentProjectId = projectId;
        projectModal.classList.remove('hidden');
        lockBodyScroll(true);
        projectModalTitle.textContent = projectId ? 'Modifier un projet' : 'Ajouter un projet';

        if (projectId) {
            fetch(`/api/admin/projects/${projectId}`)
                .then(response => response.json())
                .then(project => {
                    projectTitleInput.value = project.title ?? '';
                    projectSlugInput.value = project.slug ?? '';
                    projectClientInput.value = project.client ?? '';
                    projectDateInput.value = project.completion_date ?? '';
                    projectUrlInput.value = project.project_url ?? '';
                    projectImageInput.value = project.image ?? '';
                    projectDescriptionInput.value = project.description ?? '';
                    projectContentInput.value = project.content ?? '';
                    projectTechnologiesInput.value = Array.isArray(project.technologies) ? project.technologies.join(', ') : project.technologies ?? '';
                    projectOrderInput.value = project.order ?? 0;
                    projectFeaturedInput.checked = Boolean(project.is_featured);
                    projectActiveInput.checked = Boolean(project.is_active);
                })
                .catch(() => {
                    showAlert('Impossible de charger ce projet.', 'error');
                });
        } else {
            projectForm.reset();
            projectActiveInput.checked = true;
            projectOrderInput.value = '0';
        }
    }

    function closeProjectModal() {
        projectModal.classList.add('hidden');
        projectForm.reset();
        projectOrderInput.value = '0';
        currentProjectId = null;
        lockBodyScroll(false);
    }

    function deleteProject(projectId) {
        if (!confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')) {
            return;
        }
        fetch(`/api/admin/projects/${projectId}`, { method: 'DELETE' })
            .then(response => {
                if (!response.ok) {
                    throw new Error();
                }
                return response.json();
            })
            .then(() => {
                showAlert('Projet supprimé avec succès.');
                loadProjects();
            })
            .catch(() => {
                showAlert('Impossible de supprimer ce projet.', 'error');
            });
    }

    function handleProjectForm(event) {
        event.preventDefault();
        const payload = {
            title: projectTitleInput.value.trim(),
            slug: projectSlugInput.value.trim(),
            client: projectClientInput.value.trim(),
            completion_date: projectDateInput.value || null,
            project_url: projectUrlInput.value.trim() || null,
            image: projectImageInput.value.trim() || null,
            description: projectDescriptionInput.value.trim(),
            content: projectContentInput.value.trim() || null,
            technologies: projectTechnologiesInput.value
                ? projectTechnologiesInput.value.split(',').map(item => item.trim()).filter(Boolean)
                : [],
            order: parseInt(projectOrderInput.value, 10) || 0,
            is_featured: projectFeaturedInput.checked,
            is_active: projectActiveInput.checked,
        };

        if (!payload.title || !payload.slug || !payload.client || !payload.description) {
            showAlert('Veuillez remplir tous les champs obligatoires.', 'error');
            return;
        }

        const url = currentProjectId ? `/api/admin/projects/${currentProjectId}` : '/api/admin/projects';
        const method = currentProjectId ? 'PUT' : 'POST';

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
                showAlert(`Projet ${currentProjectId ? 'mis à jour' : 'créé'} avec succès.`);
                closeProjectModal();
                loadProjects();
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

    projectSearch.addEventListener('input', renderProjectRows);
    projectStatus.addEventListener('change', renderProjectRows);
    projectForm.addEventListener('submit', handleProjectForm);
    projectTitleInput.addEventListener('input', () => {
        if (!currentProjectId) {
            projectSlugInput.value = generateSlug(projectTitleInput.value);
        }
    });

    window.openProjectModal = openProjectModal;
    window.closeProjectModal = closeProjectModal;
    window.deleteProject = deleteProject;

    // Close on background click + ESC
    projectModal.addEventListener('click', (e) => {
        if (e.target === projectModal) closeProjectModal();
    });
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && projectModal && !projectModal.classList.contains('hidden')) {
            closeProjectModal();
        }
    });

    loadProjects();
});
</script>
@endpush
