<?php

namespace App\Http\Controllers\Technicien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TechnicienDashboardController extends Controller
{
    public function index()
    {
        // Technicien dashboard
        $technicien = auth()->user();
        
        $data = [
            'technicien' => $technicien,
            'tickets_en_cours' => [], // Add tickets assigned to this technician
            'equipements' => [], // Add equipment this technician maintains
        ];
        
        return view('dashboard.technicien', $data);
    }
}