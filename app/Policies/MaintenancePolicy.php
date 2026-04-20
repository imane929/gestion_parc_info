<?php

namespace App\Policies;

use App\Models\MaintenancePreventive;
use App\Models\User as Utilisateur;
use Illuminate\Auth\Access\HandlesAuthorization;

class MaintenancePolicy
{
    use HandlesAuthorization;

    public function viewAny(Utilisateur $user): bool
    {
        return $user->hasAnyRole(['admin', 'responsable_it', 'technicien']);
    }

    public function view(Utilisateur $user, MaintenancePreventive $maintenance): bool
    {
        return $user->hasAnyRole(['admin', 'responsable_it', 'technicien']);
    }

    public function create(Utilisateur $user): bool
    {
        return $user->hasAnyRole(['admin', 'responsable_it', 'technicien']);
    }

    public function update(Utilisateur $user, MaintenancePreventive $maintenance): bool
    {
        return $user->hasAnyRole(['admin', 'responsable_it', 'technicien']);
    }

    public function delete(Utilisateur $user, MaintenancePreventive $maintenance): bool
    {
        return $user->hasAnyRole(['admin', 'responsable_it']);
    }
}
