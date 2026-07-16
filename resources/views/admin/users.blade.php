@extends('layouts.admin')

@section('title', 'Utilisateurs - Admin Infinity WAB')
@section('page-title', 'Utilisateurs')

@section('content')
<div class="space-y-6">
    <section class="bg-white rounded-lg border border-slate-200 p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-200 pb-4">
            <div>
                <h2 class="text-lg font-semibold text-slate-800">Utilisateurs</h2>
                <p class="text-xs text-slate-500 mt-0.5">Comptes admin / staff</p>
            </div>
            <button type="button" onclick="openUserModal()" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                Nouvel utilisateur
            </button>
        </div>

        <div class="mt-4 flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[200px]">
                <input id="userSearch" type="search" placeholder="Rechercher…" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-700 focus:border-indigo-500">
            </div>
        </div>

        <div class="mt-4 overflow-hidden rounded-lg border border-slate-200">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                        <tr>
                            <th class="px-5 py-3">Utilisateur</th>
                            <th class="px-5 py-3">Email</th>
                            <th class="px-5 py-3">Rôle</th>
                            <th class="px-5 py-3">Verification</th>
                            <th class="px-5 py-3">Créé</th>
                            <th class="px-5 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody">
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-sm text-slate-400">Chargement des utilisateurs...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="usersEmptyState" class="hidden px-5 py-10 text-center text-sm text-slate-500">
                <p class="text-lg font-semibold text-slate-900">Aucun utilisateur à afficher</p>
                <p>Créez un nouvel utilisateur ou ajustez votre recherche.</p>
            </div>
        </div>
    </section>
</div>

<div
    id="userModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4 py-10"
    role="dialog"
    aria-modal="true"
    aria-labelledby="userModalTitle"
