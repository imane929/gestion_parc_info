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

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Define all role variables with defaults to avoid "Undefined variable" errors in views
        $isAdmin = $user ? $user->hasRole('admin') : false;
        $isResponsableIT = $user ? $user->hasRole('responsable_it') : false;
        $isTechnicien = $user ? $user->hasRole('technicien') : false;
        $isManager = $user ? $user->hasRole('manager') : false;
        $isUtilisateur = $user ? $user->hasRole('utilisateur') : false;

        $stats = [
            'total_actifs' => 0,
            'tickets_ouverts' => 0,
            'contrats_expirant' => 0,
            'total_utilisateurs' => 0,
            'demandes_acces_attente' => 0,
            'mes_equipements' => 0,
            'mes_tickets' => 0,
            'notifications_non_lues' => 0
        ];
        
        if ($isAdmin) {
            $stats = array_merge($stats, [
                'total_actifs' => ActifInformatique::count(),
                'tickets_ouverts' => TicketMaintenance::where('statut', 'ouvert')->count(),
                'contrats_expirant' => ContratMaintenance::whereBetween('date_fin', [now(), now()->addDays(30)])->count(),
                'total_utilisateurs' => Utilisateur::count(),
                'demandes_acces_attente' => \App\Models\DemandeAcces::where('statut', 'en_attente')->count(),
            ]);
        } elseif ($isResponsableIT) {
            $stats = array_merge($stats, [
                'total_actifs' => ActifInformatique::count(),
                'tickets_en_cours' => TicketMaintenance::whereIn('statut', ['ouvert', 'en_cours'])->count(),
                'contrats_actifs' => ContratMaintenance::where('date_debut', '<=', now())
                    ->where('date_fin', '>=', now())
                    ->count(),
                'actifs_non_affectes' => ActifInformatique::whereNull('utilisateur_affecte_id')->count(),
                'maintenances_planifiees' => \App\Models\MaintenancePreventive::where('statut', 'planifie')->count(),
                'maintenances_en_cours' => \App\Models\MaintenancePreventive::where('statut', 'en_cours')->count(),
                'maintenances_terminees' => \App\Models\MaintenancePreventive::where('statut', 'termine')->count(),
                'tickets_ouverts_mois' => TicketMaintenance::where('statut', 'ouvert')->whereMonth('created_at', now()->month)->count(),
                'tickets_en_cours_mois' => TicketMaintenance::where('statut', 'en_cours')->whereMonth('created_at', now()->month)->count(),
                'tickets_resolus_mois' => TicketMaintenance::where('statut', 'resolu')->whereMonth('created_at', now()->month)->count(),
            ]);
        } elseif ($isTechnicien) {
            $stats = array_merge($stats, [
                'mes_tickets_assignes' => TicketMaintenance::where('assigne_a', $user->id)->count(),
                'tickets_a_traiter' => TicketMaintenance::where('statut', 'ouvert')->count(),
                'mes_interventions_en_cours' => \App\Models\Intervention::where('technicien_id', $user->id)
                    ->where('statut', 'en_cours')->count(),
                'mes_interventions_terminees' => \App\Models\Intervention::where('technicien_id', $user->id)
                    ->where('statut', 'termine')->count(),
                'maintenances_a_faire' => \App\Models\MaintenancePreventive::where('statut', 'planifie')->count(),
            ]);
        } elseif ($isManager) {
            $avgResolutionTime = TicketMaintenance::where('statut', 'resolu')
                ->whereNotNull('created_at')
                ->whereNotNull('updated_at')
                ->select(DB::raw('AVG(TIMESTAMPDIFF(HOUR, created_at, updated_at)) as avg_time'))
                ->first()->avg_time ?? 0;

            $stats = array_merge($stats, [
                'total_actifs' => ActifInformatique::count(),
                'tickets_ouverts' => TicketMaintenance::where('statut', 'ouvert')->count(),
                'contrats_actifs' => ContratMaintenance::where('date_debut', '<=', now())
                    ->where('date_fin', '>=', now())
                    ->count(),
                'contrats_a_renouveler' => ContratMaintenance::whereBetween('date_fin', [now(), now()->addDays(60)])->count(),
                'avg_resolution_time' => round($avgResolutionTime, 1),
                'satisfaction_rate' => 95,
            ]);
        } elseif ($isUtilisateur) {
            $stats = array_merge($stats, [
                'mes_equipements' => ActifInformatique::where('utilisateur_affecte_id', $user->id)->count(),
                'mes_tickets' => TicketMaintenance::where('created_by', $user->id)->count(),
                'notifications_non_lues' => $user->notifications()->whereNull('lu_at')->count(),
            ]);
        }

        // Tickets récents
        $ticketsQuery = TicketMaintenance::with(['createur', 'assigneA', 'actif']);
        if ($isUtilisateur) {
            $ticketsQuery->where('created_by', $user->id);
        } elseif ($isTechnicien) {
            $ticketsQuery->where('assigne_a', $user->id)->orWhere('statut', 'ouvert');
        }
        $ticketsRecents = $ticketsQuery->orderBy('created_at', 'desc')->limit(5)->get();

        // Actifs par localisation
        $actifsParLocalisation = collect();
        if ($isAdmin || $isResponsableIT) {
            $actifsParLocalisation = ActifInformatique::select('localisations.nom', DB::raw('count(*) as total'))
                ->join('localisations', 'actifs_informatiques.localisation_id', '=', 'localisations.id')
                ->whereNull('actifs_informatiques.deleted_at')
                ->groupBy('localisations.nom')
                ->get();
        }

        // Alertes
        $alertes = [];
        if ($isResponsableIT) {
            $alertes['licences_expirant'] = \App\Models\LicenceLogiciel::whereBetween('date_expiration', [now(), now()->addDays(30)])->count();
            $alertes['contrats_renouveler'] = ContratMaintenance::whereBetween('date_fin', [now(), now()->addDays(30)])->count();
        }

        // Actifs par type
        $actifsParType = ActifInformatique::select('type', DB::raw('count(*) as total'))
            ->groupBy('type')
            ->get()
            ->pluck('total', 'type');

        // Tickets par statut
        $ticketsParStatut = TicketMaintenance::select('statut', DB::raw('count(*) as total'))
            ->when($isUtilisateur, function($q) use ($user) {
                return $q->where('created_by', $user->id);
            })
            ->groupBy('statut')
            ->get()
            ->pluck('total', 'statut');

        // Maintenances à venir
        $maintenancesPreventives = collect();
        if ($isAdmin || $isResponsableIT || $isTechnicien) {
            $maintenancesPreventives = \App\Models\MaintenancePreventive::with('actif')
                ->where('date_prevue', '>=', now())
                ->where('statut', 'planifie')
                ->orderBy('date_prevue')
                ->limit(5)
                ->get();
        }

        // Budget
        $budgetContrats = ($isManager || $isAdmin) ? ContratMaintenance::sum('montant') : 0;

        // Card Stats
        $cardStats = [
            'total_actifs' => ActifInformatique::count(),
            'tickets_ouverts' => TicketMaintenance::where('statut', 'ouvert')->count(),
            'licences_expirantes' => \App\Models\LicenceLogiciel::whereBetween('date_expiration', [now(), now()->addDays(30)])->count(),
            'contrats_expirants' => ContratMaintenance::whereBetween('date_fin', [now(), now()->addDays(60)])->count(),
        ];

        // Chart Data
        $ticketsByStatus = TicketMaintenance::select('statut', DB::raw('count(*) as total'))
            ->groupBy('statut')
            ->pluck('total', 'statut')
            ->toArray();

        $assetsByType = ActifInformatique::select('type', DB::raw('count(*) as total'))
            ->groupBy('type')
            ->pluck('total', 'type')
            ->toArray();

        $monthlyTickets = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $count = TicketMaintenance::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
            $monthlyTickets[$month->format('M')] = $count;
        }

        return view('dashboard', [
            'stats' => $stats,
            'cardStats' => $cardStats,
            'ticketsRecents' => $ticketsRecents,
            'actifsParType' => $actifsParType,
            'ticketsParStatut' => $ticketsParStatut,
            'actifsParLocalisation' => $actifsParLocalisation,
            'maintenancesPreventives' => $maintenancesPreventives,
            'alertes' => $alertes,
            'budgetContrats' => $budgetContrats,
            'ticketsByStatus' => $ticketsByStatus,
            'assetsByType' => $assetsByType,
            'monthlyTickets' => $monthlyTickets,
            'isAdmin' => $isAdmin,
            'isResponsableIT' => $isResponsableIT,
            'isTechnicien' => $isTechnicien,
            'isManager' => $isManager,
            'isUtilisateur' => $isUtilisateur,
        ]);
    }

    public function chartsData()
    {
        // Données pour les graphiques
        $data = [
            'actifs_par_type' => ActifInformatique::select('type', DB::raw('count(*) as total'))
                ->groupBy('type')
                ->get()
                ->toArray(),
            
            'tickets_par_mois' => TicketMaintenance::select(
                    DB::raw('DATE_FORMAT(created_at, "%Y-%m") as mois'),
                    DB::raw('count(*) as total')
                )
                ->where('created_at', '>=', now()->subMonths(6))
                ->groupBy('mois')
                ->orderBy('mois')
                ->get()
                ->toArray(),
            
            'tickets_par_statut' => TicketMaintenance::select('statut', DB::raw('count(*) as total'))
                ->groupBy('statut')
                ->get()
                ->toArray(),
            
            'actifs_par_etat' => ActifInformatique::select('etat', DB::raw('count(*) as total'))
                ->groupBy('etat')
                ->get()
                ->toArray(),
        ];

        return response()->json($data);
    }
}