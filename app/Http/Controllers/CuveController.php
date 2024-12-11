<?php

namespace App\Http\Controllers;

use App\Models\Cuve;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CuveController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $search = $request->input('search');

        // Requete à la base donnée
        $query = Cuve::withTrashed();

        // Si une recherche est effectuée
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nom', 'LIKE', '%' . $search . '%')
                    ->orWhere('id', 'LIKE', '%' . $search . '%');
            });
        }

        $cuves = $query->paginate(10);

        return view('cuves.index', compact('cuves', 'search'));
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
        $cuve->delete(); // Soft delete

        \App\Helpers\LogHelper::logAction("Cuve '{$cuve->nom}' soft deleted.");

        return redirect()->route('cuves.index')->with('success', 'Cuve supprimée avec succès (soft delete).');
    }

    public function restore($id)
    {
        $cuve = Cuve::withTrashed()->findOrFail($id);
        $cuve->restore();
        \App\Helpers\LogHelper::logAction("Cuve '{$cuve->nom}' restored.");
        return redirect()->route('cuves.index')->with('success', 'Cuve restaurée avec succès.');
    }

    public function forceDelete($id)
    {
        $cuve = Cuve::withTrashed()->findOrFail($id);
        $cuve->forceDelete();
        \App\Helpers\LogHelper::logAction("Cuve '{$cuve->nom}' permanently deleted.");
        return redirect()->route('cuves.index')->with('success', 'Cuve supprimée définitivement.');
    }
}