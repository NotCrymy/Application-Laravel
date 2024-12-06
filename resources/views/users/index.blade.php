<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des utilisateurs</title>
</head>
<body>
    <h1>Liste des utilisateurs</h1>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Ajouter un utilisateur</h2>
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <label for="name">Nom :</label>
        <input type="text" name="name" required>
        <label for="email">Email :</label>
        <input type="email" name="email" required>
        <label for="password">Mot de passe :</label>
        <input type="password" name="password" required>
        <button type="submit">Ajouter</button>
    </form>
</body>
</html>