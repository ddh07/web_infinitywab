<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PartnerRequest;
use App\Models\Partner;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::ordered()->get();
        return response()->json($partners);
    }

    public function store(PartnerRequest $request)
    {
        $validated = $request->validated();
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

    public function update(PartnerRequest $request, $id)
    {
        $partner = Partner::findOrFail($id);

        $validated = $request->validated();
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
