<?php

namespace App\Policies;

use App\Models\Intervention;
use App\Models\User as Utilisateur;
use Illuminate\Auth\Access\HandlesAuthorization;

class InterventionPolicy
{
    use HandlesAuthorization;

    public function viewAny(Utilisateur $user): bool
    {
        return $user->hasAnyRole(['admin', 'responsable_it', 'technicien']);
    }

    public function view(Utilisateur $user, Intervention $intervention): bool
    {
        return $user->hasAnyRole(['admin', 'responsable_it', 'technicien']);
    }

    public function create(Utilisateur $user): bool
    {
        return $user->hasAnyRole(['admin', 'responsable_it', 'technicien']);
    }

    public function update(Utilisateur $user, Intervention $intervention): bool
    {
        return $user->hasAnyRole(['admin', 'responsable_it', 'technicien']);
    }

    public function delete(Utilisateur $user, Intervention $intervention): bool
    {
        return $user->hasAnyRole(['admin', 'responsable_it']);
    }
}
