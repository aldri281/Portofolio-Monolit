<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return response()->json(Project::with('images')->orderBy('id', 'desc')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tools' => 'nullable|array',
            'datastack' => 'nullable|string',
            'repo_link' => 'nullable|url',
            'demo_link' => 'nullable|url',
            'icon' => 'nullable|string|max:100',
            'highlights' => 'nullable|array',
        ]);

        $project = Project::create($validated);
        return response()->json($project->load('images'), 201);
    }

    public function show(Project $project)
    {
        return response()->json($project->load('images'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'tools' => 'nullable|array',
            'datastack' => 'nullable|string',
            'repo_link' => 'nullable|url',
            'demo_link' => 'nullable|url',
            'icon' => 'nullable|string|max:100',
            'highlights' => 'nullable|array',
        ]);

        $project->update($validated);
        return response()->json($project->load('images'));
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return response()->json(null, 204);
    }
}
