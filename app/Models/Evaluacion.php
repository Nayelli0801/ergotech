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
        return $this->belongsTo(Empresa::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function puesto()
    {
        return $this->belongsTo(Puesto::class);
    }

    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class);
    }

    public function metodo()
    {
        return $this->belongsTo(Metodo::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rebaEvaluacion()
    {
        return $this->hasOne(RebaEvaluacion::class, 'evaluacion_id');
    }
}