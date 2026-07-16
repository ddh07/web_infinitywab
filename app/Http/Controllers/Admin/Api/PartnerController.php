<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::active()->ordered()->get();
        return response()->json($partners);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'website' => 'nullable|url',
            'logo' => 'nullable|string|max:255',
            'category' => 'required|in:technology,financial',
            // Compat UI: "order" dans les formulaires, "sort_order" en base.
            'order' => 'nullable|integer',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? $validated['order'] ?? 0;
        unset($validated['order']);

        $partner = Partner::create($validated);
        return response()->json($partner, 201);
    }

    public function show($id)
    {
        $partner = Partner::findOrFail($id);
        return response()->json($partner);
    }

    public function update(Request $request, $id)
    {
        $partner = Partner::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'website' => 'nullable|url',
            'logo' => 'nullable|string|max:255',
            'category' => 'required|in:technology,financial',
            // Compat UI: "order" dans les formulaires, "sort_order" en base.
            'order' => 'nullable|integer',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? $validated['order'] ?? $partner->sort_order ?? 0;
        unset($validated['order']);

        $partner->update($validated);
        return response()->json($partner);
    }

    public function destroy($id)
    {
        $partner = Partner::findOrFail($id);
        $partner->delete();
        return response()->json(['message' => 'Partner deleted successfully']);
    }
}
