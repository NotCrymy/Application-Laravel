<?php

namespace App\Http\Controllers;

use App\Models\Cuve;
use App\Models\Mout;
use Illuminate\Http\Request;

class MoutController extends Controller
{
    public function store(Request $request, Cuve $cuve)
    {
        $validated = $request->validate([
            'volume' => 'required|numeric',
            'origine' => 'required|string|max:255',
            'type' => 'required|string|max:255',
        ]);

        $cuve->mouts()->create($validated); // Crée un moût dans la cuve spécifiée

        return redirect()->route('cuves.index')->with('success', 'Moût ajouté à la cuve.');
    }
}