<?php

namespace App\Http\Controllers;

use App\Models\Vehicule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VehiculeController extends Controller
{
    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        // Vérifier si l'utilisateur a déjà un véhicule (section 4 du TP)
        if (Auth::user()->vehicule) {
            return redirect()->route('vehicule.edit')
                ->with('info', 'Vous avez déjà un véhicule enregistré. Vous pouvez seulement le modifier.');
        }
        
        return view('vehicule.create');
    }

    /**
     * Enregistre un nouveau véhicule
     */
    public function store(Request $request)
    {
        // Vérifier que l'utilisateur n'a pas déjà un véhicule
        if (Auth::user()->vehicule) {
            return redirect()->route('vehicule.edit')
                ->with('error', 'Vous ne pouvez avoir qu\'un seul véhicule (section 4 du TP).');
        }
        
        // Utiliser les règles du modèle (plus maintenable)
        $validated = $request->validate(Vehicule::rules(), Vehicule::messages());
        
        // Vérifier que la photo est obligatoire (section 4 du TP)
        if (!$request->hasFile('photo')) {
            return back()->withErrors(['photo' => 'La photo du véhicule est obligatoire.'])->withInput();
        }
        
        // Upload de la photo
        if ($request->hasFile('photo')) {
            // Générer un nom de fichier sécurisé
            $filename = time() . '_' . uniqid() . '.' . $request->file('photo')->extension();
            $path = $request->file('photo')->storeAs('vehicules', $filename, 'public');
            $validated['photo'] = $path;
        }
        
        // Créer le véhicule associé à l'utilisateur
        Auth::user()->vehicule()->create($validated);
        
        // Redirection vers le tableau de bord au lieu de trajets.create
        return redirect()->route('dashboard')
            ->with('success', 'Véhicule enregistré avec succès ! Vous pouvez maintenant proposer des trajets.');
    }

    /**
     * Affiche les détails du véhicule (pour conducteurs)
     */
    public function show()
    {
        $vehicule = Auth::user()->vehicule;
        
        if (!$vehicule) {
            return redirect()->route('vehicule.create')
                ->with('error', 'Vous n\'avez pas encore de véhicule enregistré.');
        }
        
        return view('vehicule.show', compact('vehicule'));
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit()
    {
        $vehicule = Auth::user()->vehicule;
        
        if (!$vehicule) {
            return redirect()->route('vehicule.create')
                ->with('error', 'Vous n\'avez pas encore de véhicule enregistré.');
        }
        
        return view('vehicule.edit', compact('vehicule'));
    }

    /**
     * Met à jour le véhicule
     */
    public function update(Request $request)
    {
        $vehicule = Auth::user()->vehicule;
        
        if (!$vehicule) {
            return redirect()->route('vehicule.create')
                ->with('error', 'Vous n\'avez pas encore de véhicule.');
        }
        
        // Règles de validation avec exclusion de l'ID actuel
        $validated = $request->validate([
            'plaque' => 'required|string|max:20|unique:vehicules,plaque,' . $vehicule->id,
            'description' => 'required|string|min:20|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], Vehicule::messages());
        
        // Gérer la nouvelle photo
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe
            if ($vehicule->photo && Storage::disk('public')->exists($vehicule->photo)) {
                Storage::disk('public')->delete($vehicule->photo);
            }
            
            // Upload la nouvelle photo
            $filename = time() . '_' . uniqid() . '.' . $request->file('photo')->extension();
            $path = $request->file('photo')->storeAs('vehicules', $filename, 'public');
            $validated['photo'] = $path;
        } else {
            // Garder l'ancienne photo si pas de nouvelle
            unset($validated['photo']);
        }
        
        $vehicule->update($validated);
        
        return redirect()->route('vehicule.show')
            ->with('success', 'Véhicule mis à jour avec succès !');
    }

    /**
     * Supprime le véhicule
     * Note: Selon le TP, normalement on ne supprime pas le véhicule
     * car il est requis pour les trajets existants
     */
    public function destroy()
    {
        $vehicule = Auth::user()->vehicule;
        
        if (!$vehicule) {
            return redirect()->route('vehicule.create')
                ->with('error', 'Vous n\'avez pas de véhicule à supprimer.');
        }
        
        // Vérifier si l'utilisateur a des trajets à venir
        $hasTrajetsFuturs = $vehicule->user->trajets()
            ->where('date_trajet', '>=', now())
            ->exists();
            
        if ($hasTrajetsFuturs) {
            return back()->with('error',
                'Vous ne pouvez pas supprimer votre véhicule car vous avez des trajets à venir. '
                . 'Supprimez d\'abord vos trajets futurs.');
        }
        
        // Supprimer la photo du stockage
        if ($vehicule->photo && Storage::disk('public')->exists($vehicule->photo)) {
            Storage::disk('public')->delete($vehicule->photo);
        }
        
        // Supprimer le véhicule
        $vehicule->delete();
        
        return redirect()->route('dashboard')
            ->with('success', 'Véhicule supprimé avec succès.');
    }
}