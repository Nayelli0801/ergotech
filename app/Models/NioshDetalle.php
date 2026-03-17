<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NioshDetalle extends Model
{
    use HasFactory;

    protected $table = 'niosh_detalles';

    protected $fillable = [
        'niosh_evaluacion_id',
        'seccion',
        'concepto',
        'valor',
        'resultado',
    ];

    public function nioshEvaluacion()
    {
        return $this->belongsTo(NioshEvaluacion::class, 'niosh_evaluacion_id');
    }
}