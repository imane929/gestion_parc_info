<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

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

    // Relationship with equipment
    public function equipement()
    {
        return $this->belongsTo(Equipement::class);
    }

    // Relationship with technician
    public function technicien()
    {
        return $this->belongsTo(User::class, 'technicien_id');
    }

    // Relationship with creator
    public function createur()
    {
        return $this->belongsTo(User::class, 'createur_id');
    }

    // Scope for open tickets
    public function scopeOuvert($query)
    {
        return $query->where('statut', 'ouvert');
    }

    // Scope for in-progress tickets
    public function scopeEnCours($query)
    {
        return $query->where('statut', 'en_cours');
    }

    // Scope for completed tickets
    public function scopeTermine($query)
    {
        return $query->where('statut', 'termine');
    }

    // Get priority label
    public function getPrioriteLabelAttribute()
    {
        $labels = [
            'faible' => 'Faible',
            'moyenne' => 'Moyenne',
            'haute' => 'Haute',
            'urgente' => 'Urgente',
        ];

        return $labels[$this->priorite] ?? $this->priorite;
    }

    // Get status label
    public function getStatutLabelAttribute()
    {
        $labels = [
            'ouvert' => 'Ouvert',
            'en_cours' => 'En cours',
            'termine' => 'Terminé',
            'annule' => 'Annulé',
        ];

        return $labels[$this->statut] ?? $this->statut;
    }

    // Check if ticket is open
    public function getIsOuvertAttribute()
    {
        return $this->statut === 'ouvert';
    }

    // Check if ticket is in progress
    public function getIsEnCoursAttribute()
    {
        return $this->statut === 'en_cours';
    }

    // Check if ticket is completed
    public function getIsTermineAttribute()
    {
        return $this->statut === 'termine';
    }
}