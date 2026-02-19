<?php

namespace App\Http\Controllers;

use App\Models\Evaluacion;

class ReporteController extends Controller
{
    public function index()
    {
        $total = Evaluacion::count();
        $porMetodo = Evaluacion::selectRaw('metodo, count(*) as total')
                        ->groupBy('metodo')
                        ->get();

        return view('reportes.index', compact('total','porMetodo'));
    }
}
