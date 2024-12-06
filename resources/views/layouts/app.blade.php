<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gestion de la cuverie')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                @role('admin')
                    <li><a href="{{ route('cuves.index') }}">Gestion des Cuves</a></li>
                    <li><a href="{{ route('logs.index') }}">Logs</a></li>
                @endrole
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit">Déconnexion</button>
                    </form>
                </li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>@yield('header', 'Bienvenue')</h1>
        @yield('content')
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} Gestion de la Cuverie</p>
    </footer>
</body>
</html>