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
                <th>Type</th>
                <th>Origine</th>
                <th>Volume</th>
                <th>Propriétaire</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cuve->mouts as $mout)
                <tr>
                    <td>{{ $mout->type }}</td>
                    <td>{{ $mout->origine }}</td>
                    <td>{{ $mout->volume }} L</td>
                    <td>
                        @if($mout->proprietaire)
                            {{ $mout->proprietaire->nom }} {{ $mout->proprietaire->prenom }}
                            <a href="{{ route('proprietaires.show', $mout->proprietaire) }}" class="btn btn-info btn-sm" style="margin-left:10px;">
                                Voir Détails
                            </a>
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection