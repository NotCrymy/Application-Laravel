@extends('layouts.app')

@section('title', 'Propriétaires')

@section('content')
<div class="container">
    <h1>Liste des Propriétaires</h1>

    <!-- Barre de recherche -->
    <form method="GET" action="{{ route('proprietaires.index') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Rechercher un propriétaire (nom, prénom, email)" value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Rechercher</button>
        </div>
    </form>

    <!-- Tableau des propriétaires -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Téléphone</th>
            </tr>
        </thead>
        <tbody>
            @forelse($proprietaires as $proprio)
                <tr>
                    <td>{{ $proprio->id }}</td>
                    <td>{{ $proprio->nom }}</td>
                    <td>{{ $proprio->prenom }}</td>
                    <td>{{ $proprio->email }}</td>
                    <td>{{ $proprio->numtel ?: 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Aucun propriétaire trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $proprietaires->links('pagination::bootstrap-5') }}
</div>
@endsection