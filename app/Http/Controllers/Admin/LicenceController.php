<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LicenceLogiciel;
use App\Models\Logiciel;
use Illuminate\Http\Request;

class LicenceController extends Controller
{
    public function index(Request $request)
    {
        $query = LicenceLogiciel::with('logiciel');
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('cle_licence', 'like', "%{$search}%");
        }
        
        $licences = $query->paginate(25);
        return view('admin.licences.index', compact('licences'));
    }

    public function create()
    {
        $logiciels = Logiciel::all();
        return view('admin.licences.create', compact('logiciels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'logiciel_id' => 'required|exists:logiciels,id',
            'cle_licence' => 'required|unique:licence_logiciels',
            'date_achat' => 'required|date',
            'date_expiration' => 'required|date|after:date_achat',
            'nb_postes' => 'required|integer|min:1',
        ]);

        LicenceLogiciel::create($validated);
        return redirect()->route('admin.licences.index')->with('success', 'License created.');
    }

    public function edit(LicenceLogiciel $licence)
    {
        $logiciels = Logiciel::all();
        return view('admin.licences.edit', compact('licence', 'logiciels'));
    }

    public function update(Request $request, LicenceLogiciel $licence)
    {
        $validated = $request->validate([
            'logiciel_id' => 'required|exists:logiciels,id',
            'cle_licence' => 'required|unique:licence_logiciels,cle_licence,' . $licence->id,
            'date_achat' => 'required|date',
            'date_expiration' => 'required|date|after:date_achat',
            'nb_postes' => 'required|integer|min:1',
        ]);

        $licence->update($validated);
        return redirect()->route('admin.licences.index')->with('success', 'License updated.');
    }

    public function destroy(LicenceLogiciel $licence)
    {
        $licence->delete();
        return redirect()->route('admin.licences.index')->with('success', 'License deleted.');
    }
}