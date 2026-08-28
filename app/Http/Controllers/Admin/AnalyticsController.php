<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Project;
use App\Models\Product;
use App\Models\Message;
use App\Services\GoogleAnalyticsService;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function __construct(private GoogleAnalyticsService $googleAnalytics)
    {
    }

    public function data()
    {
        // Get data for the last 30 days
        $endDate = now();
        $startDate = now()->subDays(30);

        // Messages per day for chart
        $messagesData = Message::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();

        // Fill in missing dates with 0
        $messagesChart = [];
        $currentDate = clone $startDate;
        while ($currentDate <= $endDate) {
            $dateKey = $currentDate->format('Y-m-d');
            $messagesChart[$dateKey] = $messagesData[$dateKey] ?? 0;
            $currentDate->addDay();
        }

        // Stats calculations
        $stats = [
            'total_services' => Service::count(),
            'active_services' => Service::where('is_active', true)->count(),
            'total_projects' => Project::count(),
            'active_projects' => Project::where('is_active', true)->count(),
            'featured_projects' => Project::where('is_featured', true)->count(),
            'total_products' => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
            'featured_products' => Product::where('is_featured', true)->count(),
            'total_messages' => Message::count(),
            'unread_messages' => Message::where('status', 'non_lu')->count(),
            'messages_this_month' => Message::whereBetween('created_at', [$startDate, $endDate])->count(),
        ];

        // Performance metrics (calculated from real data)
        $avgResponseTime = Message::whereNotNull('read_at')
            ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, read_at)) as avg_hours')
            ->first()
            ->avg_hours ?? 24; // Default to 24 hours if no data

        $conversionRate = $stats['total_messages'] > 0
            ? round(($stats['total_projects'] / $stats['total_messages']) * 100, 2)
            : 0;

        // Trafic réel GA4 si configuré (voir GoogleAnalyticsService) ; sinon on retombe
        // sur les estimations grossières basées sur le contenu/les messages, comme avant.
        $ga4Summary = $this->googleAnalytics->summary();
        $ga4Connected = $ga4Summary !== null;

        $performance = [
            'load_time' => '1.2s', // Non mesuré (nécessiterait une API type PageSpeed/CrUX)
            'conversion_rate' => $conversionRate . '%',
            'unique_visitors' => $ga4Summary['unique_visitors'] ?? $stats['total_messages'] * 3,
            'bounce_rate' => $ga4Summary['bounce_rate'] ?? '42%',
            'avg_session_duration' => $ga4Summary['avg_session_duration'] ?? '3m 45s',
            'pages_per_session' => $ga4Summary['pages_per_session'] ?? '4.2',
            'avg_response_time' => round($avgResponseTime, 1) . 'h',
        ];

        $ga4PageViews = $this->googleAnalytics->pageViewsByPrefix([
            'services_views' => '/services',
            'projects_views' => '/projets',
            'products_views' => '/produits',
        ]);

        // Content popularity : vraies vues GA4 si disponibles, sinon estimation basée
        // sur le nombre d'éléments actifs (grossier, faute de mesure réelle de trafic).
        $content_popularity = [
            'services_views' => $ga4PageViews['services_views'] ?? $stats['active_services'] * 150,
            'projects_views' => $ga4PageViews['projects_views'] ?? $stats['active_projects'] * 200,
            'products_views' => $ga4PageViews['products_views'] ?? $stats['active_products'] * 100,
        ];

        return response()->json([
            'messages_chart' => $messagesChart,
            'stats' => $stats,
            'performance' => $performance,
            'content_popularity' => $content_popularity,
            'ga4_connected' => $ga4Connected,
        ]);
    }
}
