<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CuveController;
use App\Http\Controllers\MoutController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\Auth\LoginController;

// Route racine : redirection vers login si non connecté
Route::get('/', function () {
    return redirect()->route('login');
})->name('root');

// Routes pour l'authentification
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Routes protégées par l'authentification
Route::middleware('auth')->group(function () {

    // Route unique pour le Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Routes pour les cuves
    Route::get('/cuves', [CuveController::class, 'index'])->name('cuves.index'); // Voir toutes les cuves
    Route::get('/cuves/{cuve}', [CuveController::class, 'show'])->name('cuves.show'); // Détails d'une cuve (moûts inclus)
    Route::get('/cuves/{cuve}/edit', [CuveController::class, 'edit'])->name('cuves.edit'); // Modifier une cuve et gérer les moûts
    Route::put('/cuves/{cuve}', [CuveController::class, 'update'])->name('cuves.update'); // Mise à jour de la cuve
    Route::delete('/cuves/{cuve}', [CuveController::class, 'destroy'])->name('cuves.destroy'); // Supprimer une cuve

    // Actions sur les moûts dans le contexte des cuves
    Route::post('/cuves/{cuve}/mouts', [MoutController::class, 'store'])->name('cuves.mouts.store'); // Ajouter un moût
    Route::put('/cuves/{cuve}/mouts/{mout}', [MoutController::class, 'update'])->name('cuves.mouts.update'); // Mettre à jour un moût
    Route::delete('/cuves/{cuve}/mouts/{mout}', [MoutController::class, 'destroy'])->name('cuves.mouts.destroy'); // Supprimer un moût


    // Routes pour les utilisateurs (admin uniquement)
    Route::middleware(['can:admin-access'])->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index'); // Voir les utilisateurs
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit'); // Éditer un utilisateur
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update'); // Mettre à jour un utilisateur
        Route::post('/users', [UserController::class, 'store'])->name('users.store'); // Créer un utilisateur
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy'); // Supprimer un utilisateur
    });

    // Routes pour les logs (admin uniquement)
    Route::middleware('can:admin-access')->get('/logs', [LogController::class, 'index'])->name('logs.index');
});