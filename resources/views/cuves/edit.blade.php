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
        <a href="{{ route('cuves.index') }}" class="btn btn-secondary">Annuler</a>
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
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cuve->mouts as $mout)
                <tr>
                    <td>{{ $mout->type }}</td>
                    <td>{{ $mout->origine }}</td>
                    <td>{{ $mout->volume }} L</td>
                    <td>{{ $mout->proprietaire ? $mout->proprietaire->nom.' '.$mout->proprietaire->prenom : 'N/A' }}</td>
                    <td>
                        <form action="{{ route('cuves.mouts.destroy', [$cuve, $mout]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection