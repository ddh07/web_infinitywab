<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Partner;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Afficher les détails de l'entreprise
     */
    public function index()
    {
        $company = Company::active()->first();
        $partners = Partner::active()->ordered()->get();

        return view('company.index', compact('company', 'partners'));
    }

    /**
     * API pour récupérer les informations de l'entreprise
     */
    public function api()
    {
        $company = Company::active()->first();

        if (!$company) {
            return response()->json(['error' => 'Company not found'], 404);
        }

        return response()->json([
            'company' => $company,
            'stats' => $company->stats ?? []
        ]);
    }

    /**
     * API pour récupérer les partenaires
     */
    public function partnersApi()
    {
        $partners = Partner::active()->ordered()->get();

        return response()->json([
            'partners' => $partners
        ]);
    }

    /**
     * API pour récupérer les partenaires par catégorie
     */
    public function partnersByCategory($category)
    {
        $partners = Partner::active()
            ->byCategory($category)
            ->ordered()
            ->get();

        return response()->json([
            'partners' => $partners,
            'category' => $category
        ]);
    }
}
