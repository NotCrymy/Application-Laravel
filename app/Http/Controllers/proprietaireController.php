<?php

namespace App\Http\Controllers;

use App\Models\Proprietaire;
use App\Http\Requests\StoreProprietaireRequest;
use App\Http\Requests\ProprietaireIndexRequest;

class ProprietaireController extends Controller
{
    // Affiche la liste paginée des propriétaires avec recherche
    public function index(ProprietaireIndexRequest $request)
    {
        $search = $request->input('search');

        \App\Helpers\LogHelper::logAction("Visualisation de l'annuaire .");

        // Requête pour filtrer les propriétaires
        $query = Proprietaire::query();

        if ($search) {
            $query->where('nom', 'LIKE', "%{$search}%")
                    ->orWhere('prenom', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
        }

        $proprietaires = $query->paginate(10);

        return view('proprietaires.index', compact('proprietaires', 'search'));
    }

    // Crée un nouveau propriétaire
    public function store(StoreProprietaireRequest $request)
    {
        $validated = $request->validated();

        $proprio = Proprietaire::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Propriétaire ajouté avec succès',
            'proprietaire' => $proprio,
        ]);
    }

    // Affiche les détails d'un propriétaire
    public function show(Proprietaire $proprietaire)
    {
        return view('proprietaires.show', compact('proprietaire'));
    }
}
