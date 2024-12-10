<?php

namespace App\Http\Controllers;

use App\Models\Cuve;
use Illuminate\Http\Request;

class CuveController extends Controller
{
    public function index(Request $request)
    {
        $query = Cuve::query();

        // Recherche par ID ou nom
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('id', $search)
                ->orWhere('nom', 'LIKE', "%$search%");
        }

        // Applique la pagination (10 cuves par page)
        $cuves = $query->paginate(10);

        return view('cuves.index', compact('cuves'));
    }

    public function edit(Cuve $cuve)
    {
        return view('cuves.edit', compact('cuve'));
    }

    public function update(Request $request, Cuve $cuve)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        $oldNom = $cuve->nom;

        $cuve->update(['nom' => $validated['nom']]);

        \App\Helpers\LogHelper::logAction("Modification de la cuve '{$oldNom}' : Nouveau nom = '{$cuve->nom}'.");

        return redirect()->route('cuves.index')->with('success', 'Cuve mise à jour avec succès.');
    }

    public function destroy(Cuve $cuve)
    {
        $nom = $cuve->nom;

        $cuve->delete();

        \App\Helpers\LogHelper::logAction("Suppression de la cuve '{$nom}'.");

        return redirect()->route('cuves.index')->with('success', 'Cuve supprimée avec succès.');
    }

    public function show(Cuve $cuve)
    {
        // Charger les moûts associés à la cuve
        $cuve->load('mouts');

        return view('cuves.show', compact('cuve'));
    }
}