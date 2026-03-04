<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trajet;
use Illuminate\Support\Facades\Auth;

class TrajetController extends Controller
{
    /**
     * Liste publique des trajets
     */
    public function index()
    {
        $trajets = Trajet::with(['user', 'user.vehicule'])
            ->where('date_trajet', '>=', now())
            ->orderBy('date_trajet')
            ->paginate(10);
        
        return view('trajets.index', compact('trajets'));
    }

    /**
     * Affiche les trajets de l'utilisateur connecté
     */
    public function mesTrajets()
    {
        $trajets = Auth::user()->trajets()
            ->orderBy('date_trajet', 'desc')
            ->paginate(10);
            
        return view('mes-trajets', compact('trajets'));
    }

    /**
     * Formulaire création
     */
    public function create()
    {
        if (!Auth::user()->vehicule) {
            return redirect()->route('vehicule.create')
                ->with('error', 'Vous devez enregistrer un véhicule avant de créer un trajet');
        }

        return view('trajets.create');
    }

    /**
     * Enregistrement
     */
    public function store(Request $request)
    {
        if (!$request->user()->vehicule) {
            return redirect()->route('vehicule.create')
                ->with('error', 'Vous devez enregistrer un véhicule avant de créer un trajet');
        }

        $validated = $request->validate([
            'ville_depart' => 'required|string|max:100',
            'lieu_depart' => 'required|string|max:255',
            'ville_arrivee' => 'required|string|max:100',
            'lieu_arrivee' => 'required|string|max:255',
            'date_trajet' => 'required|date|after:now',
            'places_disponibles' => 'required|integer|min:1|max:10',
        ]);

        $request->user()->trajets()->create($validated);

        return redirect()->route('trajets.index')->with('success', 'Trajet créé avec succès !');
    }

    /**
     * Détail public
     */
    public function show(Trajet $trajet)
    {
        $trajet->load(['user', 'user.vehicule']);
        return view('trajets.show', compact('trajet'));
    }

    /**
     * Edition
     */
    public function edit(Trajet $trajet)
    {
        if (Auth::id() !== $trajet->user_id) {
            abort(403);
        }

        return view('trajets.edit', compact('trajet'));
    }

    /**
     * Mise à jour
     */
    public function update(Request $request, Trajet $trajet)
    {
        if (Auth::id() !== $trajet->user_id) {
            abort(403);
        }

        $validated = $request->validate([
            'ville_depart' => 'required|string|max:100',
            'lieu_depart' => 'required|string|max:255',
            'ville_arrivee' => 'required|string|max:100',
            'lieu_arrivee' => 'required|string|max:255',
            'date_trajet' => 'required|date|after:now',
            'places_disponibles' => 'required|integer|min:1|max:10',
        ]);

        $trajet->update($validated);

        return redirect()->route('trajets.mes')->with('success', 'Trajet modifié avec succès !');
    }

    /**
     * Suppression
     */
    public function destroy(Trajet $trajet)
    {
        if (Auth::id() !== $trajet->user_id) {
            abort(403);
        }

        $trajet->delete();

        return redirect()->route('trajets.mes')->with('success', 'Trajet supprimé !');
    }
}