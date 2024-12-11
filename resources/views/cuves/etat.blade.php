@extends('layouts.app')

@section('title', 'État des Cuves')

@section('content')
<div class="container">
    <h1 class="my-4 text-center">État des Cuves</h1>

    <!-- On stocke les données JSON dans des éléments cachés -->
    <div id="data-container" class="d-none">
        <div id="types-data">{{ json_encode($types) }}</div>
        <div id="volumes-data">{{ json_encode($volumes) }}</div>
        <div id="cuves-names-data">{{ json_encode($cuvesNames) }}</div>
        <div id="cuves-fill-data">{{ json_encode($cuvesFillRates) }}</div>
    </div>

    <div class="row mb-5">
        <div class="col-12">
            <h2 class="text-center mb-3">Volume total par Type de Moût</h2>
            <canvas id="moutsChart"></canvas>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-12">
            <h2 class="text-center mb-3">Taux de Remplissage des Cuves</h2>
            <canvas id="cuvesChart"></canvas>
        </div>
    </div>
</div>
@endsection