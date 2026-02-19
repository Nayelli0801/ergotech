<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use App\Models\Rol;

class User extends Authenticatable
{
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
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

    // Relación con rol
    public function rol()
    {
        return $this->belongsTo(Rol::class);
    }

    // Evaluaciones del usuario
    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class);
    }

    // Verificar roles
    public function isAdmin()
    {
        return $this->rol && $this->rol->nombre === 'admin';
    }

    public function isEvaluador()
    {
        return $this->rol && $this->rol->nombre === 'evaluador';
    }
}
