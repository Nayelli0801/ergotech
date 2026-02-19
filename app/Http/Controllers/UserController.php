<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rol;

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
}


