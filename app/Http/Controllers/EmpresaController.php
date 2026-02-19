<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function index()
    {
        $empresas = Empresa::all();
        return view('empresas.index', compact('empresas'));
    }

    public function create()
    {
        return view('empresas.create');
    }

    public function store(Request $request)
{
    Empresa::create([
        'nombre' => $request->nombre,
        'direccion' => $request->direccion
    ]);

    return redirect('/empresas')->with('success','Empresa creada');
}


    public function edit($id)
{
    $empresa = Empresa::findOrFail($id);
    return view('empresas.edit', compact('empresa'));
}

public function update(Request $request, $id)
{
    $empresa = Empresa::findOrFail($id);

    $empresa->update([
        'nombre' => $request->nombre,
        'direccion' => $request->direccion,
        'telefono' => $request->telefono,
    ]);

    return redirect()->route('empresas.index')->with('success', 'Empresa actualizada');
}

public function destroy($id)
{
    Empresa::destroy($id);
    return redirect()->route('empresas.index')->with('success', 'Empresa eliminada');
}

}
