<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mon Application')</title>
    <!-- Ajoutez ici vos fichiers CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        @auth
            <nav>
                <a href="{{ route('dashboard') }}">Dashboard</a>
                @can('admin-access')
                    <a href="{{ route('users.index') }}">Utilisateurs</a>
                    <a href="{{ route('logs.index') }}">Logs</a>
                @endcan
                @can('caviste-access')
                    <a href="{{ route('cuves.index') }}">Cuves</a>
                @endcan
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">Déconnexion</button>
                </form>
            </nav>
        @endauth
    </header>
    <main>
        @yield('content')
    </main>
    <!-- Ajoutez ici vos fichiers JS -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>