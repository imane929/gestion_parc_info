<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\TicketMaintenance;
use App\Models\Commentaire;
use App\Models\Intervention;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', TicketMaintenance::class);

        $user = $request->user();
        $query = TicketMaintenance::with(['createur', 'assigneA', 'actif']);

        // Filtres selon le rôle
        if ($user->hasRole('utilisateur') && !$user->hasAnyRole(['admin', 'responsable_it', 'technicien'])) {
            // Les utilisateurs normaux voient seulement leurs tickets
            $query->where('created_by', $user->id);
        } elseif ($user->hasRole('technicien') && !$user->hasAnyRole(['admin', 'responsable_it'])) {
            // Les techniciens voient leurs tickets assignés
            $query->where(function($q) use ($user) {
                $q->where('created_by', $user->id)
                  ->orWhere('assigne_a', $user->id);
            });
        }

        // Filtres supplémentaires
        if ($request->has('statut')) {
            $query->where('statut', $request->statut);
        }
        if ($request->has('priorite')) {
            $query->where('priorite', $request->priorite);
        }
        if ($request->has('createur_id')) {
            $query->where('created_by', $request->createur_id);
        }
        if ($request->has('technicien_id')) {
            $query->where('assigne_a', $request->technicien_id);
        }
        if ($request->has('actif_id')) {
            $query->where('actif_informatique_id', $request->actif_id);
        }
        if ($request->has('date_debut')) {
            $query->where('created_at', '>=', $request->date_debut);
        }
        if ($request->has('date_fin')) {
            $query->where('created_at', '<=', $request->date_fin);
        }

        // Recherche
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('numero', 'like', "%{$search}%")
                  ->orWhere('sujet', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Pagination
        $perPage = $request->get('per_page', 15);
        $tickets = $query->orderBy('created_at', 'desc')->paginate($perPage);

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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', TicketMaintenance::class);

        $validator = Validator::make($request->all(), [
            'actif_informatique_id' => 'nullable|exists:actifs_informatiques,id',
            'sujet' => 'required|string|max:200',
            'description' => 'required|string',
            'priorite' => 'required|in:basse,moyenne,haute,urgente',
            'pieces_jointes.*' => 'nullable|file|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Générer le numéro de ticket
        $numero = 'TICK-' . date('Ymd') . '-' . strtoupper(uniqid());

        $ticket = TicketMaintenance::create([
            'numero' => $numero,
            'actif_informatique_id' => $request->actif_informatique_id,
            'sujet' => $request->sujet,
            'description' => $request->description,
            'priorite' => $request->priorite,
            'statut' => 'ouvert',
            'created_by' => $request->user()->id,
        ]);

        // Gérer les pièces jointes
        if ($request->hasFile('pieces_jointes')) {
            foreach ($request->file('pieces_jointes') as $file) {
                $path = $file->store('pieces-jointes/tickets', 'public');
                
                $ticket->piecesJointes()->create([
                    'nom_fichier' => $file->getClientOriginalName(),
                    'chemin' => $path,
                    'mime' => $file->getMimeType(),
                    'taille' => $file->getSize(),
                    'uploaded_by' => $request->user()->id,
                ]);
            }
        }

        return response()->json([
            'message' => 'Ticket créé avec succès',
            'data' => $ticket->load(['createur', 'actif']),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(TicketMaintenance $ticket)
    {
        $this->authorize('view', $ticket);

        $ticket->load([
            'createur',
            'assigneA',
            'actif',
            'interventions.technicien',
            'commentaires.utilisateur',
            'piecesJointes.uploader'
        ]);

        return response()->json([
            'data' => $ticket,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TicketMaintenance $ticket)
    {
        $this->authorize('update', $ticket);

        $validator = Validator::make($request->all(), [
            'sujet' => 'sometimes|required|string|max:200',
            'description' => 'sometimes|required|string',
            'priorite' => 'sometimes|required|in:basse,moyenne,haute,urgente',
            'statut' => 'sometimes|required|in:ouvert,en_cours,en_attente,resolu,ferme',
            'actif_informatique_id' => 'sometimes|nullable|exists:actifs_informatiques,id',
            'pieces_jointes.*' => 'sometimes|nullable|file|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $ticket->update($validator->validated());

        // Gérer les nouvelles pièces jointes
        if ($request->hasFile('pieces_jointes')) {
            foreach ($request->file('pieces_jointes') as $file) {
                $path = $file->store('pieces-jointes/tickets', 'public');
                
                $ticket->piecesJointes()->create([
                    'nom_fichier' => $file->getClientOriginalName(),
                    'chemin' => $path,
                    'mime' => $file->getMimeType(),
                    'taille' => $file->getSize(),
                    'uploaded_by' => $request->user()->id,
                ]);
            }
        }

        return response()->json([
            'message' => 'Ticket mis à jour avec succès',
            'data' => $ticket->load(['createur', 'assigneA', 'actif']),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TicketMaintenance $ticket)
    {
        $this->authorize('delete', $ticket);

        // Supprimer les pièces jointes
        foreach ($ticket->piecesJointes as $piece) {
            Storage::disk('public')->delete($piece->chemin);
            $piece->delete();
        }

        $ticket->delete();

        return response()->json([
            'message' => 'Ticket supprimé avec succès',
        ]);
    }

    /**
     * Assigner le ticket à un technicien
     */
    public function assigner(Request $request, TicketMaintenance $ticket)
    {
        $this->authorize('assign', $ticket);

        $validator = Validator::make($request->all(), [
            'technicien_id' => 'required|exists:utilisateurs,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $ticket->assignerA(\App\Models\User::find($request->technicien_id));

        // Ajouter un commentaire système
        $ticket->commentaires()->create([
            'utilisateur_id' => $request->user()->id,
            'contenu' => "Ticket assigné via API",
        ]);

        return response()->json([
            'message' => 'Ticket assigné avec succès',
            'data' => $ticket->load('assigneA'),
        ]);
    }

    /**
     * Résoudre le ticket
     */
    public function resoudre(Request $request, TicketMaintenance $ticket)
    {
        $this->authorize('resolve', $ticket);

        $ticket->resoudre();

        // Ajouter un commentaire si fourni
        if ($request->has('commentaire')) {
            $ticket->commentaires()->create([
                'utilisateur_id' => $request->user()->id,
                'contenu' => $request->commentaire,
            ]);
        }

        return response()->json([
            'message' => 'Ticket résolu avec succès',
            'data' => $ticket,
        ]);
    }

    /**
     * Ajouter un commentaire
     */
    public function addComment(Request $request, TicketMaintenance $ticket)
    {
        $this->authorize('addComment', $ticket);

        $validator = Validator::make($request->all(), [
            'contenu' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $commentaire = $ticket->commentaires()->create([
            'utilisateur_id' => $request->user()->id,
            'contenu' => $request->contenu,
        ]);

        $commentaire->load('utilisateur');

        return response()->json([
            'message' => 'Commentaire ajouté',
            'data' => $commentaire,
        ], 201);
    }

    /**
     * Ajouter une intervention
     */
    public function addIntervention(Request $request, TicketMaintenance $ticket)
    {
        $this->authorize('createIntervention', $ticket);

        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'travaux' => 'required|string',
            'temps_passe' => 'required|integer|min:1',
            'pieces_jointes.*' => 'nullable|file|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $intervention = Intervention::create([
            'ticket_maintenance_id' => $ticket->id,
            'technicien_id' => $request->user()->id,
            'date' => $request->date,
            'travaux' => $request->travaux,
            'temps_passe' => $request->temps_passe,
        ]);

        // Gérer les pièces jointes
        if ($request->hasFile('pieces_jointes')) {
            foreach ($request->file('pieces_jointes') as $file) {
                $path = $file->store('pieces-jointes/interventions', 'public');
                
                $intervention->piecesJointes()->create([
                    'nom_fichier' => $file->getClientOriginalName(),
                    'chemin' => $path,
                    'mime' => $file->getMimeType(),
                    'taille' => $file->getSize(),
                    'uploaded_by' => $request->user()->id,
                ]);
            }
        }

        $intervention->load('technicien');

        return response()->json([
            'message' => 'Intervention ajoutée',
            'data' => $intervention,
        ], 201);
    }

    /**
     * Récupérer les commentaires
     */
    public function commentaires(TicketMaintenance $ticket)
    {
        $this->authorize('viewComments', $ticket);

        $commentaires = $ticket->commentaires()->with('utilisateur')->latest()->paginate(20);

        return response()->json([
            'data' => $commentaires->items(),
            'meta' => [
                'total' => $commentaires->total(),
                'per_page' => $commentaires->perPage(),
                'current_page' => $commentaires->currentPage(),
                'last_page' => $commentaires->lastPage(),
            ],
        ]);
    }

    /**
     * Récupérer les interventions
     */
    public function interventions(TicketMaintenance $ticket)
    {
        $this->authorize('viewInterventions', $ticket);

        $interventions = $ticket->interventions()->with('technicien')->latest()->paginate(20);

        return response()->json([
            'data' => $interventions->items(),
            'meta' => [
                'total' => $interventions->total(),
                'per_page' => $interventions->perPage(),
                'current_page' => $interventions->currentPage(),
                'last_page' => $interventions->lastPage(),
            ],
        ]);
    }

    /**
     * Récupérer les pièces jointes
     */
    public function piecesJointes(TicketMaintenance $ticket)
    {
        $this->authorize('viewAttachments', $ticket);

        $pieces = $ticket->piecesJointes()->with('uploader')->latest()->paginate(20);

        return response()->json([
            'data' => $pieces->items(),
            'meta' => [
                'total' => $pieces->total(),
                'per_page' => $pieces->perPage(),
                'current_page' => $pieces->currentPage(),
                'last_page' => $pieces->lastPage(),
            ],
        ]);
    }

    /**
     * Statistiques des tickets
     */
    public function statistiques(Request $request)
    {
        $this->authorize('viewAny', TicketMaintenance::class);

        $user = $request->user();
        $query = TicketMaintenance::query();

        // Filtres selon le rôle
        if ($user->hasRole('utilisateur') && !$user->hasAnyRole(['admin', 'responsable_it', 'technicien'])) {
            $query->where('created_by', $user->id);
        } elseif ($user->hasRole('technicien') && !$user->hasAnyRole(['admin', 'responsable_it'])) {
            $query->where(function($q) use ($user) {
                $q->where('created_by', $user->id)
                  ->orWhere('assigne_a', $user->id);
            });
        }

        $periode = $request->get('periode', '30'); // jours
        $dateLimite = now()->subDays($periode);

        $stats = [
            'total' => $query->count(),
            'ouverts' => $query->where('statut', 'ouvert')->count(),
            'en_cours' => $query->where('statut', 'en_cours')->count(),
            'resolus' => $query->where('statut', 'resolu')->count(),
            'par_priorite' => [
                'basse' => $query->where('priorite', 'basse')->count(),
                'moyenne' => $query->where('priorite', 'moyenne')->count(),
                'haute' => $query->where('priorite', 'haute')->count(),
                'urgente' => $query->where('priorite', 'urgente')->count(),
            ],
            'recent' => [
                'total' => $query->where('created_at', '>=', $dateLimite)->count(),
                'resolus' => $query->where('statut', 'resolu')
                    ->where('created_at', '>=', $dateLimite)
                    ->count(),
                'temps_moyen_resolution' => $this->calculerTempsMoyenResolution($query, $dateLimite),
            ],
        ];

        return response()->json([
            'data' => $stats,
            'periode' => $periode,
        ]);
    }

    /**
     * Calculer le temps moyen de résolution
     */
    private function calculerTempsMoyenResolution($query, $dateLimite)
    {
        $ticketsResolus = clone $query;
        $ticketsResolus = $ticketsResolus->where('statut', 'resolu')
            ->where('created_at', '>=', $dateLimite)
            ->get();

        if ($ticketsResolus->isEmpty()) {
            return 0;
        }

        $totalMinutes = $ticketsResolus->sum(function($ticket) {
            return $ticket->duree_ouverture * 24 * 60;
        });

        return round($totalMinutes / $ticketsResolus->count());
    }
}