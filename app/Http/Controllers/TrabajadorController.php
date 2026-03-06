<?php

namespace App\Http\Controllers;

use App\Models\Puesto;
use App\Models\Trabajador;
use Illuminate\Http\Request;

class TrabajadorController extends Controller
{
    public function index()
    {
        $trabajadores = Trabajador::with('puesto.sucursal.empresa')->latest()->get();
        return view('trabajadores.index', compact('trabajadores'));
    }

    public function create()
    {
        $puestos = Puesto::with('sucursal.empresa')->where('activo', 1)->get();
        return view('trabajadores.create', compact('puestos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'puesto_id' => 'required|exists:puestos,id',
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'nullable|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'sexo' => 'nullable|string|max:50',
            'edad' => 'nullable|integer|min:0',
            'estatura' => 'nullable|numeric|min:0',
            'peso' => 'nullable|numeric|min:0',
            'antiguedad' => 'nullable|numeric|min:0',
            'activo' => 'required|boolean',
        ]);

        Trabajador::create($request->all());

        return redirect()->route('trabajadores.index')
            ->with('success', 'Trabajador registrado correctamente.');
    }

    public function edit(string $id)
    {
        $trabajador = Trabajador::findOrFail($id);
        $puestos = Puesto::with('sucursal.empresa')->where('activo', 1)->get();

        return view('trabajadores.edit', compact('trabajador', 'puestos'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'puesto_id' => 'required|exists:puestos,id',
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'nullable|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'sexo' => 'nullable|string|max:50',
            'edad' => 'nullable|integer|min:0',
            'estatura' => 'nullable|numeric|min:0',
            'peso' => 'nullable|numeric|min:0',
            'antiguedad' => 'nullable|numeric|min:0',
            'activo' => 'required|boolean',
        ]);

        $trabajador = Trabajador::findOrFail($id);
        $trabajador->update($request->all());

        return redirect()->route('trabajadores.index')
            ->with('success', 'Trabajador actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $trabajador = Trabajador::findOrFail($id);
        $trabajador->delete();

        return redirect()->route('trabajadores.index')
            ->with('success', 'Trabajador eliminado correctamente.');
    }
}