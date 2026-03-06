<?php

namespace App\Http\Controllers;

use App\Models\Evaluacion;
use Illuminate\Http\Request;

class EvaluacionController extends Controller
{
    public function index()
    {
        $evaluaciones = Evaluacion::all();
        return view('evaluaciones.index', compact('evaluaciones'));
    }

    public function create()
    {
        return view('evaluaciones.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('evaluaciones.index')
            ->with('success', 'Evaluación creada correctamente.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}