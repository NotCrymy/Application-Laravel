<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BreakingWine')</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" sizes="32x32" href="{{ asset('favicon.ico') }}">
    <!-- Ajout du JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite('resources/js/app.js')
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
                @if(!Route::is('login')) <!-- Ne pas afficher les boutons si la route est 'login' -->
                    <ul class="navbar-nav ms-auto align-items-center">
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
                @endif
            </div>
        </div>
    </nav>
    <main class="container py-4">
        <!-- Fil d'Ariane stylisé -->
        @isset($breadcrumbs)
            <nav class="breadcrumb-container bg-light p-3 rounded mb-4 shadow-sm">
                <ol class="breadcrumb mb-0">
                    @foreach($breadcrumbs as $breadcrumb)
                        <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
                            @if(!$loop->last)
                                <a href="{{ $breadcrumb['url'] }}" class="text-decoration-none">{{ $breadcrumb['name'] }}</a>
                            @else
                                {{ $breadcrumb['name'] }}
                            @endif
                        </li>
                    @endforeach
                </ol>
            </nav>
        @endisset

        <!-- affiche les messages d'erreurs -->
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

        @yield('content')
    </main>
</body>
</html>
