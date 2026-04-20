<?php

namespace App\Policies;

use App\Models\Prestataire;
use App\Models\User as Utilisateur;
use Illuminate\Auth\Access\HandlesAuthorization;

class PrestatairePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Utilisateur $user): bool
    {
        return $user->can('prestataires.view') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it') || 
               $user->hasRoleByCode('technicien') ||
               $user->hasRoleByCode('manager');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Utilisateur $user, Prestataire $prestataire): bool
    {
        return $user->can('prestataires.view') || 
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
        return $user->can('prestataires.create') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it') ||
               $user->hasRoleByCode('manager');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Utilisateur $user, Prestataire $prestataire): bool
    {
        return $user->can('prestataires.update') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it') ||
               $user->hasRoleByCode('manager');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Utilisateur $user, Prestataire $prestataire): bool
    {
        return $user->can('prestataires.delete') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it') ||
               $user->hasRoleByCode('manager');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Utilisateur $user, Prestataire $prestataire): bool
    {
        return $user->hasRoleByCode('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Utilisateur $user, Prestataire $prestataire): bool
    {
        return $user->hasRoleByCode('admin');
    }
}
