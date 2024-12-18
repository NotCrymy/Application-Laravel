<?php

namespace App\Http\Controllers;

use App\Models\Cuve;
use App\Models\Mout;
use App\Models\Proprietaire;
use App\Http\Requests\StoreMoutRequest;
use App\Http\Requests\UpdateMoutRequest;

class MoutController extends Controller
{
    // Affiche le formulaire d'édition d'un moût pour une cuve
    public function edit($id)
    {
        $cuve = Cuve::findOrFail($id);
        $proprietaires = Proprietaire::all();
        return view('mouts.edit', compact('cuve', 'proprietaires'));
    }

    // Ajoute un moût à une cuve spécifique
    public function store(StoreMoutRequest $request, Cuve $cuve)
    {
        $validated = $request->validated();

        // Vérifie si le volume ne dépasse pas la capacité maximale de la cuve
        if ($cuve->volumeTotal() + $validated['volume'] > $cuve->volume_max) {
            return response()->json([
                'success' => false,
                'message' => 'Le volume dépasse la capacité de la cuve.'
            ], 422);
        }

        $mout = $cuve->mouts()->create($validated);

        \App\Helpers\LogHelper::logAction("Ajout du moût '{$mout->type}' ({$mout->volume} L) à la cuve '{$cuve->nom}'.");

        return response()->json([
            'success' => true,
            'message' => 'Moût ajouté avec succès.',
            'mout' => $mout
        ]);
    }

    // Met à jour un moût existant dans une cuve
    public function update(UpdateMoutRequest $request, Cuve $cuve, Mout $mout)
    {
        $validated = $request->validated();

        // Vérifier si le volume dépasse la capacité maximale de la cuve
        if (($cuve->volumeTotal() - $mout->volume + $validated['volume']) > $cuve->volume_max) {
            return back()->withErrors(['volume' => 'Le volume dépasse la capacité de la cuve.'])->withInput();
        }

        // Mettre à jour le moût
        $mout->update($validated);

        \App\Helpers\LogHelper::logAction("Modification du moût '{$mout->type}' dans la cuve '{$cuve->nom}': Nouveau volume = {$mout->volume} L.");

        return back()->with('success', 'Moût mis à jour avec succès.');
    }

    // Supprime un moût de la cuve
    public function destroy(Cuve $cuve, Mout $mout)
    {
        $moutType = $mout->type;
        $moutVolume = $mout->volume;

        $mout->delete();

        \App\Helpers\LogHelper::logAction("Suppression du moût '{$moutType}' ({$moutVolume} L) de la cuve '{$cuve->nom}'.");

        return back()->with('success', 'Moût supprimé avec succès.');
    }
}