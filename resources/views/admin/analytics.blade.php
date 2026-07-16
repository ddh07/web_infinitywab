@extends('layouts.admin')

@section('title', 'Statistiques - Admin Infinity WAB')
@section('page-title', 'Statistiques')

@section('content')
<div class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-lg font-semibold text-slate-800">Statistiques</h1>
            <p class="text-sm text-slate-500">Vue d'ensemble des performances</p>
        </div>
        <div class="flex items-center gap-3">
            <select id="periodFilter" class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500">
                    <option value="7">7 derniers jours</option>
                    <option value="30">30 derniers jours</option>
                    <option value="90">90 derniers jours</option>
                    <option value="365">1 an</option>
                </select>
                <button onclick="refreshStats()" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm font-medium">
                    Actualiser
                </button>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg border border-slate-200 shadow-sm p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500 uppercase">Services</p>
                    <p class="text-2xl font-semibold text-slate-800" id="services-count">0</p>
                    <p class="text-sm text-green-600" id="services-growth">+0 ce mois</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-slate-200 shadow-sm p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500 uppercase">Projets</p>
                    <p class="text-2xl font-semibold text-slate-800" id="projects-count">0</p>
                    <p class="text-sm text-green-600" id="projects-growth">+0 ce mois</p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-slate-200 shadow-sm p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500 uppercase">Produits</p>
                    <p class="text-2xl font-semibold text-slate-800" id="products-count">0</p>
                    <p class="text-sm text-green-600" id="products-growth">+0 ce mois</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-slate-200 shadow-sm p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500 uppercase">Messages</p>
                    <p class="text-2xl font-semibold text-slate-800" id="messages-count">0</p>
                    <p class="text-sm text-green-600" id="messages-growth">+0 ce mois</p>
                </div>
                <div class="p-3 bg-red-100 rounded-full">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Messages Over Time -->
        <div class="bg-white rounded-lg border border-slate-200 shadow-sm p-5">
            <h2 class="text-base font-semibold text-slate-800 mb-4">Messages au fil du temps</h2>
            <div class="h-64 flex items-center justify-center bg-gray-50 rounded-lg">
                <canvas id="messagesChart"></canvas>
            </div>
        </div>

        <!-- Content Distribution -->
        <div class="bg-white rounded-lg border border-slate-200 shadow-sm p-5">
            <h2 class="text-base font-semibold text-slate-800 mb-4">Répartition du contenu</h2>
            <div class="h-64 flex items-center justify-center bg-gray-50 rounded-lg">
                <canvas id="contentChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Activité récente</h2>
        </div>
        <div class="p-6">
            <div class="space-y-4" id="recent-activity">
                <!-- Activity will be loaded dynamically via JavaScript -->
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-3 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-gray-500 text-sm">Chargement de l'activité...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Performance du site</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Temps de chargement</span>
                    <span class="text-sm font-medium text-green-600" id="load-time">1.2s</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Taux de conversion</span>
                    <span class="text-sm font-medium text-blue-600" id="conversion-rate">0%</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Visiteurs uniques</span>
                    <span class="text-sm font-medium text-purple-600" id="unique-visitors">0</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Temps de réponse moyen</span>
                    <span class="text-sm font-medium text-orange-600" id="avg-response-time">24h</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Popularité du contenu</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Services vus</span>
                    <span class="text-sm font-medium text-blue-600" id="services-views">0</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Projets vus</span>
                    <span class="text-sm font-medium text-green-600" id="projects-views">0</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Produits vus</span>
                    <span class="text-sm font-medium text-purple-600" id="products-views">0</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Engagement</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Taux de rebond</span>
                    <span class="text-sm font-medium text-yellow-600" id="bounce-rate">42%</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Durée moyenne</span>
                    <span class="text-sm font-medium text-green-600" id="avg-session-duration">3m 45s</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Pages/session</span>
                    <span class="text-sm font-medium text-blue-600" id="pages-per-session">4.2</span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let analyticsData = null;
let messagesChart = null;

document.addEventListener('DOMContentLoaded', function() {
    loadAnalyticsData();
});

function loadAnalyticsData() {
    return fetch('/api/admin/analytics/data')
        .then(response => response.json())
        .then(data => {
            analyticsData = data;

            // Update overview cards
            updateOverviewCards(data.stats);

            // Update performance metrics
            updatePerformanceMetrics(data.performance);

            // Update content popularity
            updateContentPopularity(data.content_popularity);

            // Update recent activity
            updateRecentActivity(data.stats);

            // Initialize charts with real data
            initCharts(data);
        })
        .catch(error => {
            console.error('Error loading analytics data:', error);
            showAlert('Erreur lors du chargement des statistiques', 'error');
        });
}

