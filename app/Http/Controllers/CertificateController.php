<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CertificateController extends Controller
{
    public function index()
    {
        return Inertia::render('admin/certificates/index', [
            'certs' => Certificate::orderBy('id', 'desc')->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'organizer' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'link' => 'nullable|url',
        ]);

        Certificate::create($validated);
        return redirect()->back()->with('success', 'Certificate created.');
    }

    public function destroy(Certificate $certificate)
    {
        $certificate->delete();
        return redirect()->back()->with('success', 'Certificate deleted.');
    }
}
