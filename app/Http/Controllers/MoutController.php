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
            'volume' => 'required|numeric|min:0',
            'origine' => 'required|string|max:255',
            'type' => 'required|string|max:255',
        ]);

        if (!$cuve->peutAccepterVolume($validated['volume'])) {
            return redirect()->back()->withErrors(['error' => 'Volume maximum de la cuve dépassé !']);
        }

        $cuve->mouts()->create($validated); // Crée un moût dans la cuve spécifiée

        return redirect()->route('cuves.index')->with('success', 'Moût ajouté à la cuve.');
    }

    public function destroy(Cuve $cuve, Mout $mout)
    {
        if ($mout->cuve_id !== $cuve->id) {
            return redirect()->route('cuves.show', $cuve)->withErrors(['error' => 'Ce moût n\'appartient pas à cette cuve.']);
        }

        $mout->delete();

        return redirect()->route('cuves.show', $cuve)->with('success', 'Moût supprimé avec succès.');
    }
}