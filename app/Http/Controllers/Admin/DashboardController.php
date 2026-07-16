<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Project;
use App\Models\Product;
use App\Models\Message;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function stats()
    {
        // Get recent counts for different time periods
        $today = now()->startOfDay();
        $weekAgo = now()->subDays(7);
        $monthAgo = now()->subDays(30);

        return response()->json([
            'services' => [
                'total' => Service::count(),
                'active' => Service::where('is_active', true)->count(),
                'inactive' => Service::where('is_active', false)->count(),
                'recent' => Service::where('created_at', '>=', $monthAgo)->count(),
            ],
            'projects' => [
                'total' => Project::count(),
                'active' => Project::where('is_active', true)->count(),
                'inactive' => Project::where('is_active', false)->count(),
                'featured' => Project::where('is_featured', true)->count(),
                'recent' => Project::where('created_at', '>=', $monthAgo)->count(),
            ],
            'products' => [
                'total' => Product::count(),
                'active' => Product::where('is_active', true)->count(),
                'inactive' => Product::where('is_active', false)->count(),
                'featured' => Product::where('is_featured', true)->count(),
                'recent' => Product::where('created_at', '>=', $monthAgo)->count(),
            ],
            'messages' => [
                'total' => Message::count(),
                'unread' => Message::where('status', 'non_lu')->count(),
                'read' => Message::where('status', 'lu')->count(),
                'treated' => Message::where('status', 'traite')->count(),
                'today' => Message::where('created_at', '>=', $today)->count(),
                'this_week' => Message::where('created_at', '>=', $weekAgo)->count(),
            ],
            'recent_activity' => [
                'latest_service' => Service::select('id', 'title', 'created_at')
                    ->latest()
                    ->first(),
                'latest_project' => Project::select('id', 'title', 'created_at')
                    ->latest()
                    ->first(),
                'latest_product' => Product::select('id', 'title', 'created_at')
                    ->latest()
                    ->first(),
                'latest_message' => Message::select('id', 'name', 'subject', 'created_at')
                    ->latest()
                    ->first(),
            ],
            'system_info' => [
                'total_users' => \App\Models\User::count(),
                'active_users' => \App\Models\User::where('created_at', '>=', $monthAgo)->count(),
            ]
        ]);
    }
}
