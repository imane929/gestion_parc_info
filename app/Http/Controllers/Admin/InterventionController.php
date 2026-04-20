<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Intervention;
use App\Models\TicketMaintenance;
use App\Models\User as Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InterventionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Intervention::class);

        $query = Intervention::with(['ticket', 'technicien']);

        // Recherche
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('travaux', 'like', "%{$search}%")
                  ->orWhereHas('ticket', function($q2) use ($search) {
                      $q2->where('numero', 'like', "%{$search}%")
                         ->orWhere('sujet', 'like', "%{$search}%");
                  })
                  ->orWhereHas('technicien', function($q2) use ($search) {
                      $q2->where('nom', 'like', "%{$search}%")
                         ->orWhere('prenom', 'like', "%{$search}%");
                  });
            });
        }

        // Filtre par technicien
        if ($request->has('technicien_id')) {
            $query->where('technicien_id', $request->technicien_id);
        }

        // Filtre par ticket
        if ($request->has('ticket_id')) {
            $query->where('ticket_maintenance_id', $request->ticket_id);
        }

        // Filtre par date
        if ($request->filled('date_debut')) {
            $query->where('date', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $query->where('date', '<=', $request->date_fin);
        }

        $interventions = $query->orderBy('date', 'desc')->paginate(25);
        $techniciens = Utilisateur::role('technicien')->get();
        $tickets = TicketMaintenance::all();

        return view('admin.interventions.index', compact('interventions', 'techniciens', 'tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $this->authorize('create', Intervention::class);

        $ticketId = $request->get('ticket_id');
        $ticket = $ticketId ? TicketMaintenance::find($ticketId) : null;
        
        $tickets = TicketMaintenance::whereIn('statut', ['en_cours', 'en_attente'])->get();
        $techniciens = Utilisateur::role('technicien')->get();

        return view('admin.interventions.create', compact('tickets', 'techniciens', 'ticket'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Intervention::class);

        $validated = $request->validate([
            'ticket_maintenance_id' => 'required|exists:tickets_maintenance,id',
            'technicien_id' => 'required|exists:utilisateurs,id',
            'date' => 'required|date',
            'travaux' => 'required|string',
            'temps_passe' => 'required|integer|min:1',
            'notes' => 'nullable|string',
            'rapport' => 'nullable|string|max:255',
            'pieces_jointes.*' => 'nullable|file|max:10240',
            'commentaire' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $intervention = Intervention::create([
                'ticket_maintenance_id' => $validated['ticket_maintenance_id'],
                'technicien_id' => $validated['technicien_id'],
                'date' => $validated['date'],
                'travaux' => $validated['travaux'],
                'temps_passe' => $validated['temps_passe'],
                'notes' => $validated['notes'] ?? null,
                'rapport' => $validated['rapport'] ?? null,
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
                        'uploaded_by' => auth()->id(),
                    ]);
                }
            }

            // Ajouter un commentaire au ticket si fourni
            if ($validated['commentaire']) {
                $intervention->ticket->commentaires()->create([
                    'utilisateur_id' => auth()->id(),
                    'contenu' => $validated['commentaire'],
                ]);
            }

            // Mettre à jour le statut du ticket si nécessaire
            $ticket = $intervention->ticket;
            if ($ticket->statut === 'ouvert') {
                $ticket->update(['statut' => 'en_cours']);
            }

            DB::commit();

            return redirect()->route('admin.interventions.show', $intervention)
                ->with('success', 'Intervention créée avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Erreur lors de la création de l\'intervention.')
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Intervention $intervention)
    {
        $this->authorize('view', $intervention);

        $intervention->load([
            'ticket.createur',
            'ticket.actif',
            'technicien',
            'piecesJointes.uploader'
        ]);

        return view('admin.interventions.show', compact('intervention'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Intervention $intervention)
    {
        $this->authorize('update', $intervention);

        $tickets = TicketMaintenance::all();
        $techniciens = Utilisateur::role('technicien')->get();

        return view('admin.interventions.edit', compact('intervention', 'tickets', 'techniciens'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Intervention $intervention)
    {
        $this->authorize('update', $intervention);

        $validated = $request->validate([
            'ticket_maintenance_id' => 'required|exists:tickets_maintenance,id',
            'technicien_id' => 'required|exists:utilisateurs,id',
            'date' => 'required|date',
            'travaux' => 'required|string',
            'temps_passe' => 'required|integer|min:1',
            'notes' => 'nullable|string',
            'rapport' => 'nullable|string|max:255',
            'pieces_jointes.*' => 'nullable|file|max:10240',
        ]);

        DB::beginTransaction();
        try {
            $intervention->update([
                'ticket_maintenance_id' => $validated['ticket_maintenance_id'],
                'technicien_id' => $validated['technicien_id'],
                'date' => $validated['date'],
                'travaux' => $validated['travaux'],
                'temps_passe' => $validated['temps_passe'],
                'notes' => $validated['notes'] ?? null,
                'rapport' => $validated['rapport'] ?? null,
            ]);

            // Gérer les nouvelles pièces jointes
            if ($request->hasFile('pieces_jointes')) {
                foreach ($request->file('pieces_jointes') as $file) {
                    $path = $file->store('pieces-jointes/interventions', 'public');
                    
                    $intervention->piecesJointes()->create([
                        'nom_fichier' => $file->getClientOriginalName(),
                        'chemin' => $path,
                        'mime' => $file->getMimeType(),
                        'taille' => $file->getSize(),
                        'uploaded_by' => auth()->id(),
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.interventions.show', $intervention)
                ->with('success', 'Intervention mise à jour avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Erreur lors de la mise à jour de l\'intervention.')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Intervention $intervention)
    {
        $this->authorize('delete', $intervention);

        try {
            // Supprimer les pièces jointes
            foreach ($intervention->piecesJointes as $piece) {
                Storage::disk('public')->delete($piece->chemin);
                $piece->delete();
            }

            $intervention->delete();
            
            return redirect()->route('admin.interventions.index')
                ->with('success', 'Intervention supprimée avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression de l\'intervention.');
        }
    }

    /**
     * Afficher les interventions par technicien
     */
    public function parTechnicien(Request $request, Utilisateur $technicien)
    {
        $this->authorize('viewAny', Intervention::class);

        $query = Intervention::with('ticket')
            ->where('technicien_id', $technicien->id);

        // Filtre par période
        if ($request->has('periode')) {
            $periode = $request->periode;
            switch ($periode) {
                case 'semaine':
                    $query->where('date', '>=', now()->startOfWeek());
                    break;
                case 'mois':
                    $query->where('date', '>=', now()->startOfMonth());
                    break;
                case 'trimestre':
                    $query->where('date', '>=', now()->startOfQuarter());
                    break;
                case 'annee':
                    $query->where('date', '>=', now()->startOfYear());
                    break;
            }
        }

        $interventions = $query->orderBy('date', 'desc')->paginate(25);
        
        // Statistiques
        $totalTemps = $interventions->sum('temps_passe');
        $nombreInterventions = $interventions->count();
        $ticketsResolus = $interventions->unique('ticket_maintenance_id')
            ->filter(function($intervention) {
                return $intervention->ticket->statut === 'resolu';
            })
            ->count();

        return view('admin.interventions.technicien', compact(
            'interventions', 'technicien', 'totalTemps', 
            'nombreInterventions', 'ticketsResolus'
        ));
    }

    /**
     * Exporter les interventions
     */
    public function export(Request $request)
    {
        $this->authorize('export-data');

        $query = Intervention::with(['ticket', 'technicien']);

        if ($request->has('technicien_id')) {
            $query->where('technicien_id', $request->technicien_id);
        }
        if ($request->has('date_debut')) {
            $query->where('date', '>=', $request->date_debut);
        }
        if ($request->has('date_fin')) {
            $query->where('date', '<=', $request->date_fin);
        }

        $interventions = $query->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="interventions_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($interventions) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'Ticket', 'Technicien', 'Date', 'Travaux', 'Temps passé', 
                'Ticket sujet', 'Ticket statut'
            ]);

            foreach ($interventions as $intervention) {
                fputcsv($file, [
                    $intervention->ticket->numero,
                    $intervention->technicien->full_name,
                    $intervention->date->format('d/m/Y'),
                    substr($intervention->travaux, 0, 100),
                    $intervention->temps_formate,
                    $intervention->ticket->sujet,
                    $intervention->ticket->statut,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}