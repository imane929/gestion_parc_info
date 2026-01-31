<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipement extends Model
{
    protected $fillable = [
        'nom',
        'type',
        'marque',
        'modele',
        'numero_serie',
        'date_acquisition',
        'etat',
        'localisation',
        'notes',
        'user_id'
    ];

    protected $casts = [
        'date_acquisition' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function affectations(): HasMany
    {
        return $this->hasMany(Affectation::class);
    }

    // Helper methods
    public function getStatusColorAttribute(): string
    {
        return match($this->etat) {
            'neuf', 'bon' => 'success',
            'moyen' => 'warning',
            'mauvais', 'hors_service' => 'danger',
            default => 'secondary'
        };
    }

    public function getTypeIconAttribute(): string
    {
        return match($this->type) {
            'PC Portable', 'PC Bureau' => 'fas fa-laptop',
            'Serveur' => 'fas fa-server',
            'Imprimante' => 'fas fa-print',
            'Switch' => 'fas fa-network-wired',
            'Tablette' => 'fas fa-tablet-alt',
            'Téléphone' => 'fas fa-phone',
            default => 'fas fa-desktop'
        };
    }
}