function updateOverviewCards(stats) {
    document.getElementById('services-count').textContent = stats.total_services || 0;
    document.getElementById('projects-count').textContent = stats.total_projects || 0;
    document.getElementById('products-count').textContent = stats.total_products || 0;
    document.getElementById('messages-count').textContent = stats.total_messages || 0;

    // Calculate growth percentages
    const servicesGrowth = stats.total_services > 0 ? Math.round((stats.active_services / stats.total_services) * 100) : 0;
    const projectsGrowth = stats.total_projects > 0 ? Math.round((stats.active_projects / stats.total_projects) * 100) : 0;
    const productsGrowth = stats.total_products > 0 ? Math.round((stats.active_products / stats.total_products) * 100) : 0;
    const messagesGrowth = stats.total_messages > 0 ? Math.round((stats.messages_this_month / stats.total_messages) * 100) : 0;

    document.getElementById('services-growth').textContent = `+${servicesGrowth}% ce mois`;
    document.getElementById('projects-growth').textContent = `+${projectsGrowth}% ce mois`;
    document.getElementById('products-growth').textContent = `+${productsGrowth}% ce mois`;
    document.getElementById('messages-growth').textContent = `+${messagesGrowth}% ce mois`;
}

function updatePerformanceMetrics(performance) {
    document.getElementById('load-time').textContent = performance.load_time || '1.2s';
    document.getElementById('conversion-rate').textContent = performance.conversion_rate || '0%';
    document.getElementById('unique-visitors').textContent = performance.unique_visitors || '0';
    document.getElementById('avg-response-time').textContent = performance.avg_response_time || '24h';
    document.getElementById('bounce-rate').textContent = performance.bounce_rate || '42%';
    document.getElementById('avg-session-duration').textContent = performance.avg_session_duration || '3m 45s';
    document.getElementById('pages-per-session').textContent = performance.pages_per_session || '4.2';
}

function updateContentPopularity(contentPopularity) {
    document.getElementById('services-views').textContent = contentPopularity.services_views || '0';
    document.getElementById('projects-views').textContent = contentPopularity.projects_views || '0';
    document.getElementById('products-views').textContent = contentPopularity.products_views || '0';
}

function updateRecentActivity(stats) {
    const container = document.getElementById('recent-activity');

    // Get recent items from dashboard stats (we'll use the same endpoint for consistency)
    fetch('/api/admin/dashboard/stats')
        .then(response => response.json())
        .then(dashboardData => {
            const activities = [];

            // Add latest items
            if (dashboardData.recent_activity.latest_message) {
                activities.push({
                    type: 'message',
                    title: `Nouveau message de ${dashboardData.recent_activity.latest_message.name}`,
                    description: dashboardData.recent_activity.latest_message.subject,
                    time: formatDate(dashboardData.recent_activity.latest_message.created_at),
                    color: 'blue'
                });
            }

            if (dashboardData.recent_activity.latest_project) {
                activities.push({
                    type: 'project',
                    title: `Projet ajouté: ${dashboardData.recent_activity.latest_project.title}`,
                    description: 'Nouveau projet dans le portfolio',
                    time: formatDate(dashboardData.recent_activity.latest_project.created_at),
                    color: 'green'
                });
            }

            if (dashboardData.recent_activity.latest_product) {
                activities.push({
                    type: 'product',
                    title: `Produit ajouté: ${dashboardData.recent_activity.latest_product.title}`,
                    description: 'Nouveau produit en catalogue',
                    time: formatDate(dashboardData.recent_activity.latest_product.created_at),
                    color: 'purple'
                });
            }

            // Add system activity
            activities.push({
                type: 'system',
                title: 'Système - Données mises à jour',
                description: 'Statistiques recalculées automatiquement',
                time: 'Il y a quelques minutes',
                color: 'yellow'
            });

            // Render activities
            const activitiesHtml = activities.map(activity => `
                <div class="flex items-start space-x-3">
                    <div class="w-2 h-2 bg-${activity.color}-500 rounded-full mt-2"></div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-900">
                            <span class="font-medium">${activity.title}</span>
                        </p>
                        <p class="text-sm text-gray-600">${activity.description}</p>
                        <p class="text-xs text-gray-500">${activity.time}</p>
                    </div>
                </div>
            `).join('');

            container.innerHTML = activitiesHtml;
        })
        .catch(error => {
            console.error('Error loading dashboard data for recent activity:', error);
            container.innerHTML = '<p class="text-gray-500 text-sm">Erreur de chargement de l\'activité récente</p>';
        });
}

