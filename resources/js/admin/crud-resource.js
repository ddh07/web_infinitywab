/**
 * Fabrique générique pour les écrans admin de type CRUD (tableau + modale +
 * recherche/filtres) : services, projets, produits partagent tous le même
 * squelette (charger la liste, filtrer côté client, ouvrir/fermer une modale,
 * soumettre un formulaire, supprimer avec confirmation). Seules les parties
 * spécifiques à chaque ressource (rendu de ligne, remplissage du formulaire,
 * construction du payload, calcul des stats) sont fournies en config.
 *
 * @param {Object} config
 * @param {string} config.endpoint - Base URL de l'API (ex: '/api/admin/services')
 * @param {string} config.entityName - Nom affiché dans les messages (ex: 'service')
 * @param {Object} config.elements - IDs des éléments DOM impliqués
 * @param {string} config.elements.search
 * @param {string} [config.elements.statusFilter]
 * @param {string[]} [config.elements.extraFilters] - IDs d'autres <select> de filtre
 * @param {string} config.elements.tableBody
 * @param {string} config.elements.emptyState
 * @param {string} config.elements.modal
 * @param {string} config.elements.form
 * @param {string} config.elements.modalTitle
 * @param {string} config.elements.titleInput
 * @param {string} config.elements.slugInput
 * @param {Object<string,string>} config.stats - { idDomStat: nomDeLaFonction } voir computeStats
 * @param {(data: any[]) => Object<string,string|number>} config.computeStats
 * @param {(item: any, filters: {term: string, [key: string]: string}) => boolean} config.matchesFilters
 * @param {(item: any) => string} config.renderRow
 * @param {(item: any) => void} config.fillForm - Remplit le formulaire à partir d'un enregistrement existant
 * @param {() => void} [config.resetExtras] - Réinitialisations spécifiques après form.reset()
 * @param {() => Object} config.buildPayload
 * @param {(payload: Object) => string|null} config.validatePayload - Retourne un message d'erreur ou null
 */
export function createCrudResource(config) {
    const el = (id) => document.getElementById(id);

    const search = el(config.elements.search);
    const statusFilter = config.elements.statusFilter ? el(config.elements.statusFilter) : null;
    const extraFilters = (config.elements.extraFilters || []).map((id) => el(id));
    const tableBody = el(config.elements.tableBody);
    const emptyState = el(config.elements.emptyState);
    const modal = el(config.elements.modal);
    const form = el(config.elements.form);
    const modalTitle = el(config.elements.modalTitle);
    const titleInput = el(config.elements.titleInput);
    const slugInput = el(config.elements.slugInput);

    let items = [];
    let currentId = null;

    function lockBodyScroll(lock) {
        document.body.style.overflow = lock ? 'hidden' : '';
    }

    function generateSlug(value) {
        return value
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');
    }

    function applyStats(data) {
        const values = config.computeStats(data);
        Object.entries(values).forEach(([id, value]) => {
            const node = el(id);
            if (node) node.textContent = value;
        });
    }

    function currentFilters() {
        const filters = { term: search.value.trim().toLowerCase() };
        if (statusFilter) filters.status = statusFilter.value;
        extraFilters.forEach((node) => {
            if (node) filters[node.id] = node.value;
        });
        return filters;
    }

    function render() {
        if (!items.length) {
            tableBody.innerHTML = '';
            emptyState.classList.remove('hidden');
            return;
        }

        const filters = currentFilters();
        const filtered = items
            .filter((item) => config.matchesFilters(item, filters))
            .sort((a, b) => (a.order ?? 0) - (b.order ?? 0));

        if (!filtered.length) {
            tableBody.innerHTML = '';
            emptyState.classList.remove('hidden');
            return;
        }

        emptyState.classList.add('hidden');
        tableBody.innerHTML = filtered.map((item) => config.renderRow(item)).join('');
    }

    function load() {
        fetch(config.endpoint)
            .then((response) => response.json())
            .then((data) => {
                items = Array.isArray(data) ? data : [];
                applyStats(items);
                render();
            })
            .catch(() => {
                window.showAlert(`Impossible de charger les ${config.entityName}s.`, 'error');
            });
    }

    function openModal(id = null) {
        currentId = id;
        modal.classList.remove('hidden');
        lockBodyScroll(true);
        modalTitle.textContent = id
            ? `Modifier ${config.entityLabel ?? 'un ' + config.entityName}`
            : `Ajouter ${config.entityLabel ?? 'un ' + config.entityName}`;

        if (id) {
            fetch(`${config.endpoint}/${id}`)
                .then((response) => response.json())
                .then((item) => config.fillForm(item))
                .catch(() => {
                    window.showAlert(`Impossible de charger ce ${config.entityName}.`, 'error');
                });
        } else {
            form.reset();
            config.resetExtras?.();
        }
    }

    function closeModal() {
        modal.classList.add('hidden');
        form.reset();
        config.resetExtras?.();
        currentId = null;
        lockBodyScroll(false);
    }

    function deleteItem(id) {
        if (!confirm(`Êtes-vous sûr de vouloir supprimer ce ${config.entityName} ?`)) {
            return;
        }
        fetch(`${config.endpoint}/${id}`, { method: 'DELETE' })
            .then((response) => {
                if (!response.ok) throw new Error();
                return response.json();
            })
            .then(() => {
                window.showAlert(`${config.entityLabelCapitalized ?? 'Élément'} supprimé avec succès.`);
                load();
            })
            .catch(() => {
                window.showAlert(`Impossible de supprimer ce ${config.entityName}.`, 'error');
            });
    }

    async function extractErrorMessage(error) {
        if (error?.message) return error.message;
        if (error?.errors) return Object.values(error.errors).flat().join(' ');
        if (typeof error?.json === 'function') {
            const payload = await error.json().catch(() => null);
            if (payload?.message) return payload.message;
        }
        return 'Erreur lors de la sauvegarde.';
    }

    function handleFormSubmit(event) {
        event.preventDefault();
        const payload = config.buildPayload();

        const validationError = config.validatePayload(payload);
        if (validationError) {
            window.showAlert(validationError, 'error');
            return;
        }

        const url = currentId ? `${config.endpoint}/${currentId}` : config.endpoint;
        const method = currentId ? 'PUT' : 'POST';

        fetch(url, {
            method,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload),
        })
            .then((response) => {
                if (!response.ok) {
                    return response.json().then((err) => { throw err; });
                }
                return response.json();
            })
            .then(() => {
                window.showAlert(`${config.entityLabelCapitalized ?? 'Élément'} ${currentId ? 'modifié' : 'créé'} avec succès.`);
                closeModal();
                load();
            })
            .catch(async (error) => {
                window.showAlert(await extractErrorMessage(error), 'error');
            });
    }

    search.addEventListener('input', render);
    if (statusFilter) statusFilter.addEventListener('change', render);
    extraFilters.forEach((node) => node?.addEventListener('change', render));
    form.addEventListener('submit', handleFormSubmit);
    titleInput.addEventListener('input', () => {
        if (!currentId) {
            slugInput.value = generateSlug(titleInput.value);
        }
    });

    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });

    load();

    return { load, openModal, closeModal, deleteItem };
}
