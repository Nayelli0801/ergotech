<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Evaluacion extends Model
{
    use HasFactory;

    protected $table = 'evaluaciones';

    protected $fillable = [
        'empresa_id',
        'sucursal_id',
        'puesto_id',
        'trabajador_id',
        'metodo_id',
        'user_id',
        'fecha_evaluacion',
        'area_evaluada',
        'actividad',
        'observaciones',
        'resultado_final',
        'nivel_riesgo',
        'recomendaciones',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }

    public function puesto()
    {
        return $this->belongsTo(Puesto::class, 'puesto_id');
    }

    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class, 'trabajador_id');
    }

    public function metodo()
    {
        return $this->belongsTo(Metodo::class, 'metodo_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rula()
    {
        return $this->hasOne(RulaEvaluacion::class, 'evaluacion_id');
    }

    public function reba()
    {
        return $this->hasOne(RebaEvaluacion::class, 'evaluacion_id');
    }

    public function owas()
    {
        return $this->hasOne(OwasEvaluacion::class, 'evaluacion_id');
    }

    public function niosh()
    {
        return $this->hasOne(NioshEvaluacion::class, 'evaluacion_id');
    }
}