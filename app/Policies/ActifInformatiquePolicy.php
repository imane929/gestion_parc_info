<?php

namespace App\Policies;

use App\Models\ActifInformatique;
use App\Models\User as Utilisateur;
use Illuminate\Auth\Access\HandlesAuthorization;

class ActifInformatiquePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Utilisateur $user): bool
    {
        return $user->can('actifs.view') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it') || 
               $user->hasRoleByCode('technicien') ||
               $user->hasRoleByCode('manager');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Utilisateur $user, ActifInformatique $actif): bool
    {
        // L'utilisateur affecté peut voir son actif
        if ($actif->utilisateur_affecte_id === $user->id) {
            return true;
        }

        return $user->can('actifs.view') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it') || 
               $user->hasRoleByCode('technicien') ||
               $user->hasRoleByCode('manager');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Utilisateur $user): bool
    {
        return $user->can('actifs.create') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it') ||
               $user->hasRoleByCode('technicien');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Utilisateur $user, ActifInformatique $actif): bool
    {
        return $user->can('actifs.edit') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it') ||
               $user->hasRoleByCode('technicien');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Utilisateur $user, ActifInformatique $actif): bool
    {
        return $user->can('actifs.delete') || 
               $user->hasRoleByCode('admin') ||
               $user->hasRoleByCode('responsable_it');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Utilisateur $user, ActifInformatique $actif): bool
    {
        return $user->hasRoleByCode('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Utilisateur $user, ActifInformatique $actif): bool
    {
        return $user->can('actifs.delete') || $user->hasRoleByCode('admin');
    }

    /**
     * Determine whether the user can affect the model.
     */
    public function affect(Utilisateur $user, ActifInformatique $actif): bool
    {
        return $user->can('actifs.affect') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it');
    }

    /**
     * Determine whether the user can view history.
     */
    public function viewHistory(Utilisateur $user, ActifInformatique $actif): bool
    {
        return $user->can('actifs.view') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it');
    }

    /**
     * Determine whether the user can view maintenance.
     */
    public function viewMaintenance(Utilisateur $user, ActifInformatique $actif): bool
    {
        return $user->can('actifs.view') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it') || 
               $user->hasRoleByCode('technicien');
    }
}