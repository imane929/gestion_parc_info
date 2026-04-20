<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActifInformatique;
use App\Models\Localisation;
use App\Models\User as Utilisateur;
use App\Models\HistoriqueActif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', ActifInformatique::class);

        $query = ActifInformatique::with(['localisation', 'utilisateurAffecte']);

        // Recherche
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('code_inventaire', 'like', "%{$search}%")
                  ->orWhere('marque', 'like', "%{$search}%")
                  ->orWhere('modele', 'like', "%{$search}%")
                  ->orWhere('numero_serie', 'like', "%{$search}%");
            });
        }

        // Filtre par type
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Filtre par état
        if ($request->has('etat')) {
            $query->where('etat', $request->etat);
        }

        // Filtre par localisation
        if ($request->has('localisation_id')) {
            $query->where('localisation_id', $request->localisation_id);
        }

        // Filtre par affectation
        if ($request->has('affectation')) {
            if ($request->affectation === 'avec') {
                $query->whereNotNull('utilisateur_affecte_id');
            } elseif ($request->affectation === 'sans') {
                $query->whereNull('utilisateur_affecte_id');
            }
        }

        // Tri
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        $query->orderBy($sort, $direction);

        $actifs = $query->paginate(25);
        $localisations = Localisation::all();
        $utilisateurs = Utilisateur::where('etat_compte', 'actif')->get();
        $types = ['pc', 'imprimante', 'serveur', 'reseau', 'peripherique', 'mobile', 'autre'];
        $etats = ['neuf', 'bon', 'moyen', 'mauvais', 'hors_service'];

        return view('admin.actifs.index', compact('actifs', 'localisations', 'utilisateurs', 'types', 'etats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', ActifInformatique::class);

        $localisations = Localisation::all();
        $utilisateurs = Utilisateur::where('etat_compte', 'actif')->get();
        $types = ['pc', 'imprimante', 'serveur', 'reseau', 'peripherique', 'mobile', 'autre'];
        $etats = ['neuf', 'bon', 'moyen', 'mauvais', 'hors_service'];

        return view('admin.actifs.create', compact('localisations', 'utilisateurs', 'types', 'etats'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', ActifInformatique::class);

        $validated = $request->validate([
            'code_inventaire' => 'required|string|max:50|unique:actifs_informatiques',
            'type' => 'required|in:pc,imprimante,serveur,reseau,peripherique,mobile,autre',
            'marque' => 'required|string|max:100',
            'modele' => 'required|string|max:150',
            'numero_serie' => 'required|string|max:100|unique:actifs_informatiques',
            'etat' => 'required|in:neuf,bon,moyen,mauvais,hors_service',
            'date_achat' => 'nullable|date',
            'garantie_fin' => 'nullable|date|after_or_equal:date_achat',
            'description' => 'nullable|string',
            'localisation_id' => 'nullable|exists:localisations,id',
            'utilisateur_affecte_id' => 'nullable|exists:utilisateurs,id',
        ]);

        DB::beginTransaction();
        try {
            $actif = ActifInformatique::create($validated);

            // Si affectation, créer l'historique
            if ($actif->utilisateur_affecte_id) {
                HistoriqueActif::create([
                    'actif_informatique_id' => $actif->id,
                    'evenement' => 'affectation',
                    'details' => "Actif créé et affecté à l'utilisateur ID: {$actif->utilisateur_affecte_id}",
                ]);
            }

            DB::commit();

            return redirect()->route('admin.actifs.show', $actif)
                ->with('success', 'Actif créé avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Erreur lors de la création de l\'actif.')
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ActifInformatique $actif)
    {
        $this->authorize('view', $actif);

        $actif->load([
            'localisation',
            'utilisateurAffecte',
            'affectations.utilisateur',
            'tickets',
            'maintenancesPreventives',
            'installationsLogiciels.licence.logiciel',
            'historiques',
            'commentaires.utilisateur',
            'piecesJointes.uploader'
        ]);

        return view('admin.actifs.show', compact('actif'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ActifInformatique $actif)
    {
        $this->authorize('update', $actif);

        $localisations = Localisation::all();
        $utilisateurs = Utilisateur::where('etat_compte', 'actif')->get();
        $types = ['pc', 'imprimante', 'serveur', 'reseau', 'peripherique', 'mobile', 'autre'];
        $etats = ['neuf', 'bon', 'moyen', 'mauvais', 'hors_service'];

        return view('admin.actifs.edit', compact('actif', 'localisations', 'utilisateurs', 'types', 'etats'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ActifInformatique $actif)
    {
        $this->authorize('update', $actif);

        $validated = $request->validate([
            'code_inventaire' => 'required|string|max:50|unique:actifs_informatiques,code_inventaire,' . $actif->id,
            'type' => 'required|in:pc,imprimante,serveur,reseau,peripherique,mobile,autre',
            'marque' => 'required|string|max:100',
            'modele' => 'required|string|max:150',
            'numero_serie' => 'required|string|max:100|unique:actifs_informatiques,numero_serie,' . $actif->id,
            'etat' => 'required|in:neuf,bon,moyen,mauvais,hors_service',
            'date_achat' => 'nullable|date',
            'garantie_fin' => 'nullable|date|after_or_equal:date_achat',
            'description' => 'nullable|string',
            'localisation_id' => 'nullable|exists:localisations,id',
            'utilisateur_affecte_id' => 'nullable|exists:utilisateurs,id',
        ]);

        DB::beginTransaction();
        try {
            $ancienneAffectation = $actif->utilisateur_affecte_id;
            
            $actif->update($validated);

            // Gérer l'historique des affectations
            if ($ancienneAffectation != $actif->utilisateur_affecte_id) {
                if ($ancienneAffectation) {
                    HistoriqueActif::create([
                        'actif_informatique_id' => $actif->id,
                        'evenement' => 'desaffectation',
                        'details' => "Désaffecté de l'utilisateur ID: {$ancienneAffectation}",
                    ]);
                }

                if ($actif->utilisateur_affecte_id) {
                    HistoriqueActif::create([
                        'actif_informatique_id' => $actif->id,
                        'evenement' => 'affectation',
                        'details' => "Affecté à l'utilisateur ID: {$actif->utilisateur_affecte_id}",
                    ]);
                }
            }

            // Historique de mise à jour
            HistoriqueActif::create([
                'actif_informatique_id' => $actif->id,
                'evenement' => 'modification',
                'details' => 'Mise à jour des informations de l\'actif',
            ]);

            DB::commit();

            return redirect()->route('admin.actifs.show', $actif)
                ->with('success', 'Actif mis à jour avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Erreur lors de la mise à jour de l\'actif.')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ActifInformatique $actif)
    {
        $this->authorize('delete', $actif);

        try {
            $actif->delete();
            return redirect()->route('admin.actifs.index')
                ->with('success', 'Actif supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression de l\'actif.');
        }
    }

    /**
     * Affecter un actif à un utilisateur
     */
    public function affecter(Request $request, ActifInformatique $actif)
    {
        $this->authorize('affect', $actif);

        $request->validate([
            'utilisateur_id' => 'required|exists:utilisateurs,id',
        ]);

        DB::beginTransaction();
        try {
            $actif->affecterA(Utilisateur::find($request->utilisateur_id));

            DB::commit();
            if ($request->expectsJson() || str_contains((string) $request->header('Accept', ''), '*/*')) {
                return response()->json(['success' => true]);
            }
            return redirect()->back()->with('success', 'Actif affecté avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->expectsJson() || str_contains((string) $request->header('Accept', ''), '*/*')) {
                return response()->json(['success' => false], 422);
            }
            return redirect()->back()->with('error', 'Erreur lors de l\'affectation.');
        }
    }

    /**
     * Désaffecter un actif
     */
    public function desaffecter(ActifInformatique $actif)
    {
        $this->authorize('affect', $actif);

        DB::beginTransaction();
        try {
            $actif->desaffecter();

            DB::commit();
            if (request()->expectsJson() || str_contains((string) request()->header('Accept', ''), '*/*')) {
                return response()->json(['success' => true]);
            }
            return redirect()->back()->with('success', 'Actif désaffecté avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            if (request()->expectsJson() || str_contains((string) request()->header('Accept', ''), '*/*')) {
                return response()->json(['success' => false], 422);
            }
            return redirect()->back()->with('error', 'Erreur lors de la désaffectation.');
        }
    }

    /**
     * Ajouter un commentaire
     */
    public function addComment(Request $request, ActifInformatique $actif)
    {
        $this->authorize('view', $actif);

        $request->validate([
            'contenu' => 'required|string',
        ]);

        $actif->commentaires()->create([
            'utilisateur_id' => auth()->id(),
            'contenu' => $request->contenu,
        ]);

        return redirect()->back()->with('success', 'Commentaire ajouté.');
    }

    /**
     * Exporter les actifs en CSV
     */
    public function export(Request $request)
    {
        $this->authorize('export-data');

        $actifs = ActifInformatique::with(['localisation', 'utilisateurAffecte'])->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="actifs_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($actifs) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'Code Inventaire', 'Type', 'Marque', 'Modèle', 'Numéro Série', 'État',
                'Date Achat', 'Garantie Fin', 'Localisation', 'Utilisateur Affecté'
            ]);

            foreach ($actifs as $actif) {
                fputcsv($file, [
                    $actif->code_inventaire,
                    $actif->type,
                    $actif->marque,
                    $actif->modele,
                    $actif->numero_serie,
                    $actif->etat,
                    $actif->date_achat,
                    $actif->garantie_fin,
                    $actif->localisation ? $actif->localisation->nom_complet : '',
                    $actif->utilisateurAffecte ? $actif->utilisateurAffecte->full_name : '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
