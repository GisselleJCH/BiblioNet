<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;

class PerfilController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('modules.auth.perfil.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role' => 'required|string|in:Administrador,Usuario',
        ]);

        $data = $request->only(['name', 'email', 'role']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('profile_image')) {
            // Eliminar la imagen anterior si existe
            if ($user->profile_image) {
                Storage::delete('public/' . $user->profile_image);
            }

            // Guardar la nueva imagen
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $data['profile_image'] = $path;
        }

        // Actualizar el usuario directamente en la base de datos
        DB::table('users')
            ->where('id', $user->id)
            ->update($data);

        return redirect()->route('perfil.edit')->with('success', 'Perfil actualizado correctamente.');
    }
}