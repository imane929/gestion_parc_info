<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affectation extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipement_id',
        'user_id',
        'date_affectation',
        'date_retour',
        'statut',
        'notes'
    ];

    protected $dates = [
        'date_affectation',
        'date_retour'
    ];

    protected $attributes = [
        'statut' => 'actif' // Default status should be 'actif'
    ];

    public function equipement()
    {
        return $this->belongsTo(Equipement::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Check if affectation is active
    public function isActive()
    {
        return $this->statut === 'actif' && is_null($this->date_retour);
    }

    // Check if affectation is returned
    public function isRetourne()
    {
        return $this->statut === 'retourné' || !is_null($this->date_retour);
    }

    // Scope for active affectations
    public function scopeActive($query)
    {
        return $query->whereNull('date_retour');
    }

    // Helper methods
    public function getStatusAttribute(): string
    {
        return $this->date_retour ? 'retourné' : 'actif';
    }
}