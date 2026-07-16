<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContentController extends Controller
{
    public function index(Request $request)
    {
        $query = Content::query();

        // Apply filters
        if ($request->has('type') && $request->type !== '') {
            $query->ofType($request->type);
        }

        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        $contents = $query->with('author')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json($contents);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'type' => 'required|string|in:page,post,article,announcement',
            'status' => 'required|string|in:draft,published,archived',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'featured_image' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'order' => 'nullable|integer'
        ]);

        $validated['author_id'] = auth()->id();
        $validated['slug'] = $this->generateUniqueSlug($validated['title']);

        $content = Content::create($validated);

        return response()->json([
            'message' => 'Content created successfully',
            'content' => $content->load('author')
        ], 201);
    }

    public function show($id)
    {
        $content = Content::with('author')->findOrFail($id);

        return response()->json($content);
    }

    public function update(Request $request, $id)
    {
        $content = Content::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'excerpt' => 'nullable|string|max:500',
            'type' => 'sometimes|string|in:page,post,article,announcement',
            'status' => 'sometimes|string|in:draft,published,archived',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'featured_image' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'order' => 'nullable|integer'
        ]);

        // Update slug if title changed
        if (isset($validated['title']) && $validated['title'] !== $content->title) {
            $validated['slug'] = $this->generateUniqueSlug($validated['title'], $id);
        }

        $content->update($validated);

        return response()->json([
            'message' => 'Content updated successfully',
            'content' => $content->load('author')
        ]);
    }

    public function destroy($id)
    {
        $content = Content::findOrFail($id);
        $content->delete();

        return response()->json([
            'message' => 'Content deleted successfully'
        ]);
    }

    /**
     * Generate a unique slug for the content
     */
    private function generateUniqueSlug($title, $excludeId = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (Content::where('slug', $slug)->where('id', '!=', $excludeId)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
