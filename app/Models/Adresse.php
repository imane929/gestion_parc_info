<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adresse extends Model
{
    use HasFactory;

    protected $table = 'adresses';

    protected $fillable = [
        'pays',
        'ville',
        'quartier',
        'rue',
        'code_postal',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * RELATIONS
     */

    // Une adresse peut être utilisée par plusieurs prestataires
    public function prestataires()
    {
        return $this->hasMany(Prestataire::class, 'adresse_id');
    }

    /**
     * MÉTHODES
     */

    public function getAdresseCompleteAttribute()
    {
        $parts = [];
        
        if ($this->rue) {
            $parts[] = $this->rue;
        }
        
        if ($this->quartier) {
            $parts[] = $this->quartier;
        }
        
        if ($this->ville) {
            $parts[] = $this->ville;
        }
        
        if ($this->code_postal) {
            $parts[] = $this->code_postal;
        }
        
        if ($this->pays && $this->pays !== 'Maroc') {
            $parts[] = $this->pays;
        }
        
        return implode(', ', $parts);
    }

    public function getCoordonneesAttribute()
    {
        if ($this->latitude && $this->longitude) {
            return "{$this->latitude}, {$this->longitude}";
        }
        
        return null;
    }

    public function aCoordonnees()
    {
        return !is_null($this->latitude) && !is_null($this->longitude);
    }
}