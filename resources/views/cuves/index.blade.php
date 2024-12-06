<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des cuves</title>
</head>
<body>
    <h1>Liste des cuves</h1>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Volume maximum</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cuves as $cuve)
                <tr>
                    <td>{{ $cuve->id }}</td>
                    <td>{{ $cuve->nom }}</td>
                    <td>{{ $cuve->volume_max }}</td>
                    <td>
                        <form action="{{ route('cuves.mouts.store', $cuve->id) }}" method="POST">
                            @csrf
                            <label for="volume">Volume :</label>
                            <input type="number" name="volume" required>
                            <label for="origine">Origine :</label>
                            <input type="text" name="origine" required>
                            <label for="type">Type :</label>
                            <input type="text" name="type" required>
                            <button type="submit">Ajouter un moût</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>