<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parametre extends Model
{
    use HasFactory;

    protected $table = 'parametres';

    protected $fillable = [
        'cle',
        'valeur',
        'groupe',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * SCOPES
     */

    public function scopeParGroupe($query, $groupe)
    {
        return $query->where('groupe', $groupe);
    }

    public function scopeSysteme($query)
    {
        return $query->where('groupe', 'systeme');
    }

    public function scopeApplication($query)
    {
        return $query->where('groupe', 'application');
    }

    public function scopeEmail($query)
    {
        return $query->where('groupe', 'email');
    }

    /**
     * MÉTHODES STATIQUES
     */

    public static function getValeur($cle, $default = null)
    {
        $parametre = self::where('cle', $cle)->first();
        return $parametre ? $parametre->valeur : $default;
    }

    public static function setValeur($cle, $valeur, $groupe = 'systeme', $description = null)
    {
        $parametre = self::firstOrCreate(
            ['cle' => $cle],
            ['groupe' => $groupe, 'description' => $description]
        );
        
        $parametre->valeur = $valeur;
        $parametre->save();
        
        return $parametre;
    }
}