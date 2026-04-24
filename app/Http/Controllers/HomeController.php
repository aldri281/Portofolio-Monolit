<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Skill;
use App\Models\Certificate;
use App\Models\Profile;
use App\Models\SiteSetting;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('created_at', 'desc')->get();
        $skills = Skill::orderBy('category')->orderBy('name')->get();
        $certificates = Certificate::orderBy('id', 'desc')->get();
        $profile = Profile::first();
        $settings = SiteSetting::all()->pluck('value', 'key')->toArray();

        return Inertia::render('index', [
            'projects' => $projects,
            'skills' => $skills,
            'certificates' => $certificates,
            'profile' => $profile,
            'settings' => $settings,
        ]);
    }
}
