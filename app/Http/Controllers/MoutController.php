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
            'type' => 'required|string|max:255',
            'origine' => 'required|string|max:255',
            'volume' => 'required|numeric|min:0',
        ]);

        // Calcul du volume total après ajout
        $nouveauVolume = $cuve->mouts->sum('volume') + $validated['volume'];

        if ($nouveauVolume > $cuve->volume_max) {
            return redirect()->back()->with('error', 'Le volume total dépasserait la capacité maximale de la cuve.');
        }

        $mout = $cuve->mouts()->create($validated);

        \App\Helpers\LogHelper::logAction("Ajout d'un moût '{$mout->type}' ({$mout->volume} L) à la cuve '{$cuve->nom}'.");

        return redirect()->route('cuves.show', $cuve)->with('success', 'Moût ajouté avec succès.');
    }

    public function destroy(Cuve $cuve, Mout $mout)
    {
        if ($mout->cuve_id !== $cuve->id) {
            return redirect()->route('cuves.show', $cuve)->withErrors(['error' => 'Ce moût n\'appartient pas à cette cuve.']);
        }

        $mout->delete();

        \App\Helpers\LogHelper::logAction("Suppression d'un moût dans la cuve {$cuve->nom} : {$mout->type} ({$mout->volume} L).");

        return redirect()->route('cuves.show', $cuve)->with('success', 'Moût supprimé avec succès.');
    }

    public function edit(Cuve $cuve, Mout $mout)
    {
        return view('mouts.edit', compact('cuve', 'mout'));
    }

    public function update(Request $request, Cuve $cuve, Mout $mout)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'origine' => 'required|string|max:255',
            'volume' => 'required|numeric|min:0',
        ]);

        // Calcul du volume total après modification
        $nouveauVolume = $cuve->mouts->sum('volume') - $mout->volume + $validated['volume'];

        if ($nouveauVolume > $cuve->volume_max) {
            return redirect()->back()->with('error', 'Le volume total dépasserait la capacité maximale de la cuve.');
        }

        $oldMout = $mout->getOriginal();

        $mout->update($validated);

        \App\Helpers\LogHelper::logAction(
            "Modification du moût '{$oldMout['type']}' dans la cuve '{$cuve->nom}': "
            . "Ancien type = '{$oldMout['type']}', Nouveau type = '{$mout->type}', "
            . "Ancienne origine = '{$oldMout['origine']}', Nouvelle origine = '{$mout->origine}', "
            . "Ancien volume = '{$oldMout['volume']}', Nouveau volume = '{$mout->volume}'."
        );

        return redirect()->route('cuves.show', $cuve)->with('success', 'Moût modifié avec succès.');
    }
}