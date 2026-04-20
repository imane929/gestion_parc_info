<?php

namespace App\Policies;

use App\Models\Localisation;
use App\Models\User as Utilisateur;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocalisationPolicy
{
    use HandlesAuthorization;

    public function viewAny(Utilisateur $user): bool
    {
        return $user->can('localisations.view') || 
               $user->hasAnyRole(['admin', 'responsable_it', 'technicien']);
    }

    public function view(Utilisateur $user, Localisation $localisation): bool
    {
        return $user->can('localisations.view') || 
               $user->hasAnyRole(['admin', 'responsable_it', 'technicien']);
    }

    public function create(Utilisateur $user): bool
    {
        return $user->can('localisations.create') || 
               $user->hasAnyRole(['admin', 'responsable_it', 'technicien']);
    }

    public function update(Utilisateur $user, Localisation $localisation): bool
    {
        return $user->can('localisations.edit') || 
               $user->hasAnyRole(['admin', 'responsable_it', 'technicien']);
    }

    public function delete(Utilisateur $user, Localisation $localisation): bool
    {
        return $user->can('localisations.delete') || 
               $user->hasAnyRole(['admin', 'responsable_it']);
    }
}
