<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nom036Detalle extends Model
{
    use HasFactory;

    protected $table = 'nom036_detalles';

    protected $fillable = [
        'nom036_evaluacion_id',
        'seccion',
        'concepto',
        'valor',
        'resultado',
    ];

    public function nom036Evaluacion()
    {
        return $this->belongsTo(Nom036Evaluacion::class, 'nom036_evaluacion_id');
    }
}