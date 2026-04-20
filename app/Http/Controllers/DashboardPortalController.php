<?php

namespace App\Http\Controllers;

use App\Models\ActifInformatique;
use App\Models\AffectationActif;
use App\Models\ContratMaintenance;
use App\Models\Intervention;
use App\Models\JournalActivite;
use App\Models\LicenceLogiciel;
use App\Models\Localisation;
use App\Models\Logiciel;
use App\Models\MaintenancePreventive;
use App\Models\Notification;
use App\Models\TicketMaintenance;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DashboardPortalController extends Controller
{
    public function redirect(): RedirectResponse
    {
        return redirect()->route(auth()->user()->dashboardRouteName());
    }

    public function admin(): View
    {
        $this->ensureRoles(['admin']);

        $recentActivities = \App\Models\JournalActivite::with('utilisateur')
            ->latest()
            ->limit(8)
            ->get();

        $assets = ActifInformatique::with(['localisation', 'utilisateurAffecte'])
            ->latest()
            ->limit(8)
            ->get();

        $tickets = TicketMaintenance::with(['actif', 'createur', 'assigneA'])
            ->latest()
            ->limit(8)
            ->get();

        return view('dashboards.admin', [
            'pageTitle' => 'Admin Dashboard',
            'kpis' => [
                'total_assets' => ActifInformatique::count(),
                'total_users' => User::count(),
                'open_tickets' => TicketMaintenance::whereIn('statut', ['ouvert', 'en_cours', 'en_attente'])->count(),
                'resolved_tickets' => TicketMaintenance::whereIn('statut', ['resolu', 'ferme'])->count(),
            ],
            'assetsByType' => $this->pluckCounts(ActifInformatique::select('type', DB::raw('COUNT(*) as total'))->groupBy('type')->get(), 'type'),
            'ticketsByStatus' => $this->pluckCounts(TicketMaintenance::select('statut', DB::raw('COUNT(*) as total'))->groupBy('statut')->get(), 'statut'),
            'recentActivities' => $recentActivities,
            'assets' => $assets,
            'tickets' => $tickets,
            'assignments' => $this->assignmentQuery()->limit(8)->get(),
            'licenses' => $this->licenseQuery()->limit(8)->get(),
            'locations' => Localisation::withCount('actifs')->orderByDesc('actifs_count')->limit(8)->get(),
            'reportMetrics' => $this->reportMetrics(),
            'settingsSummary' => $this->settingsSummary(),
        ]);
    }

    public function gestionnaireIt(): View
    {
        $this->ensureRoles(['admin', 'responsable_it']);

        return view('dashboards.gestionnaire_it', [
            'pageTitle' => 'IT Manager Dashboard',
            'kpis' => [
                'total_assets' => ActifInformatique::count(),
                'assigned_assets' => ActifInformatique::whereNotNull('utilisateur_affecte_id')->count(),
                'unassigned_assets' => ActifInformatique::whereNull('utilisateur_affecte_id')->count(),
                'planned_maintenance' => MaintenancePreventive::where('statut', 'planifie')->count(),
            ],
            'assets' => ActifInformatique::with(['localisation', 'utilisateurAffecte'])->latest()->limit(10)->get(),
            'assignments' => $this->assignmentQuery()->limit(10)->get(),
            'locations' => Localisation::withCount('actifs')->orderBy('site')->limit(10)->get(),
            'assetsByType' => $this->pluckCounts(ActifInformatique::select('type', DB::raw('COUNT(*) as total'))->groupBy('type')->get(), 'type'),
            'assetsByLocation' => $this->pluckCounts(
                ActifInformatique::join('localisations', 'actifs_informatiques.localisation_id', '=', 'localisations.id')
                    ->select('localisations.site as label', DB::raw('COUNT(*) as total'))
                    ->groupBy('localisations.site')
                    ->get(),
                'label'
            ),
            'reportMetrics' => $this->reportMetrics(),
        ]);
    }

    public function technicien(): View
    {
        $this->ensureRoles(['admin', 'responsable_it', 'technicien']);

        $user = auth()->user();

        $myTickets = TicketMaintenance::with(['actif', 'createur'])
            ->where('assigne_a', $user->id)
            ->latest()
            ->limit(10)
            ->get();

        $myInterventions = Intervention::with(['ticket.actif'])
            ->where('technicien_id', $user->id)
            ->latest('date')
            ->limit(10)
            ->get();

        return view('dashboards.technicien', [
            'pageTitle' => 'Technician Dashboard',
            'kpis' => [
                'assigned_tickets' => TicketMaintenance::where('assigne_a', $user->id)->count(),
                'open_tickets' => TicketMaintenance::where('assigne_a', $user->id)->whereIn('statut', ['ouvert', 'en_cours', 'en_attente'])->count(),
                'resolved_tickets' => TicketMaintenance::where('assigne_a', $user->id)->whereIn('statut', ['resolu', 'ferme'])->count(),
                'logged_interventions' => Intervention::where('technicien_id', $user->id)->count(),
            ],
            'myTickets' => $myTickets,
            'myInterventions' => $myInterventions,
            'maintenanceHistory' => MaintenancePreventive::with('actif')
                ->whereIn('statut', ['en_cours', 'termine', 'annule'])
                ->latest('date_prevue')
                ->limit(12)
                ->get(),
        ]);
    }

    public function utilisateur(): View
    {
        $this->ensureRoles(['utilisateur', 'admin', 'responsable_it', 'technicien', 'manager']);

        $user = auth()->user();

        return view('dashboards.utilisateur', [
            'pageTitle' => 'User Dashboard',
            'kpis' => [
                'my_assets' => ActifInformatique::where('utilisateur_affecte_id', $user->id)->count(),
                'my_open_tickets' => TicketMaintenance::where('created_by', $user->id)->whereIn('statut', ['ouvert', 'en_cours', 'en_attente'])->count(),
                'my_resolved_tickets' => TicketMaintenance::where('created_by', $user->id)->whereIn('statut', ['resolu', 'ferme'])->count(),
                'unread_notifications' => Notification::where('utilisateur_id', $user->id)->whereNull('lu_at')->count(),
            ],
            'myAssets' => ActifInformatique::with('localisation')
                ->where('utilisateur_affecte_id', $user->id)
                ->latest()
                ->get(),
            'myTickets' => TicketMaintenance::with(['actif', 'assigneA'])
                ->where('created_by', $user->id)
                ->latest()
                ->limit(10)
                ->get(),
        ]);
    }

    public function analytics(): View
    {
        $this->ensureRoles(['admin', 'responsable_it', 'manager']);

        $technicianPerformance = User::whereHas('roles', function ($query) {
            $query->whereIn('code', ['technicien', 'responsable_it']);
        })
            ->withCount([
                'ticketsAssignes as total_tickets',
                'ticketsAssignes as resolved_tickets' => fn ($query) => $query->whereIn('statut', ['resolu', 'ferme']),
                'interventions as total_interventions',
            ])
            ->get();

        $failureRate = ActifInformatique::withCount('tickets')
            ->orderByDesc('tickets_count')
            ->limit(10)
            ->get();

        return view('dashboards.analytics', [
            'pageTitle' => 'Analytics Dashboard',
            'maintenanceCost' => (float) ContratMaintenance::sum('montant'),
            'failureRate' => $failureRate,
            'technicianPerformance' => $technicianPerformance,
            'ticketsTrend' => $this->monthlyTicketTrend(),
            'costByProvider' => ContratMaintenance::join('prestataires', 'contrats_maintenance.prestataire_id', '=', 'prestataires.id')
                ->select('prestataires.nom as label', DB::raw('SUM(contrats_maintenance.montant) as total'))
                ->groupBy('prestataires.nom')
                ->get(),
            'statusMetrics' => $this->reportMetrics(),
        ]);
    }

    public function assignments(Request $request): View
    {
        $this->ensureRoles(['admin', 'responsable_it']);

        $query = $this->assignmentQuery();

        if ($search = $request->string('search')->toString()) {
            $query->where(function ($builder) use ($search) {
                $builder->whereHas('actif', fn ($q) => $q->where('code_inventaire', 'like', "%{$search}%")->orWhere('modele', 'like', "%{$search}%"))
                    ->orWhereHas('utilisateur', fn ($q) => $q->where('nom', 'like', "%{$search}%")->orWhere('prenom', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('status')) {
            $request->status === 'active' ? $query->whereNull('date_fin') : $query->whereNotNull('date_fin');
        }

        return view('portal.assignments', [
            'pageTitle' => 'Assignments',
            'assignments' => $query->paginate(15)->withQueryString(),
        ]);
    }

    public function softwareLicenses(Request $request): View
    {
        $this->ensureRoles(['admin', 'responsable_it']);

        $query = $this->licenseQuery();

        if ($search = $request->string('search')->toString()) {
            $query->where(function ($builder) use ($search) {
                $builder->whereHas('logiciel', fn ($q) => $q->where('nom', 'like', "%{$search}%")->orWhere('version', 'like', "%{$search}%"))
                    ->orWhere('cle_licence', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'expired') {
                $query->where('date_expiration', '<', now());
            }

            if ($request->status === 'expiring') {
                $query->whereBetween('date_expiration', [now(), now()->addDays(30)]);
            }
        }

        return view('portal.software-licenses', [
            'pageTitle' => 'Software & Licenses',
            'licenses' => $query->paginate(15)->withQueryString(),
            'expiredCount' => LicenceLogiciel::where('date_expiration', '<', now())->count(),
            'expiringCount' => LicenceLogiciel::whereBetween('date_expiration', [now(), now()->addDays(30)])->count(),
        ]);
    }

    public function maintenanceHistory(): View
    {
        $this->ensureRoles(['admin', 'responsable_it', 'technicien']);

        $user = auth()->user();
        $interventions = Intervention::with(['ticket.actif', 'technicien'])
            ->when($user->hasRoleByCode('technicien') && !$user->hasRoleByCode('responsable_it') && !$user->hasRoleByCode('admin'), function ($query) use ($user) {
                $query->where('technicien_id', $user->id);
            })
            ->latest('date')
            ->paginate(15);

        return view('portal.maintenance-history', [
            'pageTitle' => 'Maintenance History',
            'interventions' => $interventions,
            'maintenances' => MaintenancePreventive::with('actif')->latest('date_prevue')->limit(15)->get(),
        ]);
    }

    public function search(Request $request): View
    {
        $this->ensureRoles(['admin', 'responsable_it', 'technicien', 'utilisateur', 'manager']);

        $term = trim($request->string('q')->toString());
        $user = auth()->user();

        $assets = collect();
        $tickets = collect();
        $users = collect();
        $software = collect();

        if ($term !== '') {
            if ($user->hasAnyRole(['admin', 'responsable_it', 'technicien', 'manager'])) {
                $assets = ActifInformatique::with(['localisation', 'utilisateurAffecte'])
                    ->where(function ($query) use ($term) {
                        $query->where('code_inventaire', 'like', "%{$term}%")
                            ->orWhere('marque', 'like', "%{$term}%")
                            ->orWhere('modele', 'like', "%{$term}%");
                    })
                    ->limit(8)
                    ->get();

                $software = Logiciel::where(function ($query) use ($term) {
                    $query->where('nom', 'like', "%{$term}%")
                        ->orWhere('version', 'like', "%{$term}%")
                        ->orWhere('editeur', 'like', "%{$term}%");
                })->limit(8)->get();
            }

            $tickets = TicketMaintenance::with(['actif', 'assigneA'])
                ->when($user->hasRoleByCode('utilisateur') && !$user->hasAnyRole(['admin', 'responsable_it', 'technicien', 'manager']), fn ($query) => $query->where('created_by', $user->id))
                ->where(function ($query) use ($term) {
                    $query->where('numero', 'like', "%{$term}%")
                        ->orWhere('sujet', 'like', "%{$term}%")
                        ->orWhere('description', 'like', "%{$term}%");
                })
                ->limit(8)
                ->get();

            if ($user->hasAnyRole(['admin', 'responsable_it'])) {
                $users = User::where(function ($query) use ($term) {
                    $query->where('nom', 'like', "%{$term}%")
                        ->orWhere('prenom', 'like', "%{$term}%")
                        ->orWhere('email', 'like', "%{$term}%");
                })->limit(8)->get();
            }
        }

        return view('portal.search', compact('term', 'assets', 'tickets', 'users', 'software'));
    }

    protected function assignmentQuery()
    {
        return AffectationActif::with(['actif.localisation', 'utilisateur'])->latest('date_debut');
    }

    protected function licenseQuery()
    {
        return LicenceLogiciel::with('logiciel')->orderBy('date_expiration');
    }

    protected function reportMetrics(): array
    {
        return [
            'assets' => ActifInformatique::count(),
            'tickets' => TicketMaintenance::count(),
            'maintenance' => MaintenancePreventive::count(),
            'contract_value' => (float) ContratMaintenance::sum('montant'),
        ];
    }

    protected function settingsSummary(): array
    {
        return [
            'expiring_contracts' => ContratMaintenance::whereBetween('date_fin', [now(), now()->addDays(30)])->count(),
            'expired_licenses' => LicenceLogiciel::where('date_expiration', '<', now())->count(),
            'pending_maintenance' => MaintenancePreventive::where('statut', 'planifie')->count(),
            'active_locations' => Localisation::count(),
        ];
    }

    protected function monthlyTicketTrend(): array
    {
        $labels = [];
        $values = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $labels[] = $month->translatedFormat('M Y');
            $values[] = TicketMaintenance::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        }

        return compact('labels', 'values');
    }

    protected function pluckCounts(Collection $rows, string $labelKey): array
    {
        return $rows->mapWithKeys(fn ($row) => [$row->{$labelKey} => (int) $row->total])->toArray();
    }

    protected function ensureRoles(array $roles): void
    {
        $user = auth()->user();

        abort_unless($user && $user->hasAnyRole($roles), 403);
    }
}
