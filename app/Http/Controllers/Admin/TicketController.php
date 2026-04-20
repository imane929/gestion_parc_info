<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TicketMaintenance;
use App\Models\ActifInformatique;
use App\Models\User as Utilisateur;
use App\Models\Intervention;
use App\Models\Commentaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', TicketMaintenance::class);

        $query = TicketMaintenance::with(['createur', 'assigneA', 'actif']);
        
        // If user is "utilisateur" role, show only their own tickets
        if (auth()->user()->hasRoleByCode('utilisateur')) {
            $query->where('created_by', auth()->id());
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

        // Filtre par statut
        if ($request->has('statut')) {
            $query->where('statut', $request->statut);
        }

        // Filtre par priorité
        if ($request->has('priorite')) {
            $query->where('priorite', $request->priorite);
        }

        // Filtre par technicien assigné
        if ($request->has('technicien_id')) {
            $query->where('assigne_a', $request->technicien_id);
        }

        // Filtre par créateur
        if ($request->has('createur_id')) {
            $query->where('created_by', $request->createur_id);
        }

        // Filtre par actif
        if ($request->has('actif_id')) {
            $query->where('actif_informatique_id', $request->actif_id);
        }

        // Tri
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        $query->orderBy($sort, $direction);

        $tickets = $query->paginate(25);
        
        $techniciens = Utilisateur::role('technicien')->get();
        $actifs = ActifInformatique::all();
        $statuts = ['ouvert', 'en_cours', 'en_attente', 'resolu', 'ferme'];
        $priorites = ['basse', 'moyenne', 'haute', 'urgente'];

        return view('admin.tickets.index', compact('tickets', 'techniciens', 'actifs', 'statuts', 'priorites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', TicketMaintenance::class);

        $actifs = ActifInformatique::all();
        $utilisateurs = Utilisateur::where('etat_compte', 'actif')->get();
        $techniciens = Utilisateur::role('technicien')->get();
        
        return view('admin.tickets.create', compact('actifs', 'utilisateurs', 'techniciens'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', TicketMaintenance::class);

        $validated = $request->validate([
            'actif_informatique_id' => 'nullable|exists:actifs_informatiques,id',
            'sujet' => 'required|string|max:200',
            'description' => 'required|string',
            'priorite' => 'required|in:basse,moyenne,haute,urgente',
            'assigne_a' => 'nullable|exists:utilisateurs,id',
            'pieces_jointes.*' => 'nullable|file|max:10240', // 10MB max
        ]);

        DB::beginTransaction();
        try {
            // Générer le numéro de ticket
            $numero = 'TICK-' . date('Ymd') . '-' . strtoupper(uniqid());

            $ticket = TicketMaintenance::create([
                'numero' => $numero,
                'actif_informatique_id' => $validated['actif_informatique_id'],
                'sujet' => $validated['sujet'],
                'description' => $validated['description'],
                'priorite' => $validated['priorite'],
                'statut' => $validated['assigne_a'] ? 'en_cours' : 'ouvert',
                'assigne_a' => $validated['assigne_a'],
                'created_by' => auth()->id(),
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
                        'uploaded_by' => auth()->id(),
                    ]);
                }
            }

            DB::commit();

            // TODO: Envoyer une notification si assigné

            return redirect()->route('admin.tickets.show', $ticket)
                ->with('success', 'Ticket créé avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Erreur lors de la création du ticket.')
                ->withInput();
        }
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

        return view('admin.tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TicketMaintenance $ticket)
    {
        $this->authorize('update', $ticket);

        $actifs = ActifInformatique::all();
        $techniciens = Utilisateur::role('technicien')->get();
        $statuts = ['ouvert', 'en_cours', 'en_attente', 'resolu', 'ferme'];
        $priorites = ['basse', 'moyenne', 'haute', 'urgente'];

        return view('admin.tickets.edit', compact('ticket', 'actifs', 'techniciens', 'statuts', 'priorites'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TicketMaintenance $ticket)
    {
        $this->authorize('update', $ticket);

        $validated = $request->validate([
            'actif_informatique_id' => 'nullable|exists:actifs_informatiques,id',
            'sujet' => 'required|string|max:200',
            'description' => 'required|string',
            'priorite' => 'required|in:basse,moyenne,haute,urgente',
            'statut' => 'required|in:ouvert,en_cours,en_attente,resolu,ferme',
            'assigne_a' => 'nullable|exists:utilisateurs,id',
            'pieces_jointes.*' => 'nullable|file|max:10240',
        ]);

        DB::beginTransaction();
        try {
            $ancienStatut = $ticket->statut;
            $ancienAssignation = $ticket->assigne_a;

            $ticket->update($validated);

            // Si le ticket vient d'être assigné
            if (!$ancienAssignation && $ticket->assigne_a) {
                $ticket->statut = 'en_cours';
                $ticket->save();
                
                // TODO: Notification au technicien
            }

            // Si le ticket est résolu
            if ($ancienStatut !== 'resolu' && $ticket->statut === 'resolu') {
                // TODO: Notification au créateur
            }

            // Gérer les nouvelles pièces jointes
            if ($request->hasFile('pieces_jointes')) {
                foreach ($request->file('pieces_jointes') as $file) {
                    $path = $file->store('pieces-jointes/tickets', 'public');
                    
                    $ticket->piecesJointes()->create([
                        'nom_fichier' => $file->getClientOriginalName(),
                        'chemin' => $path,
                        'mime' => $file->getMimeType(),
                        'taille' => $file->getSize(),
                        'uploaded_by' => auth()->id(),
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.tickets.show', $ticket)
                ->with('success', 'Ticket mis à jour avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Erreur lors de la mise à jour du ticket.')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TicketMaintenance $ticket)
    {
        $this->authorize('delete', $ticket);

        try {
            // Supprimer les pièces jointes
            foreach ($ticket->piecesJointes as $piece) {
                Storage::disk('public')->delete($piece->chemin);
                $piece->delete();
            }

            $ticket->delete();
            
            return redirect()->route('admin.tickets.index')
                ->with('success', 'Ticket supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression du ticket.');
        }
    }

    /**
     * Assigner un ticket à un technicien
     */
    public function assigner(Request $request, TicketMaintenance $ticket)
    {
        $this->authorize('assign', $ticket);

        $request->validate([
            'technicien_id' => 'required|exists:utilisateurs,id',
        ]);

        DB::beginTransaction();
        try {
            $ticket->assignerA(Utilisateur::find($request->technicien_id));
            
            // Ajouter un commentaire système
            $ticket->commentaires()->create([
                'utilisateur_id' => auth()->id(),
                'contenu' => "Ticket assigné à " . $ticket->assigneA->full_name,
            ]);

            DB::commit();
            if ($request->expectsJson() || str_contains((string) $request->header('Accept', ''), '*/*')) {
                return response()->json(['success' => true]);
            }
            // TODO: Notification
            return redirect()->back()->with('success', 'Ticket assigné avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->expectsJson() || str_contains((string) $request->header('Accept', ''), '*/*')) {
                return response()->json(['success' => false], 422);
            }
            return redirect()->back()->with('error', 'Erreur lors de l\'assignation.');
        }
    }

    /**
     * Résoudre un ticket
     */
    public function resoudre(Request $request, TicketMaintenance $ticket)
    {
        $this->authorize('resolve', $ticket);

        $request->validate([
            'commentaire' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $ticket->resoudre();

            // Ajouter un commentaire si fourni
            if ($request->commentaire) {
                $ticket->commentaires()->create([
                    'utilisateur_id' => auth()->id(),
                    'contenu' => $request->commentaire,
                ]);
            }

            // Ajouter un commentaire système
            $ticket->commentaires()->create([
                'utilisateur_id' => auth()->id(),
                'contenu' => "Ticket marqué comme résolu",
            ]);

            DB::commit();
            
            // TODO: Notification au créateur
            if ($request->expectsJson() || str_contains((string) $request->header('Accept', ''), '*/*')) {
                return response()->json(['success' => true]);
            }
            return redirect()->back()->with('success', 'Ticket résolu avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->expectsJson() || str_contains((string) $request->header('Accept', ''), '*/*')) {
                return response()->json(['success' => false], 422);
            }
            return redirect()->back()->with('error', 'Erreur lors de la résolution.');
        }
    }

    /**
     * Fermer un ticket
     */
    public function fermer(TicketMaintenance $ticket)
    {
        $this->authorize('resolve', $ticket);

        DB::beginTransaction();
        try {
            $ticket->fermer();

            // Ajouter un commentaire système
            $ticket->commentaires()->create([
                'utilisateur_id' => auth()->id(),
                'contenu' => "Ticket fermé",
            ]);

            DB::commit();
            
            return redirect()->back()->with('success', 'Ticket fermé avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de la fermeture.');
        }
    }

    /**
     * Ajouter un commentaire
     */
    public function addComment(Request $request, TicketMaintenance $ticket)
    {
        $this->authorize('addComment', $ticket);

        $request->validate([
            'contenu' => 'required|string',
        ]);

        $ticket->commentaires()->create([
            'utilisateur_id' => auth()->id(),
            'contenu' => $request->contenu,
        ]);

        return redirect()->back()->with('success', 'Commentaire ajouté.');
    }

    /**
     * Ajouter une intervention
     */
    public function addIntervention(Request $request, TicketMaintenance $ticket)
    {
        $this->authorize('createIntervention', $ticket);

        $validated = $request->validate([
            'date' => 'required|date',
            'travaux' => 'required|string',
            'temps_passe' => 'required|integer|min:1',
            'pieces_jointes.*' => 'nullable|file|max:10240',
        ]);

        DB::beginTransaction();
        try {
            $intervention = Intervention::create([
                'ticket_maintenance_id' => $ticket->id,
                'technicien_id' => auth()->id(),
                'date' => $validated['date'],
                'travaux' => $validated['travaux'],
                'temps_passe' => $validated['temps_passe'],
            ]);

            // Gérer les pièces jointes
            if ($request->hasFile('pieces_jointes')) {
                foreach ($request->file('pieces_jointes') as $file) {
                    $path = $file->store('pieces-jointes/interventions', 'public');
                    
                    $intervention->piecesJointes()->create([
                        'objet_type' => Intervention::class,
                        'objet_id' => $intervention->id,
                        'nom_fichier' => $file->getClientOriginalName(),
                        'chemin' => $path,
                        'mime' => $file->getMimeType(),
                        'taille' => $file->getSize(),
                        'uploaded_by' => auth()->id(),
                    ]);
                }
            }

            DB::commit();
            
            return redirect()->back()->with('success', 'Intervention ajoutée.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de l\'ajout de l\'intervention.');
        }
    }

    /**
     * Exporter les tickets
     */
    public function export(Request $request)
    {
        $this->authorize('export-data');

        $query = TicketMaintenance::with(['createur', 'assigneA', 'actif']);

        // Appliquer les filtres
        if ($request->has('statut')) {
            $query->where('statut', $request->statut);
        }
        if ($request->has('priorite')) {
            $query->where('priorite', $request->priorite);
        }
        if ($request->has('date_debut')) {
            $query->where('created_at', '>=', $request->date_debut);
        }
        if ($request->has('date_fin')) {
            $query->where('created_at', '<=', $request->date_fin);
        }

        $tickets = $query->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="tickets_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($tickets) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'Numéro', 'Sujet', 'Statut', 'Priorité', 'Créé par', 'Assigné à',
                'Actif', 'Date création', 'Date dernière mise à jour'
            ]);

            foreach ($tickets as $ticket) {
                fputcsv($file, [
                    $ticket->numero,
                    $ticket->sujet,
                    $ticket->statut,
                    $ticket->priorite,
                    $ticket->createur ? $ticket->createur->full_name : '',
                    $ticket->assigneA ? $ticket->assigneA->full_name : '',
                    $ticket->actif ? $ticket->actif->code_inventaire : '',
                    $ticket->created_at->format('d/m/Y H:i'),
                    $ticket->updated_at->format('d/m/Y H:i'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
