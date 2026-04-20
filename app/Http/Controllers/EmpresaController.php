<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpresaController extends Controller
{
    // 📌 LISTAR
    public function index()
    {
        $empresas = Empresa::latest()->paginate(10);
        return view('empresas.index', compact('empresas'));
    }

    // 📌 FORM CREAR
    public function create()
    {
        return view('empresas.create');
    }

    // 📌 GUARDAR
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'nullable|string',
            'telefono' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        // Guardar imagen
        if ($request->hasFile('imagen')) {
            $ruta = $request->file('imagen')->store('empresas', 'public');
            $data['imagen'] = $ruta;
        }

        Empresa::create($data);

        return redirect()->route('empresas.index')
            ->with('success', 'Empresa creada correctamente');
    }

    // 📌 FORM EDITAR
    public function edit($id)
    {
        $empresa = Empresa::findOrFail($id);
        return view('empresas.edit', compact('empresa'));
    }

    // 📌 ACTUALIZAR
    public function update(Request $request, $id)
    {
        $empresa = Empresa::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'nullable|string',
            'telefono' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        // Si hay nueva imagen
        if ($request->hasFile('imagen')) {

            // borrar imagen anterior
            if ($empresa->imagen) {
                Storage::delete('public/' . $empresa->imagen);
            }

            // guardar nueva
            $ruta = $request->file('imagen')->store('empresas', 'public');
            $data['imagen'] = $ruta;
        }

        $empresa->update($data);

        return redirect()->route('empresas.index')
            ->with('success', 'Empresa actualizada correctamente');
    }

    // 📌 ELIMINAR
    public function destroy($id)
    {
        $empresa = Empresa::findOrFail($id);

        // borrar imagen si existe
        if ($empresa->imagen) {
            Storage::delete('public/' . $empresa->imagen);
        }

        $empresa->delete();

        return redirect()->route('empresas.index')
            ->with('success', 'Empresa eliminada correctamente');
    }
    public function show($id)
{
    $empresa = Empresa::findOrFail($id);
    return view('empresas.show', compact('empresa'));
}
}