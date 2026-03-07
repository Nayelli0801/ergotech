<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Evaluacion;
use App\Models\Puesto;
use App\Models\Sucursal;
use App\Models\Trabajador;
use Illuminate\Http\Request;

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
            'rebaEvaluacion'
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

        $datos = [
            'empresa_id' => $request->empresa_id,
            'sucursal_id' => $request->sucursal_id,
            'puesto_id' => $request->puesto_id,
            'trabajador_id' => $request->trabajador_id,
            'fecha_evaluacion' => $request->fecha_evaluacion,
            'area_evaluada' => $request->area_evaluada,
            'actividad_general' => $request->actividad_general,
            'observaciones' => $request->observaciones,
        ];

        switch (strtoupper($request->metodo)) {
            case 'REBA':
                return redirect()->route('reba.create', $datos);

            case 'RULA':
                return back()->withInput()->with('error', 'RULA aún no está implementado.');

            case 'OWAS':
                return back()->withInput()->with('error', 'OWAS aún no está implementado.');

            case 'NIOSH':
                return back()->withInput()->with('error', 'NIOSH aún no está implementado.');

            default:
                return back()->withInput()->with('error', 'Método no válido.');
        }
    }
}