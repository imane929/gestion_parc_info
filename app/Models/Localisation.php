<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localisation extends Model
{
    use HasFactory;

    protected $table = 'localisations';

    protected $fillable = [
        'site',
        'batiment',
        'etage',
        'bureau',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * RELATIONS
     */

    // Une localisation peut contenir plusieurs actifs
    public function actifs()
    {
        return $this->hasMany(ActifInformatique::class, 'localisation_id');
    }

    /**
     * SCOPES
     */

    public function scopeParSite($query, $site)
    {
        return $query->where('site', $site);
    }

    public function scopeRechercher($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('site', 'like', "%{$search}%")
              ->orWhere('batiment', 'like', "%{$search}%")
              ->orWhere('bureau', 'like', "%{$search}%");
        });
    }

    /**
     * MÉTHODES
     */

    public function getNomCompletAttribute()
    {
        $parts = [$this->site];
        
        if ($this->batiment) {
            $parts[] = "Bâtiment {$this->batiment}";
        }
        
        if ($this->etage) {
            $parts[] = "Étage {$this->etage}";
        }
        
        if ($this->bureau) {
            $parts[] = "Bureau {$this->bureau}";
        }
        
        return implode(' - ', $parts);
    }

    public function getActifsCountAttribute()
    {
        return $this->actifs()->count();
    }
}