<?php

namespace App\Http\Controllers;

use App\Models\Proprietaire;
use Illuminate\Http\Request;

class ProprietaireController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'numtel' => 'nullable|string',
            'email' => 'required|email|unique:proprietaires,email',
        ]);

        Proprietaire::create($validated);

        return back()->with('success', 'Propriétaire ajouté avec succès.');
    }

    public function show(Proprietaire $proprietaire)
    {
        return view('proprietaires.show', compact('proprietaire'));
    }
}
