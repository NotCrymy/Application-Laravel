@extends('layouts.app')

@section('title', 'Historique des Logs')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">Historique des Logs</h1>

    @if($logs->count())
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Utilisateur</th>
                    <th>Action</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                    <tr>
                        <td>{{ $log->id }}</td>
                        <td>{{ $log->user->name ?? 'Utilisateur Supprimé' }}</td>
                        <td>{{ $log->action }}</td>
                        <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Conteneur pour la pagination -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <!-- Texte de la pagination -->
            <div class="text-muted">
                {{ __('Showing') }} {{ $logs->firstItem() }} {{ __('to') }} {{ $logs->lastItem() }} {{ __('of') }} {{ $logs->total() }} {{ __('results') }}
            </div>

            <!-- Boutons de la pagination -->
            <div>
                {{ $logs->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @else
        <div class="alert alert-info text-center">
            Aucun log à afficher pour le moment.
        </div>
    @endif
</div>
@endsection