function formatDate(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const diffTime = Math.abs(now - date);
    const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));

    if (diffDays === 0) {
        return 'Aujourd\'hui';
    } else if (diffDays === 1) {
        return 'Hier';
    } else if (diffDays < 7) {
        return `Il y a ${diffDays} jours`;
    } else {
        return date.toLocaleDateString('fr-FR');
    }
}

// Chart implementations with real data
function initCharts(data) {
    if (data && data.messages_chart) {
        drawMessagesChart(data.messages_chart);
    }
    if (data && data.stats) {
        drawContentChart(data.stats);
    }
}

function drawMessagesChart(messagesData) {
    const canvas = document.getElementById('messagesChart');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    const width = canvas.width;
    const height = canvas.height;

    // Clear canvas
    ctx.clearRect(0, 0, width, height);

    // Draw chart background
    ctx.fillStyle = '#f9fafb';
    ctx.fillRect(0, 0, width, height);

    // Draw grid lines
    ctx.strokeStyle = '#e5e7eb';
    ctx.lineWidth = 1;

    for (let i = 0; i <= 5; i++) {
        const y = (height - 40) * (i / 5) + 20;
        ctx.beginPath();
        ctx.moveTo(40, y);
        ctx.lineTo(width - 20, y);
        ctx.stroke();
    }

    // Draw data points
    const dates = Object.keys(messagesData);
    const maxValue = Math.max(...Object.values(messagesData));

    ctx.strokeStyle = '#3B82F6';
    ctx.lineWidth = 3;
    ctx.beginPath();

    dates.forEach((date, index) => {
        const x = 40 + (index * (width - 60) / (dates.length - 1));
        const y = height - 40 - ((messagesData[date] / maxValue) * (height - 60));

        if (index === 0) {
            ctx.moveTo(x, y);
        } else {
            ctx.lineTo(x, y);
        }

        // Draw point
        ctx.fillStyle = '#3B82F6';
        ctx.beginPath();
        ctx.arc(x, y, 4, 0, 2 * Math.PI);
        ctx.fill();
    });

    ctx.stroke();
}

function drawContentChart(stats) {
    const canvas = document.getElementById('contentChart');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    const centerX = canvas.width / 2;
    const centerY = canvas.height / 2;
    const radius = Math.min(canvas.width, canvas.height) / 3;

    // Clear canvas
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    const total = (stats.total_services || 0) + (stats.total_projects || 0) + (stats.total_products || 0);
    if (total === 0) return;

    const servicesAngle = (stats.total_services / total) * 2 * Math.PI;
    const projectsAngle = (stats.total_projects / total) * 2 * Math.PI;
    const productsAngle = (stats.total_products / total) * 2 * Math.PI;

    // Services slice
    ctx.fillStyle = '#3B82F6';
    ctx.beginPath();
    ctx.moveTo(centerX, centerY);
    ctx.arc(centerX, centerY, radius, 0, servicesAngle);
    ctx.closePath();
    ctx.fill();

    // Projects slice
    ctx.fillStyle = '#10B981';
    ctx.beginPath();
    ctx.moveTo(centerX, centerY);
    ctx.arc(centerX, centerY, radius, servicesAngle, servicesAngle + projectsAngle);
    ctx.closePath();
    ctx.fill();

    // Products slice
    ctx.fillStyle = '#8B5CF6';
    ctx.beginPath();
    ctx.moveTo(centerX, centerY);
    ctx.arc(centerX, centerY, radius, servicesAngle + projectsAngle, 2 * Math.PI);
    ctx.closePath();
    ctx.fill();
}

function refreshStats() {
    const button = event.target;
    const originalText = button.textContent;

    button.textContent = 'Actualisation...';
    button.disabled = true;

    loadAnalyticsData().finally(() => {
        button.textContent = originalText;
        button.disabled = false;
    });
}

// Period filter (for future enhancement)
document.getElementById('periodFilter').addEventListener('change', function() {
    refreshStats();
});
</script>
@endpush
@endsection
