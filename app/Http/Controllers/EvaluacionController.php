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
        $empresas = Empresa::all();
        $sucursales = Sucursal::all();
        $puestos = Puesto::all();
        $trabajadores = Trabajador::all();

        return view('evaluaciones.create', compact('empresas', 'sucursales', 'puestos', 'trabajadores'));
    }

    public function seleccionarMetodo(Request $request)
    {
        $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'sucursal_id' => 'required|exists:sucursales,id',
            'puesto_id' => 'required|exists:puestos,id',
            'trabajador_id' => 'required|exists:trabajadores,id',
            'fecha' => 'required|date',
            'metodo' => 'required|string',
        ]);

        $datos = [
            'empresa_id' => $request->empresa_id,
            'sucursal_id' => $request->sucursal_id,
            'puesto_id' => $request->puesto_id,
            'trabajador_id' => $request->trabajador_id,
            'fecha' => $request->fecha,
            'observaciones' => $request->observaciones,
        ];

        switch (strtoupper($request->metodo)) {
            case 'REBA':
                return redirect()->route('reba.create', $datos);

            case 'RULA':
                return back()->with('error', 'RULA aún no está implementado.');

            case 'OWAS':
                return back()->with('error', 'OWAS aún no está implementado.');

            case 'NIOSH':
                return back()->with('error', 'NIOSH aún no está implementado.');

            default:
                return back()->with('error', 'Método no válido.');
        }
    }
}