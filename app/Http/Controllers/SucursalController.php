<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Sucursal;
use Illuminate\Http\Request;

class SucursalController extends Controller
{
    public function index()
    {
        $sucursales = Sucursal::with('empresa')->latest()->get();
        return view('sucursales.index', compact('sucursales'));
    }

    public function create()
    {
        $empresas = Empresa::where('activo', 1)->get();
        return view('sucursales.create', compact('empresas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'nombre' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'responsable' => 'nullable|string|max:255',
            'activo' => 'required|boolean',
        ]);

        Sucursal::create($request->all());

        return redirect()->route('sucursales.index')
            ->with('success', 'Sucursal registrada correctamente.');
    }

    public function edit(string $id)
    {
        $sucursal = Sucursal::findOrFail($id);
        $empresas = Empresa::where('activo', 1)->get();

        return view('sucursales.edit', compact('sucursal', 'empresas'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'nombre' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'responsable' => 'nullable|string|max:255',
            'activo' => 'required|boolean',
        ]);

        $sucursal = Sucursal::findOrFail($id);
        $sucursal->update($request->all());

        return redirect()->route('sucursales.index')
            ->with('success', 'Sucursal actualizada correctamente.');
    }

    public function destroy(string $id)
    {
        $sucursal = Sucursal::findOrFail($id);
        $sucursal->delete();

        return redirect()->route('sucursales.index')
            ->with('success', 'Sucursal eliminada correctamente.');
    }
}