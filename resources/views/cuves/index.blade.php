@extends('layouts.app')

@section('title', 'Cuves')

@section('content')
<div class="container">
    <h1>Liste des Cuves</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Volume Maximum</th>
                <th>Volume Utilisé</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cuves as $cuve)
                <tr>
                    <td>{{ $cuve->id }}</td>
                    <td>{{ $cuve->nom }}</td>
                    <td>{{ $cuve->volume_max }} L</td>
                    <td>{{ $cuve->volumeTotal() }} L</td>
                    <td>
                        <a href="{{ route('cuves.show', $cuve) }}" class="btn btn-info btn-sm">Voir les Moûts</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection