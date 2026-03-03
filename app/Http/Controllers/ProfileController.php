<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Mostrar el formulario de edición del perfil
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Actualizar la información del perfil del usuario
     */
    public function update(Request $request)
    {
        // Obtener el usuario autenticado
        $user = $request->user();

        // Validación de los campos
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'profile_photo' => ['nullable', 'image', 'max:2048'], // Máx 2MB
        ]);

        // 🔹 Si el usuario subió una nueva foto
        if ($request->hasFile('profile_photo')) {

            // 🔸 Eliminar la foto anterior si existe
            if ($user->profile_photo) {
                Storage::delete('public/' . $user->profile_photo);
            }

            // 🔸 Guardar la nueva foto en storage/app/public/profile-photos
            $path = $request->file('profile_photo')
                            ->store('profile-photos', 'public');

            // 🔸 Guardar la ruta en la base de datos
            $user->profile_photo = $path;
        }

        // 🔹 Actualizar datos del usuario
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;

        // 🔹 Guardar cambios en la base de datos
        $user->save();

        return back()->with('status', 'profile-updated');
    }

    /**
     * Eliminar la cuenta del usuario
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Validar contraseña actual antes de eliminar
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Cerrar sesión
        Auth::logout();

        // Eliminar usuario
        $user->delete();

        // Invalidar sesión
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
