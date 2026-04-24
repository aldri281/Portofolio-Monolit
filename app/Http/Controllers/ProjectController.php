<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index()
    {
        return Inertia::render('admin/projects/index', [
            'projects' => Project::with('images')->orderBy('id', 'desc')->get()
        ]);
    }

    public function create()
    {
        return Inertia::render('admin/projects/create');
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
        return redirect('/admin/projects')->with('success', 'Project created.');
    }

    public function edit(Project $project)
    {
        return Inertia::render('admin/projects/edit', [
            'project' => $project->load('images')
        ]);
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
        return redirect('/admin/projects')->with('success', 'Project updated.');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect('/admin/projects')->with('success', 'Project deleted.');
    }
}
