<?php

namespace App\Policies;

use App\Models\TicketMaintenance;
use App\Models\User as Utilisateur;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketMaintenancePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Utilisateur $user): bool
    {
        return $user->can('tickets.view') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it') || 
               $user->hasRoleByCode('technicien') ||
               $user->hasRoleByCode('manager') ||
               $user->hasRoleByCode('utilisateur');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Utilisateur $user, TicketMaintenance $ticket): bool
    {
        // Le créateur peut voir son ticket
        if ($ticket->created_by === $user->id) {
            return true;
        }

        // Le technicien assigné peut voir le ticket
        if ($ticket->assigne_a === $user->id) {
            return true;
        }

        return $user->can('tickets.view') || 
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
        return $user->can('tickets.create') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it') || 
               $user->hasRoleByCode('technicien') ||
               $user->hasRoleByCode('utilisateur');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Utilisateur $user, TicketMaintenance $ticket): bool
    {
        // Le créateur peut modifier son ticket s'il n'est pas assigné
        if ($ticket->created_by === $user->id && !$ticket->assigne_a) {
            return true;
        }

        return $user->can('tickets.edit') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it') || 
               $user->hasRoleByCode('technicien');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Utilisateur $user, TicketMaintenance $ticket): bool
    {
        // Seul l'admin ou le responsable IT peut supprimer
        return $user->can('tickets.delete') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it');
    }

    /**
     * Determine whether the user can assign the model.
     */
    public function assign(Utilisateur $user, TicketMaintenance $ticket): bool
    {
        return $user->can('tickets.assign') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it');
    }

    /**
     * Determine whether the user can resolve the model.
     */
    public function resolve(Utilisateur $user, TicketMaintenance $ticket): bool
    {
        // Le technicien assigné peut résoudre
        if ($ticket->assigne_a === $user->id) {
            return true;
        }

        return $user->can('tickets.resolve') || 
               $user->hasRoleByCode('admin') || 
               $user->hasRoleByCode('responsable_it');
    }

    /**
     * Determine whether the user can view interventions.
     */
    public function viewInterventions(Utilisateur $user, TicketMaintenance $ticket): bool
    {
        return $this->view($user, $ticket);
    }

    /**
     * Determine whether the user can create interventions.
     */
    public function createIntervention(Utilisateur $user, TicketMaintenance $ticket): bool
    {
        return $this->resolve($user, $ticket);
    }

    /**
     * Determine whether the user can view comments.
     */
    public function viewComments(Utilisateur $user, TicketMaintenance $ticket): bool
    {
        return $this->view($user, $ticket);
    }

    /**
     * Determine whether the user can add comments.
     */
    public function addComment(Utilisateur $user, TicketMaintenance $ticket): bool
    {
        return $this->view($user, $ticket);
    }

    /**
     * Determine whether the user can view attachments.
     */
    public function viewAttachments(Utilisateur $user, TicketMaintenance $ticket): bool
    {
        return $this->view($user, $ticket);
    }

    /**
     * Determine whether the user can add attachments.
     */
    public function addAttachment(Utilisateur $user, TicketMaintenance $ticket): bool
    {
        return $this->view($user, $ticket);
    }
}