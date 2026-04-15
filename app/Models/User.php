<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use App\Models\Rol;

// 🔥 IMPORTANTE: Spatie
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, TwoFactorAuthenticatable, HasRoles;

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
        'rol_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // 🔹 Relación que ya tenías (NO se toca)
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    // 🔹 Tus funciones actuales (siguen funcionando)
    public function isAdmin()
    {
        return $this->rol && $this->rol->nombre === 'admin';
    }

    public function isEvaluador()
    {
        return $this->rol && $this->rol->nombre === 'evaluador';
    }

    // 🔥 OPCIONAL (recomendado): sincronizar rol con Spatie
    public function syncSpatieRole()
    {
        if ($this->rol) {
            $this->syncRoles([$this->rol->nombre]);
        }
    }
}