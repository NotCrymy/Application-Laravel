@extends('layouts.app')

@section('title', 'Modifier Utilisateur')

@section('content')
<div class="container">
    <h1>Modifier l'Utilisateur : {{ $user->name }}</h1>
    
    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mot de Passe (laissez vide pour ne pas modifier)</label>
            <input type="password" class="form-control" id="password" name="password">
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

        <button type="submit" class="btn btn-success">Sauvegarder</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Annuler</a>
    </form>

    <!-- Bouton pour soft delete ou restaurer l'utilisateur -->
    @if(!$user->trashed())
        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline-block mt-3">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Supprimer (Soft Delete)</button>
        </form>
    @else
        <form action="{{ route('users.restore', $user->id) }}" method="POST" class="d-inline-block mt-3">
            @csrf
            <button type="submit" class="btn btn-success">Restaurer</button>
        </form>
    @endif
</div>
@endsection