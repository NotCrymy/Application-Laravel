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
        return view('cuves.show', compact('cuve'));
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

        $cuve->update($validated);

        return redirect()->route('cuves.index')->with('success', 'Cuve mise à jour avec succès.');
    }

    public function destroy(Cuve $cuve)
    {
        $cuve->delete();
        return redirect()->route('cuves.index')->with('success', 'Cuve supprimée avec succès.');
    }
}