<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    protected $fillable = [
        'titre',
        'description',
        'priorite',
        'statut',
        'equipement_id',
        'technicien_id',
        'createur_id',
        'date_ouverture',
        'date_cloture',
        'solution'
    ];

    protected $casts = [
        'date_ouverture' => 'datetime',
        'date_cloture' => 'datetime',
    ];

    public function equipement(): BelongsTo
    {
        return $this->belongsTo(Equipement::class);
    }

    public function technicien(): BelongsTo
    {
        return $this->belongsTo(User::class, 'technicien_id');
    }

    public function createur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'createur_id');
    }

    // Helper methods
    public function getPriorityColorAttribute(): string
    {
        return match($this->priorite) {
            'urgente' => 'danger',
            'haute' => 'warning',
            'moyenne' => 'info',
            'faible' => 'success',
            default => 'secondary'
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->statut) {
            'ouvert' => 'danger',
            'en_cours' => 'warning',
            'termine' => 'success',
            'annule' => 'secondary',
            default => 'info'
        };
    }
}