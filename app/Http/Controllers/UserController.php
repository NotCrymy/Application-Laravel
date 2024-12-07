<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Liste tous les utilisateurs.
     */
    public function index()
    {
        $users = User::all(); // Liste tous les utilisateurs
        return view('users.index', compact('users'));
    }

    /**
     * Crée un nouvel utilisateur.
     */
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

    /**
     * Affiche le formulaire pour modifier un utilisateur.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id); // Trouver l'utilisateur
        $roles = Role::all(); // Récupérer tous les rôles disponibles
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Met à jour les informations d'un utilisateur (y compris le rôle).
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|exists:roles,name', // Valider que le rôle existe
        ]);

        // Met à jour les informations de l'utilisateur
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'] ? bcrypt($validated['password']) : $user->password,
        ]);

        // Met à jour le rôle
        $user->syncRoles([$validated['role']]);

        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Supprime un utilisateur.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé.');
    }
}