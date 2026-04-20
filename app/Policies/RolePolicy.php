<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User as Utilisateur;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Utilisateur $user): bool
    {
        return $user->can('roles.view') || $user->hasRoleByCode('admin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Utilisateur $user, Role $role): bool
    {
        return $user->can('roles.view') || $user->hasRoleByCode('admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Utilisateur $user): bool
    {
        return $user->can('roles.create') || $user->hasRoleByCode('admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Utilisateur $user, Role $role): bool
    {
        // Ne pas permettre la modification du rôle admin
        if ($role->code === 'admin') {
            return $user->hasRoleByCode('admin');
        }

        return $user->can('roles.edit') || $user->hasRoleByCode('admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Utilisateur $user, Role $role): bool
    {
        // Ne pas permettre la suppression du rôle admin
        if ($role->code === 'admin') {
            return false;
        }

        return $user->can('roles.delete') || $user->hasRoleByCode('admin');
    }

    /**
     * Determine whether the user can assign the role.
     */
    public function assign(Utilisateur $user, Role $role): bool
    {
        // Seul l'admin peut assigner le rôle admin
        if ($role->code === 'admin') {
            return $user->hasRoleByCode('admin');
        }

        return $user->can('roles.edit') || $user->hasRoleByCode('admin') || $user->hasRoleByCode('responsable_it');
    }

    /**
     * Determine whether the user can manage permissions.
     */
    public function managePermissions(Utilisateur $user, Role $role): bool
    {
        return $user->hasRoleByCode('admin');
    }

    /**
     * Determine whether the user can assign permissions to a user.
     */
    public function assignPermissions(Utilisateur $user): bool
    {
        return $user->hasRoleByCode('admin') || $user->can('users.edit');
    }
}
