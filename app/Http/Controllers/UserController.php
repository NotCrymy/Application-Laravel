<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    // Liste tous les utilisateurs avec leurs rôles et les soft deletes
    public function index()
    {
        $users = User::withTrashed()->get();
        $roles = Role::all();
        $defaultRole = 'cuviste';

        \App\Helpers\LogHelper::logAction("Consultation de la liste des utilisateurs.");

        return view('users.index', compact('users', 'roles', 'defaultRole'));
    }

    // Crée un nouvel utilisateur avec un rôle spécifié
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|max:30',
            'role' => 'required|exists:roles,name',
        ]);

        // Vérifie les permissions pour créer un administrateur
        if ($validated['role'] === 'admin' && !auth()->user()->can('manage-admins')) {
            return redirect()->route('users.index')->withErrors('Vous n\'êtes pas autorisé à ajouter un administrateur.');
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        $user->assignRole($validated['role']);

        \App\Helpers\LogHelper::logAction("Création de l'utilisateur '{$user->name}' avec le rôle '{$validated['role']}'.");

        return redirect()->route('users.index')->with('success', 'Utilisateur ajouté avec succès.');
    }

    // Affiche le formulaire pour modifier un utilisateur
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $defaultRole = 'cuviste';

        \App\Helpers\LogHelper::logAction("Accès à l'édition de l'utilisateur '{$user->name}'.");

        return view('users.edit', compact('user', 'roles', 'defaultRole'));
    }

    // Met à jour les informations d'un utilisateur existant
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|exists:roles,name',
        ]);

        $oldName = $user->name;
        $oldEmail = $user->email;

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'] ? bcrypt($validated['password']) : $user->password,
        ]);

        $user->syncRoles([$validated['role']]);

        \App\Helpers\LogHelper::logAction("Mise à jour de l'utilisateur '{$oldName}' : Nouveau nom = '{$user->name}', Nouveau rôle = '{$validated['role']}', Ancien email = '{$oldEmail}', Nouvel email = '{$user->email}'.");

        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    // Supprime un utilisateur (soft delete)
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Empêche la suppression d'un administrateur sans permissions
        if ($user->hasRole('admin') && !auth()->user()->can('manage-admins')) {
            return redirect()->route('users.index')->withErrors('Vous n\'êtes pas autorisé à supprimer un administrateur.');
        }

        // Empêche l'utilisateur de se supprimer lui-même
        if (auth()->id() === $user->id) {
            return redirect()->route('users.index')->withErrors('Vous ne pouvez pas vous supprimer vous-même.');
        }

        $user->delete();
        \App\Helpers\LogHelper::logAction("Utilisateur '{$user->name}' soft deleted.");

        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès (soft delete).');
    }

    // Restaure un utilisateur soft deleted
    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        \App\Helpers\LogHelper::logAction("Utilisateur '{$user->name}' restored.");

        return redirect()->route('users.index')->with('success', 'Utilisateur restauré avec succès.');
    }

    // Supprime définitivement un utilisateur
    public function forceDelete($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->forceDelete();

        \App\Helpers\LogHelper::logAction("Utilisateur '{$user->name}' permanently deleted.");

        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé définitivement.');
    }

    // Met à jour le rôle d'un utilisateur
    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Empêche la modification du rôle "super-admin"
        if ($user->hasRole('super-admin')) {
            return redirect()->route('users.index')->withErrors('Le rôle du super administrateur ne peut pas être modifié.');
        }

        $validated = $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        $oldRoles = $user->getRoleNames()->join(', ');

        $user->syncRoles([$validated['role']]);

        \App\Helpers\LogHelper::logAction("Mise à jour des rôles de l'utilisateur '{$user->name}' : Ancien(s) rôle(s) = '{$oldRoles}', Nouveau rôle = '{$validated['role']}'.");

        return redirect()->route('users.index')->with('success', 'Le rôle de l\'utilisateur a été mis à jour avec succès.');
    }
}