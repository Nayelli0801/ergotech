<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OcraDetalle extends Model
{
    protected $table = 'ocra_detalles';

    protected $fillable = [
        'ocra_evaluacion_id',
        'seccion',
        'concepto',
        'valor',
        'puntaje',
    ];

    public function ocraEvaluacion()
    {
        return $this->belongsTo(OcraEvaluacion::class, 'ocra_evaluacion_id');
    }
}