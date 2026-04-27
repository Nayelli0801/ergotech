<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'rfc' => 'nullable|string|max:50',
            'telefono' => 'nullable|string|max:50',
            'correo' => 'nullable|email|max:255',
            'direccion' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'activo' => 'nullable|boolean',
        ]);

        $data = $request->except('logo');

        $data['activo'] = $request->has('activo') ? 1 : 0;

        if ($request->hasFile('logo')) {
            $ruta = $request->file('logo')->store('empresas', 'public');
            $data['logo'] = $ruta;
        }

        Empresa::create($data);

        return redirect()->route('empresas.index')
            ->with('success', 'Empresa creada correctamente');
    }

    public function show($id)
    {
        $empresa = Empresa::findOrFail($id);
        return view('empresas.show', compact('empresa'));
    }

    public function edit($id)
    {
        $empresa = Empresa::findOrFail($id);
        return view('empresas.edit', compact('empresa'));
    }

    public function update(Request $request, $id)
    {
        $empresa = Empresa::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'razon_social' => 'nullable|string|max:255',
            'rfc' => 'nullable|string|max:50',
            'telefono' => 'nullable|string|max:50',
            'correo' => 'nullable|email|max:255',
            'direccion' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'activo' => 'nullable|boolean',
        ]);

        $data = $request->except('logo');

        $data['activo'] = $request->has('activo') ? 1 : 0;

        if ($request->hasFile('logo')) {
            if ($empresa->logo) {
                Storage::disk('public')->delete($empresa->logo);
            }

            $ruta = $request->file('logo')->store('empresas', 'public');
            $data['logo'] = $ruta;
        }

        $empresa->update($data);

        return redirect()->route('empresas.index')
            ->with('success', 'Empresa actualizada correctamente');
    }

    public function destroy($id)
    {
        $empresa = Empresa::findOrFail($id);

        if ($empresa->logo) {
            Storage::disk('public')->delete($empresa->logo);
        }

        $empresa->delete();

        return redirect()->route('empresas.index')
            ->with('success', 'Empresa eliminada correctamente');
    }
}