<?php

namespace App\Http\Controllers;

use App\Models\Puesto;
use App\Models\Sucursal;
use Illuminate\Http\Request;

class PuestoController extends Controller
{
    public function index()
    {
        $puestos = Puesto::with('sucursal.empresa')->latest()->get();
        return view('puestos.index', compact('puestos'));
    }

    public function create()
    {
        $sucursales = Sucursal::with('empresa')->where('activo', 1)->get();
        return view('puestos.create', compact('sucursales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sucursal_id' => 'required|exists:sucursales,id',
            'nombre' => 'required|string|max:255',
            'area' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'activo' => 'required|boolean',
        ]);

        Puesto::create($request->all());

        return redirect()->route('puestos.index')
            ->with('success', 'Puesto registrado correctamente.');
    }

    public function edit(string $id)
    {
        $puesto = Puesto::findOrFail($id);
        $sucursales = Sucursal::with('empresa')->where('activo', 1)->get();

        return view('puestos.edit', compact('puesto', 'sucursales'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'sucursal_id' => 'required|exists:sucursales,id',
            'nombre' => 'required|string|max:255',
            'area' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'activo' => 'required|boolean',
        ]);

        $puesto = Puesto::findOrFail($id);
        $puesto->update($request->all());

        return redirect()->route('puestos.index')
            ->with('success', 'Puesto actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $puesto = Puesto::findOrFail($id);
        $puesto->delete();

        return redirect()->route('puestos.index')
            ->with('success', 'Puesto eliminado correctamente.');
    }
}