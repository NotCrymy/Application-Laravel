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

        if ($cuve->volumeTotal() + $validated['volume'] > $cuve->volume_max) {
            return back()->withErrors(['volume' => 'Le volume dépasse la capacité de la cuve.']);
        }

        $cuve->mouts()->create($validated);

        return back()->with('success', 'Moût ajouté avec succès.');
    }

    public function update(Request $request, Cuve $cuve, Mout $mout)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'origine' => 'required|string|max:255',
            'volume' => 'required|numeric|min:0',
        ]);

        if (($cuve->volumeTotal() - $mout->volume + $validated['volume']) > $cuve->volume_max) {
            return back()->withErrors(['volume' => 'Le volume dépasse la capacité de la cuve.']);
        }

        $mout->update($validated);

        return back()->with('success', 'Moût mis à jour avec succès.');
    }

    public function destroy(Cuve $cuve, Mout $mout)
    {
        $mout->delete();
        return back()->with('success', 'Moût supprimé avec succès.');
    }
}