<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActifInformatique;
use App\Models\TicketMaintenance;
use App\Models\User as Utilisateur;
use App\Models\Logiciel;
use App\Models\ContratMaintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Afficher la page des rapports
     */
    public function index()
    {
        $this->authorize('reports.view');

        return view('admin.reports.index');
    }

    /**
     * Générer un rapport d'actifs
     */
    public function actifs(Request $request)
    {
        $this->authorize('reports.generate');

        $query = ActifInformatique::with(['localisation', 'utilisateurAffecte']);

        // Filtres
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }
        if ($request->has('etat')) {
            $query->where('etat', $request->etat);
        }
        if ($request->has('localisation_id')) {
            $query->where('localisation_id', $request->localisation_id);
        }
        if ($request->has('date_achat_debut')) {
            $query->where('date_achat', '>=', $request->date_achat_debut);
        }
        if ($request->has('date_achat_fin')) {
            $query->where('date_achat', '<=', $request->date_achat_fin);
        }

        // clone query to compute overall stats before pagination
        $allActifs = (clone $query)->get();
        $totalValeur = 0; // À calculer si on a un champ prix

        $actifs = $query->paginate(50)->appends($request->query());

        // statistics for full dataset
        $totalCount = $allActifs->count();
        $inUse = $allActifs->whereNotNull('utilisateur_affecte_id')->count();
        $inStore = $allActifs->whereNull('utilisateur_affecte_id')->count();
        $underWarranty = $allActifs->filter(function($a) { return $a->garantieEstValide(); })->count();

        // chart data
        $typeData = $allActifs->groupBy('type')->map->count();
        $stateData = $allActifs->groupBy('etat')->map->count();

        return view('admin.reports.actifs', compact(
            'actifs',
            'totalValeur',
            'totalCount',
            'inUse',
            'inStore',
            'underWarranty',
            'typeData',
            'stateData'
        ));
    }

    /**
     * Générer un rapport de tickets
     */
    public function tickets(Request $request)
    {
        $this->authorize('reports.generate');

        $query = TicketMaintenance::with(['createur', 'assigneA', 'actif']);

        // Filtres
        if ($request->has('statut')) {
            $query->where('statut', $request->statut);
        }
        if ($request->has('priorite')) {
            $query->where('priorite', $request->priorite);
        }
        if ($request->has('technicien_id')) {
            $query->where('assigne_a', $request->technicien_id);
        }
        if ($request->has('date_debut')) {
            $query->where('created_at', '>=', $request->date_debut);
        }
        if ($request->has('date_fin')) {
            $query->where('created_at', '<=', $request->date_fin);
        }

        // keep full collection for stats and charts
        $allTickets = (clone $query)->get();
        
        $tickets = $query->paginate(50)->appends($request->query());

        // Statistiques based on all results
        $stats = [
            'total' => $allTickets->count(),
            'ouverts' => $allTickets->where('statut', 'ouvert')->count(),
            'en_cours' => $allTickets->where('statut', 'en_cours')->count(),
            'resolus' => $allTickets->where('statut', 'resolu')->count(),
            'temps_moyen_resolution' => $this->calculerTempsMoyenResolution($allTickets),
        ];

        // extra summary values used in view
        $highPriority = $allTickets->whereIn('priorite', ['haute', 'urgente'])->count();
        $newLast7 = $allTickets->where('created_at', '>=', now()->subDays(7))->count();

        // chart datasets based on full collection
        $statusData = [
            'ouvert' => $allTickets->where('statut', 'ouvert')->count(),
            'en_cours' => $allTickets->where('statut', 'en_cours')->count(),
            'resolu' => $allTickets->where('statut', 'resolu')->count(),
            'ferme' => $allTickets->where('statut', 'ferme')->count(),
        ];

        $priorityData = $allTickets->groupBy('priorite')->map->count();

        // trend counts for last 30 days
        $trendLabels = [];
        $trendCounts = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $trendLabels[] = $date;
            $trendCounts[] = $allTickets->where('created_at', '>=', $date . ' 00:00:00')
                                       ->where('created_at', '<=', $date . ' 23:59:59')
                                       ->count();
        }

        return view('admin.reports.tickets', compact(
            'tickets',
            'stats',
            'highPriority',
            'newLast7',
            'statusData',
            'priorityData',
            'trendLabels',
            'trendCounts'
        ));
    }

    /**
     * Générer un rapport d'inventaire
     */
    public function inventaire()
    {
        $this->authorize('reports.generate');

        // Actifs par type
        $actifsParType = ActifInformatique::select('type', DB::raw('count(*) as total'))
            ->groupBy('type')
            ->get()
            ->pluck('total', 'type');

        // Actifs par état
        $actifsParEtat = ActifInformatique::select('etat', DB::raw('count(*) as total'))
            ->groupBy('etat')
            ->get()
            ->pluck('total', 'etat');

        // Actifs par localisation
        $actifsParLocalisation = ActifInformatique::with('localisation')
            ->select('localisation_id', DB::raw('count(*) as total'))
            ->groupBy('localisation_id')
            ->get()
            ->mapWithKeys(function($item) {
                return [$item->localisation ? $item->localisation->nom_complet : 'Non localisé' => $item->total];
            });

        // Âge des actifs
        $actifsParAge = ActifInformatique::whereNotNull('date_achat')
            ->get()
            ->groupBy(function($actif) {
                $age = $actif->age;
                if ($age < 1) return '< 1 an';
                if ($age < 3) return '1-3 ans';
                if ($age < 5) return '3-5 ans';
                return '> 5 ans';
            })
            ->map->count();

        return view('admin.reports.inventaire', compact(
            'actifsParType',
            'actifsParEtat',
            'actifsParLocalisation',
            'actifsParAge'
        ));
    }

    /**
     * Générer un rapport de maintenance
     */
    public function maintenance(Request $request)
    {
        $this->authorize('reports.generate');

        $periode = $request->get('periode', '30'); // jours

        // Tickets par technicien
        $ticketsParTechnicien = TicketMaintenance::where('created_at', '>=', now()->subDays($periode))
            ->whereNotNull('assigne_a')
            ->with('assigneA')
            ->select('assigne_a', DB::raw('count(*) as total'))
            ->groupBy('assigne_a')
            ->get()
            ->mapWithKeys(function($item) {
                return [$item->assigneA->full_name ?? 'Non assigné' => $item->total];
            });

        // Temps moyen de résolution par technicien
        $tempsResolution = DB::table('tickets_maintenance as t')
            ->join('interventions as i', 't.id', '=', 'i.ticket_maintenance_id')
            ->join('utilisateurs as u', 'i.technicien_id', '=', 'u.id')
            ->where('t.created_at', '>=', now()->subDays($periode))
            ->where('t.statut', 'resolu')
            ->select('u.nom', 'u.prenom', DB::raw('AVG(i.temps_passe) as temps_moyen'))
            ->groupBy('u.id', 'u.nom', 'u.prenom')
            ->get();

        // Types de problèmes les plus fréquents
        $problemesFrequents = TicketMaintenance::where('created_at', '>=', now()->subDays($periode))
            ->select('sujet', DB::raw('count(*) as total'))
            ->groupBy('sujet')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        return view('admin.reports.maintenance', compact(
            'ticketsParTechnicien',
            'tempsResolution',
            'problemesFrequents',
            'periode'
        ));
    }

    /**
     * Générer un rapport des licences
     */
    public function licences()
    {
        $this->authorize('reports.generate');

        $logiciels = Logiciel::with(['licences', 'installations'])->get();

        // Licences expirées
        $licencesExpirees = DB::table('licence_logiciels')
            ->join('logiciels', 'licence_logiciels.logiciel_id', '=', 'logiciels.id')
            ->where('date_expiration', '<', now())
            ->select('logiciels.nom', DB::raw('count(*) as total'))
            ->groupBy('logiciels.id', 'logiciels.nom')
            ->get();

        // Licences expirant bientôt
        $licencesExpirant = DB::table('licence_logiciels')
            ->join('logiciels', 'licence_logiciels.logiciel_id', '=', 'logiciels.id')
            ->whereBetween('date_expiration', [now(), now()->addDays(60)])
            ->select('logiciels.nom', DB::raw('count(*) as total'))
            ->groupBy('logiciels.id', 'logiciels.nom')
            ->get();

        // Taux d'utilisation des licences
        $tauxUtilisation = [];
        foreach ($logiciels as $logiciel) {
            $postesUtilises = $logiciel->installations_count;
            $postesTotaux = $logiciel->licences->sum('nb_postes');
            
            if ($postesTotaux > 0) {
                $taux = ($postesUtilises / $postesTotaux) * 100;
                $tauxUtilisation[$logiciel->nom] = [
                    'utilises' => $postesUtilises,
                    'totaux' => $postesTotaux,
                    'taux' => round($taux, 2),
                    'disponibles' => $postesTotaux - $postesUtilises,
                ];
            }
        }

        return view('admin.reports.licences', compact(
            'logiciels',
            'licencesExpirees',
            'licencesExpirant',
            'tauxUtilisation'
        ));
    }

    /**
     * Générer un rapport des contrats
     */
    public function contrats()
    {
        $this->authorize('reports.generate');

        $contrats = ContratMaintenance::with('prestataire')->get();

        // Contrats par statut
        $contratsParStatut = [
            'actifs' => $contrats->where('date_debut', '<=', now())
                ->where('date_fin', '>=', now())
                ->count(),
            'expires' => $contrats->where('date_fin', '<', now())
                ->count(),
            'futurs' => $contrats->where('date_debut', '>', now())
                ->count(),
        ];

        // Contrats expirant bientôt
        $contratsExpirant = $contrats->filter(function($contrat) {
            return $contrat->jours_restants > 0 && $contrat->jours_restants <= 60;
        });

        // Valeur totale des contrats
        $valeurTotale = $contrats->sum('montant');

        return view('admin.reports.contrats', compact(
            'contrats',
            'contratsParStatut',
            'contratsExpirant',
            'valeurTotale'
        ));
    }

    /**
     * Générer un rapport personnalisé
     */
    public function personnalise(Request $request)
    {
        $this->authorize('reports.generate');

        $type = $request->get('type', 'actifs');
        $format = $request->get('format', 'html');
        $periode = $request->get('periode', '30');

        // Logique pour générer le rapport selon le type
        switch ($type) {
            case 'actifs':
                $data = $this->genererRapportActifs($request);
                break;
            case 'tickets':
                $data = $this->genererRapportTickets($request);
                break;
            case 'maintenance':
                $data = $this->genererRapportMaintenance($request);
                break;
            case 'licences':
                $data = $this->genererRapportLicences($request);
                break;
            default:
                abort(404, 'Type de rapport non supporté');
        }

        if ($format === 'pdf') {
            // TODO: Générer PDF
            return response()->json(['message' => 'PDF generation not implemented yet']);
        } elseif ($format === 'csv') {
            return $this->exporterCSV($data, $type);
        }

        return view('admin.reports.personnalise', compact('data', 'type'));
    }

    /**
     * Exporter un rapport en CSV
     */
    private function exporterCSV($data, $type)
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="rapport_' . $type . '_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($data, $type) {
            $file = fopen('php://output', 'w');
            
            // Écrire l'en-tête selon le type
            switch ($type) {
                case 'actifs':
                    fputcsv($file, ['Code Inventaire', 'Type', 'Marque', 'Modèle', 'État', 'Localisation', 'Utilisateur Affecté']);
                    foreach ($data['actifs'] as $actif) {
                        fputcsv($file, [
                            $actif->code_inventaire,
                            $actif->type,
                            $actif->marque,
                            $actif->modele,
                            $actif->etat,
                            $actif->localisation ? $actif->localisation->nom_complet : '',
                            $actif->utilisateurAffecte ? $actif->utilisateurAffecte->full_name : '',
                        ]);
                    }
                    break;
                // Ajouter d'autres types...
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Calculer le temps moyen de résolution
     */
    private function calculerTempsMoyenResolution($tickets)
    {
        $ticketsResolus = $tickets->where('statut', 'resolu');
        
        if ($ticketsResolus->isEmpty()) {
            return 0;
        }

        $totalMinutes = $ticketsResolus->sum(function($ticket) {
            return $ticket->duree_ouverture * 24 * 60; // Convertir jours en minutes
        });

        return round($totalMinutes / $ticketsResolus->count());
    }

    /**
     * Générer rapport actifs
     */
    private function genererRapportActifs($request)
    {
        $query = ActifInformatique::with(['localisation', 'utilisateurAffecte']);

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        return ['actifs' => $query->get()];
    }

    /**
     * Générer rapport tickets
     */
    private function genererRapportTickets($request)
    {
        $query = TicketMaintenance::with(['createur', 'assigneA', 'actif']);

        if ($request->has('periode')) {
            $query->where('created_at', '>=', now()->subDays($request->periode));
        }

        return ['tickets' => $query->get()];
    }

    /**
     * Générer rapport maintenance
     */
    private function genererRapportMaintenance($request)
    {
        // Implémenter selon les besoins
        return [];
    }

    /**
     * Générer rapport licences
     */
    private function genererRapportLicences($request)
    {
        // Implémenter selon les besoins
        return [];
    }
}