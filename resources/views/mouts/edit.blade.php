@extends('layouts.app')

@section('title', 'Modifier un Moût')

@section('content')
<div class="container">
    <h1>Modifier le Moût : {{ $mout->type }}</h1>

    <form action="{{ route('mouts.update', [$cuve, $mout]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <input type="text" class="form-control" id="type" name="type" value="{{ $mout->type }}" required>
        </div>
        <div class="mb-3">
            <label for="origine" class="form-label">Origine</label>
            <input type="text" class="form-control" id="origine" name="origine" value="{{ $mout->origine }}" required>
        </div>
        <div class="mb-3">
            <label for="volume" class="form-label">Volume (L)</label>
            <input type="number" step="0.01" class="form-control" id="volume" name="volume" value="{{ $mout->volume }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
        <a href="{{ route('cuves.show', $cuve) }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection