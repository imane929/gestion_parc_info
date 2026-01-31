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
        $equipements = Equipement::with('user')->latest()->paginate(10);
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
    
    // API Methods for AJAX
    public function apiIndex()
    {
        $equipements = Equipement::latest()->take(10)->get();
        return response()->json($equipements);
    }
    
    public function apiStore(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'type' => 'required|string',
            'date_acquisition' => 'required|date',
            'etat' => 'required|string',
            'localisation' => 'required|string'
        ]);
        
        $equipement = Equipement::create($request->all());
        return response()->json($equipement, 201);
    }
    
    public function apiUpdate(Request $request, Equipement $equipement)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'type' => 'required|string',
            'etat' => 'required|string',
            'localisation' => 'required|string'
        ]);
        
        $equipement->update($request->all());
        return response()->json($equipement);
    }
    
    public function apiDestroy(Equipement $equipement)
    {
        $equipement->delete();
        return response()->json(['message' => 'Équipement supprimé avec succès.']);
    }
}