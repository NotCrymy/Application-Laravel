<?php

namespace App\Http\Controllers;

use App\Models\Cuve;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateCuveRequest;
use App\Models\Mout;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CuveController extends Controller
{
    use AuthorizesRequests;

    // Affiche la liste des cuves avec option de recherche
    public function index(Request $request)
    {
        $search = $request->input('search');

        \App\Helpers\LogHelper::logAction("Visualisation des cuves .");

        // Requête pour inclure les soft deletes
        $query = Cuve::withTrashed();

        // Filtrer par recherche si un terme est fourni
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nom', 'LIKE', "%{$search}%")
                    ->orWhere('id', 'LIKE', "%{$search}%");
            });
        }

        $cuves = $query->paginate(10);

        return view('cuves.index', compact('cuves', 'search'));
    }

    // Affiche les détails d'une cuve
    public function show(Cuve $cuve)
    {
        \App\Helpers\LogHelper::logAction("Consultation des détails de la cuve '{$cuve->nom}'.");
        return view('cuves.show', compact('cuve'));
    }

    // Retourne le formulaire d'édition d'une cuve
    public function edit(Cuve $cuve)
    {
        $proprietaires = Mout::all();
        \App\Helpers\LogHelper::logAction("Accès à l'édition de la cuve '{$cuve->nom}'.");
        return view('cuves.edit', compact('cuve', 'proprietaires'));
    }

    // Met à jour les informations d'une cuve
    public function update(UpdateCuveRequest $request, Cuve $cuve)
    {
        $validated = $request->validated();

        $oldName = $cuve->nom;

        $cuve->update($validated);

        \App\Helpers\LogHelper::logAction("Mise à jour de la cuve '{$oldName}' : Nouveau nom = '{$cuve->nom}'.");

        return redirect()->route('cuves.edit', ['cuve' => $cuve->id])->with('success', 'Cuve mise à jour avec succès.');
    }

    // Effectue un soft delete sur une cuve
    public function destroy(Cuve $cuve)
    {
        $cuve->delete();
        \App\Helpers\LogHelper::logAction("Cuve '{$cuve->nom}' soft deleted.");
        return redirect()->route('cuves.index')->with('success', 'Cuve supprimée avec succès (soft delete).');
    }

    // Restaure une cuve supprimée
    public function restore($id)
    {
        $cuve = Cuve::withTrashed()->findOrFail($id);
        $cuve->restore();
        \App\Helpers\LogHelper::logAction("Cuve '{$cuve->nom}' restored.");
        return redirect()->route('cuves.index')->with('success', 'Cuve restaurée avec succès.');
    }

    // Supprime définitivement une cuve
    public function forceDelete($id)
    {
        $cuve = Cuve::withTrashed()->findOrFail($id);
        $cuve->forceDelete();
        \App\Helpers\LogHelper::logAction("Cuve '{$cuve->nom}' permanently deleted.");
        return redirect()->route('cuves.index')->with('success', 'Cuve supprimée définitivement.');
    }

    // Affiche l'état des cuves et les statistiques des moûts
    public function etat()
    {
        // Récupère toutes les cuves avec leurs moûts
        $cuves = Cuve::with('mouts')->get();

        // Calcule le volume total par type de moût
        $moutsByType = \App\Models\Mout::select('type', \Illuminate\Support\Facades\DB::raw('SUM(volume) as total_volume'))
                                        ->groupBy('type')
                                        ->get();

        // Prépare les données pour le graphique des moûts par type
        $types = $moutsByType->pluck('type');
        $volumes = $moutsByType->pluck('total_volume');

        // Calcule le taux de remplissage de chaque cuve
        $cuvesData = $cuves->map(function($cuve) {
            return [
                'nom' => $cuve->nom,
                'taux_remplissage' => $cuve->volume_max > 0 
                    ? ($cuve->volumeTotal() / $cuve->volume_max) * 100 
                    : 0,
            ];
        });

        $cuvesNames = $cuvesData->pluck('nom');
        $cuvesFillRates = $cuvesData->pluck('taux_remplissage');

        return view('cuves.etat', compact('types', 'volumes', 'cuvesNames', 'cuvesFillRates'));
    }
}