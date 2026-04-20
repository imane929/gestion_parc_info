<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ActifInformatique;
use App\Models\TicketMaintenance;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $results = [];

        // Search assets
        $assets = ActifInformatique::where('code_inventaire', 'like', "%{$query}%")
            ->orWhere('marque', 'like', "%{$query}%")
            ->orWhere('modele', 'like', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(function($asset) {
                return [
                    'type' => 'asset',
                    'id' => $asset->id,
                    'title' => $asset->code_inventaire,
                    'subtitle' => $asset->marque . ' ' . $asset->modele,
                    'url' => route('admin.actifs.show', $asset),
                    'icon' => 'fa-desktop'
                ];
            });

        $results = array_merge($results, $assets->toArray());

        return response()->json($results);
    }
}