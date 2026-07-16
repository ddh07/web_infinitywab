@extends('layouts.admin')

@section('title', 'Dashboard - Admin Infinity WAB')
@section('page-title', 'Tableau de bord')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-lg border border-slate-200 p-5 shadow-sm">
        <h1 class="text-xl font-semibold text-slate-800">Bonjour, {{ auth()->user()->name }}</h1>
        <p class="text-sm text-slate-500 mt-1">{{ now()->translatedFormat('l d F Y') }} — {{ now()->format('H:i') }}</p>
    </div>

    <section class="grid grid-cols-2 gap-4 lg:grid-cols-4">
        <div class="bg-white rounded-lg border border-slate-200 p-4 shadow-sm">
            <p class="text-xs font-medium text-slate-500 uppercase">Services</p>
            <p class="mt-2 text-2xl font-semibold text-slate-800" id="services-count">0</p>
            <p class="text-xs text-slate-500"><span id="services-growth">+0%</span> ce mois</p>
        </div>
        <div class="bg-white rounded-lg border border-slate-200 p-4 shadow-sm">
            <p class="text-xs font-medium text-slate-500 uppercase">Projets</p>
            <p class="mt-2 text-2xl font-semibold text-slate-800" id="projects-count">0</p>
            <p class="text-xs text-slate-500"><span id="projects-growth">+0%</span> ce mois</p>
        </div>
        <div class="bg-white rounded-lg border border-slate-200 p-4 shadow-sm">
            <p class="text-xs font-medium text-slate-500 uppercase">Produits</p>
            <p class="mt-2 text-2xl font-semibold text-slate-800" id="products-count">0</p>
            <p class="text-xs text-slate-500"><span id="products-growth">+0%</span> ce mois</p>
        </div>
        <div class="bg-white rounded-lg border border-slate-200 p-4 shadow-sm">
            <p class="text-xs font-medium text-slate-500 uppercase">Messages</p>
            <p class="mt-2 text-2xl font-semibold text-slate-800" id="messages-count">0</p>
            <p class="text-xs text-slate-500"><span id="messages-growth">+0%</span> cette semaine</p>
        </div>
    </section>

    <section class="grid gap-6 lg:grid-cols-3">
        <div class="bg-white rounded-lg border border-slate-200 p-5 shadow-sm lg:col-span-2">
            <h2 class="text-base font-semibold text-slate-800">Actions rapides</h2>
            <div class="mt-4 grid gap-3 sm:grid-cols-2">
                <a href="{{ route('admin.services') }}" class="block rounded-lg border border-slate-200 p-4 text-sm hover:bg-slate-50">
                    <span class="font-medium text-slate-800">Services</span>
                    <span class="block text-xs text-slate-500 mt-0.5">Créer, modifier, ordonner</span>
                </a>
                <a href="{{ route('admin.projects') }}" class="block rounded-lg border border-slate-200 p-4 text-sm hover:bg-slate-50">
                    <span class="font-medium text-slate-800">Projets</span>
                    <span class="block text-xs text-slate-500 mt-0.5">Portfolio, technologies</span>
                </a>
                <a href="{{ route('admin.products') }}" class="block rounded-lg border border-slate-200 p-4 text-sm hover:bg-slate-50">
                    <span class="font-medium text-slate-800">Produits</span>
                    <span class="block text-xs text-slate-500 mt-0.5">Catalogue, prix</span>
                </a>
                <a href="{{ route('admin.messages') }}" class="block rounded-lg border border-slate-200 p-4 text-sm hover:bg-slate-50">
                    <span class="font-medium text-slate-800">Messages</span>
                    <span class="block text-xs text-slate-500 mt-0.5">Lire, répondre</span>
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-slate-200 p-5 shadow-sm">
            <h2 class="text-base font-semibold text-slate-800">Messages récents</h2>
            <div class="mt-4 space-y-2" id="recent-messages">
                <div class="rounded-lg border border-slate-200 bg-slate-50 p-4 text-center text-sm text-slate-500">Chargement…</div>
            </div>
            <div class="mt-4 border-t border-slate-200 pt-3">
                <a href="{{ route('admin.messages') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700">Voir tous</a>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
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
                container.innerHTML = '<div class="rounded-lg border border-slate-200 bg-slate-50 p-4 text-center text-sm text-slate-500">Aucun message.</div>';
                return;
            }

            container.innerHTML = messages.map(message => `
                <div class="rounded-lg border border-slate-200 bg-slate-50 p-3 hover:bg-white">
                    <div class="flex items-start gap-3">
                        <div class="h-8 w-8 flex-shrink-0 rounded-full bg-indigo-600 text-white flex items-center justify-center text-xs font-semibold">${(message.name || '?').charAt(0).toUpperCase()}</div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-medium text-slate-800">${escapeHtml(message.name || '—')}</p>
                            <p class="truncate text-xs text-slate-500">${escapeHtml(message.subject || '—')} — ${formatDate(message.created_at)}</p>
                        </div>
                    </div>
                </div>
            `).join('');
        })
        .catch(() => {
            document.getElementById('recent-messages').innerHTML = '<div class="rounded-lg border border-slate-200 bg-red-50 p-4 text-center text-sm text-red-600">Erreur de chargement.</div>';
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
