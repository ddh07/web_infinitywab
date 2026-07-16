<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Partner;
use App\Models\Product;
use App\Models\Project;
use App\Models\Service;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(): View
    {
        $company = Company::active()->first();
        $companyStats = $company?->stats ?? [];

        $partners = Partner::active()->ordered()->get();
        $services = Service::active()->ordered()->take(4)->get();
        $projects = Project::active()->ordered()->take(3)->get();
        $carouselHighlights = Project::active()->ordered()->take(4)->get();
        $featuredProducts = Product::active()->featured()->ordered()->take(3)->get();

        $heroStats = [
            ['label' => 'Projets livrés', 'value' => $companyStats['projects_completed'] ?? '250+'],
            ['label' => 'Clients satisfaits', 'value' => $companyStats['satisfied_clients'] ?? '150+'],
            ['label' => 'Support', 'value' => $companyStats['support_availability'] ?? '24/7'],
        ];

        return view('home', compact(
            'company',
            'partners',
            'services',
            'projects',
            'carouselHighlights',
            'featuredProducts',
            'heroStats',
        ));
    }
}

