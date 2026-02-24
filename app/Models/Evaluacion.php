<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Empresa;

class Evaluacion extends Model
{
    protected $table = 'evaluaciones';
    protected $fillable = [
        'empresa_id',
        'user_id',
        'metodo',
        'fecha',
        'observaciones'
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function evaluador()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    
}
