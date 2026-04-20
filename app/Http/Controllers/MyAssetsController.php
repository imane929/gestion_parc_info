<?php

namespace App\Http\Controllers;

use App\Models\ActifInformatique;
use Illuminate\Http\Request;

class MyAssetsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get assets assigned to the current user
        $actifs = ActifInformatique::with('localisation')
            ->where('utilisateur_affecte_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total' => $actifs->count(),
            'en_service' => $actifs->whereIn('etat', ['neuf', 'bon', 'moyen'])->count(),
            'en_reparation' => $actifs->whereIn('etat', ['mauvais', 'hors_service'])->count(),
        ];

        return view('my-assets', compact('actifs', 'stats'));
    }
}
