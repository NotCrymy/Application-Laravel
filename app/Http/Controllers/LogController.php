<?php

namespace App\Http\Controllers;

use App\Models\Log;

class LogController extends Controller
{
    public function index()
    {
        $logs = Log::latest()->get(); // Liste tous les logs, les plus récents en premier
        return view('logs.index', compact('logs')); // Retourne une vue temporaire
    }
}