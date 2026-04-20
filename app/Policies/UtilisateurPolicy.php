<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UtilisateurPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     */
    public function before(User $user, $ability)
    {
        // Admin can do everything
        if ($user->hasRoleByCode('admin')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('users.view') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        // Users can always view themselves
        if ($user->id === $model->id) {
            return true;
        }

        return $user->can('users.view') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('users.create') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        // Users can update themselves
        if ($user->id === $model->id) {
            return true;
        }

        return $user->can('users.edit') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        // Can't delete yourself
        if ($user->id === $model->id) {
            return false;
        }

        return $user->can('users.delete') || 
               $user->hasRoleByCode('admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->hasRoleByCode('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->hasRoleByCode('admin');
    }

    /**
     * Determine whether the user can change roles.
     */
    public function changeRole(User $user, User $model): bool
    {
        return $user->hasRoleByCode('admin');
    }

    /**
     * Determine whether the user can view profile.
     */
    public function viewProfile(User $user, User $model): bool
    {
        return $user->id === $model->id || 
               $user->can('users.view') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it');
    }

    /**
     * Determine whether the user can view activity logs.
     */
    public function viewActivityLogs(User $user): bool
    {
        return $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it');
    }

    /**
     * Determine whether the user can export users.
     */
    public function export(User $user): bool
    {
        return $user->can('users.view') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it');
    }

    /**
     * Determine whether the user can toggle user status.
     */
    public function toggleStatus(User $user, User $model): bool
    {
        // Can't toggle your own status
        if ($user->id === $model->id) {
            return false;
        }

        return $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it');
    }
}
