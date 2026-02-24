<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rol;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
{
    $usuarios = User::with('rol')->get();
    return view('usuarios.index', compact('usuarios'));
}

public function edit($id)
{
    $user = User::findOrFail($id);
    $roles = Rol::all();

    return view('usuarios.edit', compact('user','roles'));
}

public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $user->rol_id = $request->rol_id;
    $user->save();

    return redirect()->route('usuarios.index');
}

public function create()
{
    $roles = Rol::all();
    return view('usuarios.create', compact('roles'));
}

// Guardar usuario
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'rol_id' => 'required|exists:rols,id',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'rol_id' => $request->rol_id,
    ]);

    return redirect()->route('usuarios.index')
        ->with('success', 'Usuario creado correctamente');
}


}


