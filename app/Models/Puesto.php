<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Puesto extends Model
{
    use HasFactory;

    protected $table = 'puestos';

    protected $fillable = [
        'sucursal_id',
        'nombre',
        'area',
        'descripcion',
        'activo',
    ];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }

    public function trabajadores()
    {
        return $this->hasMany(Trabajador::class, 'puesto_id');
    }

    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class, 'puesto_id');
    }
}