<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipement;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Affectation;
use Illuminate\Http\Request;
use PDF;
use Excel;

class RapportController extends Controller
{
    public function index()
    {
        return view('admin.rapports.index');
    }
    
    public function generate(Request $request)
    {
        $request->validate([
            'type' => 'required|in:equipements,utilisateurs,tickets,affectations',
            'format' => 'required|in:pdf,excel,csv',
            'periode' => 'required|in:today,week,month,year,all'
        ]);
        
        $data = $this->getReportData($request->type, $request->periode);
        
        if ($request->format == 'pdf') {
            $pdf = PDF::loadView('admin.rapports.templates.' . $request->type, $data);
            return $pdf->download('rapport-' . $request->type . '-' . now()->format('Y-m-d') . '.pdf');
        }
        
        // For Excel/CSV, you'd need to implement using Laravel Excel package
        return back()->with('error', 'Format non supporté pour le moment.');
    }
    
    private function getReportData($type, $periode)
    {
        $dateFilter = $this->getDateFilter($periode);
        
        switch ($type) {
            case 'equipements':
                $query = Equipement::query();
                if ($dateFilter) {
                    $query->whereBetween('created_at', $dateFilter);
                }
                return ['equipements' => $query->get()];
                
            case 'utilisateurs':
                $query = User::query();
                if ($dateFilter) {
                    $query->whereBetween('created_at', $dateFilter);
                }
                return ['users' => $query->get()];
                
            case 'tickets':
                $query = Ticket::with(['equipement', 'technicien']);
                if ($dateFilter) {
                    $query->whereBetween('created_at', $dateFilter);
                }
                return ['tickets' => $query->get()];
                
            case 'affectations':
                $query = Affectation::with(['equipement', 'user']);
                if ($dateFilter) {
                    $query->whereBetween('created_at', $dateFilter);
                }
                return ['affectations' => $query->get()];
        }
        
        return [];
    }
    
    private function getDateFilter($periode)
    {
        $now = now();
        
        return match($periode) {
            'today' => [$now->copy()->startOfDay(), $now->copy()->endOfDay()],
            'week' => [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()],
            'month' => [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()],
            'year' => [$now->copy()->startOfYear(), $now->copy()->endOfYear()],
            default => null
        };
    }
}