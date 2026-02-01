<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Affectation;
use App\Models\Equipement;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AffectationController extends Controller
{
    public function index()
    {
        $affectations = Affectation::with(['equipement', 'user'])
            ->latest()
            ->paginate(10);

        return view('admin.affectations.index', compact('affectations'));
    }
    
    public function create()
    {
        // Get equipements that are not currently assigned (no active affectation)
        $equipements = Equipement::whereDoesntHave('affectations', function($query) {
            $query->where('statut', 'actif');
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
            'date_retour' => 'nullable|date|after_or_equal:date_affectation',
            'statut' => 'required|in:actif,retourné',
            'raison' => 'nullable|string|max:500',
        ]);

        // If status is "retourné" but no date_retour is set, set it to today
        $data = $request->all();
        if ($data['statut'] === 'retourné' && empty($data['date_retour'])) {
            $data['date_retour'] = Carbon::now()->format('Y-m-d');
        }
        
        // If status is "actif", ensure date_retour is null
        if ($data['statut'] === 'actif') {
            $data['date_retour'] = null;
        }

        Affectation::create($data);
        
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
            'date_retour' => 'nullable|date|after_or_equal:date_affectation',
            'statut' => 'required|in:actif,retourné',
            'raison' => 'nullable|string|max:500',
        ]);

        $data = $request->all();
        
        // Handle status and date_retour logic
        if ($data['statut'] === 'retourné' && empty($data['date_retour'])) {
            $data['date_retour'] = Carbon::now()->format('Y-m-d');
        }
        
        if ($data['statut'] === 'actif') {
            $data['date_retour'] = null;
        }

        $affectation->update($data);
        
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