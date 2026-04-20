<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaintenancePreventive;
use App\Models\ActifInformatique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', MaintenancePreventive::class);

        $query = MaintenancePreventive::with('actif');

        // Recherche
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('actif', function($q) use ($search) {
                $q->where('code_inventaire', 'like', "%{$search}%")
                  ->orWhere('marque', 'like', "%{$search}%")
                  ->orWhere('modele', 'like', "%{$search}%");
            });
        }

        // Filtre par statut
        if ($request->has('statut')) {
            $query->where('statut', $request->statut);
        }

        // Filtre par type
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Filtre par date
        if ($request->has('date_debut')) {
            $query->where('date_prevue', '>=', $request->date_debut);
        }
        if ($request->has('date_fin')) {
            $query->where('date_prevue', '<=', $request->date_fin);
        }

        // Filtre par retard
        if ($request->has('retard')) {
            $query->where('date_prevue', '<', now())
                  ->whereIn('statut', ['planifie', 'en_cours']);
        }

        $maintenances = $query->orderBy('date_prevue')->paginate(25);
        $statuts = ['planifie', 'en_cours', 'termine', 'annule'];
        $types = ['nettoyage', 'verification', 'mise_a_jour', 'remplacement', 'autre'];

        return view('admin.maintenances.index', compact('maintenances', 'statuts', 'types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', MaintenancePreventive::class);

        $actifs = ActifInformatique::all();
        $types = ['nettoyage', 'verification', 'mise_a_jour', 'remplacement', 'autre'];
        $statuts = ['planifie', 'en_cours', 'termine', 'annule'];

        return view('admin.maintenances.create', compact('actifs', 'types', 'statuts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', MaintenancePreventive::class);

        $validated = $request->validate([
            'actif_informatique_id' => 'required|exists:actifs_informatiques,id',
            'date_prevue' => 'required|date',
            'type' => 'required|in:nettoyage,verification,mise_a_jour,remplacement,autre',
            'statut' => 'required|in:planifie,en_cours,termine,annule',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        MaintenancePreventive::create($validated);

        return redirect()->route('admin.maintenances.index')
            ->with('success', 'Maintenance planifiée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MaintenancePreventive $maintenance)
    {
        $this->authorize('view', $maintenance);

        $maintenance->load(['actif', 'actif.localisation', 'actif.utilisateurAffecte']);
        return view('admin.maintenances.show', compact('maintenance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MaintenancePreventive $maintenance)
    {
        $this->authorize('update', $maintenance);

        $actifs = ActifInformatique::all();
        $types = ['nettoyage', 'verification', 'mise_a_jour', 'remplacement', 'autre'];
        $statuts = ['planifie', 'en_cours', 'termine', 'annule'];

        return view('admin.maintenances.edit', compact('maintenance', 'actifs', 'types', 'statuts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MaintenancePreventive $maintenance)
    {
        $this->authorize('update', $maintenance);

        $validated = $request->validate([
            'actif_informatique_id' => 'required|exists:actifs_informatiques,id',
            'date_prevue' => 'required|date',
            'type' => 'required|in:nettoyage,verification,mise_a_jour,remplacement,autre',
            'statut' => 'required|in:planifie,en_cours,termine,annule',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $maintenance->update($validated);

        return redirect()->route('admin.maintenances.show', $maintenance)
            ->with('success', 'Maintenance mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaintenancePreventive $maintenance)
    {
        $this->authorize('delete', $maintenance);

        try {
            $maintenance->delete();
            return redirect()->route('admin.maintenances.index')
                ->with('success', 'Maintenance supprimée avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression de la maintenance.');
        }
    }

    /**
     * Démarrer une maintenance
     */
    public function demarrer(MaintenancePreventive $maintenance)
    {
        $this->authorize('update', $maintenance);

        if (!$maintenance->estPlanifiee()) {
            return redirect()->back()
                ->with('error', 'Seules les maintenances planifiées peuvent être démarrées.');
        }

        $maintenance->demarrer();
        return redirect()->back()->with('success', 'Maintenance démarrée.');
    }

    /**
     * Terminer une maintenance
     */
    public function terminer(MaintenancePreventive $maintenance)
    {
        $this->authorize('update', $maintenance);

        if (!$maintenance->estEnCours()) {
            return redirect()->back()
                ->with('error', 'Seules les maintenances en cours peuvent être terminées.');
        }

        $maintenance->terminer();
        return redirect()->back()->with('success', 'Maintenance terminée.');
    }

    /**
     * Annuler une maintenance
     */
    public function annuler(MaintenancePreventive $maintenance)
    {
        $this->authorize('update', $maintenance);

        if ($maintenance->estTerminee()) {
            return redirect()->back()
                ->with('error', 'Une maintenance terminée ne peut pas être annulée.');
        }

        $maintenance->update(['statut' => 'annule']);
        return redirect()->back()->with('success', 'Maintenance annulée.');
    }

    /**
     * Maintenances en retard
     */
    public function retard()
    {
        $this->authorize('viewAny', MaintenancePreventive::class);

        $maintenances = MaintenancePreventive::with('actif')
            ->where('date_prevue', '<', now())
            ->whereIn('statut', ['planifie', 'en_cours'])
            ->orderBy('date_prevue')
            ->paginate(25);

        return view('admin.maintenances.retard', compact('maintenances'));
    }

    /**
     * Maintenances à venir
     */
    public function prochaines(Request $request)
    {
        $this->authorize('viewAny', MaintenancePreventive::class);

        $jours = $request->get('jours', 7);
        
        $maintenances = MaintenancePreventive::with('actif')
            ->whereBetween('date_prevue', [now(), now()->addDays($jours)])
            ->where('statut', 'planifie')
            ->orderBy('date_prevue')
            ->paginate(25);

        return view('admin.maintenances.prochaines', compact('maintenances', 'jours'));
    }

    /**
     * Générer un planning de maintenance
     */
    public function planning(Request $request)
    {
        $this->authorize('viewAny', MaintenancePreventive::class);

        $mois = $request->get('mois', now()->month);
        $annee = $request->get('annee', now()->year);

        $debut = \Carbon\Carbon::create($annee, $mois, 1);
        $fin = $debut->copy()->endOfMonth();

        $maintenances = MaintenancePreventive::with('actif')
            ->whereBetween('date_prevue', [$debut, $fin])
            ->orderBy('date_prevue')
            ->get()
            ->groupBy(function($maintenance) {
                return $maintenance->date_prevue->format('Y-m-d');
            });

        $moisSuivant = $debut->copy()->addMonth();
        $moisPrecedent = $debut->copy()->subMonth();

        return view('admin.maintenances.planning', compact(
            'maintenances', 'debut', 'fin', 'mois', 'annee',
            'moisSuivant', 'moisPrecedent'
        ));
    }

    /**
     * Exporter les maintenances
     */
    public function export(Request $request)
    {
        $this->authorize('export-data');

        $query = MaintenancePreventive::with('actif');

        if ($request->has('statut')) {
            $query->where('statut', $request->statut);
        }
        if ($request->has('date_debut')) {
            $query->where('date_prevue', '>=', $request->date_debut);
        }
        if ($request->has('date_fin')) {
            $query->where('date_prevue', '<=', $request->date_fin);
        }

        $maintenances = $query->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="maintenances_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($maintenances) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'Actif', 'Type', 'Date prévue', 'Statut', 'Jours restants',
                'Description', 'Notes'
            ]);

            foreach ($maintenances as $maintenance) {
                fputcsv($file, [
                    $maintenance->actif->code_inventaire,
                    $maintenance->type,
                    $maintenance->date_prevue->format('d/m/Y'),
                    $maintenance->statut,
                    $maintenance->jours_restants,
                    $maintenance->description ?? '',
                    $maintenance->notes ?? '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}