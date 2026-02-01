<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipement;
use App\Models\User;
use Illuminate\Http\Request;

class EquipementController extends Controller
{
    public function index()
    {
        $equipements = Equipement::latest()->paginate(10);
        return view('admin.equipements.index', compact('equipements'));
    }
    
    public function create()
    {
        $users = User::all();
        return view('admin.equipements.create', compact('users'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'type' => 'required|string',
            'date_acquisition' => 'required|date',
            'etat' => 'required|string|in:neuf,bon,moyen,mauvais,hors_service',
            'localisation' => 'required|string'
        ]);
        
        Equipement::create($request->all());
        
        return redirect()->route('admin.equipements.index')
            ->with('success', 'Équipement ajouté avec succès.');
    }
    
    public function show(Equipement $equipement)
    {
        return view('admin.equipements.show', compact('equipement'));
    }
    
    public function edit(Equipement $equipement)
    {
        $users = User::all();
        return view('admin.equipements.edit', compact('equipement', 'users'));
    }
    
    public function update(Request $request, Equipement $equipement)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'type' => 'required|string',
            'etat' => 'required|string|in:neuf,bon,moyen,mauvais,hors_service',
            'localisation' => 'required|string'
        ]);
        
        $equipement->update($request->all());
        
        return redirect()->route('admin.equipements.index')
            ->with('success', 'Équipement mis à jour avec succès.');
    }
    
    public function destroy(Equipement $equipement)
    {
        $equipement->delete();
        
        return redirect()->route('admin.equipements.index')
            ->with('success', 'Équipement supprimé avec succès.');
    }
}