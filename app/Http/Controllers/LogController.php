<?php

namespace App\Http\Controllers;

use App\Models\Log;

class LogController extends Controller
{
    // Affiche la liste paginée des logs avec leurs utilisateurs associés
    public function index()
    {
        $logs = Log::with('user')->latest()->paginate(10); // Récupère les logs avec pagination
        return view('logs.index', compact('logs'));
    }
}