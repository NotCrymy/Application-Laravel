@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Tableau de Bord')

@can('admin-access')
    <a href="{{ route('users.index') }}">Gestion des utilisateurs</a>
    <a href="{{ route('logs.index') }}">Voir les logs</a>
@endcan

@can('caviste-access')
    <a href="{{ route('cuves.index') }}">Accéder aux cuves</a>
@endcan

@section('content')
    <p>Bienvenue, {{ Auth::user()->name }} !</p>
    <p>Utilisez la navigation pour accéder aux fonctionnalités.</p>
@endsection