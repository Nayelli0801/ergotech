<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RebaDetalle extends Model
{
    use HasFactory;

    protected $table = 'reba_detalles';

    protected $fillable = [
        'reba_evaluacion_id',
        'seccion',
        'concepto',
        'valor',
        'puntaje',
    ];

    public function rebaEvaluacion()
    {
        return $this->belongsTo(RebaEvaluacion::class, 'reba_evaluacion_id');
    }
}