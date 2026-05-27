<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OcraEvaluacion extends Model
{
    protected $table = 'ocra_evaluaciones';

    protected $fillable = [
        'evaluacion_id',
        'lado_evaluado',
        'duracion_tarea',
        'acciones_tecnicas',
        'frecuencia_acciones',
        'fuerza',
        'postura_hombro',
        'postura_codo',
        'postura_muneca',
        'postura_mano',
        'repetitividad',
        'factores_adicionales',
        'recuperacion',
        'indice_ocra',
        'nivel_riesgo',
        'recomendaciones',
        'observaciones',
    ];

    public function evaluacion()
    {
        return $this->belongsTo(Evaluacion::class, 'evaluacion_id');
    }

    public function detalles()
    {
        return $this->hasMany(OcraDetalle::class, 'ocra_evaluacion_id');
    }
}