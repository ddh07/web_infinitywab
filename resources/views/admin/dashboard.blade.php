@extends('layouts.admin')

@section('title', 'Dashboard - Admin Infinity WAB')
@section('page-title', 'Tableau de bord')

@section('content')
<div class="space-y-6">
    <div class="bg-surface-raised rounded-lg border border-(--border-default) p-5 shadow-sm">
        <h1 class="text-xl font-semibold text-ink-primary">Bonjour, {{ auth()->user()->name }}</h1>
        <p class="text-sm text-ink-muted mt-1">{{ now()->translatedFormat('l d F Y') }} — {{ now()->format('H:i') }}</p>
    </div>

    <section class="grid grid-cols-2 gap-4 lg:grid-cols-4">
        <div class="bg-surface-raised rounded-lg border border-(--border-default) p-4 shadow-sm">
            <p class="text-xs font-medium text-ink-muted uppercase">Services</p>
            <p class="mt-2 text-2xl font-semibold text-ink-primary" id="services-count">0</p>
            <p class="text-xs text-ink-muted"><span id="services-growth">+0%</span> ce mois</p>
        </div>
        <div class="bg-surface-raised rounded-lg border border-(--border-default) p-4 shadow-sm">
            <p class="text-xs font-medium text-ink-muted uppercase">Projets</p>
            <p class="mt-2 text-2xl font-semibold text-ink-primary" id="projects-count">0</p>
            <p class="text-xs text-ink-muted"><span id="projects-growth">+0%</span> ce mois</p>
        </div>
        <div class="bg-surface-raised rounded-lg border border-(--border-default) p-4 shadow-sm">
            <p class="text-xs font-medium text-ink-muted uppercase">Produits</p>
            <p class="mt-2 text-2xl font-semibold text-ink-primary" id="products-count">0</p>
            <p class="text-xs text-ink-muted"><span id="products-growth">+0%</span> ce mois</p>
        </div>
        <div class="bg-surface-raised rounded-lg border border-(--border-default) p-4 shadow-sm">
            <p class="text-xs font-medium text-ink-muted uppercase">Messages</p>
            <p class="mt-2 text-2xl font-semibold text-ink-primary" id="messages-count">0</p>
            <p class="text-xs text-ink-muted"><span id="messages-growth">+0%</span> cette semaine</p>
        </div>
    </section>

    <section class="grid gap-6 lg:grid-cols-3">
        <div class="bg-surface-raised rounded-lg border border-(--border-default) p-5 shadow-sm lg:col-span-2">
            <h2 class="text-base font-semibold text-ink-primary">Actions rapides</h2>
            <div class="mt-4 grid gap-3 sm:grid-cols-2">
                <a href="{{ route('admin.services') }}" class="block rounded-lg border border-(--border-default) p-4 text-sm hover:bg-surface-sunken">
                    <span class="font-medium text-ink-primary">Services</span>
                    <span class="block text-xs text-ink-muted mt-0.5">Créer, modifier, ordonner</span>
                </a>
                <a href="{{ route('admin.projects') }}" class="block rounded-lg border border-(--border-default) p-4 text-sm hover:bg-surface-sunken">
                    <span class="font-medium text-ink-primary">Projets</span>
                    <span class="block text-xs text-ink-muted mt-0.5">Portfolio, technologies</span>
                </a>
                <a href="{{ route('admin.products') }}" class="block rounded-lg border border-(--border-default) p-4 text-sm hover:bg-surface-sunken">
                    <span class="font-medium text-ink-primary">Produits</span>
                    <span class="block text-xs text-ink-muted mt-0.5">Catalogue, prix</span>
                </a>
                <a href="{{ route('admin.messages') }}" class="block rounded-lg border border-(--border-default) p-4 text-sm hover:bg-surface-sunken">
                    <span class="font-medium text-ink-primary">Messages</span>
                    <span class="block text-xs text-ink-muted mt-0.5">Lire, répondre</span>
                </a>
            </div>
        </div>

        <div class="bg-surface-raised rounded-lg border border-(--border-default) p-5 shadow-sm">
            <h2 class="text-base font-semibold text-ink-primary">Messages récents</h2>
            <div class="mt-4 space-y-2" id="recent-messages">
                <div class="rounded-lg border border-(--border-default) bg-surface-sunken p-4 text-center text-sm text-ink-muted">Chargement…</div>
            </div>
            <div class="mt-4 border-t border-(--border-default) pt-3">
                <a href="{{ route('admin.messages') }}" class="text-sm font-medium text-azure-600 hover:text-azure-700 dark:text-azure-400 dark:hover:text-azure-300">Voir tous</a>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script nonce="{{ $cspNonce }}">
