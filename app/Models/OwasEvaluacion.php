<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OwasEvaluacion extends Model
{
    use HasFactory;

    protected $table = 'owas_evaluaciones';

    protected $fillable = [
        'evaluacion_id',
        'espalda',
        'brazos',
        'piernas',
        'carga',
        'codigo_postura',
        'categoria_riesgo',
        'accion_correctiva',
    ];

    public function evaluacion()
    {
        return $this->belongsTo(Evaluacion::class, 'evaluacion_id');
    }

    public function detalles()
    {
        return $this->hasMany(OwasDetalle::class, 'owas_evaluacion_id');
    }
}