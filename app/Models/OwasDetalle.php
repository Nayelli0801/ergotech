<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OwasDetalle extends Model
{
    use HasFactory;

    protected $table = 'owas_detalle';

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