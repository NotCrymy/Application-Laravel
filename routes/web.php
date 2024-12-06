<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CuveController;
use App\Http\Controllers\MoutController;
use App\Http\Controllers\LogController;

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

Route::get('/cuves', [CuveController::class, 'index'])->name('cuves.index');
Route::post('/cuves/{cuve}/mouts', [MoutController::class, 'store'])->name('cuves.mouts.store');

Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
