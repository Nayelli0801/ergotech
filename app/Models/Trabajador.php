<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trabajador extends Model
{
    use HasFactory;

    protected $table = 'trabajadores';

    protected $fillable = [
        'puesto_id',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'sexo',
        'edad',
        'estatura',
        'peso',
        'antiguedad',
        'activo',
    ];

    public function puesto()
    {
        return $this->belongsTo(Puesto::class, 'puesto_id');
    }
}