<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected const ROLE_ALIASES = [
        'gestionnaire_it' => 'responsable_it',
    ];

    protected $table = 'utilisateurs';

    protected $fillable = [
        'uuid',
        'civilite',
        'nom',
        'prenom',
        'email',
        'telephone',
        'password',
        'etat_compte',
        'derniere_connexion_at',
        'photo_url',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'derniere_connexion_at' => 'datetime',
        'etat_compte' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Uuid::uuid4()->toString();
            }
        });
    }

    public function getFullNameAttribute()
    {
        return trim($this->prenom . ' ' . $this->nom);
    }

    public function getInitialsAttribute()
    {
        $first = substr($this->prenom ?? $this->name ?? 'U', 0, 1);
        $last = substr($this->nom ?? '', 0, 1);
        return strtoupper($first . $last);
    }

    public function getPhotoUrlAttribute($value)
    {
        if (empty($value)) {
            return null;
        }
        
        if (str_starts_with($value, '/storage/')) {
            return $value;
        }
        
        return '/storage/' . $value;
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'utilisateur_id');
    }

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class, 'utilisateur_id');
    }

    public function journalActivites()
    {
        return $this->hasMany(JournalActivite::class, 'utilisateur_id');
    }

    public function actifsAffectes()
    {
        return $this->hasMany(ActifInformatique::class, 'utilisateur_affecte_id');
    }

    public function affectationsActifs()
    {
        return $this->hasMany(AffectationActif::class, 'utilisateur_id');
    }

    public function ticketsCrees()
    {
        return $this->hasMany(TicketMaintenance::class, 'created_by');
    }

    public function ticketsAssignes()
    {
        return $this->hasMany(TicketMaintenance::class, 'assigne_a');
    }

    public function interventions()
    {
        return $this->hasMany(Intervention::class, 'technicien_id');
    }

    public function piecesJointes()
    {
        return $this->hasMany(PieceJointe::class, 'uploaded_by');
    }

    public function scopeActifs($query)
    {
        return $query->where('etat_compte', 'actif');
    }

    public function scopeTechniciens($query)
    {
        return $query->whereHas('roles', function ($q) {
            $q->whereIn('code', ['technicien', 'responsable_it']);
        });
    }

    public function scopeParRole($query, $roleCode)
    {
        return $query->whereHas('roles', function ($q) use ($roleCode) {
            $q->where('code', $roleCode);
        });
    }

    public function estTechnicien()
    {
        return $this->hasRoleByCode('technicien') || $this->hasRoleByCode('responsable_it');
    }

    public function estAdministrateur()
    {
        return $this->hasRoleByCode('admin');
    }

    public function estResponsableIT()
    {
        return $this->hasRoleByCode('responsable_it');
    }

    public function estGestionnaireIT()
    {
        return $this->hasRoleByCode('responsable_it');
    }

    public function dashboardRouteName(): string
    {
        if ($this->hasRoleByCode('admin')) {
            return 'admin.dashboard.admin';
        }

        if ($this->hasRoleByCode('responsable_it')) {
            return 'admin.dashboard.gestionnaire_it';
        }

        if ($this->hasRoleByCode('technicien')) {
            return 'admin.dashboard.technicien';
        }

        if ($this->hasRoleByCode('manager')) {
            return 'admin.dashboard.analytics';
        }

        return 'admin.dashboard.utilisateur';
    }

    public function primaryPortalRole(): string
    {
        if ($this->hasRoleByCode('admin')) {
            return 'admin';
        }

        if ($this->hasRoleByCode('responsable_it')) {
            return 'gestionnaire_it';
        }

        if ($this->hasRoleByCode('technicien')) {
            return 'technicien';
        }

        if ($this->hasRoleByCode('manager')) {
            return 'analytics';
        }

        return 'utilisateur';
    }

    public function roleDisplayName(): string
    {
        return match ($this->primaryPortalRole()) {
            'admin' => 'Administrateur',
            'gestionnaire_it' => 'Gestionnaire IT',
            'technicien' => 'Technicien',
            'analytics' => 'Analyste',
            default => 'Utilisateur',
        };
    }

    public function roleSidebarView(): string
    {
        return match ($this->primaryPortalRole()) {
            'admin' => 'includes.sidebar-admin',
            'gestionnaire_it' => 'includes.sidebar-gestionnaire_it',
            'technicien' => 'includes.sidebar-technicien',
            'analytics' => 'includes.sidebar-analytics',
            default => 'includes.sidebar-utilisateur',
        };
    }

    protected function normalizeRoleCode($code): string
    {
        return self::ROLE_ALIASES[$code] ?? $code;
    }

    public function peutTraiterTickets()
    {
        return $this->estTechnicien() || $this->estResponsableIT() || $this->estAdministrateur();
    }

    public function hasRoleByCode($code): bool
    {
        if (is_object($code)) {
            if (method_exists($code, 'first')) {
                $first = $code->first();
                $code = $first ? ($first->code ?? $first->name ?? '') : '';
            } else {
                $code = $code->code ?? $code->name ?? '';
            }
        }
        
        if (empty($code)) {
            return false;
        }

        $code = $this->normalizeRoleCode((string) $code);
        
        // Check both role_utilisateur (custom table) and model_has_roles (Spatie)
        $fromRoleUtilisateur = DB::table('role_utilisateur')
            ->join('roles', 'role_utilisateur.role_id', '=', 'roles.id')
            ->where('role_utilisateur.model_id', $this->id)
            ->where('roles.code', $code)
            ->exists();
        
        if ($fromRoleUtilisateur) {
            return true;
        }
        
        return DB::table('model_has_roles')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('model_has_roles.model_id', $this->id)
            ->where('model_has_roles.model_type', 'App\\Models\\User')
            ->where('roles.code', $code)
            ->exists();
    }

    public function hasRole($role, $guard = null): bool
    {
        if (is_object($role)) {
            if (method_exists($role, 'first')) {
                $first = $role->first();
                $roleName = $first ? ($first->code ?? $first->name ?? '') : '';
            } else {
                $roleName = $role->code ?? $role->name ?? '';
            }
        } else {
            $roleName = $role;
        }
        
        if (empty($roleName)) {
            return false;
        }

        $roleName = $this->normalizeRoleCode((string) $roleName);
        
        // Check both tables
        $fromRoleUtilisateur = DB::table('role_utilisateur')
            ->join('roles', 'role_utilisateur.role_id', '=', 'roles.id')
            ->where('role_utilisateur.model_id', $this->id)
            ->where(function($query) use ($roleName) {
                $query->where('roles.code', $roleName)
                      ->orWhere('roles.name', $roleName);
            })
            ->exists();
        
        if ($fromRoleUtilisateur) {
            return true;
        }
        
        return DB::table('model_has_roles')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('model_has_roles.model_id', $this->id)
            ->where('model_has_roles.model_type', 'App\\Models\\User')
            ->where(function($query) use ($roleName) {
                $query->where('roles.code', $roleName)
                      ->orWhere('roles.name', $roleName);
            })
            ->exists();
    }

    public function hasAnyRole($roles, $guard = null): bool
    {
        foreach (is_array($roles) ? $roles : func_get_args() as $role) {
            if ($this->hasRole($role, $guard)) {
                return true;
            }
        }
        return false;
    }
}
