@extends('layouts.app')

@section('title', 'Modifier les Moûts')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">Gestion des Moûts de la Cuve: {{ $cuve->nom }}</h1>

    <!-- Formulaire pour ajouter un moût -->
    <h2 class="mt-5">Ajouter un Moût</h2>
    <form id="addMoutForm" method="POST" action="{{ route('cuves.mouts.store', $cuve) }}">
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
        <div class="mb-3">
            <label for="proprietaire_id" class="form-label">Propriétaire</label>
            <select class="form-control" id="proprietaire_id" name="proprietaire_id" required>
                @foreach($proprietaires as $prop)
                    <option value="{{ $prop->id }}">{{ $prop->nom }} {{ $prop->prenom }} ({{ $prop->email }})</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter le Moût</button>
    </form>

    <!-- Formulaire pour ajouter un propriétaire -->
    <h2 class="mt-5">Ajouter un Propriétaire</h2>
    <form id="addProprietaireForm" method="POST" action="{{ route('proprietaires.store') }}">
        @csrf
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" required>
        </div>
        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" class="form-control" id="prenom" name="prenom" required>
        </div>
        <div class="mb-3">
            <label for="numtel" class="form-label">Téléphone</label>
            <input type="text" class="form-control" id="numtel" name="numtel">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter le Propriétaire</button>
    </form>
</div>
@endsection
