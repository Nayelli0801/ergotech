<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RulaEvaluacion extends Model
{
    use HasFactory;

    protected $table = 'rula_evaluaciones';

    protected $fillable = [
        'evaluacion_id',
        'brazo',
        'antebrazo',
        'muneca',
        'giro_muneca',
        'cuello',
        'tronco',
        'piernas',
        'uso_muscular',
        'carga_fuerza',
        'puntuacion_a',
        'puntuacion_b',
        'puntuacion_c',
        'puntuacion_d',
        'puntuacion_final',
        'nivel_accion',
    ];

    public function evaluacion()
    {
        return $this->belongsTo(Evaluacion::class, 'evaluacion_id');
    }

    public function detalles()
    {
        return $this->hasMany(RulaDetalle::class, 'rula_evaluacion_id');
    }
}