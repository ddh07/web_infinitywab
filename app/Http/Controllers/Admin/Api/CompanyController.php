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
            'whatsapp' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'vision' => 'nullable|array',
            'vision.*.title' => 'nullable|string|max:500',
            'vision.*.body' => 'nullable|string|max:1000',
            'vision.*.icon' => 'nullable|string|max:50',
            'vision.*.image' => 'nullable|string|max:2048',
            'mission' => 'nullable|array',
            'mission.*.title' => 'nullable|string|max:500',
            'mission.*.body' => 'nullable|string|max:1000',
            'mission.*.icon' => 'nullable|string|max:50',
            'mission.*.image' => 'nullable|string|max:2048',
            'values' => 'nullable|array',
            'values.*.title' => 'nullable|string|max:255',
            'values.*.body' => 'nullable|string|max:1000',
            'values.*.icon' => 'nullable|string|max:50',
            'values.*.image' => 'nullable|string|max:2048',
            'display_mode' => 'nullable|string|in:list,cards,timeline,feature-cards,feature-centered,feature-image',
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
