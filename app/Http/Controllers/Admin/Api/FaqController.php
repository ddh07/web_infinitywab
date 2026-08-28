<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FaqRequest;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('order')->get();
        return response()->json($faqs);
    }

    public function store(FaqRequest $request)
    {
        $faq = Faq::create($request->validated());
        return response()->json($faq, 201);
    }

    public function show($id)
    {
        $faq = Faq::findOrFail($id);
        return response()->json($faq);
    }

    public function update(FaqRequest $request, $id)
    {
        $faq = Faq::findOrFail($id);
        $faq->update($request->validated());
        return response()->json($faq);
    }

    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();
        return response()->json(['message' => 'FAQ deleted successfully']);
    }
}
