<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index()
    {
        return response()->json(Certificate::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'organizer' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'link' => 'nullable|url',
        ]);

        $certificate = Certificate::create($validated);
        return response()->json($certificate, 201);
    }

    public function show(Certificate $certificate)
    {
        return response()->json($certificate);
    }

    public function update(Request $request, Certificate $certificate)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'organizer' => 'sometimes|required|string|max:255',
            'duration' => 'sometimes|required|string|max:255',
            'link' => 'nullable|url',
        ]);

        $certificate->update($validated);
        return response()->json($certificate);
    }

    public function destroy(Certificate $certificate)
    {
        $certificate->delete();
        return response()->json(null, 204);
    }
}
