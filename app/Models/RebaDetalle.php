<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RebaDetalle extends Model
{
    protected $fillable = [
        'evaluacion_id',
        'cuello',
        'tronco',
        'piernas',
        'carga',
        'brazo',
        'antebrazo',
        'muneca',
        'puntaje_a',
        'puntaje_b',
        'puntaje_final'
    ];

    // 🔥 Relación inversa
    public function evaluacion()
    {
        return $this->belongsTo(Evaluacion::class);
    }
}