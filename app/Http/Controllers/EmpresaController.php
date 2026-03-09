<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function index()
    {
        $empresas = Empresa::latest()->paginate(10);
        return view('empresas.index', compact('empresas'));
    }

    public function create()
    {
        return view('empresas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'razon_social' => 'nullable|string|max:255',
            'rfc' => 'nullable|string|max:20',
            'telefono' => 'nullable|string|max:20',
            'correo' => 'nullable|email|max:255',
            'direccion' => 'nullable|string',
        ]);

        Empresa::create([
            'nombre' => $request->nombre,
            'razon_social' => $request->razon_social,
            'rfc' => $request->rfc,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
            'direccion' => $request->direccion,
            'activo' => $request->has('activo') ? 1 : 0,
        ]);

        return redirect()->route('empresas.index')
            ->with('success', 'Empresa creada correctamente.');
    }

    public function show(string $id)
    {
        $empresa = Empresa::with('sucursales')->findOrFail($id);
        return view('empresas.show', compact('empresa'));
    }

    public function edit(string $id)
    {
        $empresa = Empresa::findOrFail($id);
        return view('empresas.edit', compact('empresa'));
    }

    public function update(Request $request, string $id)
    {
        $empresa = Empresa::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'razon_social' => 'nullable|string|max:255',
            'rfc' => 'nullable|string|max:20',
            'telefono' => 'nullable|string|max:20',
            'correo' => 'nullable|email|max:255',
            'direccion' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $empresa->update([
            'nombre' => $request->nombre,
            'razon_social' => $request->razon_social,
            'rfc' => $request->rfc,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
            'direccion' => $request->direccion,
            'activo' => $request->has('activo') ? 1 : 0,
        ]);

        return redirect()->route('empresas.index')
            ->with('success', 'Empresa actualizada correctamente.');
    }

    public function destroy(string $id)
    {
        $empresa = Empresa::findOrFail($id);
        $empresa->delete();

        return redirect()->route('empresas.index')
            ->with('success', 'Empresa eliminada correctamente.');
    }
}