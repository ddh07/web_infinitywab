<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    protected array $iconLabel = [
        'monitor' => 'Maintenance & Hardware',
        'wifi' => 'Réseaux & Infrastructure',
        'code' => 'Développement & Intégration',
        'cog' => 'Ops & Automatisation',
        'lightbulb' => 'Innovation & Conseil',
        'academic-cap' => 'Formation Tech',
    ];

    public function index()
    {
        $services = Service::active()
            ->ordered()
            ->get();

        $featuredServices = $services
            ->filter(fn($service) => $service->is_featured ?? false)
            ->values()
            ->take(3);

        $serviceSummary = [
            'total' => $services->count(),
            'categories' => $services->pluck('icon')->filter()->unique()->count(),
            'with_content' => $services->filter(fn($service) => filled($service->content))->count(),
        ];

        $categoryChips = $services->pluck('icon')->filter()->unique()->mapWithKeys(function ($icon) {
            $label = $this->iconLabel[$icon] ?? Str::headline($icon);
            return [$icon => $label];
        });

        return view('services', compact('services', 'featuredServices', 'serviceSummary', 'categoryChips'));
    }

    public function show($slug)
    {
        $service = Service::active()
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedServices = Service::active()
            ->where('id', '!=', $service->id)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('service-detail', compact('service', 'relatedServices'));
    }
}
