<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Empresa;
use App\Models\User;
use App\Models\RebaDetalle;
use App\Models\Metodo;

class Evaluacion extends Model
{
    protected $table = 'evaluaciones';

    protected $fillable = [
        'empresa_id',
        'user_id',
        'metodo_id',        // ✅ nuevo (profesional)
        'metodo',           // ✅ viejo (texto) - lo dejamos por compatibilidad
        'fecha',
        'observaciones',
        'puntaje',
        'puntaje_total',
        'nivel_riesgo'
    ];

    // 🔹 Relación con Empresa
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    // 🔹 Relación con Usuario (evaluador)
    public function evaluador()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 🔹 Relación con Método (tabla metodos)
    public function metodoRelacion()
    {
        return $this->belongsTo(Metodo::class, 'metodo_id');
    }

    // 🔥 RELACIÓN CON REBA
    public function reba()
    {
        return $this->hasOne(RebaDetalle::class);
    }
}