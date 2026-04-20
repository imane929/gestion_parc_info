<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestataire extends Model
{
    use HasFactory;

    protected $table = 'prestataires';

    protected $fillable = [
        'nom',
        'telephone',
        'email',
        'adresse_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * RELATIONS
     */

    // Un prestataire a une adresse
    public function adresse()
    {
        return $this->belongsTo(Adresse::class, 'adresse_id');
    }

    // Un prestataire peut avoir plusieurs contrats
    public function contrats()
    {
        return $this->hasMany(ContratMaintenance::class, 'prestataire_id');
    }

    /**
     * SCOPES
     */

    public function scopeAvecContratsActifs($query)
    {
        return $query->whereHas('contrats', function($q) {
            $q->actifs();
        });
    }

    public function scopeRechercher($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('nom', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('telephone', 'like', "%{$search}%");
        });
    }

    /**
     * MÉTHODES
     */

    public function getContratsActifsCountAttribute()
    {
        return $this->contrats()->actifs()->count();
    }

    public function getCoordonneesAttribute()
    {
        if ($this->adresse) {
            return $this->adresse->adresse_complete;
        }
        
        return null;
    }

    public function getContactsAttribute()
    {
        $contacts = [];
        
        if ($this->telephone) {
            $contacts[] = "Tél: {$this->telephone}";
        }
        
        if ($this->email) {
            $contacts[] = "Email: {$this->email}";
        }
        
        return implode(' | ', $contacts);
    }
}