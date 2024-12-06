@extends('layouts.app')

@section('content')
<h1>Bienvenue sur le Dashboard</h1>

@can('admin-access')
    <h2>Section Admin</h2>
    <a href="{{ route('users.index') }}">Gérer les Utilisateurs</a>
    <a href="{{ route('logs.index') }}">Voir les Logs</a>
    <a href="{{ route('cuves.index') }}">Voir les Cuves</a>
@endcan

@can('manager-access')
    <h2>Section Manager</h2>
    <p>Accès à certaines fonctionnalités spécifiques.</p>
@endcan

@can('caviste-access')
    <h2>Section Caviste</h2>
    <a href="{{ route('cuves.index') }}">Voir les Cuves</a>
@endcan
@endsection