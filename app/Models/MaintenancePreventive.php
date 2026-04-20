<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenancePreventive extends Model
{
    use HasFactory;

    protected $table = 'maintenance_preventive';

    protected $fillable = [
        'actif_informatique_id',
        'date_prevue',
        'type',
        'statut',
        'description',
        'notes',
    ];

    protected $casts = [
        'date_prevue' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * RELATIONS
     */

    // Une maintenance préventive appartient à un actif
    public function actif()
    {
        return $this->belongsTo(ActifInformatique::class, 'actif_informatique_id');
    }

    /**
     * SCOPES
     */

    public function scopePlanifiees($query)
    {
        return $query->where('statut', 'planifie');
    }

    public function scopeEnCours($query)
    {
        return $query->where('statut', 'en_cours');
    }

    public function scopeTerminees($query)
    {
        return $query->where('statut', 'termine');
    }

    public function scopeProchaines($query, $jours = 7)
    {
        return $query->whereBetween('date_prevue', [now(), now()->addDays($jours)])
                     ->where('statut', 'planifie');
    }

    public function scopeEnRetard($query)
    {
        return $query->where('date_prevue', '<', now())
                     ->whereIn('statut', ['planifie', 'en_cours']);
    }

    /**
     * MÉTHODES
     */

    public function getJoursRestantsAttribute()
    {
        return now()->diffInDays($this->date_prevue, false);
    }

    public function estPlanifiee()
    {
        return $this->statut === 'planifie';
    }

    public function estEnCours()
    {
        return $this->statut === 'en_cours';
    }

    public function estTerminee()
    {
        return $this->statut === 'termine';
    }

    public function estEnRetard()
    {
        return $this->date_prevue < now() && !$this->estTerminee();
    }

    public function demarrer()
    {
        $this->statut = 'en_cours';
        $this->save();
        
        return $this;
    }

    public function terminer()
    {
        $this->statut = 'termine';
        $this->save();
        
        return $this;
    }
}