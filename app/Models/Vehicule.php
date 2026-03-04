<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Vehicule extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'photo',
        'plaque',
        'description',
    ];

    /**
     * Les attributs qui doivent être convertis en types natifs.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relation avec l'utilisateur (propriétaire).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec les trajets de l'utilisateur.
     * Un véhicule peut être utilisé dans plusieurs trajets.
     */
    public function trajets()
    {
        return $this->hasManyThrough(
            Trajet::class,
            User::class,
            'id',           // Clé étrangère sur users
            'user_id',      // Clé étrangère sur trajets
            'user_id',      // Clé locale sur vehicules
            'id'            // Clé locale sur users
        );
    }

    /**
     * Accessor pour obtenir l'URL complète de la photo.
     * Gère l'image par défaut si aucune photo n'est fournie (bonus section 7).
     */
    public function getPhotoUrlAttribute()
    {
        if ($this->photo && Storage::disk('public')->exists($this->photo)) {
            return asset('storage/' . $this->photo);
        }
        
        // Image par défaut pour Coviturage Lomé
        return asset('images/vehicule-default.jpg');
    }

    /**
     * Accessor pour vérifier si le véhicule a une photo.
     */
    public function getHasPhotoAttribute()
    {
        return !empty($this->photo);
    }

    /**
     * Accessor pour la plaque formatée (ex: AB 123 CD pour Lomé).
     */
    public function getPlaqueFormateeAttribute()
    {
        $plaque = strtoupper(trim($this->plaque));
        
        // Formatage basique pour plaques togolaises
        if (preg_match('/^([A-Z]{2,3})(\d{1,4})([A-Z]{0,2})$/', $plaque, $matches)) {
            return $matches[1] . ' ' . $matches[2] . ($matches[3] ? ' ' . $matches[3] : '');
        }
        
        return $plaque;
    }

    /**
     * Règles de validation pour la création.
     */
    public static function rules($vehiculeId = null)
    {
        $uniqueRule = $vehiculeId
            ? 'unique:vehicules,plaque,' . $vehiculeId
            : 'unique:vehicules,plaque';

        return [
            'plaque' => ['required', 'string', 'max:20', $uniqueRule],
            'photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'description' => ['required', 'string', 'min:20', 'max:1000'],
        ];
    }

    /**
     * Messages d'erreur personnalisés en français.
     */
    public static function messages()
    {
        return [
            'plaque.required' => 'La plaque d\'immatriculation est obligatoire.',
            'plaque.unique' => 'Cette plaque d\'immatriculation est déjà enregistrée.',
            'photo.required' => 'La photo du véhicule est obligatoire.',
            'photo.image' => 'Le fichier doit être une image valide.',
            'photo.mimes' => 'L\'image doit être au format JPEG, PNG, JPG ou GIF.',
            'photo.max' => 'L\'image ne doit pas dépasser 2 Mo.',
            'description.required' => 'La description du véhicule est obligatoire.',
            'description.min' => 'La description doit contenir au moins 20 caractères.',
            'description.max' => 'La description ne doit pas dépasser 1000 caractères.',
        ];
    }

    /**
     * Vérifie si l'utilisateur peut créer un véhicule.
     * Empêche d'avoir plus d'un véhicule (section 4 du TP).
     */
    public static function userCanCreateVehicule($userId)
    {
        return !self::where('user_id', $userId)->exists();
    }

    /**
     * Récupère le véhicule d'un utilisateur spécifique.
     */
    public static function getUserVehicule($userId)
    {
        return self::where('user_id', $userId)->first();
    }

    /**
     * Supprime la photo du stockage lors de la suppression.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($vehicule) {
            // Supprime la photo du stockage
            if ($vehicule->photo && Storage::disk('public')->exists($vehicule->photo)) {
                Storage::disk('public')->delete($vehicule->photo);
            }
        });

        static::updating(function ($vehicule) {
            // Supprime l'ancienne photo si une nouvelle est uploadée
            if ($vehicule->isDirty('photo') && $vehicule->getOriginal('photo')) {
                $oldPhoto = $vehicule->getOriginal('photo');
                if (Storage::disk('public')->exists($oldPhoto)) {
                    Storage::disk('public')->delete($oldPhoto);
                }
            }
        });
    }

    /**
     * Scope pour les véhicules actifs (avec photo).
     */
    public function scopeAvecPhoto($query)
    {
        return $query->whereNotNull('photo');
    }

    /**
     * Récupère une description raccourcie pour les aperçus.
     */
    public function getDescriptionCourteAttribute()
    {
        if (strlen($this->description) > 100) {
            return substr($this->description, 0, 100) . '...';
        }
        return $this->description;
    }
}