<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class ProfileController extends Controller
{
    /**
     * Mostrar el formulario para editar el perfil.
     */
    public function edit()
    {
        // Obtengo todos los roles disponibles
        $roles = Role::all();

        // Devuelvo la vista 'profile.edit' con los roles obtenidos
        return view('profile.edit', compact('roles'));
    }

    /**
     * Actualizar el perfil del usuario autenticado.
     */
    public function update(Request $request)
    {
        // Primero, valido los datos de la solicitud
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
            'avatar' => 'nullable|image|max:1024',
            'role' => 'required|string|exists:roles,name',
        ]);

        // Obtengo el usuario autenticado
        $user = auth()->user();

        // Actualizo el nombre y el correo electrónico del usuario
        $user->update($request->only('name', 'email'));

        // Si se ha subido un nuevo avatar, lo almaceno y actualizo el campo avatar del usuario
        if ($request->hasFile('avatar')) {
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        // Actualizo el rol del usuario
        $user->syncRoles(Role::where('name', $request->role)->first());

        // Redirijo a la vista de edición del perfil con un mensaje de éxito
        return redirect()->route('profile.edit')->with('success', 'Perfil actualizado exitosamente.');
    }
}
