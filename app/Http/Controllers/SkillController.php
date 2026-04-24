<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SkillController extends Controller
{
    public function index()
    {
        return Inertia::render('admin/skills/index', [
            'skills' => Skill::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'icon' => 'nullable|string',
        ]);

        Skill::create($validated);
        return redirect()->back()->with('success', 'Skill created.');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();
        return redirect()->back()->with('success', 'Skill deleted.');
    }
}
