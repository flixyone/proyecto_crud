<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Almacenar un nuevo usuario en el almacenamiento.
     */
    public function store(Request $request)
    {
        // Primero, valido los datos de la solicitud
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|exists:roles,name',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Manejo el avatar del usuario si se ha subido uno
        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        // Creo un nuevo usuario con los datos validados
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => $avatarPath,
        ]);

        // Asigno el rol al usuario
        $user->assignRole($request->role);

        // Redirijo a la vista de edición del perfil con un mensaje de éxito
        return redirect()->route('profile.edit')->with('success', 'Usuario creado exitosamente');
    }

    /**
     * Actualizar un usuario en el almacenamiento.
     */
    public function update(Request $request, $id)
    {
        // Primero, valido los datos de la solicitud
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string|exists:roles,name',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Obtengo el usuario especificado por su id
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;

        // Actualizo la contraseña si se ha proporcionado una nueva
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        // Manejo el avatar del usuario si se ha subido uno nuevo
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        // Actualizo el rol del usuario
        $user->syncRoles([$request->role]);
        $user->save();

        // Redirijo a la vista de edición del perfil con un mensaje de éxito
        return redirect()->route('profile.edit')->with('success', 'Usuario actualizado exitosamente');
    }
}
