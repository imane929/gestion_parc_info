<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffectationActif extends Model
{
    use HasFactory;

    protected $table = 'affectation_actifs';

    protected $fillable = [
        'actif_informatique_id',
        'utilisateur_id',
        'date_debut',
        'date_fin',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * RELATIONS
     */

    // Une affectation appartient à un actif
    public function actif()
    {
        return $this->belongsTo(ActifInformatique::class, 'actif_informatique_id');
    }

    // Une affectation appartient à un utilisateur
    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }

    /**
     * SCOPES
     */

    public function scopeActives($query)
    {
        return $query->whereNull('date_fin');
    }

    public function scopeTerminees($query)
    {
        return $query->whereNotNull('date_fin');
    }

    public function scopePourUtilisateur($query, $userId)
    {
        return $query->where('utilisateur_id', $userId);
    }

    public function scopePourActif($query, $actifId)
    {
        return $query->where('actif_informatique_id', $actifId);
    }

    /**
     * MÉTHODES
     */

    public function getDureeAttribute()
    {
        if (!$this->date_debut) {
            return null;
        }
        
        $fin = $this->date_fin ?? now();
        return $this->date_debut->diffInDays($fin);
    }

    public function estActive()
    {
        return is_null($this->date_fin);
    }

    public function terminer()
    {
        $this->date_fin = now();
        $this->save();
        
        return $this;
    }
}