document.addEventListener('DOMContentLoaded', function() {
    loadDashboardStats();
    loadRecentMessages();
});

function loadDashboardStats() {
    fetch('/api/admin/dashboard/stats')
        .then(response => response.json())
        .then(data => {
            document.getElementById('services-count').textContent = data.services.total;
            document.getElementById('projects-count').textContent = data.projects.total;
            document.getElementById('products-count').textContent = data.products.total;
            document.getElementById('messages-count').textContent = data.messages.total;

            const servicesGrowth = data.services.total > 0 ? Math.round((data.services.recent / data.services.total) * 100) : 0;
            const projectsGrowth = data.projects.total > 0 ? Math.round((data.projects.recent / data.projects.total) * 100) : 0;
            const productsGrowth = data.products.total > 0 ? Math.round((data.products.recent / data.products.total) * 100) : 0;
            const messagesGrowth = data.messages.total > 0 ? Math.round((data.messages.this_week / data.messages.total) * 100) : 0;

            document.getElementById('services-growth').textContent = `+${servicesGrowth}%`;
            document.getElementById('projects-growth').textContent = `+${projectsGrowth}%`;
            document.getElementById('products-growth').textContent = `+${productsGrowth}%`;
            document.getElementById('messages-growth').textContent = `+${messagesGrowth}%`;
        })
        .catch(() => showAlert('Erreur lors du chargement des statistiques', 'error'));
}

function loadRecentMessages() {
    fetch('/api/admin/messages?limit=4')
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('recent-messages');
            const messages = Array.isArray(data?.data) ? data.data : [];

            if (!messages.length) {
                container.innerHTML = '<div class="rounded-lg border border-(--border-default) bg-surface-sunken p-4 text-center text-sm text-ink-muted">Aucun message.</div>';
                return;
            }

            container.innerHTML = messages.map(message => `
                <div class="rounded-lg border border-(--border-default) bg-surface-sunken p-3 hover:bg-surface-raised">
                    <div class="flex items-start gap-3">
                        <div class="h-8 w-8 flex-shrink-0 rounded-full bg-azure-600 text-white flex items-center justify-center text-xs font-semibold">${(message.name || '?').charAt(0).toUpperCase()}</div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-medium text-ink-primary">${escapeHtml(message.name || '—')}</p>
                            <p class="truncate text-xs text-ink-muted">${escapeHtml(message.subject || '—')} — ${formatDate(message.created_at)}</p>
                        </div>
                    </div>
                </div>
            `).join('');
        })
        .catch(() => {
            document.getElementById('recent-messages').innerHTML = '<div class="rounded-lg border border-(--border-default) bg-red-50 dark:bg-red-500/10 p-4 text-center text-sm text-red-600 dark:text-red-400">Erreur de chargement.</div>';
        });
}

function formatDate(dateString) {
    const date = new Date(dateString);
    if (Number.isNaN(date.getTime())) return '—';
    const now = new Date();
    const diffDays = Math.floor((now - date) / (1000 * 60 * 60 * 24));
    if (diffDays === 0) return 'Aujourd\'hui';
    if (diffDays === 1) return 'Hier';
    if (diffDays < 7) return `Il y a ${diffDays} jours`;
    return date.toLocaleDateString('fr-FR');
}

function escapeHtml(value) {
    return String(value).replaceAll('&', '&amp;').replaceAll('<', '&lt;').replaceAll('>', '&gt;').replaceAll('"', '&quot;').replaceAll("'", '&#039;');
}
</script>
@endpush
