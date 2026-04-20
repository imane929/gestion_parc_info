<?php

namespace App\Policies;

use App\Models\Logiciel;
use App\Models\User as Utilisateur;
use Illuminate\Auth\Access\HandlesAuthorization;

class LogicielPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Utilisateur $user): bool
    {
        return $user->can('logiciels.view') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it') || 
               $user->hasRoleByCode('technicien');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Utilisateur $user, Logiciel $logiciel): bool
    {
        return $user->can('logiciels.view') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it') || 
               $user->hasRoleByCode('technicien');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Utilisateur $user): bool
    {
        return $user->can('logiciels.create') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it') ||
               $user->hasRoleByCode('technicien');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Utilisateur $user, Logiciel $logiciel): bool
    {
        return $user->can('logiciels.edit') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it') ||
               $user->hasRoleByCode('technicien');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Utilisateur $user, Logiciel $logiciel): bool
    {
        return $user->can('logiciels.delete') || 
               $user->hasRoleByCode('admin') ||
               $user->hasRoleByCode('responsable_it');
    }

    /**
     * Determine whether the user can view licenses.
     */
    public function viewLicenses(Utilisateur $user, Logiciel $logiciel): bool
    {
        return $user->can('logiciels.view') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it');
    }

    /**
     * Determine whether the user can manage licenses.
     */
    public function manageLicenses(Utilisateur $user, Logiciel $logiciel): bool
    {
        return $user->can('logiciels.edit') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it');
    }

    /**
     * Determine whether the user can view installations.
     */
    public function viewInstallations(Utilisateur $user, Logiciel $logiciel): bool
    {
        return $user->can('logiciels.view') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it') || 
               $user->hasRoleByCode('technicien');
    }

    /**
     * Determine whether the user can manage installations.
     */
    public function manageInstallations(Utilisateur $user, Logiciel $logiciel): bool
    {
        return $user->can('logiciels.edit') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it');
    }
}