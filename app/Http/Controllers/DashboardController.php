<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipement;
use App\Models\Ticket;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $stats = [
            'userEquipments' => Equipement::where('user_id', $user->id)->count(),
            'userTickets' => Ticket::where('createur_id', $user->id)->count(),
            'activeTickets' => Ticket::where('createur_id', $user->id)
                ->where('statut', '!=', 'termine')
                ->count(),
            'assignedEquipments' => Equipement::where('user_id', $user->id)
                ->latest()
                ->take(5)
                ->get()
        ];
        
        return view('dashboard.user', compact('stats', 'user'));
    }
}