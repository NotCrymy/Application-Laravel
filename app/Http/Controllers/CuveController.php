<?php

namespace App\Http\Controllers;

use App\Models\Cuve;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CuveController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $cuves = Cuve::with('mouts')->paginate(10);
        return view('cuves.index', compact('cuves'));
    }

    public function show(Cuve $cuve)
    {
        // Ajout d'un log pour l'accès aux détails de la cuve
        \App\Helpers\LogHelper::logAction("Consultation des détails de la cuve '{$cuve->nom}'.");

        return view('cuves.show', compact('cuve'));
    }

    public function edit(Cuve $cuve)
    {
        // Ajout d'un log pour l'accès à l'édition de la cuve
        \App\Helpers\LogHelper::logAction("Accès à l'édition de la cuve '{$cuve->nom}'.");

        return view('cuves.edit', compact('cuve'));
    }

    public function update(Request $request, Cuve $cuve)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        $oldName = $cuve->nom;

        $cuve->update($validated);

        // Ajout d'un log pour la mise à jour de la cuve
        \App\Helpers\LogHelper::logAction("Mise à jour de la cuve '{$oldName}' : Nouveau nom = '{$cuve->nom}'.");

        return redirect()->route('cuves.edit', ['cuve' => $cuve->id])->with('success', 'Cuve mise à jour avec succès.');
    }

    public function destroy(Cuve $cuve)
    {
        $cuveName = $cuve->nom;

        $cuve->delete();

        // Ajout d'un log pour la suppression de la cuve
        \App\Helpers\LogHelper::logAction("Suppression de la cuve '{$cuveName}'.");

        return redirect()->route('cuves.index')->with('success', 'Cuve supprimée avec succès.');
    }
}