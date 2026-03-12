<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nom036Evaluacion extends Model
{
    use HasFactory;

    protected $table = 'nom036_evaluaciones';

    protected $fillable = [
        'evaluacion_id',
        'tipo_actividad',
        'objeto_manipulado',
        'peso_carga',
        'frecuencia',
        'duracion',
        'distancia_recorrida',
        'altura_inicial',
        'altura_final',
        'postura_tronco',
        'postura_brazos',
        'postura_piernas',
        'agarre',
        'asimetria',
        'movimientos_repetitivos',
        'fuerza_brusca',
        'condiciones_ambientales',
        'superficie_trabajo',
        'espacio_trabajo',
        'nivel_riesgo',
        'observaciones',
    ];

    protected $casts = [
        'asimetria' => 'boolean',
        'movimientos_repetitivos' => 'boolean',
        'fuerza_brusca' => 'boolean',
        'peso_carga' => 'float',
        'frecuencia' => 'float',
        'duracion' => 'float',
        'distancia_recorrida' => 'float',
        'altura_inicial' => 'float',
        'altura_final' => 'float',
    ];

    public function evaluacion()
    {
        return $this->belongsTo(Evaluacion::class, 'evaluacion_id');
    }

    public function detalles()
    {
        return $this->hasMany(Nom036Detalle::class, 'nom036_evaluacion_id');
    }
}