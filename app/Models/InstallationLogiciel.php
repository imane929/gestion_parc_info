<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstallationLogiciel extends Model
{
    use HasFactory;

    protected $table = 'installation_logiciels';

    protected $fillable = [
        'licence_logiciel_id',
        'actif_informatique_id',
        'date_installation',
    ];

    protected $casts = [
        'date_installation' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * RELATIONS
     */

    // Une installation utilise une licence
    public function licence()
    {
        return $this->belongsTo(LicenceLogiciel::class, 'licence_logiciel_id');
    }

    // Une installation est sur un actif
    public function actif()
    {
        return $this->belongsTo(ActifInformatique::class, 'actif_informatique_id');
    }

    // Relation vers le logiciel via la licence
    public function logiciel()
    {
        return $this->through('licence')->has('logiciel');
    }

    /**
     * SCOPES
     */

    public function scopePourActif($query, $actifId)
    {
        return $query->where('actif_informatique_id', $actifId);
    }

    public function scopePourLicence($query, $licenceId)
    {
        return $query->where('licence_logiciel_id', $licenceId);
    }

    /**
     * MÉTHODES
     */

    public function getAgeAttribute()
    {
        return $this->date_installation->diffInDays(now());
    }
}