<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    private function applyLegacyDefaults(array $validated, ?Project $existing = null): array
    {
        // `projects` table includes legacy columns not exposed in the admin UI.
        // Ensure required DB fields are always present to prevent SQL errors.
        $validated['category'] = $validated['category'] ?? ($existing?->category ?? 'general');

        if (!isset($validated['status'])) {
            if ($existing) {
                $validated['status'] = $existing->status;
            } else {
                $isActive = (bool) ($validated['is_active'] ?? true);
                $validated['status'] = $isActive ? 'en_cours' : 'en_attente';
            }
        }

        // Keep `project_date` in sync for legacy views if it's used anywhere.
        if (!isset($validated['project_date'])) {
            $validated['project_date'] = $validated['completion_date'] ?? ($existing?->project_date ?? null);
        }

        return $validated;
    }

    public function index()
    {
        $projects = Project::orderBy('order')->get();
        return response()->json($projects);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:projects',
            'description' => 'required|string|max:500',
            'content' => 'nullable|string',
            'client' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'status' => 'nullable|in:en_attente,en_cours,termine',
            'project_date' => 'nullable|date',
            'technologies' => 'nullable|array',
            'image' => 'nullable|string|max:255',
            'completion_date' => 'nullable|date',
            'project_url' => 'nullable|url',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'order' => 'integer'
        ]);

        $validated = $this->applyLegacyDefaults($validated, null);
        $project = Project::create($validated);
        return response()->json($project, 201);
    }

    public function show($id)
    {
        $project = Project::findOrFail($id);
        return response()->json($project);
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:projects,slug,' . $id,
            'description' => 'required|string|max:500',
            'content' => 'nullable|string',
            'client' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'status' => 'nullable|in:en_attente,en_cours,termine',
            'project_date' => 'nullable|date',
            'technologies' => 'nullable|array',
            'image' => 'nullable|string|max:255',
            'completion_date' => 'nullable|date',
            'project_url' => 'nullable|url',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'order' => 'integer'
        ]);

        $validated = $this->applyLegacyDefaults($validated, $project);
        $project->update($validated);
        return response()->json($project);
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        return response()->json(['message' => 'Project deleted successfully']);
    }
}
