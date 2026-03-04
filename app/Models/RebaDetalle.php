<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RebaDetalle extends Model
{
    protected $fillable = [
        'evaluacion_id',

        'lado',

        'cuello',
        'cuello_ajuste',

        'tronco',
        'tronco_ajuste',

        'piernas',

        'carga',

        'brazo',
        'antebrazo',

        'muneca',
        'muneca_ajuste',

        'agarre',
        'actividad',

        'puntaje_a',
        'puntaje_b',
        'puntaje_final',
    ];

    public function evaluacion()
    {
        return $this->belongsTo(Evaluacion::class);
    }
}