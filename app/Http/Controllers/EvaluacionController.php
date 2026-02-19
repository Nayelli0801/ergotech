<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\User;
use App\Models\Evaluacion;
use Illuminate\Http\Request;

class EvaluacionController extends Controller
{
    public function __construct()
{
    $this->middleware(function ($request, $next) {

        if (!auth()->user()->isAdmin() && !auth()->user()->isEvaluador()) {
            abort(403, 'No tienes permiso para acceder aquí.');
        }

        return $next($request);
    });
}

    public function index()
     {
    if (!auth()->user()->isAdmin() && !auth()->user()->isEvaluador()) {
        abort(403);
    }

    $evaluaciones = Evaluacion::all();
    return view('evaluaciones.index', compact('evaluaciones'));
    }

    public function create()
    {
        $empresas = Empresa::all();

        $evaluadores = User::whereHas('rol', function($q){
            $q->where('nombre','evaluador');
        })->get();

        return view('evaluaciones.create', compact('empresas','evaluadores'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'user_id' => 'required|exists:users,id',
            'metodo' => 'required|string|max:255',
            'fecha' => 'required|date',
            'observaciones' => 'nullable|string'
        ]);

        Evaluacion::create($validated);

        return redirect()->route('evaluaciones.index')
            ->with('success', 'Evaluación creada correctamente');
    }

    public function edit($id)
    {
        $evaluacion = Evaluacion::findOrFail($id);
        $empresas = Empresa::all();

        $evaluadores = User::whereHas('rol', function($q){
            $q->where('nombre','evaluador');
        })->get();

        return view('evaluaciones.edit', compact('evaluacion','empresas','evaluadores'));
    }

    public function update(Request $request, $id)
    {
        $evaluacion = Evaluacion::findOrFail($id);

        $validated = $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'user_id' => 'required|exists:users,id',
            'metodo' => 'required|string|max:255',
            'fecha' => 'required|date',
            'observaciones' => 'nullable|string'
        ]);

        $evaluacion->update($validated);

        return redirect()->route('evaluaciones.index')
            ->with('success','Evaluación actualizada correctamente');
    }

    public function destroy($id)
    {
        $evaluacion = Evaluacion::findOrFail($id);
        $evaluacion->delete();

        return redirect()->route('evaluaciones.index')
            ->with('success','Evaluación eliminada correctamente');
    }

    public function historial()
{
    $evaluaciones = Evaluacion::where('user_id', auth()->id())->get();
    return view('evaluaciones.historial', compact('evaluaciones'));
}




}
