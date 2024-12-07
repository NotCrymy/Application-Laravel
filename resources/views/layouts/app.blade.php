<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BreakingWine')</title>
    
    <!-- Ajout du CSS compilé avec SCSS -->
    @vite('resources/sass/app.scss')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand fw-bold text-warning" href="{{ route('dashboard') }}">
                BreakingWine
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <!-- Bouton retour au dashboard -->
                    <li class="nav-item me-2">
                        <a class="btn btn-primary px-4" href="{{ route('dashboard') }}">
                            <i class="fas fa-home me-1"></i> Retour au Dashboard
                        </a>
                    </li>
                    <!-- Bouton logout -->
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button class="btn btn-danger px-4" type="submit">
                                <i class="fas fa-sign-out-alt me-1"></i> Déconnexion
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="container py-4">
        @yield('content')
    </main>
    <!-- Ajout du JS compilé -->
    @vite('resources/js/app.js')
</body>
</html>
