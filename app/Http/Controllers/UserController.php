<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all(); // Liste tous les utilisateurs
        return view('users.index', compact('users')); // Retourne une vue temporaire
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ],
            [
                'name.required' => 'Le champ "Nom" est obligatoire.',
                'email.required' => 'Le champ "Email" est obligatoire.',
                'email.email' => 'Veuillez fournir une adresse email valide.',
                'email.unique' => 'Cet email est déjà utilisé.',
                'password.required' => 'Le champ "Mot de passe" est obligatoire.',
                'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            ]
        );

        $validated['password'] = bcrypt($validated['password']); // Hash du mot de passe
        User::create($validated);

        return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé.');
    }
}
