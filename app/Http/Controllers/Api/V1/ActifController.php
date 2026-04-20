<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ActifInformatique;
use App\Models\HistoriqueActif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ActifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', ActifInformatique::class);

        $query = ActifInformatique::with(['localisation', 'utilisateurAffecte']);

        // Filtres
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }
        if ($request->has('etat')) {
            $query->where('etat', $request->etat);
        }
        if ($request->has('localisation_id')) {
            $query->where('localisation_id', $request->localisation_id);
        }
        if ($request->has('utilisateur_affecte_id')) {
            $query->where('utilisateur_affecte_id', $request->utilisateur_affecte_id);
        }
        if ($request->has('garantie_valide')) {
            $query->whereNotNull('garantie_fin')
                  ->where('garantie_fin', '>=', now());
        }

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

        // Pagination
        $perPage = $request->get('per_page', 15);
        $actifs = $query->paginate($perPage);

        return response()->json([
            'data' => $actifs->items(),
            'meta' => [
                'total' => $actifs->total(),
                'per_page' => $actifs->perPage(),
                'current_page' => $actifs->currentPage(),
                'last_page' => $actifs->lastPage(),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', ActifInformatique::class);

        $validator = Validator::make($request->all(), [
            'code_inventaire' => 'required|string|max:50|unique:actifs_informatiques',
            'type' => 'required|in:pc,imprimante,serveur,reseau,peripherique,mobile,autre',
            'marque' => 'required|string|max:100',
            'modele' => 'required|string|max:150',
            'numero_serie' => 'required|string|max:100|unique:actifs_informatiques',
            'etat' => 'required|in:neuf,bon,moyen,mauvais,hors_service',
            'date_achat' => 'nullable|date',
            'garantie_fin' => 'nullable|date|after_or_equal:date_achat',
            'localisation_id' => 'nullable|exists:localisations,id',
            'utilisateur_affecte_id' => 'nullable|exists:utilisateurs,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $actif = ActifInformatique::create($validator->validated());

        // Historique
        HistoriqueActif::create([
            'actif_informatique_id' => $actif->id,
            'evenement' => 'creation',
            'details' => 'Actif créé via API',
        ]);

        return response()->json([
            'message' => 'Actif créé avec succès',
            'data' => $actif->load(['localisation', 'utilisateurAffecte']),
        ], 201);
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
            'tickets' => function($query) {
                $query->latest()->limit(5);
            },
            'maintenancesPreventives' => function($query) {
                $query->latest()->limit(5);
            },
            'installationsLogiciels.licence.logiciel',
            'historiques' => function($query) {
                $query->latest()->limit(10);
            },
        ]);

        return response()->json([
            'data' => $actif,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ActifInformatique $actif)
    {
        $this->authorize('update', $actif);

        $validator = Validator::make($request->all(), [
            'code_inventaire' => 'required|string|max:50|unique:actifs_informatiques,code_inventaire,' . $actif->id,
            'type' => 'required|in:pc,imprimante,serveur,reseau,peripherique,mobile,autre',
            'marque' => 'required|string|max:100',
            'modele' => 'required|string|max:150',
            'numero_serie' => 'required|string|max:100|unique:actifs_informatiques,numero_serie,' . $actif->id,
            'etat' => 'required|in:neuf,bon,moyen,mauvais,hors_service',
            'date_achat' => 'nullable|date',
            'garantie_fin' => 'nullable|date|after_or_equal:date_achat',
            'localisation_id' => 'nullable|exists:localisations,id',
            'utilisateur_affecte_id' => 'nullable|exists:utilisateurs,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $ancienneAffectation = $actif->utilisateur_affecte_id;
        
        $actif->update($validator->validated());

        // Historique des modifications
        HistoriqueActif::create([
            'actif_informatique_id' => $actif->id,
            'evenement' => 'modification',
            'details' => 'Mise à jour via API',
        ]);

        // Historique d'affectation
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

        return response()->json([
            'message' => 'Actif mis à jour avec succès',
            'data' => $actif->load(['localisation', 'utilisateurAffecte']),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ActifInformatique $actif)
    {
        $this->authorize('delete', $actif);

        $actif->delete();

        return response()->json([
            'message' => 'Actif supprimé avec succès',
        ]);
    }

    /**
     * Affecter l'actif à un utilisateur
     */
    public function affecter(Request $request, ActifInformatique $actif)
    {
        $this->authorize('affect', $actif);

        $validator = Validator::make($request->all(), [
            'utilisateur_id' => 'required|exists:utilisateurs,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $actif->affecterA(\App\Models\User::find($request->utilisateur_id));

        return response()->json([
            'message' => 'Actif affecté avec succès',
            'data' => $actif->load('utilisateurAffecte'),
        ]);
    }

    /**
     * Désaffecter l'actif
     */
    public function desaffecter(ActifInformatique $actif)
    {
        $this->authorize('affect', $actif);

        $actif->desaffecter();

        return response()->json([
            'message' => 'Actif désaffecté avec succès',
            'data' => $actif,
        ]);
    }

    /**
     * Récupérer l'historique de l'actif
     */
    public function historique(ActifInformatique $actif)
    {
        $this->authorize('viewHistory', $actif);

        $historique = $actif->historiques()->latest()->paginate(20);

        return response()->json([
            'data' => $historique->items(),
            'meta' => [
                'total' => $historique->total(),
                'per_page' => $historique->perPage(),
                'current_page' => $historique->currentPage(),
                'last_page' => $historique->lastPage(),
            ],
        ]);
    }

    /**
     * Récupérer les tickets de l'actif
     */
    public function tickets(ActifInformatique $actif)
    {
        $this->authorize('viewMaintenance', $actif);

        $tickets = $actif->tickets()->with(['createur', 'assigneA'])->latest()->paginate(20);

        return response()->json([
            'data' => $tickets->items(),
            'meta' => [
                'total' => $tickets->total(),
                'per_page' => $tickets->perPage(),
                'current_page' => $tickets->currentPage(),
                'last_page' => $tickets->lastPage(),
            ],
        ]);
    }

    /**
     * Statistiques des actifs
     */
    public function statistiques()
    {
        $this->authorize('viewAny', ActifInformatique::class);

        $stats = [
            'total' => ActifInformatique::count(),
            'par_type' => ActifInformatique::select('type', DB::raw('count(*) as total'))
                ->groupBy('type')
                ->get()
                ->pluck('total', 'type'),
            'par_etat' => ActifInformatique::select('etat', DB::raw('count(*) as total'))
                ->groupBy('etat')
                ->get()
                ->pluck('total', 'etat'),
            'affectes' => ActifInformatique::whereNotNull('utilisateur_affecte_id')->count(),
            'sans_affectation' => ActifInformatique::whereNull('utilisateur_affecte_id')->count(),
            'garantie_valide' => ActifInformatique::whereNotNull('garantie_fin')
                ->where('garantie_fin', '>=', now())
                ->count(),
            'garantie_expiree' => ActifInformatique::whereNotNull('garantie_fin')
                ->where('garantie_fin', '<', now())
                ->count(),
        ];

        return response()->json([
            'data' => $stats,
        ]);
    }

    /**
     * Actifs avec garantie expirant bientôt
     */
    public function garantieExpirant(Request $request)
    {
        $this->authorize('viewAny', ActifInformatique::class);

        $jours = $request->get('jours', 30);
        
        $actifs = ActifInformatique::with(['localisation', 'utilisateurAffecte'])
            ->whereNotNull('garantie_fin')
            ->whereBetween('garantie_fin', [now(), now()->addDays($jours)])
            ->orderBy('garantie_fin')
            ->paginate(20);

        return response()->json([
            'data' => $actifs->items(),
            'meta' => [
                'total' => $actifs->total(),
                'per_page' => $actifs->perPage(),
                'current_page' => $actifs->currentPage(),
                'last_page' => $actifs->lastPage(),
                'jours' => $jours,
            ],
        ]);
    }
}