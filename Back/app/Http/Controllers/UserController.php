<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function createUser(Request $request)
    {
        $user=Auth::user();
        // Vérification du rôle avant de créer un utilisateur
        if ($user->role !== 'super_admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Logique pour créer un utilisateur
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'user',  // Seulement pour l'admin
        ]);

        return response()->json($user);
    }

    public function updateUser(Request $request, $id)
    {
        // Vérification si l'utilisateur a un rôle d'admin
        $user=Auth::user();
        if ($user->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $user = User::findOrFail($id);
        $user->update($request->all());

        return response()->json($user);
    }
}
