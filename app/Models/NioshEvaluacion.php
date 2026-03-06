<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NioshEvaluacion extends Model
{
    use HasFactory;

    protected $table = 'niosh_evaluaciones';

    protected $fillable = [
        'evaluacion_id',
        'distancia_horizontal',
        'altura_inicial',
        'desplazamiento_vertical',
        'angulo_asimetria',
        'frecuencia_levantamiento',
        'duracion',
        'calidad_agarre',
        'peso_objeto',
        'constante_carga',
        'hm',
        'vm',
        'dm',
        'am',
        'fm',
        'cm',
        'rwl',
        'indice_levantamiento',
        'nivel_riesgo',
    ];

    public function evaluacion()
    {
        return $this->belongsTo(Evaluacion::class, 'evaluacion_id');
    }
}