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
        session()->flash('success', 'Certificate created.');
        session()->save();
        return redirect()->back();
    }
    public function update(Request $request, Certificate $certificate)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'organizer' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'link' => 'nullable|url',
        ]);

        $certificate->update($validated);
        session()->flash('success', 'Certificate updated.');
        session()->save();
        return redirect()->back();
    }

    public function destroy(Certificate $certificate)
    {
        $certificate->delete();
        session()->flash('success', 'Certificate deleted.');
        session()->save();
        return redirect()->back();
    }
}
