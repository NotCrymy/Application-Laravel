@extends('layouts.app')

@section('title', 'Gestion des Utilisateurs')

@section('content')
<div class="container">
    <h1 class="mb-4">Gestion des Utilisateurs</h1>

    <!-- Section pour ajouter un utilisateur -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Ajouter un Utilisateur
        </div>
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="name" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nom de l'utilisateur" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Adresse Email" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="password" class="form-label">Mot de Passe</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Rôle</label>
                    <select name="role" id="role" class="form-select">
                        @foreach($roles as $role)
                            @if(($role->name === 'admin' || $role->name === 'super-admin') && !auth()->user()->can('manage-admins'))
                                @continue
                            @endif
                            <option value="{{ $role->name }}" {{ trim($role->name) === trim($defaultRole) ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Ajouter l'Utilisateur</button>
            </form>
        </div>
    </div>

    <!-- Tableau des utilisateurs -->
    <h2 class="mb-3">Liste des Utilisateurs</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->roles->pluck('name')->join(', ') }}</td>
                    <td class="d-flex gap-2">
                        @if(!$user->hasRole('super-admin'))
                            <!-- Bouton Modifier -->
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">Modifier</a>

                            <!-- Bouton Supprimer Définitivement -->
                            <form action="{{ route('users.forceDelete', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Supprimer Définitivement</button>
                            </form>
                        
                            <!-- Bouton Restaurer -->
                            @if($user->trashed())
                                <form action="{{ route('users.restore', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Restaurer</button>
                                </form>
                            @endif
                        @else
                            <span class="badge bg-secondary">Super Admin</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection