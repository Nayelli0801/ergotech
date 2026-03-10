<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RulaDetalle extends Model
{
    use HasFactory;

    protected $table = 'rula_detalles';

    protected $fillable = [
        'rula_evaluacion_id',
        'seccion',
        'concepto',
        'valor',
        'puntaje',
    ];

    public function rulaEvaluacion()
    {
        return $this->belongsTo(RulaEvaluacion::class, 'rula_evaluacion_id');
    }
}