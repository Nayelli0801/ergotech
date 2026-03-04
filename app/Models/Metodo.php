<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metodo extends Model
{
    use HasFactory;

    protected $table = 'metodos';

    protected $fillable = [
        'nombre',
    ];
}