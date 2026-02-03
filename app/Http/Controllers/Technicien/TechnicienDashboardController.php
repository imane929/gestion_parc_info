<?php

namespace App\Http\Controllers\Technicien;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Equipement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TechnicienDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get tickets assigned to this technicien
        $tickets = Ticket::where('technicien_id', $user->id)
            ->orWhere('createur_id', $user->id) //changed from user_id to createur_id
            ->with('equipement')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        // Get stats
        $stats = [
            'tickets_assigned' => Ticket::where('technicien_id', $user->id)
                ->where('statut', '!=', 'termine')
                ->count(),
            'active_interventions' => Ticket::where('technicien_id', $user->id)
                ->where('statut', 'en_cours')
                ->count(),
            'tickets_resolved' => Ticket::where('technicien_id', $user->id)
                ->where('statut', 'termine')
                ->whereMonth('created_at', now()->month)
                ->count(),
        ];
        
        return view('dashboard.technicien', compact('tickets', 'stats'));
    }
    
    public function tickets()
    {
        $user = Auth::user();
        $tickets = Ticket::where('technicien_id', $user->id)
            ->orWhere('createur_id', $user->id)
            ->with(['equipement', 'technicien', 'createur'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('technicien.tickets.index', compact('tickets'));
    }
    
    public function showTicket(Ticket $ticket)
    {
        // Check if the technicien has access to this ticket
        if ($ticket->technicien_id != Auth::id() && $ticket->createur_id != Auth::id()) {
            abort(403, 'Accès non autorisé à ce ticket.');
        }
        
        $ticket->load(['equipement', 'technicien', 'createur']);
        return view('technicien.tickets.show', compact('ticket'));
    }
    
    public function createTicket()
    {
        $equipements = Equipement::where('etat', '!=', 'hors_service')->get();
        return view('technicien.tickets.create', compact('equipements'));
    }
    
    public function storeTicket(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'equipement_id' => 'required|exists:equipements,id',
            'priorite' => 'required|in:faible,moyenne,haute,urgente',
        ]);
        
        $validated['createur_id'] = Auth::id();
        $validated['statut'] = 'ouvert';
        
        Ticket::create($validated);
        
        return redirect()->route('technicien.tickets')
            ->with('success', 'Ticket créé avec succès.');
    }
    
    public function startTicket(Ticket $ticket)
    {
        // Check if the technicien is assigned to this ticket
        if ($ticket->technicien_id != Auth::id()) {
            abort(403, 'Vous n\'êtes pas assigné à ce ticket.');
        }
        
        $ticket->update([
            'statut' => 'en_cours',
            'date_debut' => now(),
        ]);
        
        return redirect()->back()->with('success', 'Ticket marqué comme en cours.');
    }
    
    public function completeTicket(Ticket $ticket)
    {
        // Check if the technicien is assigned to this ticket
        if ($ticket->technicien_id != Auth::id()) {
            abort(403, 'Vous n\'êtes pas assigné à ce ticket.');
        }
        
        $ticket->update([
            'statut' => 'termine',
            'date_fin' => now(),
        ]);
        
        return redirect()->back()->with('success', 'Ticket marqué comme terminé.');
    }
    
    public function interventions()
    {
        $user = Auth::user();
        $interventions = Ticket::where('technicien_id', $user->id)
            ->where('statut', 'en_cours')
            ->with(['equipement', 'createur'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('technicien.interventions.index', compact('interventions'));
    }
    
    public function equipements()
    {
        $equipements = Equipement::where('etat', '!=', 'hors_service')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('technicien.equipements.index', compact('equipements'));
    }
    
    public function historique()
    {
        $user = Auth::user();
        $historique = Ticket::where('technicien_id', $user->id)
            ->where('statut', 'termine')
            ->with(['equipement', 'createur'])
            ->orderBy('date_fin', 'desc')
            ->paginate(20);
            
        return view('technicien.historique.index', compact('historique'));
    }
    
    public function rapports()
    {
        $user = Auth::user();
        $month = now()->month;
        $year = now()->year;
        
        $stats = [
            'tickets_ce_mois' => Ticket::where('technicien_id', $user->id)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->count(),
            'tickets_resolus' => Ticket::where('technicien_id', $user->id)
                ->where('statut', 'termine')
                ->whereMonth('date_fin', $month)
                ->whereYear('date_fin', $year)
                ->count(),
            'temps_moyen' => Ticket::where('technicien_id', $user->id)
                ->where('statut', 'termine')
                ->whereMonth('date_fin', $month)
                ->whereYear('date_fin', $year)
                ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, date_debut, date_fin)) as temps_moyen')
                ->value('temps_moyen'),
        ];
        
        return view('technicien.rapports.index', compact('stats'));
    }
}