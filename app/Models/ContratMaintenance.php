<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContratMaintenance extends Model
{
    use HasFactory;

    protected $table = 'contrats_maintenance';

    protected $fillable = [
        'prestataire_id',
        'numero',
        'date_debut',
        'date_fin',
        'sla',
        'montant',
        'renouvellement_auto',
        'jours_alerte',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'montant' => 'decimal:2',
        'renouvellement_auto' => 'boolean',
        'jours_alerte' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * RELATIONS
     */

    // Un contrat appartient à un prestataire
    public function prestataire()
    {
        return $this->belongsTo(Prestataire::class, 'prestataire_id');
    }

    /**
     * SCOPES
     */

    public function scopeActifs($query)
    {
        return $query->where('date_debut', '<=', now())
                     ->where('date_fin', '>=', now());
    }

    public function scopeExpires($query)
    {
        return $query->where('date_fin', '<', now());
    }

    public function scopeProcheExpiration($query, $jours = 30)
    {
        return $query->whereBetween('date_fin', [now(), now()->addDays($jours)])
                     ->where('date_fin', '>=', now());
    }

    /**
     * MÉTHODES
     */

    public function getDureeAttribute()
    {
        return $this->date_debut->diffInDays($this->date_fin);
    }

    public function getJoursRestantsAttribute()
    {
        return now()->diffInDays($this->date_fin, false);
    }

    public function estActif()
    {
        return $this->date_debut <= now() && $this->date_fin >= now();
    }

    public function estExpire()
    {
        return $this->date_fin < now();
    }

    public function estProcheExpiration($jours = 30)
    {
        if ($this->estExpire()) {
            return false;
        }
        
        return $this->date_fin->diffInDays(now()) <= $jours;
    }

    public function getStatutAttribute()
    {
        if ($this->estExpire()) {
            return 'expire';
        }
        
        if ($this->estActif()) {
            return 'actif';
        }
        
        return 'futur';
    }

    public function estProcheExpirationAlert()
    {
        if ($this->estExpire()) {
            return false;
        }
        
        return $this->joursRestants <= $this->jours_alerte;
    }

    public function getMontantFormateAttribute()
    {
        if (!$this->montant) {
            return null;
        }
        
        return number_format($this->montant, 2, ',', ' ') . ' DH';
    }
}