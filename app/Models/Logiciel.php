<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logiciel extends Model
{
    use HasFactory;

    protected $table = 'logiciels';

    protected $fillable = [
        'nom',
        'editeur',
        'version',
        'type',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * RELATIONS
     */

    // Un logiciel a plusieurs licences
    public function licences()
    {
        return $this->hasMany(LicenceLogiciel::class, 'logiciel_id');
    }

    // Un logiciel peut avoir plusieurs installations
    public function installations()
    {
        return $this->hasManyThrough(
            InstallationLogiciel::class,
            LicenceLogiciel::class,
            'logiciel_id', // Foreign key on LicenceLogiciel table
            'licence_logiciel_id', // Foreign key on InstallationLogiciel table
            'id', // Local key on Logiciel table
            'id' // Local key on LicenceLogiciel table
        );
    }

    /**
     * SCOPES
     */

    public function scopeParEditeur($query, $editeur)
    {
        return $query->where('editeur', $editeur);
    }

    public function scopeParType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeRechercher($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('nom', 'like', "%{$search}%")
              ->orWhere('editeur', 'like', "%{$search}%")
              ->orWhere('version', 'like', "%{$search}%");
        });
    }

    /**
     * MÉTHODES
     */

    public function getNomCompletAttribute()
    {
        return "{$this->nom} {$this->version}";
    }

    public function getLicencesValidesCountAttribute()
    {
        return $this->licences()->where('date_expiration', '>=', now())->count();
    }

    public function getInstallationsCountAttribute()
    {
        return $this->installations()->count();
    }

    public function getPostesUtilisesAttribute()
    {
        return $this->installations()->count();
    }

    public function getPostesDisponiblesAttribute()
    {
        $totalPostes = $this->licences()->sum('nb_postes');
        $postesUtilises = $this->getPostesUtilisesAttribute();
        
        return $totalPostes - $postesUtilises;
    }
}