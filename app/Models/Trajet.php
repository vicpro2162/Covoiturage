<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trajet extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',              // ID du conducteur
        'ville_depart',         // CORRIGE TON ERREUR - ajouté ici
        'lieu_depart',          // Description précise du lieu de départ
        'ville_arrivee',        // Ville d'arrivée
        'lieu_arrivee',         // Description précise du lieu d'arrivée
        'date_trajet',          // Date et heure du trajet
        'places_disponibles',   // Nombre de places disponibles
    ];

    /**
     * Les attributs qui doivent être convertis en types natifs.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_trajet' => 'datetime',
        'places_disponibles' => 'integer',
    ];

    /**
     * Relation: Un trajet appartient à un utilisateur (conducteur).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation: Un trajet a un véhicule (via l'utilisateur).
     * Comme spécifié dans le TP, le véhicule est lié à l'utilisateur.
     */
    public function vehicule()
    {
        return $this->hasOneThrough(
            Vehicule::class,
            User::class,
            'id',           // Clé sur la table users
            'user_id',      // Clé sur la table vehicules
            'user_id',      // Clé sur la table trajets
            'id'            // Clé sur la table users
        );
    }

    /**
     * Accessor pour obtenir le conducteur du trajet.
     */
    public function getConducteurAttribute()
    {
        return $this->user;
    }

    /**
     * Accessor pour obtenir le véhicule du conducteur.
     */
    public function getVehiculeAttribute()
    {
        return $this->user->vehicule ?? null;
    }

    /**
     * Vérifie si l'utilisateur connecté est le propriétaire du trajet.
     * Important pour la sécurité (section 6 du TP).
     */
    public function isProprietaire()
    {
        return $this->user_id === auth()->id();
    }

    /**
     * Vérifie s'il reste des places disponibles.
     */
    public function hasPlacesDisponibles()
    {
        return $this->places_disponibles > 0;
    }

    /**
     * Scope pour récupérer seulement les trajets futurs.
     */
    public function scopeFuturs($query)
    {
        return $query->where('date_trajet', '>=', now());
    }

    /**
     * Scope pour filtrer par ville de départ (bonus section 7).
     */
    public function scopeFiltrerVilleDepart($query, $ville)
    {
        if (!empty($ville)) {
            return $query->where('ville_depart', 'LIKE', '%' . $ville . '%');
        }
        return $query;
    }

    /**
     * Scope pour filtrer par ville d'arrivée (bonus section 7).
     */
    public function scopeFiltrerVilleArrivee($query, $ville)
    {
        if (!empty($ville)) {
            return $query->where('ville_arrivee', 'LIKE', '%' . $ville . '%');
        }
        return $query;
    }

    /**
     * Formate la date du trajet pour l'affichage.
     */
    public function getDateFormateeAttribute()
    {
        return $this->date_trajet->format('d/m/Y H:i');
    }

    /**
     * Formate seulement la date.
     */
    public function getDateOnlyAttribute()
    {
        return $this->date_trajet->format('d/m/Y');
    }

    /**
     * Formate seulement l'heure.
     */
    public function getHeureOnlyAttribute()
    {
        return $this->date_trajet->format('H:i');
    }
}