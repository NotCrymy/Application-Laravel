<?php

namespace App\Http\Controllers;

use App\Models\Cuve;
use Illuminate\Http\Request;

class CuveController extends Controller
{
    public function index()
    {
        $cuves = Cuve::all(); // Liste toutes les cuves
        return view('cuves.index', compact('cuves')); // Retourne une vue temporaire
    }
}
