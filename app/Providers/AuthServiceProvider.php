<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \App\Models\User::class => \App\Policies\UtilisateurPolicy::class,
        \App\Models\ActifInformatique::class => \App\Policies\ActifInformatiquePolicy::class,
        \App\Models\TicketMaintenance::class => \App\Policies\TicketMaintenancePolicy::class,
        \App\Models\Logiciel::class => \App\Policies\LogicielPolicy::class,
        \App\Models\ContratMaintenance::class => \App\Policies\ContratMaintenancePolicy::class,
        \App\Models\Role::class => \App\Policies\RolePolicy::class,
        \App\Models\Localisation::class => \App\Policies\LocalisationPolicy::class,
        \App\Models\MaintenancePreventive::class => \App\Policies\MaintenancePolicy::class,
        \App\Models\Intervention::class => \App\Policies\InterventionPolicy::class,
        \App\Models\LicenceLogiciel::class => \App\Policies\LicencePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Définir des gates supplémentaires
        Gate::define('view-dashboard', function ($user) {
            return $user->hasRoleByCode('admin') || $user->hasRoleByCode('responsable_it') || $user->hasRoleByCode('technicien') || $user->hasRoleByCode('manager');
        });

        Gate::define('maintenances.view', function ($user) {
            return $user->hasRoleByCode('admin') || $user->hasRoleByCode('responsable_it') || $user->hasRoleByCode('technicien') || $user->hasRoleByCode('manager');
        });

        Gate::define('actifs.view', function ($user) {
            return $user->hasRoleByCode('admin') || $user->hasRoleByCode('responsable_it') || $user->hasRoleByCode('technicien') || $user->hasRoleByCode('manager');
        });

        Gate::define('tickets.view', function ($user) {
            return $user->hasRoleByCode('admin') || $user->hasRoleByCode('responsable_it') || $user->hasRoleByCode('technicien') || $user->hasRoleByCode('manager');
        });

        Gate::define('create tickets', function ($user) {
            return $user->hasRoleByCode('admin') || $user->hasRoleByCode('responsable_it') || $user->hasRoleByCode('technicien') || $user->hasRoleByCode('manager');
        });

        Gate::define('edit tickets', function ($user) {
            return $user->hasRoleByCode('admin') || $user->hasRoleByCode('responsable_it') || $user->hasRoleByCode('technicien');
        });

        Gate::define('assign tickets', function ($user) {
            return $user->hasRoleByCode('admin') || $user->hasRoleByCode('responsable_it');
        });

        Gate::define('resolve tickets', function ($user) {
            return $user->hasRoleByCode('admin') || $user->hasRoleByCode('responsable_it') || $user->hasRoleByCode('technicien');
        });

        Gate::define('logiciels.view', function ($user) {
            return $user->hasRoleByCode('admin') || $user->hasRoleByCode('responsable_it') || $user->hasRoleByCode('technicien') || $user->hasRoleByCode('manager');
        });

        Gate::define('localisations.view', function ($user) {
            return $user->hasRoleByCode('admin') || $user->hasRoleByCode('responsable_it') || $user->hasRoleByCode('technicien') || $user->hasRoleByCode('manager');
        });

        Gate::define('contrats.view', function ($user) {
            return $user->hasRoleByCode('admin') || $user->hasRoleByCode('responsable_it') || $user->hasRoleByCode('manager');
        });

        Gate::define('prestataires.view', function ($user) {
            return $user->hasRoleByCode('admin') || $user->hasRoleByCode('responsable_it') || $user->hasRoleByCode('manager');
        });

        Gate::define('reports.view', function ($user) {
            return $user->hasRoleByCode('admin') || $user->hasRoleByCode('responsable_it') || $user->hasRoleByCode('manager');
        });

        Gate::define('licences.view', function ($user) {
            return $user->hasRoleByCode('admin') || $user->hasRoleByCode('responsable_it') || $user->hasRoleByCode('technicien') || $user->hasRoleByCode('manager');
        });

        Gate::define('interventions.view', function ($user) {
            return $user->hasRoleByCode('admin') || $user->hasRoleByCode('responsable_it') || $user->hasRoleByCode('technicien');
        });

        Gate::define('notifications.view', function ($user) {
            return $user->hasRoleByCode('admin') || $user->hasRoleByCode('responsable_it') || $user->hasRoleByCode('technicien') || $user->hasRoleByCode('manager');
        });

        // Maintenance permissions for views
        Gate::define('create maintenances', function ($user) {
            return $user->hasRoleByCode('admin') || $user->hasRoleByCode('responsable_it') || $user->hasRoleByCode('technicien');
        });

        Gate::define('edit maintenances', function ($user) {
            return $user->hasRoleByCode('admin') || $user->hasRoleByCode('responsable_it') || $user->hasRoleByCode('technicien');
        });

        Gate::define('update maintenances', function ($user) {
            return $user->hasRoleByCode('admin') || $user->hasRoleByCode('responsable_it') || $user->hasRoleByCode('technicien');
        });

        Gate::define('manage-users', function ($user) {
            return $user->hasRoleByCode('admin');
        });

        Gate::define('manage-roles', function ($user) {
            return $user->hasRoleByCode('admin');
        });

        Gate::define('manage-permissions', function ($user) {
            return $user->hasRoleByCode('admin');
        });

        Gate::define('treat-tickets', function ($user) {
            return $user->hasRoleByCode('admin') || $user->hasRoleByCode('responsable_it') || $user->hasRoleByCode('technicien');
        });

        Gate::define('manage-system', function ($user) {
            return $user->hasRoleByCode('admin');
        });

        Gate::define('export-data', function ($user) {
            return $user->hasRoleByCode('admin') || $user->hasRoleByCode('responsable_it') || $user->hasRoleByCode('manager');
        });

        Gate::define('import-data', function ($user) {
            return $user->hasRoleByCode('admin') || $user->hasRoleByCode('responsable_it');
        });

        Gate::define('view-reports', function ($user) {
            return $user->hasRoleByCode('admin') || $user->hasRoleByCode('responsable_it') || $user->hasRoleByCode('manager');
        });

        Gate::define('generate-reports', function ($user) {
            return $user->can('reports.generate') || $user->hasRoleByCode('admin') || $user->hasRoleByCode('responsable_it');
        });

        Gate::define('manage-settings', function ($user) {
            return $user->can('settings.edit') || $user->hasRoleByCode('admin');
        });
    }
}