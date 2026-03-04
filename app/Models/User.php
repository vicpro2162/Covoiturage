<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'prenom',
        'nom',
        'telephone',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Accessor pour 'name' (compatibilité Breeze)
     */
    public function getNameAttribute()
    {
        return $this->prenom . ' ' . $this->nom;
    }

    public function vehicule()
    {
        return $this->hasOne(Vehicule::class);
    }
    
    public function trajets()
    {
        return $this->hasMany(Trajet::class);
    }

    public function hasVehicule()
    {
        return $this->vehicule !== null;
    }

    /**
     * Récupère le véhicule de l'utilisateur avec vérification.
     */
    public function getVehiculeOrFail()
    {
        if (!$this->hasVehicule()) {
            throw new \Exception('Vous devez enregistrer un véhicule d\'abord.');
        }
        return $this->vehicule;
    }
}
