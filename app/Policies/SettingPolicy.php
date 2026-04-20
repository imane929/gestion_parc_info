<?php

namespace App\Policies;

use App\Models\User as Utilisateur;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingPolicy
{
    use HandlesAuthorization;

    public function viewAny(Utilisateur $user): bool
    {
        return $user->can('settings.view') || $user->hasRoleByCode('admin');
    }

    public function view(Utilisateur $user): bool
    {
        return $user->can('settings.view') || $user->hasRoleByCode('admin');
    }

    public function update(Utilisateur $user): bool
    {
        return $user->can('settings.edit') || $user->hasRoleByCode('admin');
    }
}
