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
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cuve->mouts as $mout)
                <tr>
                    <td>{{ $mout->id }}</td>
                    <td>{{ $mout->type }}</td>
                    <td>{{ $mout->origine }}</td>
                    <td>{{ $mout->volume }} L</td>
                    <td class="text-end">
                        <form action="{{ route('mouts.destroy', [$cuve, $mout]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


    <!-- Formulaire pour ajouter un moût -->
    <h3 class="mt-5">Ajouter un Moût</h3>
    <form action="{{ route('cuves.mouts.store', $cuve) }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="type" class="form-label">Type</label>
                <input type="text" class="form-control" id="type" name="type" placeholder="Type de moût" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="origine" class="form-label">Origine</label>
                <input type="text" class="form-control" id="origine" name="origine" placeholder="Origine du moût" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="volume" class="form-label">Volume (L)</label>
                <input type="number" step="0.01" class="form-control" id="volume" name="volume" placeholder="Volume" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Ajouter le Moût</button>
    </form>
</div>
@endsection