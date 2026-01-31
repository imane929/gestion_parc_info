<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Equipement;
use App\Models\Ticket;
use App\Models\Affectation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Get statistics
        $stats = [
            'totalEquipements' => Equipement::count(),
            'totalUsers' => User::count(),
            'maintenanceCount' => Ticket::where('statut', '!=', 'termine')->count(),
            'openTickets' => Ticket::where('statut', 'ouvert')->count(),
            'activeAffectations' => Affectation::whereNull('date_retour')->count(),
            'recentUsers' => User::latest()->take(5)->get(),
            'equipmentByType' => $this->getEquipmentByType(),
            'recentEquipments' => Equipement::latest()->take(5)->get(),
            'recentTickets' => Ticket::with(['equipement', 'technicien'])
                ->latest()
                ->take(5)
                ->get()
        ];
        
        return view('dashboard.admin', compact('stats'));
    }
    
    private function getEquipmentByType()
    {
        return Equipement::select('type', DB::raw('COUNT(*) as count'))
            ->groupBy('type')
            ->pluck('count', 'type')
            ->toArray();
    }
    
    // API Methods for AJAX requests
    public function getStats()
    {
        $stats = [
            'totalEquipements' => Equipement::count(),
            'totalUsers' => User::count(),
            'maintenanceCount' => Ticket::where('statut', '!=', 'termine')->count(),
            'openTickets' => Ticket::where('statut', 'ouvert')->count(),
            'chartData' => $this->getChartData()
        ];
        
        return response()->json($stats);
    }
    
    public function getRecentEquipments()
    {
        $equipments = Equipement::latest()->take(10)->get();
        return response()->json($equipments);
    }
    
    public function getRecentMaintenance()
    {
        $maintenance = Ticket::with('equipement')
            ->where('statut', '!=', 'termine')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($ticket) {
                return [
                    'equipement_nom' => $ticket->equipement->nom ?? 'N/A',
                    'description' => $ticket->description,
                    'date' => $ticket->created_at->format('Y-m-d H:i:s'),
                    'statut' => $ticket->statut,
                    'priorite' => $ticket->priorite
                ];
            });
        
        return response()->json($maintenance);
    }
    
    private function getChartData()
    {
        $types = Equipement::selectRaw('type, COUNT(*) as count')
            ->groupBy('type')
            ->get();
        
        $labels = $types->pluck('type')->toArray();
        $data = $types->pluck('count')->toArray();
        
        $backgroundColors = [
            'rgba(79, 70, 229, 0.7)',
            'rgba(124, 58, 237, 0.7)',
            'rgba(59, 130, 246, 0.7)',
            'rgba(16, 185, 129, 0.7)',
            'rgba(245, 158, 11, 0.7)',
            'rgba(239, 68, 68, 0.7)',
            'rgba(139, 92, 246, 0.7)',
            'rgba(6, 182, 212, 0.7)'
        ];
        
        return [
            'labels' => $labels,
            'datasets' => [[
                'label' => 'Équipements par type',
                'data' => $data,
                'backgroundColor' => array_slice($backgroundColors, 0, count($labels)),
                'borderColor' => array_slice($backgroundColors, 0, count($labels)),
                'borderWidth' => 1
            ]]
        ];
    }
}