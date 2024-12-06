@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<h1>Bienvenue sur le Dashboard Admin</h1>
<p>Vous avez accès à toutes les fonctionnalités.</p>

<p>Utilisez la navigation pour accéder aux fonctionnalités.</p>

@can('admin-access')
    <a href="{{ route('users.index') }}">Gestion des utilisateurs</a>
    <a href="{{ route('logs.index') }}">Voir les logs</a>
    <a href="{{ route('cuves.index') }}">Accéder aux cuves</a>
@endcan

@endsection
