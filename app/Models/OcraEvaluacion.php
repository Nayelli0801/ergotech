<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OcraEvaluacion extends Model
{
    protected $table = 'ocra_evaluaciones';

    protected $fillable = [
        'evaluacion_id',
        'lado_evaluado',

        'duracion_turno',
        'tiempo_no_repetitivo',
        'pausas',
        'almuerzo',
        'numero_ciclos',

        'tntr',
        'tnc',

        'fr',
        'atd',
        'ate',
        'ff',
        'ffz',

        'pho',
        'pco',
        'pmu',
        'pma',
        'pes',
        'fp',

        'ffm',
        'fso',
        'fc',

        'md',
        'ickl',
        'indice_ocra',
        'nivel_riesgo',
        'accion_recomendada',
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