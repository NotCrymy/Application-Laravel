@extends('layouts.app')

@section('title', 'Modifier une Cuve')

@section('content')
<div class="container">
<h1>Modifier la Cuve : {{ $cuve->nom }}</h1>
    
    <form action="{{ route('cuves.update', $cuve) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nom" class="form-label">Nom de la Cuve</label>
            <input type="text" class="form-control" id="nom" name="nom" value="{{ $cuve->nom }}" required>
        </div>
        
        <div class="mb-3">
            <label for="volume_max" class="form-label">Volume Maximum (L)</label>
            <input type="number" step="0.01" class="form-control" id="volume_max" name="volume_max" value="{{ $cuve->volume_max }}" required>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <button type="submit" class="btn btn-success">Enregistrer les Modifications</button>
            <form action="{{ route('cuves.destroy', $cuve) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette cuve ?');">
                @csrf
                @method('DELETE')
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-danger">Supprimer la Cuve</button>
                </div>
            </form>
            <a href="{{ route('cuves.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>

    <h2 class="mt-5">Moûts dans la Cuve</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
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
                    <td>
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
</div>
@endsection