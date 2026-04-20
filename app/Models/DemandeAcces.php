<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeAcces extends Model
{
    use HasFactory;

    protected $table = 'demandes_acces';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'departement',
        'raison',
        'statut',
        'traitée_par',
        'traitée_at',
        'commentaire',
    ];

    protected $casts = [
        'traitée_at' => 'datetime',
    ];

    public function traitePar()
    {
        return $this->belongsTo(User::class, 'traitée_par');
    }

    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    public function scopeApprouvee($query)
    {
        return $query->where('statut', 'approuvee');
    }

    public function scopeRejetee($query)
    {
        return $query->where('statut', 'rejetee');
    }
}
