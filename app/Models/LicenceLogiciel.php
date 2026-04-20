<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicenceLogiciel extends Model
{
    use HasFactory;

    protected $table = 'licence_logiciels';

    protected $fillable = [
        'logiciel_id',
        'cle_licence',
        'date_achat',
        'date_expiration',
        'nb_postes',
        'notes',
    ];

    protected $casts = [
        'date_achat' => 'date',
        'date_expiration' => 'date',
        'nb_postes' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * RELATIONS
     */

    // Une licence appartient à un logiciel
    public function logiciel()
    {
        return $this->belongsTo(Logiciel::class, 'logiciel_id');
    }

    // Une licence peut avoir plusieurs installations
    public function installations()
    {
        return $this->hasMany(InstallationLogiciel::class, 'licence_logiciel_id');
    }

    /**
     * SCOPES
     */

    public function scopeValides($query)
    {
        return $query->where('date_expiration', '>=', now());
    }

    public function scopeExpirees($query)
    {
        return $query->where('date_expiration', '<', now());
    }

    public function scopeProcheExpiration($query, $jours = 30)
    {
        return $query->whereBetween('date_expiration', [now(), now()->addDays($jours)]);
    }

    public function scopeAvecPostesDisponibles($query)
    {
        return $query->whereRaw('nb_postes > (SELECT COUNT(*) FROM installation_logiciels WHERE licence_logiciel_id = licence_logiciels.id)');
    }

    /**
     * MÉTHODES
     */

    public function getInstallationsCountAttribute()
    {
        return $this->installations()->count();
    }

    public function getPostesDisponiblesAttribute()
    {
        return $this->nb_postes - $this->getInstallationsCountAttribute();
    }

    public function estValide()
    {
        return $this->date_expiration >= now();
    }

    public function estProcheExpiration($jours = 30)
    {
        if (!$this->estValide()) {
            return false;
        }
        
        return $this->date_expiration->diffInDays(now()) <= $jours;
    }

    public function aPostesDisponibles()
    {
        return $this->getPostesDisponiblesAttribute() > 0;
    }

    public function getJoursRestantsAttribute()
    {
        return now()->diffInDays($this->date_expiration, false);
    }
}