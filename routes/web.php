<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CuveController;
use App\Http\Controllers\MoutController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;

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

    // Dashboard pour les administrateurs
    Route::get('/dashboard/admin', function () {
        return view(view: 'dashboard.admin');
    })->middleware('can:admin-access')->name('dashboard.admin');

    // Dashboard pour les managers
    Route::get('/dashboard/manager', function () {
        return view(view: 'dashboard.manager');
    })->middleware('can:manager-access')->name('dashboard.manager');

    // Dashboard pour les cavistes
    Route::get('/dashboard/caviste', function () {
        return view(view: 'dashboard.caviste');
    })->middleware('can:caviste-access')->name('dashboard.caviste');

    // Routes pour les administrateurs uniquement
    Route::middleware('can:admin-access')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

        Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
    });

    // Routes pour les cavistes et administrateurs (accès aux cuves)
    Route::middleware('can:caviste-access')->group(function () {
        Route::get('/cuves', [CuveController::class, 'index'])->name('cuves.index');
        Route::post('/cuves/{cuve}/mouts', [MoutController::class, 'store'])->name('cuves.mouts.store');
    });
});