@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Tableau de Bord')

@section('content')
    <p>Bienvenue, {{ Auth::user()->name }} !</p>
    <p>Utilisez la navigation pour accéder aux fonctionnalités.</p>
@endsection