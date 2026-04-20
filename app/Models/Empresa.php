<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresas';

    protected $fillable = [
        'nombre',
        'razon_social',
        'rfc',
        'telefono',
        'correo',
        'direccion',
        'activo',
        'imagen',
    ];

    public function sucursales()
    {
        return $this->hasMany(Sucursal::class, 'empresa_id');
    }

    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class, 'empresa_id');
    }
}