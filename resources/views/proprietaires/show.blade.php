@extends('layouts.app')

@section('title', 'Détails du Propriétaire')

@section('content')
<div class="container">
    <h1>Détails du Propriétaire</h1>
    <p><strong>Nom :</strong> {{ $proprietaire->nom }}</p>
    <p><strong>Prénom :</strong> {{ $proprietaire->prenom }}</p>
    <p><strong>Téléphone :</strong> {{ $proprietaire->numtel }}</p>
    <p><strong>Email :</strong> {{ $proprietaire->email }}</p>

    <!-- Si on veut lister les mouts du propriétaire -->
    @if($proprietaire->mouts->count() > 0)
        <h2>Moûts de ce Propriétaire</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Origine</th>
                    <th>Volume</th>
                    <th>Cuve</th>
                </tr>
            </thead>
            <tbody>
                @foreach($proprietaire->mouts as $mout)
                    <tr>
                        <td>{{ $mout->type }}</td>
                        <td>{{ $mout->origine }}</td>
                        <td>{{ $mout->volume }} L</td>
                        <td>{{ $mout->cuve ? $mout->cuve->nom : 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Ce propriétaire n a aucun moût.</p>
    @endif
</div>
@endsection
