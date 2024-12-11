<?php

namespace App\Http\Controllers;

use App\Models\Cuve;
use App\Models\Mout;
use App\Models\Proprietaire;
use Illuminate\Http\Request;

class MoutController extends Controller
{
    public function edit(Cuve $cuve)
    {
        $proprietaires = Proprietaire::all();
        return view('mouts.edit', compact('cuve', 'proprietaires'));
    }

    public function store(Request $request, Cuve $cuve)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'origine' => 'required|string|max:255',
            'volume' => 'required|numeric|min:0',
            'proprietaire_id' => 'required|exists:proprietaires,id',
        ]);

        if ($cuve->volumeTotal() + $validated['volume'] > $cuve->volume_max) {
            return back()->withErrors(['volume' => 'Le volume dépasse la capacité de la cuve.']);
        }

        $mout = $cuve->mouts()->create($validated);

        \App\Helpers\LogHelper::logAction("Ajout du moût '{$mout->type}' ({$mout->volume} L) à la cuve '{$cuve->nom}'.");

        return back()->with('success', 'Moût ajouté avec succès.');
    }

    public function update(Request $request, Cuve $cuve, Mout $mout)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'origine' => 'required|string|max:255',
            'volume' => 'required|numeric|min:0',
            'proprietaire_id' => 'required|exists:proprietaires,id',
        ]);

        if (($cuve->volumeTotal() - $mout->volume + $validated['volume']) > $cuve->volume_max) {
            return back()->withErrors(['volume' => 'Le volume dépasse la capacité de la cuve.']);
        }

        $mout->update($validated);

        \App\Helpers\LogHelper::logAction("Modification du moût '{$mout->type}' dans la cuve '{$cuve->nom}': Nouveau volume = {$mout->volume} L, Nouvelle origine = {$mout->origine}.");

        return back()->with('success', 'Moût mis à jour avec succès.');
    }

    public function destroy(Cuve $cuve, Mout $mout)
    {
        $moutType = $mout->type;
        $moutVolume = $mout->volume;

        $mout->delete();

        \App\Helpers\LogHelper::logAction("Suppression du moût '{$moutType}' ({$moutVolume} L) de la cuve '{$cuve->nom}'.");

        return back()->with('success', 'Moût supprimé avec succès.');
    }
}