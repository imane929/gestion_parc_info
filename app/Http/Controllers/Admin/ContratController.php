<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContratMaintenance;
use App\Models\Prestataire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', ContratMaintenance::class);

        $query = ContratMaintenance::with('prestataire');

        // Recherche
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('numero', 'like', "%{$search}%")
                  ->orWhere('sla', 'like', "%{$search}%")
                  ->orWhereHas('prestataire', function($q2) use ($search) {
                      $q2->where('nom', 'like', "%{$search}%");
                  });
            });
        }

        // Filtre par statut
        if ($request->has('statut')) {
            switch ($request->statut) {
                case 'actif':
                    $query->where('date_debut', '<=', now())
                          ->where('date_fin', '>=', now());
                    break;
                case 'expire':
                    $query->where('date_fin', '<', now());
                    break;
                case 'futur':
                    $query->where('date_debut', '>', now());
                    break;
            }
        }

        // Filtre par prestataire
        if ($request->has('prestataire_id')) {
            $query->where('prestataire_id', $request->prestataire_id);
        }

        // Tri
        $sort = $request->get('sort', 'date_debut');
        $direction = $request->get('direction', 'desc');
        $query->orderBy($sort, $direction);

        $contrats = $query->paginate(25);
        $prestataires = Prestataire::all();

        return view('admin.contrats.index', compact('contrats', 'prestataires'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', ContratMaintenance::class);

        $prestataires = Prestataire::all();
        return view('admin.contrats.create', compact('prestataires'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', ContratMaintenance::class);

        $validated = $request->validate([
            'prestataire_id' => 'required|exists:prestataires,id',
            'numero' => 'required|string|max:100|unique:contrats_maintenance',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'sla' => 'nullable|string',
            'montant' => 'nullable|numeric|min:0',
            'renouvellement_auto' => 'boolean',
            'jours_alerte' => 'nullable|integer|min:1',
        ]);

        ContratMaintenance::create($validated);

        return redirect()->route('admin.contrats.index')
            ->with('success', 'Contrat créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ContratMaintenance $contrat)
    {
        $this->authorize('view', $contrat);

        $contrat->load(['prestataire.adresse']);
        return view('admin.contrats.show', compact('contrat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContratMaintenance $contrat)
    {
        $this->authorize('update', $contrat);

        $prestataires = Prestataire::all();
        return view('admin.contrats.edit', compact('contrat', 'prestataires'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContratMaintenance $contrat)
    {
        $this->authorize('update', $contrat);

        $validated = $request->validate([
            'prestataire_id' => 'required|exists:prestataires,id',
            'numero' => 'required|string|max:100|unique:contrats_maintenance,numero,' . $contrat->id,
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'sla' => 'nullable|string',
            'montant' => 'nullable|numeric|min:0',
            'renouvellement_auto' => 'boolean',
            'jours_alerte' => 'nullable|integer|min:1',
        ]);

        $contrat->update($validated);

        return redirect()->route('admin.contrats.show', $contrat)
            ->with('success', 'Contrat mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContratMaintenance $contrat)
    {
        $this->authorize('delete', $contrat);

        try {
            $contrat->delete();
            return redirect()->route('admin.contrats.index')
                ->with('success', 'Contrat supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression du contrat.');
        }
    }

    /**
     * Renouveler un contrat
     */
    public function renouveler(Request $request, ContratMaintenance $contrat)
    {
        $this->authorize('renew', $contrat);

        $validated = $request->validate([
            'date_fin' => 'required|date|after:today',
            'nouveau_numero' => 'nullable|string|max:100|unique:contrats_maintenance,numero',
            'ajuster_montant' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Créer une nouvelle version du contrat
            $nouveauContrat = $contrat->replicate();
            $nouveauContrat->numero = $validated['nouveau_numero'] ?? $contrat->numero . '-REN';
            $nouveauContrat->date_debut = $contrat->date_fin->addDay();
            $nouveauContrat->date_fin = $validated['date_fin'];
            
            if ($validated['ajuster_montant'] ?? false) {
                $nouveauContrat->montant = $validated['ajuster_montant'];
            }
            
            $nouveauContrat->save();

            DB::commit();
            
            return redirect()->route('admin.contrats.show', $nouveauContrat)
                ->with('success', 'Contrat renouvelé avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors du renouvellement.');
        }
    }

    /**
     * Exporter les contrats
     */
    public function export(Request $request)
    {
        $this->authorize('export-data');

        $contrats = ContratMaintenance::with('prestataire')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="contrats_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($contrats) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'Numéro', 'Prestataire', 'Date début', 'Date fin', 'Statut', 
                'Jours restants', 'Montant', 'SLA'
            ]);

            foreach ($contrats as $contrat) {
                fputcsv($file, [
                    $contrat->numero,
                    $contrat->prestataire->nom,
                    $contrat->date_debut->format('d/m/Y'),
                    $contrat->date_fin->format('d/m/Y'),
                    $contrat->statut,
                    $contrat->jours_restants,
                    $contrat->montant,
                    substr($contrat->sla ?? '', 0, 100),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Afficher les contrats expirant bientôt
     */
    public function expirant(Request $request)
    {
        $this->authorize('viewAny', ContratMaintenance::class);

        $jours = $request->get('jours', 30);
        
        $contrats = ContratMaintenance::with('prestataire')
            ->whereBetween('date_fin', [now(), now()->addDays($jours)])
            ->where('date_fin', '>=', now())
            ->orderBy('date_fin')
            ->paginate(25);

        return view('admin.contrats.expirant', compact('contrats', 'jours'));
    }
}