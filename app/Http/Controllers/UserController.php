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
        $roles = Role::all(); // Récupère tous les rôles
        $defaultRole = 'caviste'; // Rôle par défaut
        return view('users.index', compact('users', 'roles', 'defaultRole'));
    }

    /**
     * Crée un nouvel utilisateur.
     */
    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|max:30',
            'role' => 'required|exists:roles,name',
        ]);

        // Vérifie si l'utilisateur essaie d'ajouter un administrateur
        if ($validated['role'] === 'admin' && !auth()->user()->can('manage-admins')) {
            return redirect()->route('users.index')->with('error', 'Vous n\'êtes pas autorisé à ajouter un administrateur.');
        }

        // Création de l'utilisateur
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        // Attribution du rôle
        $user->assignRole($validated['role']);

        return redirect()->route('users.index')->with('success', 'Utilisateur ajouté avec succès.');
    }

    /**
     * Affiche le formulaire pour modifier un utilisateur.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id); // Trouver l'utilisateur
        $roles = Role::all(); // Récupérer tous les rôles disponibles
        $defaultRole = 'caviste'; // Rôle par défaut
        return view('users.edit', compact('user', 'roles', 'defaultRole'));
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

        // Vérifie si l'utilisateur est un administrateur
        if ($user->hasRole('admin') && !auth()->user()->can('manage-admins')) {
            return redirect()->route('users.index')->with('error', 'Vous n\'êtes pas autorisé à supprimer un administrateur.');
        }

        // Vérifie si l'utilisateur essaie de se supprimer lui-même
        if (auth()->id() === $user->id) {
            return redirect()->route('users.index')->with('error', 'Vous ne pouvez pas vous supprimer vous-même.');
        }

        // Supprime l'utilisateur
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }

    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Vérifie si l'utilisateur est un super admin
        if ($user->hasRole('super-admin')) {
            return redirect()->route('users.index')->with('error', 'Le rôle du super administrateur ne peut pas être modifié.');
        }

        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        $user->syncRoles([$request->input('role')]);

        return redirect()->route('users.index')->with('success', 'Le rôle de l\'utilisateur a été mis à jour avec succès.');
    }
}