>
    <div class="w-full max-w-2xl rounded-lg bg-white p-6 shadow-xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-slate-800" id="userModalTitle">Ajouter un utilisateur</h3>
            </div>
            <button type="button" onclick="closeUserModal()" class="rounded-lg bg-slate-100 p-2 text-slate-600 hover:bg-slate-200">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form id="userForm" class="mt-6 space-y-5" novalidate>
            <input type="hidden" id="userId">

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="block text-xs font-medium text-slate-600">Nom *</label>
                    <input type="text" id="userName" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-700 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-600">Email *</label>
                    <input type="email" id="userEmail" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-700 focus:border-indigo-500">
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-6">
                <label class="flex items-center gap-2 text-sm text-slate-700">
                    <input type="checkbox" id="userIsAdmin" class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    Administrateur
                </label>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="block text-xs font-medium text-slate-600">Mot de passe</label>
                    <input type="password" id="userPassword" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-700 focus:border-indigo-500" autocomplete="new-password">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-600">Confirmation</label>
                    <input type="password" id="userPasswordConfirmation" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-700 focus:border-indigo-500" autocomplete="new-password">
                </div>
            </div>

            <div class="flex justify-center gap-3 pt-4 border-t border-slate-200 sticky bottom-0 bg-white">
                <button type="button" onclick="closeUserModal()" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">
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
    const userSearch = document.getElementById('userSearch');
    const usersTableBody = document.getElementById('usersTableBody');
    const usersEmptyState = document.getElementById('usersEmptyState');
    const userModal = document.getElementById('userModal');
    const userForm = document.getElementById('userForm');
    const userModalTitle = document.getElementById('userModalTitle');

    const userIdInput = document.getElementById('userId');
    const userNameInput = document.getElementById('userName');
    const userEmailInput = document.getElementById('userEmail');
    const userIsAdminInput = document.getElementById('userIsAdmin');
    const userPasswordInput = document.getElementById('userPassword');
    const userPasswordConfirmationInput = document.getElementById('userPasswordConfirmation');

    let usersData = [];
    let currentUserId = null;

    function lockBodyScroll(lock) {
        document.body.style.overflow = lock ? 'hidden' : '';
    }

    function formatDate(value) {
        if (!value) return '—';
        const date = new Date(value);
        if (Number.isNaN(date.getTime())) return '—';
        return new Intl.DateTimeFormat('fr-FR').format(date);
    }

    function renderUsers() {
        const term = userSearch?.value?.trim().toLowerCase() || '';

        const filtered = usersData.filter((u) => {
            if (!term) return true;
            return `${u.name ?? ''} ${u.email ?? ''}`.toLowerCase().includes(term);
        });

        if (!filtered.length) {
            usersTableBody.innerHTML = '';
            usersEmptyState.classList.remove('hidden');
            return;
        }

        usersEmptyState.classList.add('hidden');

        const rows = filtered.map((user) => `
            <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                <td class="px-5 py-4 font-semibold text-slate-900">${user.name ?? '—'}</td>
                <td class="px-5 py-4 text-slate-700">${user.email ?? '—'}</td>
                <td class="px-5 py-4">
                    <span class="inline-flex items-center rounded-full px-3 py-1 text-[11px] font-semibold ${user.is_admin ? 'bg-indigo-100 text-indigo-700' : 'bg-slate-200 text-slate-700'}">
                        ${user.is_admin ? 'Admin' : 'Staff'}
                    </span>
                </td>
                <td class="px-5 py-4">
                    <span class="inline-flex items-center rounded-full px-3 py-1 text-[11px] font-semibold ${user.email_verified_at ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700'}">
                        ${user.email_verified_at ? 'Verifie' : 'Non verifie'}
                    </span>
                </td>
                <td class="px-5 py-4 text-slate-600">${formatDate(user.created_at)}</td>
                <td class="px-5 py-4 text-sm font-semibold text-slate-700">
                    <button type="button" onclick="openUserModal(${user.id})" class="mr-3 text-indigo-600 hover:text-indigo-900">Modifier</button>
                    ${!user.email_verified_at ? `<button type="button" onclick="resendVerificationEmail(${user.id})" class="mr-3 text-amber-600 hover:text-amber-900">Renvoyer verification</button>` : ''}
                    <button type="button" onclick="deleteUser(${user.id})" class="text-rose-600 hover:text-rose-900">Supprimer</button>
                </td>
            </tr>
        `).join('');

        usersTableBody.innerHTML = rows;
    }

    function loadUsers() {
        fetch('/api/admin/users')
            .then((response) => response.json())
            .then((data) => {
                usersData = Array.isArray(data) ? data : [];
                renderUsers();
            })
            .catch(() => {
                usersTableBody.innerHTML = '';
                usersEmptyState.classList.remove('hidden');
                usersEmptyState.innerHTML = '<p class="text-lg font-semibold text-slate-900">Erreur de chargement</p>';
            });
    }

    function resetForm() {
        userForm.reset();
        userIdInput.value = '';
        currentUserId = null;
        userIsAdminInput.checked = false;
    }

    function openUserModal(userId = null) {
        currentUserId = userId;
        userModal.classList.remove('hidden');
        lockBodyScroll(true);
        userModalTitle.textContent = userId ? 'Modifier un utilisateur' : 'Ajouter un utilisateur';

        if (!userId) {
            resetForm();
            userIsAdminInput.checked = false;
            userPasswordInput.required = true;
            userPasswordConfirmationInput.required = true;
            return;
        }

        userPasswordInput.required = false;
        userPasswordConfirmationInput.required = false;

        fetch(`/api/admin/users/${userId}`)
            .then((response) => response.json())
            .then((user) => {
                userIdInput.value = user.id;
                userNameInput.value = user.name ?? '';
                userEmailInput.value = user.email ?? '';
                userIsAdminInput.checked = Boolean(user.is_admin);
                userPasswordInput.value = '';
                userPasswordConfirmationInput.value = '';
            })
            .catch(() => {
                showAlert('Impossible de charger cet utilisateur.', 'error');
                closeUserModal();
            });
    }

    function closeUserModal() {
        userModal.classList.add('hidden');
        userForm.reset();
        userIdInput.value = '';
        currentUserId = null;
        lockBodyScroll(false);
    }

    function deleteUser(userId) {
        if (!confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) return;

        fetch(`/api/admin/users/${userId}`, { method: 'DELETE' })
            .then(async (response) => {
                const payload = await response.json().catch(() => null);
                if (!response.ok) {
                    const message = payload?.message || 'Suppression impossible.';
                    throw new Error(message);
                }
                return payload;
            })
            .then(() => {
                showAlert('Utilisateur supprimé avec succès.', 'success');
                loadUsers();
            })
            .catch((err) => {
                showAlert(err?.message || 'Erreur lors de la suppression.', 'error');
            });
    }

    function resendVerificationEmail(userId) {
        fetch(`/api/admin/users/${userId}/resend-verification`, { method: 'POST' })
            .then(async (response) => {
                const payload = await response.json().catch(() => null);
                if (!response.ok) {
                    const message = payload?.message || 'Envoi impossible.';
                    throw new Error(message);
                }
                return payload;
            })
            .then((payload) => {
                showAlert(payload?.message || 'Email de verification renvoye.', 'success');
            })
            .catch((err) => {
                showAlert(err?.message || 'Erreur lors de l envoi du mail de verification.', 'error');
            });
    }

    function handleSubmit(event) {
        event.preventDefault();

        const isCreate = !currentUserId;

        const payload = {
            name: userNameInput.value.trim(),
            email: userEmailInput.value.trim(),
            is_admin: Boolean(userIsAdminInput.checked),
        };

        const password = userPasswordInput.value.trim();
        const passwordConfirmation = userPasswordConfirmationInput.value.trim();

        if (isCreate) {
            if (!payload.name || !payload.email) {
                showAlert('Nom et email sont requis.', 'error');
                return;
            }
            if (!password || !passwordConfirmation) {
                showAlert('Le mot de passe et sa confirmation sont requis.', 'error');
                return;
            }
            if (password !== passwordConfirmation) {
                showAlert('La confirmation du mot de passe ne correspond pas.', 'error');
                return;
            }
            payload.password = password;
            payload.password_confirmation = passwordConfirmation;
        } else {
            // Mise à jour : le mot de passe est optionnel
            if (password || passwordConfirmation) {
                if (!password || !passwordConfirmation) {
                    showAlert('Pour changer le mot de passe, remplissez les deux champs.', 'error');
                    return;
                }
                if (password !== passwordConfirmation) {
                    showAlert('La confirmation du mot de passe ne correspond pas.', 'error');
                    return;
                }
                payload.password = password;
                payload.password_confirmation = passwordConfirmation;
            }
        }

        const url = currentUserId ? `/api/admin/users/${currentUserId}` : '/api/admin/users';
        const method = currentUserId ? 'PUT' : 'POST';

        fetch(url, {
            method,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload),
        })
            .then(async (response) => {
                const data = await response.json().catch(() => null);
                if (!response.ok) {
                    const message = data?.message || (data?.errors ? Object.values(data.errors).flat().join(' ') : 'Erreur lors de la sauvegarde.');
                    throw new Error(message);
                }
                return data;
            })
            .then(() => {
                showAlert(`Utilisateur ${currentUserId ? 'mis à jour' : 'créé'} avec succès.`, 'success');
                closeUserModal();
                loadUsers();
            })
            .catch((err) => {
                showAlert(err?.message || 'Erreur lors de la sauvegarde.', 'error');
            });
    }

    userSearch?.addEventListener('input', renderUsers);
    userForm.addEventListener('submit', handleSubmit);

    // Close modal on background click + ESC
    userModal?.addEventListener('click', (e) => {
        if (e.target === userModal) closeUserModal();
    });
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && userModal && !userModal.classList.contains('hidden')) {
            closeUserModal();
        }
    });

    window.openUserModal = openUserModal;
    window.closeUserModal = closeUserModal;
    window.deleteUser = deleteUser;
    window.resendVerificationEmail = resendVerificationEmail;

    loadUsers();
});
</script>
@endpush

