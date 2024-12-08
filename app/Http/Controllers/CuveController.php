<?php

namespace App\Http\Controllers;

use App\Models\Cuve;
use App\Models\Mout;
use Illuminate\Http\Request;

class CuveController extends Controller
{
    public function index()
    {
        $cuves = Cuve::all(); // Liste toutes les cuves
        return view('cuves.index', compact('cuves')); // Retourne une vue temporaire
    }

    public function edit(Cuve $cuve)
    {
        return view('cuves.edit', compact('cuve'));
    }

    public function update(Request $request, Cuve $cuve)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'volume_max' => 'required|numeric|min:0',
        ]);

        $oldNom = $cuve->nom;
        $oldVolumeMax = $cuve->volume_max;

        $cuve->update($validated);

        \App\Helpers\LogHelper::logAction("Modification de la cuve '{$oldNom}' : Nouveau nom = '{$cuve->nom}', Ancien volume max = '{$oldVolumeMax}', Nouveau volume max = '{$cuve->volume_max}'.");

        return redirect()->route('cuves.index')->with('success', 'Cuve mise à jour avec succès.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'volume_max' => 'required|numeric|min:0',
        ]);

        $cuve = Cuve::create($validated);

        \App\Helpers\LogHelper::logAction("Création de la cuve '{$cuve->nom}' avec un volume maximum de {$cuve->volume_max} L.");

        return redirect()->route('cuves.index')->with('success', 'Cuve créée avec succès.');
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
        $cuve->load('mouts'); // Charge les moûts associés à la cuve
        return view('cuves.show', compact('cuve'));
    }
}
