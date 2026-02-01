<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Equipement;
use App\Models\User;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with(['equipement', 'technicien', 'createur'])->latest()->paginate(10);
        return view('admin.tickets.index', compact('tickets'));
    }
    
    public function create()
    {
        $equipements = Equipement::all();
        $techniciens = User::where('role', 'technicien')->get();
        return view('admin.tickets.create', compact('equipements', 'techniciens'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'equipement_id' => 'required|exists:equipements,id',
            'description' => 'required|string',
            'priorite' => 'required|in:faible,moyenne,haute,urgente',
            'technicien_id' => 'nullable|exists:users,id',
            'solution' => 'nullable|string',
        ]);
        
        // Add the createur_id (current logged-in user)
        $data = $request->all();
        $data['createur_id'] = auth()->id(); // This is the key fix!
        $data['statut'] = 'ouvert'; // Set default status
    
        Ticket::create($data);
    
        return redirect()->route('admin.tickets.index')
            ->with('success', 'Ticket créé avec succès.');
    }
    
    public function show(Ticket $ticket)
    {
        $ticket->load(['equipement', 'technicien', 'createur']);
        return view('admin.tickets.show', compact('ticket'));
    }
    
    public function edit(Ticket $ticket)
    {
        $equipements = Equipement::all();
        $techniciens = User::where('role', 'technicien')->get();
        return view('admin.tickets.edit', compact('ticket', 'equipements', 'techniciens'));
    }
    
    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'equipement_id' => 'required|exists:equipements,id',
            'description' => 'required|string',
            'priorite' => 'required|in:faible,moyenne,haute,urgente',
            'statut' => 'required|in:ouvert,en_cours,termine,annule',
            'technicien_id' => 'nullable|exists:users,id',
            'solution' => 'nullable|string',
        ]);
        
        $data = $request->all();
    
        // If ticket is being closed, set date_cloture
        if ($request->statut == 'termine' && $ticket->statut != 'termine') {
            $data['date_cloture'] = now();
        }
    
        $ticket->update($data);
    
        return redirect()->route('admin.tickets.index')
            ->with('success', 'Ticket mis à jour avec succès.');
    }
    
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        
        return redirect()->route('admin.tickets.index')
            ->with('success', 'Ticket supprimé avec succès.');
    }
}