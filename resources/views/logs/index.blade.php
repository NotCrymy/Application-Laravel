@extends('layouts.app')

@section('title', 'Logs')

@section('content')
<div class="container">
    <h1>Logs</h1>
    <table class="table table-striped">
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
                    <td>{{ $log->user->name ?? 'Utilisateur supprimé' }}</td>
                    <td>{{ $log->action }}</td>
                    <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $logs->links() }}
    </div>
</div>
@endsection