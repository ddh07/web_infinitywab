<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::active()
            ->ordered()
            ->paginate(9);

        $featuredProjects = Project::active()
            ->featured()
            ->ordered()
            ->limit(3)
            ->get();

        $projectStats = [
            'total' => $projects->total(),
            'featured' => $featuredProjects->count(),
            'clients' => Project::active()->distinct()->count('client'),
        ];

        $projectCategories = Project::active()
            ->pluck('category')
            ->filter()
            ->unique()
            ->values();

        return view('projects', compact('projects', 'featuredProjects', 'projectStats', 'projectCategories'));
    }
    
    public function show($slug)
    {
        $project = Project::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
            
        return view('project-detail', compact('project'));
    }
}
