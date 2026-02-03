<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Equipement;
use App\Models\Affectation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get user's assigned equipment through affectations
        $affectations = Affectation::where('user_id', $user->id)
            ->whereNull('date_retour')
            ->with('equipement')
            ->get();
            
        $equipements = $affectations->pluck('equipement');
        
        // Get user's tickets
        $tickets = Ticket::where('createur_id', $user->id)
            ->with('equipement')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
                    
        // Stats
        $stats = [
            'equipementsCount' => $equipements->count(),
            'ticketsCount' => Ticket::where('createur_id', $user->id)->count(),
            'resolvedTickets' => Ticket::where('createur_id', $user->id)
                ->where('statut', 'termine')
                ->count(),
            'pendingTickets' => Ticket::where('createur_id', $user->id)
                ->where('statut', '!=', 'termine')
                ->count(),
        ];
        
        return view('dashboard.user', compact('equipements', 'tickets', 'stats'));
    }
    
    public function tickets()
    {
        $user = Auth::user();
        $tickets = Ticket::where('createur_id', $user->id)
            ->with(['equipement', 'technicien'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('user.tickets.index', compact('tickets'));
    }
    
    public function createTicket()
    {
        // Get user's assigned equipment
        $affectations = Affectation::where('user_id', Auth::id())
            ->whereNull('date_retour')
            ->with('equipement')
            ->get();
            
        $equipements = $affectations->pluck('equipement');
        
        return view('user.tickets.create', compact('equipements'));
    }
    
    public function storeTicket(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'equipement_id' => 'required|exists:equipements,id',
            'priorite' => 'required|in:faible,moyenne,haute,urgente',
        ]);
        
        $validated['user_id'] = Auth::id();
        $validated['statut'] = 'ouvert';
        
        Ticket::create($validated);
        
        return redirect()->route('user.tickets')
            ->with('success', 'Ticket créé avec succès.');
    }
    
    public function equipements()
    {
        $user = Auth::user();
        
        $affectations = Affectation::where('user_id', $user->id)
            ->whereNull('date_retour')
            ->with('equipement')
            ->paginate(20);
            
        return view('user.equipements.index', compact('affectations'));
    }
}