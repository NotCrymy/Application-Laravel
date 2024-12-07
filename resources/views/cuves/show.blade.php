@extends('layouts.app')

@section('title', 'Détails de la Cuve')

@section('content')
<div class="container">
    <h1>Détails de la Cuve : {{ $cuve->nom }}</h1>
    <p><strong>Volume Maximum :</strong> {{ $cuve->volume_max }} L</p>
    <p><strong>Volume Utilisé :</strong> {{ $cuve->volumeTotal() }} L</p>

    <h2>Moûts Contenus dans la Cuve</h2>
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
                        <form action="{{ route('mouts.destroy', [$cuve, $mout]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('cuves.edit', $cuve) }}" class="btn btn-warning">Modifier la Cuve</a>
</div>
@endsection