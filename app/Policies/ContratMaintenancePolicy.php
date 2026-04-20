<?php

namespace App\Policies;

use App\Models\ContratMaintenance;
use App\Models\User as Utilisateur;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContratMaintenancePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Utilisateur $user): bool
    {
        return $user->can('contrats.view') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it') || 
               $user->hasRoleByCode('manager');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Utilisateur $user, ContratMaintenance $contrat): bool
    {
        return $user->can('contrats.view') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it') || 
               $user->hasRoleByCode('manager');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Utilisateur $user): bool
    {
        return $user->can('contrats.create') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it') ||
               $user->hasRoleByCode('manager');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Utilisateur $user, ContratMaintenance $contrat): bool
    {
        return $user->can('contrats.edit') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it') ||
               $user->hasRoleByCode('manager');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Utilisateur $user, ContratMaintenance $contrat): bool
    {
        return $user->can('contrats.delete') || 
               $user->hasRoleByCode('admin') ||
               $user->hasRoleByCode('manager');
    }

    /**
     * Determine whether the user can view provider.
     */
    public function viewProvider(Utilisateur $user, ContratMaintenance $contrat): bool
    {
        return $this->view($user, $contrat);
    }

    /**
     * Determine whether the user can renew contract.
     */
    public function renew(Utilisateur $user, ContratMaintenance $contrat): bool
    {
        return $user->can('contrats.edit') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it') ||
               $user->hasRoleByCode('manager');
    }

    /**
     * Determine whether the user can export contracts.
     */

    public function export(Utilisateur $user): bool
    {
        return $user->can('contrats.view');
    }

    /**
     * Determine whether the user can view SLA.
     */
    public function viewSLA(Utilisateur $user, ContratMaintenance $contrat): bool
    {
        return $this->view($user, $contrat);
    }
}