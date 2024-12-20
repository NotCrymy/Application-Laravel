@extends('layouts.app')

@section('title', 'Modifier une Cuve')

@section('content')
<div class="container">
    <h1>Modifier la Cuve : {{ $cuve->nom }}</h1>
    
    <!-- Formulaire pour la mise à jour -->
    <form action="{{ route('cuves.update', $cuve) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nom" class="form-label">Nom de la Cuve</label>
            <input type="text" class="form-control" id="nom" name="nom" value="{{ $cuve->nom }}" required>
        </div>

        <div class="mb-3">
            <label for="volume_max" class="form-label">Volume Maximum (L)</label>
            <input type="number" step="0.01" class="form-control" id="volume_max" name="volume_max" value="{{ $cuve->volume_max }}" disabled>
        </div>

        <button type="submit" class="btn btn-success">Enregistrer les Modifications</button>
        <a href="{{ route('cuves.index') }}" class="btn btn-secondary">Revenir</a>
    </form>

    <!-- Formulaire pour la suppression -->
    <form action="{{ route('cuves.destroy', $cuve) }}" method="POST" class="mt-4">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger w-10">Supprimer la Cuve</button>
    </form>

    <h2 class="mt-5">Moûts dans la Cuve</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Type</th>
                <th>Origine</th>
                <th>Volume</th>
                <th>Propriétaire</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cuve->mouts as $mout)
                <tr>
                    <!-- Affichage des informations du moût -->
                    <td>{{ $mout->type }}</td>
                    <td>{{ $mout->origine }}</td>
                    <td>
                        <!-- Formulaire de modification du volume uniquement -->
                        <form action="{{ route('cuves.mouts.update', [$cuve, $mout]) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')

                            <!-- Champ pour modifier le volume -->
                            <input type="number" name="volume" value="{{ $mout->volume }}" class="form-control form-control-sm d-inline" style="width: 80px;" min="0" step="0.1" required>

                            <!-- Champs cachés pour les autres données -->
                            <input type="hidden" name="type" value="{{ $mout->type }}">
                            <input type="hidden" name="origine" value="{{ $mout->origine }}">
                            <input type="hidden" name="proprietaire_id" value="{{ $mout->proprietaire_id }}">

                            <!-- Bouton pour soumettre le formulaire -->
                            <button type="submit" class="btn btn-primary btn-sm">Modifier</button>
                        </form>
                    </td>
                    <td>
                        <!-- Affichage du propriétaire -->
                        {{ $mout->proprietaire ? $mout->proprietaire->nom . ' ' . $mout->proprietaire->prenom : 'N/A' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection