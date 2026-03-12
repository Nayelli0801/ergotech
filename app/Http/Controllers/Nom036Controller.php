<?php

namespace App\Http\Controllers;

use App\Models\Evaluacion;
use Illuminate\Http\Request;

class Nom036Controller extends Controller
{
    public function create($evaluacionId)
    {
        $evaluacion = Evaluacion::with([
            'empresa',
            'sucursal',
            'puesto',
            'trabajador',
            'metodo'
        ])->findOrFail($evaluacionId);

        return view('nom036.create', compact('evaluacion'));
    }

    public function store(Request $request, $evaluacionId)
    {
        return back()->with('success', 'Controlador NOM-036 funcionando.');
    }

    public function show($id)
    {
        abort(404, 'Vista NOM-036 aún no implementada.');
    }
}