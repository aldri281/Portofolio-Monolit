<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Profile;

class ProfileController extends Controller
{
    public function index()
    {
        return Profile::first() ?? response()->json(['message' => 'Profile not found'], 444);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'resume_url' => 'nullable|string',
            'tagline' => 'nullable|string',
            'bio' => 'nullable|string',
        ]);

        $profile = Profile::first() ?? new Profile();
        $profile->fill($validated);
        $profile->save();

        return response()->json($profile);
    }
}
