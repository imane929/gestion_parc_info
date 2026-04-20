<?php

namespace App\Policies;

use App\Models\LicenceLogiciel;
use App\Models\User as Utilisateur;
use Illuminate\Auth\Access\HandlesAuthorization;

class LicencePolicy
{
    use HandlesAuthorization;

    public function viewAny(Utilisateur $user): bool
    {
        return $user->can('licences.view') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it') ||
               $user->hasRoleByCode('technicien');
    }

    public function view(Utilisateur $user, LicenceLogiciel $licence): bool
    {
        return $user->can('licences.view') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it') ||
               $user->hasRoleByCode('technicien');
    }

    public function create(Utilisateur $user): bool
    {
        return $user->can('licences.create') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it');
    }

    public function update(Utilisateur $user, LicenceLogiciel $licence): bool
    {
        return $user->can('licences.edit') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it');
    }

    public function delete(Utilisateur $user, LicenceLogiciel $licence): bool
    {
        return $user->can('licences.delete') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it');
    }
}
