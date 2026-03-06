<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RebaEvaluacion extends Model
{
    use HasFactory;

    protected $table = 'reba_evaluaciones';

    protected $fillable = [
        'evaluacion_id',
        'cuello',
        'tronco',
        'piernas',
        'brazo',
        'antebrazo',
        'muneca',
        'carga',
        'tipo_agarre',
        'actividad',
        'puntuacion_a',
        'puntuacion_b',
        'puntuacion_c',
        'puntuacion_final',
        'nivel_riesgo',
        'accion_requerida',
    ];

    public function evaluacion()
    {
        return $this->belongsTo(Evaluacion::class, 'evaluacion_id');
    }

    public function detalles()
    {
        return $this->hasMany(RebaDetalle::class, 'reba_evaluacion_id');
    }
}