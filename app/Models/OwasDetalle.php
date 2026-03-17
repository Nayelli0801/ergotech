<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OwasDetalle extends Model
{
    use HasFactory;

    protected $table = 'owas_detalles';

    protected $fillable = [
        'owas_evaluacion_id',
        'seccion',
        'concepto',
        'valor',
        'puntaje',
    ];

    public function owasEvaluacion()
    {
        return $this->belongsTo(OwasEvaluacion::class, 'owas_evaluacion_id');
    }
}