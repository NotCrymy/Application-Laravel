@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <h1 class="text-center my-4">Bienvenue sur le Dashboard</h1>
    <!-- Section Admin -->
    @canany(['admin-access', 'super-admin-access'])
        <div class="mb-5">
            <h2 class="text-primary text-center mb-3">Section Admin</h2>
            <div class="card shadow-sm border-primary">
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('users.index') }}" class="btn btn-primary w-100 py-3 centered-button">
                                Gérer les Utilisateurs
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('logs.index') }}" class="btn btn-secondary w-100 py-3 centered-button">
                                Voir les Logs
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('cuves.index') }}" class="btn btn-info w-100 py-3 centered-button">
                                Voir les Cuves
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('proprietaires.index') }}" class="btn btn-warning w-100 py-3 centered-button">
                                Annuaire
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('cuves.etat') }}" class="btn btn-dark w-100 py-3 centered-button">
                                État des Cuves
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcanany

    <!-- Section Manager -->
    @can('manager-access')
        <div class="mb-5">
            <h2 class="text-warning text-center mb-3">Section Manager</h2>
            <div class="card shadow-sm border-warning">
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('cuves.index') }}" class="btn btn-warning w-100 py-3 centered-button">
                                Voir les Cuves
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('proprietaires.index') }}" class="btn btn-warning w-100 py-3 centered-button">
                                Annuaire
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('cuves.etat') }}" class="btn btn-dark w-100 py-3 centered-button">
                                État des Cuves
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan

    <!-- Section Cuviste -->
    @can('cuviste-access')
        <div>
            <h2 class="text-success text-center mb-3">Section Cuviste</h2>
            <div class="card shadow-sm border-success">
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('cuves.index') }}" class="btn btn-success w-100 py-3">
                                Voir les Cuves
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('proprietaires.index') }}" class="btn btn-success w-100 py-3">
                                Annuaire
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('cuves.etat') }}" class="btn btn-dark w-100 py-3 centered-button">
                                État des Cuves
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan
</div>
@endsection