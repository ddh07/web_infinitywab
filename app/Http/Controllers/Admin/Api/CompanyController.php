<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function show()
    {
        $company = Company::active()->first();
        return response()->json($company);
    }

    public function update(Request $request)
    {
        $company = Company::active()->first() ?? new Company();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email:filter|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'stats' => 'nullable|array',
            'social_links' => 'nullable|array',
            'is_active' => 'boolean'
        ]);

        $company->fill($validated);
        $company->is_active = true;
        $company->save();
        
        return response()->json($company);
    }
}
