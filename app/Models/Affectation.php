<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Affectation extends Model
{
    protected $fillable = [
        'equipement_id',
        'user_id',
        'date_affectation',
        'date_retour',
        'raison'
    ];

    protected $casts = [
        'date_affectation' => 'date',
        'date_retour' => 'date',
    ];

    public function equipement(): BelongsTo
    {
        return $this->belongsTo(Equipement::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Helper methods
    public function getStatusAttribute(): string
    {
        return $this->date_retour ? 'retourné' : 'actif';
    }
}