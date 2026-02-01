<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Affectation;
use App\Models\Equipement;
use App\Models\User;
use Illuminate\Http\Request;

class AffectationController extends Controller
{
    public function index()
    {
        $affectations = Affectation::with(['equipement', 'user'])->latest()->paginate(10);
        return view('admin.affectations.index', compact('affectations'));
    }
    
    public function create()
    {
        $equipements = Equipement::whereDoesntHave('affectations', function($query) {
            $query->whereNull('date_retour');
        })->get();
        
        $users = User::all();
        return view('admin.affectations.create', compact('equipements', 'users'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'equipement_id' => 'required|exists:equipements,id',
            'user_id' => 'required|exists:users,id',
            'date_affectation' => 'required|date',
            'date_retour' => 'nullable|date|after:date_affectation',
            'raison' => 'nullable|string',
        ]);
        
        Affectation::create($request->all());
        
        return redirect()->route('admin.affectations.index')
            ->with('success', 'Affectation créée avec succès.');
    }
    
    public function show(Affectation $affectation)
    {
        $affectation->load(['equipement', 'user']);
        return view('admin.affectations.show', compact('affectation'));
    }
    
    public function edit(Affectation $affectation)
    {
        $equipements = Equipement::all();
        $users = User::all();
        return view('admin.affectations.edit', compact('affectation', 'equipements', 'users'));
    }
    
    public function update(Request $request, Affectation $affectation)
    {
        $request->validate([
            'equipement_id' => 'required|exists:equipements,id',
            'user_id' => 'required|exists:users,id',
            'date_affectation' => 'required|date',
            'date_retour' => 'nullable|date|after:date_affectation',
            'raison' => 'nullable|string',
        ]);
        
        $affectation->update($request->all());
        
        return redirect()->route('admin.affectations.index')
            ->with('success', 'Affectation mise à jour avec succès.');
    }
    
    public function destroy(Affectation $affectation)
    {
        $affectation->delete();
        
        return redirect()->route('admin.affectations.index')
            ->with('success', 'Affectation supprimée avec succès.');
    }
}