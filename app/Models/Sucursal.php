<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sucursal extends Model
{
    use HasFactory;

    protected $table = 'sucursales';

    protected $fillable = [
        'empresa_id',
        'nombre',
        'direccion',
        'telefono',
        'responsable',
        'activo',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function puestos()
    {
        return $this->hasMany(Puesto::class, 'sucursal_id');
    }

    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class, 'sucursal_id');
    }
}