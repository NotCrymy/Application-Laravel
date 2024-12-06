<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logs</title>
</head>
<body>
    <h1>Historique des actions</h1>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Utilisateur</th>
                <th>Action</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $log)
                <tr>
                    <td>{{ $log->id }}</td>
                    <td>{{ $log->user->name ?? 'Utilisateur supprimé' }}</td>
                    <td>{{ $log->action }}</td>
                    <td>{{ $log->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>