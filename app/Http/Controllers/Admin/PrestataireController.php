<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prestataire;
use App\Models\Adresse;
use Illuminate\Http\Request;

class PrestataireController extends Controller
{
    public function index()
    {
        $prestataires = Prestataire::withCount('contrats')->paginate(25);
        return view('admin.prestataires.index', compact('prestataires'));
    }

    public function create()
    {
        return view('admin.prestataires.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:200',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:150',
        ]);

        Prestataire::create($validated);
        return redirect()->route('admin.prestataires.index')->with('success', 'Provider created.');
    }

    public function show(Prestataire $prestataire)
    {
        return view('admin.prestataires.show', compact('prestataire'));
    }

    public function edit(Prestataire $prestataire)
    {
        return view('admin.prestataires.edit', compact('prestataire'));
    }

    public function update(Request $request, Prestataire $prestataire)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:200',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:150',
        ]);

        $prestataire->update($validated);
        return redirect()->route('admin.prestataires.show', $prestataire)->with('success', 'Provider updated.');
    }

    public function destroy(Prestataire $prestataire)
    {
        $prestataire->delete();
        return redirect()->route('admin.prestataires.index')->with('success', 'Provider deleted.');
    }
}