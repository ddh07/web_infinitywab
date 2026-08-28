@extends('layouts.admin')

@section('title', 'Messages - Admin Infinity WAB')
@section('page-title', 'Messages')

@section('content')
@php
    use Illuminate\Support\Str;

    $messages = \App\Models\Message::latest()->get();
@endphp

<div class="flex flex-col h-[calc(100vh-12rem)] min-h-[560px]" id="mailApp" data-view="list">
    <div class="flex flex-wrap items-center justify-between gap-3 mb-3">
        <div>
            <h1 class="text-lg font-semibold text-ink-primary">Messages</h1>
            <p class="text-xs text-ink-muted">
                <span id="messages-total">Total : {{ $messages->count() }}</span>
                — <span id="messages-unread" class="text-azure-600 dark:text-azure-400 font-medium">Non lus : {{ $messages->where('status', 'non_lu')->count() }}</span>
            </p>
        </div>
    </div>

    <!-- Barre d'outils -->
    <div class="flex flex-wrap items-center gap-2 bg-surface-raised border border-(--border-default) rounded-t-lg px-3 py-2.5">
        <label class="flex items-center px-1 cursor-pointer" title="Tout sélectionner">
            <input type="checkbox" id="selectAll" class="w-4 h-4 rounded border-(--border-default) text-azure-600 focus:ring-azure-500">
        </label>

        <button type="button" id="btnRefresh" title="Actualiser" class="p-2 rounded-lg text-ink-secondary hover:bg-surface-sunken">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
        </button>

        <!-- Barre par défaut : filtres -->
        <div id="toolbarDefault" class="flex items-center gap-1 pl-1 ml-1 border-l border-(--border-default)">
            <button type="button" class="filter-tab px-3 py-1.5 rounded-lg bg-azure-100 text-azure-800 dark:bg-azure-500/10 dark:text-azure-400 text-sm font-medium" data-filter="all">
                Tous
            </button>
            <button type="button" class="filter-tab px-3 py-1.5 rounded-lg text-ink-secondary hover:bg-surface-sunken text-sm font-medium" data-filter="unread">
                Non lus
            </button>
            <button type="button" class="filter-tab px-3 py-1.5 rounded-lg text-ink-secondary hover:bg-surface-sunken text-sm font-medium" data-filter="read">
                Lus
            </button>
        </div>

        <!-- Barre contextuelle : actions groupées (affichée dès qu'une case est cochée) -->
        <div id="toolbarBulk" class="hidden items-center gap-1 pl-1 ml-1 border-l border-(--border-default)">
            <span id="bulkCount" class="text-sm text-ink-secondary font-medium mr-1">0 sélectionné(s)</span>
            <button type="button" id="btnBulkRead" title="Marquer comme lu" class="p-2 rounded-lg text-ink-secondary hover:bg-surface-sunken">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </button>
            <button type="button" id="btnBulkUnread" title="Marquer comme non lu" class="p-2 rounded-lg text-ink-secondary hover:bg-surface-sunken">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    <circle cx="18.5" cy="6.5" r="4" fill="currentColor" stroke="none"/>
                </svg>
            </button>
            <button type="button" id="btnBulkDelete" title="Supprimer" class="p-2 rounded-lg text-ink-secondary hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-500/10">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </button>
        </div>

        <div class="ml-auto relative">
            <svg class="w-4 h-4 text-ink-muted absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/>
            </svg>
            <input type="text" id="searchMessages" placeholder="Rechercher dans les messages" class="pl-9 pr-3 py-2 border border-(--border-default) bg-surface-sunken rounded-lg text-sm w-56 focus:w-72 transition-[width] focus:border-azure-500">
        </div>
    </div>

    <!-- Vue scindée liste / lecture -->
    <div class="flex-1 min-h-0 flex border border-t-0 border-(--border-default) rounded-b-lg overflow-hidden bg-surface-raised">
        <div id="messageListPane" class="w-full lg:w-[380px] xl:w-[420px] flex-shrink-0 border-r border-(--border-default) overflow-y-auto">
            @forelse($messages as $message)
                @php
                    $isUnread = $message->status === 'non_lu';
                    $rowDate = $message->created_at->isToday()
                        ? $message->created_at->format('H:i')
                        : ($message->created_at->isCurrentYear()
                            ? $message->created_at->translatedFormat('d M')
                            : $message->created_at->format('d/m/Y'));
                @endphp
                <div class="message-row group relative flex items-start gap-3 px-3 py-3 cursor-pointer border-b border-(--border-default) hover:bg-surface-sunken {{ $isUnread ? 'is-unread' : '' }}"
                     data-id="{{ $message->id }}"
                     data-read="{{ $isUnread ? 0 : 1 }}"
                     data-name="{{ $message->name }}"
                     data-email="{{ $message->email }}"
                     data-phone="{{ $message->phone }}"
                     data-subject="{{ $message->subject }}"
                     data-message="{{ $message->message }}"
                     data-date="{{ $message->created_at->format('d/m/Y H:i') }}"
                     data-ago="{{ $message->created_at->diffForHumans() }}"
                     data-ip="{{ $message->ip_address }}"
                     data-agent="{{ $message->user_agent }}"
                     tabindex="0"
                     role="button">
                    <span class="unread-bar absolute left-0 top-0 bottom-0 w-1 bg-azure-500 rounded-r"></span>

                    <input type="checkbox" class="row-checkbox mt-1.5 w-4 h-4 rounded border-(--border-default) text-azure-600 flex-shrink-0">

                    <div class="w-9 h-9 rounded-full bg-azure-600 flex items-center justify-center flex-shrink-0 text-white text-xs font-semibold">
                        {{ strtoupper(substr($message->name, 0, 2)) }}
                    </div>

                    <div class="min-w-0 flex-1">
                        <div class="flex items-baseline justify-between gap-2">
                            <span class="row-name truncate text-sm">{{ $message->name }}</span>
                            <span class="row-date flex-shrink-0 text-xs text-ink-muted">{{ $rowDate }}</span>
                            <div class="row-actions flex-shrink-0 items-center gap-0.5">
                                <button type="button" class="p-1.5 rounded hover:bg-surface-raised text-ink-muted" data-quick-action="toggle-read" title="{{ $isUnread ? 'Marquer comme lu' : 'Marquer comme non lu' }}">
                                    <svg class="icon-action-markread w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <svg class="icon-action-markunread w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        <circle cx="18.5" cy="6.5" r="4" fill="currentColor" stroke="none"/>
                                    </svg>
                                </button>
                                <button type="button" class="p-1.5 rounded hover:bg-surface-raised text-ink-muted hover:text-red-600" data-quick-action="delete" title="Supprimer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="row-subject truncate text-sm">{{ $message->subject }}</div>
                        <div class="truncate text-xs text-ink-muted">{{ Str::limit($message->message, 90) }}</div>
                    </div>
                </div>
            @empty
                <div class="p-10 text-center text-ink-muted">
                    <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-sm font-medium text-ink-primary">Aucun message</p>
                    <p class="text-xs">Vous n'avez reçu aucun message pour le moment.</p>
                </div>
            @endforelse
        </div>

        <div id="messageDetailPane" class="hidden lg:flex flex-1 min-w-0 flex-col">
            <div id="detailEmpty" class="flex-1 flex flex-col items-center justify-center text-ink-muted gap-3">
                <svg class="w-14 h-14 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <p class="text-sm">Sélectionnez un message pour l'afficher</p>
            </div>

            <div id="detailContent" class="hidden flex-1 min-h-0 flex-col">
                <div class="flex items-center gap-1 px-4 py-2.5 border-b border-(--border-default)">
                    <button type="button" id="btnBackToList" class="lg:hidden p-2 -ml-1 rounded-lg hover:bg-surface-sunken text-ink-secondary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <button type="button" id="detailToggleRead" class="p-2 rounded-lg hover:bg-surface-sunken text-ink-secondary" title="Marquer comme non lu">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </button>
                    <button type="button" id="detailDelete" class="p-2 rounded-lg hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-500/10 text-ink-secondary" title="Supprimer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>

                <div class="flex-1 min-h-0 overflow-y-auto px-6 py-5 space-y-5">
                    <h2 id="detailSubject" class="text-xl font-semibold text-ink-primary"></h2>

                    <div class="flex items-start gap-3">
                        <div id="detailAvatar" class="w-11 h-11 rounded-full bg-azure-600 flex items-center justify-center flex-shrink-0 text-white font-semibold"></div>
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-baseline gap-x-2">
                                <span id="detailName" class="font-medium text-ink-primary"></span>
                                <span id="detailEmail" class="text-sm text-ink-muted"></span>
                            </div>
                            <div id="detailPhone" class="hidden text-sm text-ink-muted"></div>
                        </div>
                        <div class="flex-shrink-0 text-right text-xs text-ink-muted">
                            <div id="detailDate"></div>
                            <div id="detailAgo"></div>
                        </div>
                    </div>

                    <p id="detailBody" class="text-sm text-ink-secondary whitespace-pre-wrap leading-relaxed"></p>

                    <div class="pt-4 border-t border-(--border-default) flex items-center flex-wrap gap-4">
                        <a id="detailMailto" href="#" class="inline-flex items-center gap-2 text-sm font-medium text-azure-600 hover:text-azure-700">
                            Répondre par email
                        </a>
                        <a id="detailTel" href="#" class="hidden inline-flex items-center gap-2 text-sm font-medium text-mint-600 hover:text-mint-700">
                            Appeler
                        </a>
                    </div>

                    <details class="text-xs text-ink-muted pt-2">
                        <summary class="cursor-pointer select-none">Informations techniques</summary>
                        <div class="mt-2 space-y-1">
                            <div>IP : <span id="detailIp"></span></div>
                            <div>Navigateur : <span id="detailAgent"></span></div>
                        </div>
                    </details>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script nonce="{{ $cspNonce }}">
(function () {
    const mailApp = document.getElementById('mailApp');
    const listPane = document.getElementById('messageListPane');
    const selectAllCheckbox = document.getElementById('selectAll');
    const toolbarDefault = document.getElementById('toolbarDefault');
    const toolbarBulk = document.getElementById('toolbarBulk');
    const bulkCount = document.getElementById('bulkCount');
    const detailEmpty = document.getElementById('detailEmpty');
    const detailContent = document.getElementById('detailContent');
    let currentOpenId = null;
    let currentFilter = 'all';
    let currentSearch = '';

    function rows() {
        return Array.from(listPane.querySelectorAll('.message-row'));
    }

    function findRow(id) {
        return listPane.querySelector(`.message-row[data-id="${id}"]`);
    }

    function visibleRows() {
        return rows().filter(row => row.style.display !== 'none');
    }

    // --- Filtrage (onglets + recherche), combinés plutôt qu'exclusifs ---
    function applyVisibility() {
        rows().forEach(row => {
            const matchesFilter = currentFilter === 'all'
                || (currentFilter === 'unread' && row.dataset.read === '0')
                || (currentFilter === 'read' && row.dataset.read === '1');
            const matchesSearch = !currentSearch || row.textContent.toLowerCase().includes(currentSearch);
            row.style.display = (matchesFilter && matchesSearch) ? '' : 'none';
        });
        updateBulkToolbar();
    }

    document.querySelectorAll('.filter-tab').forEach(function (btn) {
        btn.addEventListener('click', function () {
            currentFilter = btn.dataset.filter;
            document.querySelectorAll('.filter-tab').forEach(other => {
                const active = other === btn;
                other.classList.toggle('bg-azure-100', active);
                other.classList.toggle('text-azure-800', active);
                other.classList.toggle('dark:bg-azure-500/10', active);
                other.classList.toggle('dark:text-azure-400', active);
                other.classList.toggle('text-ink-secondary', !active);
            });
            applyVisibility();
        });
    });

    document.getElementById('searchMessages').addEventListener('input', function (e) {
        currentSearch = e.target.value.toLowerCase();
        applyVisibility();
    });

    document.getElementById('btnRefresh').addEventListener('click', function () {
        location.reload();
    });

    // --- Sélection multiple ---
    function updateBulkToolbar() {
        const selected = rows().filter(r => r.querySelector('.row-checkbox').checked);
        const count = selected.length;
        toolbarBulk.classList.toggle('hidden', count === 0);
        toolbarBulk.classList.toggle('flex', count > 0);
        toolbarDefault.classList.toggle('hidden', count > 0);
        if (count > 0) bulkCount.textContent = `${count} sélectionné${count > 1 ? 's' : ''}`;

        const visible = visibleRows();
        const visibleChecked = visible.filter(r => r.querySelector('.row-checkbox').checked);
        selectAllCheckbox.checked = visible.length > 0 && visibleChecked.length === visible.length;
        selectAllCheckbox.indeterminate = visibleChecked.length > 0 && visibleChecked.length < visible.length;
    }

    selectAllCheckbox.addEventListener('change', function () {
        visibleRows().forEach(row => {
            row.querySelector('.row-checkbox').checked = selectAllCheckbox.checked;
        });
        updateBulkToolbar();
    });

    listPane.addEventListener('change', function (e) {
        if (e.target.classList.contains('row-checkbox')) {
            updateBulkToolbar();
        }
    });

    listPane.querySelectorAll('.row-checkbox').forEach(cb => {
        cb.addEventListener('click', e => e.stopPropagation());
    });

    // --- Ouverture d'un message dans le volet de lecture ---
    function setRowReadState(row, isRead) {
        row.dataset.read = isRead ? '1' : '0';
        row.classList.toggle('is-unread', !isRead);
        const quickBtn = row.querySelector('[data-quick-action="toggle-read"]');
        if (quickBtn) quickBtn.title = isRead ? 'Marquer comme non lu' : 'Marquer comme lu';

        if (currentOpenId === row.dataset.id) {
            const toggleBtn = document.getElementById('detailToggleRead');
            toggleBtn.title = isRead ? 'Marquer comme non lu' : 'Marquer comme lu';
        }
        updateCounters();
        applyVisibility();
    }

    function openMessage(id) {
        const row = findRow(id);
        if (!row) return;
        currentOpenId = id;

        rows().forEach(r => r.classList.remove('bg-azure-100/70', 'dark:bg-azure-500/10'));
        row.classList.add('bg-azure-100/70', 'dark:bg-azure-500/10');

        detailEmpty.classList.add('hidden');
        detailContent.classList.remove('hidden');
        detailContent.classList.add('flex');

        document.getElementById('detailSubject').textContent = row.dataset.subject;
        document.getElementById('detailName').textContent = row.dataset.name;
        document.getElementById('detailEmail').textContent = row.dataset.email;
        document.getElementById('detailAvatar').textContent = row.dataset.name.slice(0, 2).toUpperCase();
        document.getElementById('detailDate').textContent = row.dataset.date;
        document.getElementById('detailAgo').textContent = row.dataset.ago;
        document.getElementById('detailBody').textContent = row.dataset.message;
        document.getElementById('detailIp').textContent = row.dataset.ip || '—';
        document.getElementById('detailAgent').textContent = row.dataset.agent || '—';

        const phoneEl = document.getElementById('detailPhone');
        phoneEl.textContent = row.dataset.phone || '';
        phoneEl.classList.toggle('hidden', !row.dataset.phone);

        document.getElementById('detailMailto').href = `mailto:${row.dataset.email}`;
        const tel = document.getElementById('detailTel');
        if (row.dataset.phone) {
            tel.href = `tel:${row.dataset.phone}`;
            tel.classList.remove('hidden');
        } else {
            tel.classList.add('hidden');
        }

        document.getElementById('detailToggleRead').title = row.dataset.read === '1' ? 'Marquer comme non lu' : 'Marquer comme lu';

        if (mailApp) mailApp.dataset.view = 'detail';

        if (row.dataset.read === '0') {
            markAsRead(id);
        }
    }

    function closeDetail() {
        currentOpenId = null;
        detailContent.classList.add('hidden');
        detailContent.classList.remove('flex');
        detailEmpty.classList.remove('hidden');
        if (mailApp) mailApp.dataset.view = 'list';
    }

    document.getElementById('btnBackToList').addEventListener('click', function () {
        if (mailApp) mailApp.dataset.view = 'list';
    });

    rows().forEach(row => {
        row.addEventListener('click', function (e) {
            if (e.target.closest('.row-checkbox') || e.target.closest('[data-quick-action]')) return;
            openMessage(row.dataset.id);
        });
        row.addEventListener('keydown', function (e) {
            if ((e.key === 'Enter' || e.key === ' ') && !e.target.closest('[data-quick-action]') && !e.target.closest('.row-checkbox')) {
                e.preventDefault();
                openMessage(row.dataset.id);
            }
        });
    });

    // --- Actions unitaires (API existante) ---
    function markAsRead(messageId) {
        const row = findRow(messageId);
        return fetch(`/api/admin/messages/${messageId}/read`, { method: 'POST' })
            .then(r => r.json())
            .then(data => {
                if (data.success && row) setRowReadState(row, true);
            });
    }

    function markAsUnread(messageId) {
        const row = findRow(messageId);
        return fetch(`/api/admin/messages/${messageId}/unread`, { method: 'POST' })
            .then(r => r.json())
            .then(data => {
                if (data.success && row) setRowReadState(row, false);
            });
    }

    function deleteMessages(ids) {
        return Promise.all(ids.map(id => fetch(`/api/admin/messages/${id}`, { method: 'DELETE' }).then(r => r.json())))
            .then(() => {
                ids.forEach(id => {
                    const row = findRow(id);
                    if (row) row.remove();
                    if (currentOpenId === String(id)) closeDetail();
                });
                updateCounters();
                updateBulkToolbar();
            });
    }

    async function confirmDelete(count) {
        const label = count > 1 ? `ces ${count} messages` : 'ce message';
        return window.confirmDialog(`Êtes-vous sûr de vouloir supprimer ${label} ? Cette action est irréversible.`, {
            title: 'Supprimer',
            confirmLabel: 'Supprimer',
        });
    }

    // --- Actions rapides sur une ligne (icônes au survol) ---
    listPane.addEventListener('click', function (e) {
        const actionEl = e.target.closest('[data-quick-action]');
        if (!actionEl) return;
        e.stopPropagation();

        const row = actionEl.closest('.message-row');
        if (!row) return;
        const id = row.dataset.id;
        const action = actionEl.dataset.quickAction;

        if (action === 'toggle-read') {
            row.dataset.read === '1' ? markAsUnread(id) : markAsRead(id);
        } else if (action === 'delete') {
            confirmDelete(1).then(ok => { if (ok) deleteMessages([id]); });
        }
    });

    // --- Actions dans le volet de lecture ---
    document.getElementById('detailToggleRead').addEventListener('click', function () {
        if (!currentOpenId) return;
        const row = findRow(currentOpenId);
        row.dataset.read === '1' ? markAsUnread(currentOpenId) : markAsRead(currentOpenId);
    });

    document.getElementById('detailDelete').addEventListener('click', async function () {
        if (!currentOpenId) return;
        const ok = await confirmDelete(1);
        if (ok) deleteMessages([currentOpenId]);
    });

    // --- Actions groupées ---
    function selectedIds() {
        return rows().filter(r => r.querySelector('.row-checkbox').checked).map(r => r.dataset.id);
    }

    document.getElementById('btnBulkRead').addEventListener('click', function () {
        Promise.all(selectedIds().map(id => markAsRead(id))).then(updateBulkToolbar);
    });

    document.getElementById('btnBulkUnread').addEventListener('click', function () {
        Promise.all(selectedIds().map(id => markAsUnread(id))).then(updateBulkToolbar);
    });

    document.getElementById('btnBulkDelete').addEventListener('click', async function () {
        const ids = selectedIds();
        if (!ids.length) return;
        const ok = await confirmDelete(ids.length);
        if (ok) deleteMessages(ids);
    });

    function updateCounters() {
        const total = rows().length;
        const unread = rows().filter(r => r.dataset.read === '0').length;
        const totalEl = document.getElementById('messages-total');
        const unreadEl = document.getElementById('messages-unread');
        if (totalEl) totalEl.textContent = `Total : ${total}`;
        if (unreadEl) unreadEl.textContent = `Non lus : ${unread}`;
    }

    // --- Raccourcis clavier ---
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && currentOpenId) {
            closeDetail();
        }
    });
})();
</script>
@endpush
@endsection
