<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Evaluacion;
use App\Models\Metodo;
use App\Models\Puesto;
use App\Models\Sucursal;
use App\Models\Trabajador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluacionController extends Controller
{
    public function index()
    {
        $evaluaciones = Evaluacion::with([
            'empresa',
            'sucursal',
            'puesto',
            'trabajador',
            'metodo',
            'rebaEvaluacion',
            'rulaEvaluacion',
            'owasEvaluacion',
            'nioshEvaluacion',
            'nom036'
        ])->latest()->get();

        return view('evaluaciones.index', compact('evaluaciones'));
    }

    public function create()
    {
        $empresas = Empresa::where('activo', 1)->get();
        $sucursales = Sucursal::with('empresa')->where('activo', 1)->get();
        $puestos = Puesto::with('sucursal')->where('activo', 1)->get();
        $trabajadores = Trabajador::with('puesto')->where('activo', 1)->get();

        return view('evaluaciones.create', compact('empresas', 'sucursales', 'puestos', 'trabajadores'));
    }

    public function seleccionarMetodo(Request $request)
    {
        $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'sucursal_id' => 'required|exists:sucursales,id',
            'puesto_id' => 'required|exists:puestos,id',
            'trabajador_id' => 'required|exists:trabajadores,id',
            'fecha_evaluacion' => 'required|date',
            'metodo' => 'required|string',
            'area_evaluada' => 'nullable|string|max:255',
            'actividad_general' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string',
        ]);

        $metodo = Metodo::whereRaw('UPPER(nombre) = ?', [strtoupper($request->metodo)])->first();

        if (!$metodo) {
            return back()->withInput()->with('error', 'El método seleccionado no existe en la base de datos.');
        }

        $evaluacion = Evaluacion::create([
            'empresa_id' => $request->empresa_id,
            'sucursal_id' => $request->sucursal_id,
            'puesto_id' => $request->puesto_id,
            'trabajador_id' => $request->trabajador_id,
            'metodo_id' => $metodo->id,
            'user_id' => Auth::id(),
            'fecha_evaluacion' => $request->fecha_evaluacion,
            'area_evaluada' => $request->area_evaluada,
            'actividad' => $request->actividad_general,
            'observaciones' => $request->observaciones,
        ]);

        switch (strtoupper($request->metodo)) {
            case 'REBA':
                return redirect()->route('reba.create', $evaluacion->id);

            case 'RULA':
                return redirect()->route('rula.create', $evaluacion->id);

            case 'OWAS':
                return redirect()->route('owas.create', $evaluacion->id);

            case 'NIOSH':
                return redirect()->route('niosh.create', $evaluacion->id);

            case 'NOM-036':
            case 'NOM036':
            case 'NOM 036':
                return redirect()->route('nom036.create', $evaluacion->id);

            default:
                return back()->withInput()->with('error', 'Método no válido.');
        }
    }
}