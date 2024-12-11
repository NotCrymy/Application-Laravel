@extends('layouts.app')

@section('title', 'Cuves')

@section('content')
<div class="container">
    <h1>Liste des Cuves</h1>

    <!-- Barre de recherche -->
    <form method="GET" action="{{ route('cuves.index') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Rechercher une cuve par numéro ou nom" value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Rechercher</button>
        </div>
    </form>

    <!-- Tableau des cuves -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>N°</th>
                <th>Nom</th>
                <th>Volume Maximum</th>
                <th>Volume Utilisé</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cuves as $cuve)
                <tr>
                    <td>{{ $cuve->id }}</td>
                    <td>{{ $cuve->nom }}</td>
                    <td>{{ $cuve->volume_max }} L</td>
                    <td>{{ $cuve->volumeTotal() }} L</td>
                    <td>
                        <!-- Bouton Voir la Cuve -->
                        @canany('view', $cuve)
                            <a href="{{ route('cuves.show', $cuve) }}" class="btn btn-info btn-sm">Voir la Cuve</a>
                        @endcanany

                        <!-- Bouton Modifier le Moût -->
                        @can('update', $cuve)
                            @if($cuve->mouts->count() > 0)
                                <a href="{{ route('cuves.edit', $cuve) }}" class="btn btn-warning btn-sm">Modifier les Moûts</a>
                            @endif
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Aucune cuve trouvée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="d-flex justify-content-center mt-4">
        {{ $cuves->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection