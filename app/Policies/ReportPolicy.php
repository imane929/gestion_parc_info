<?php

namespace App\Policies;

use App\Models\User as Utilisateur;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReportPolicy
{
    use HandlesAuthorization;

    public function viewAny(Utilisateur $user): bool
    {
        return $user->can('reports.view') || $user->hasRoleByCode('admin');
    }

    public function view(Utilisateur $user): bool
    {
        return $user->can('reports.view') || $user->hasRoleByCode('admin');
    }

    public function generate(Utilisateur $user): bool
    {
        return $user->can('reports.generate') || $user->hasRoleByCode('admin');
    }
}
