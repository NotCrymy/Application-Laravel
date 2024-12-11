<?php

namespace App\Http\Controllers;

use App\Models\Proprietaire;
use Illuminate\Http\Request;

class ProprietaireController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Proprietaire::query();

        if ($search) {
            $query->where('nom', 'LIKE', "%{$search}%")
                    ->orWhere('prenom', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
        }

        $proprietaires = $query->paginate(10);

        return view('proprietaires.index', compact('proprietaires', 'search'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email|unique:proprietaires,email',
            'numtel' => 'nullable|string',
        ]);

        $proprio = Proprietaire::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Propriétaire ajouté avec succès',
            'proprietaire' => $proprio,
        ]);
    }


    public function show(Proprietaire $proprietaire)
    {
        return view('proprietaires.show', compact('proprietaire'));
    }
}
