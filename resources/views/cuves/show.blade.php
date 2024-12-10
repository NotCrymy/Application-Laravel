@extends('layouts.app')

@section('title', 'Détails de la Cuve')

@section('content')
<div class="container">
    <h1>Détails de la Cuve : {{ $cuve->nom }}</h1>
    <p><strong>Volume Maximum :</strong> {{ $cuve->volume_max }} L</p>
    <p><strong>Volume Utilisé :</strong> {{ $cuve->volumeTotal() }} L</p>

    <!-- Tableau des moûts -->
    <h2 class="mt-5">Moûts Contenus dans la Cuve</h2>
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

    @can('add-mout')
    <h2>Ajouter un Moût</h2>
    <form action="{{ route('cuves.mouts.store', $cuve) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <input type="text" class="form-control" id="type" name="type" required>
        </div>
        <div class="mb-3">
            <label for="origine" class="form-label">Origine</label>
            <input type="text" class="form-control" id="origine" name="origine" required>
        </div>
        <div class="mb-3">
            <label for="volume" class="form-label">Volume (L)</label>
            <input type="number" step="0.01" class="form-control" id="volume" name="volume" required>
        </div>
        <button type="submit" class="btn btn-success">Ajouter</button>
    </form>
    @endcan
</div>
@endsection