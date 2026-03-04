<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - Coviturage Lomé</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .card-header {
            border-radius: 10px 10px 0 0 !important;
        }
        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        .alert {
            border-radius: 8px;
        }
    </style>
</head>
<body>
        <!-- Contenu de ta vue actuelle ici -->
                <!-- ... le reste de ton code ... -->
    {{-- resources/views/profile/edit.blade.php --}}
    @extends('layouts.app')

    @section('title', 'Mon Profil')

    @section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-user-circle"></i> <h6 >Mon Profil</h6>
                        </h4>
                    </div>
                    
                    <div class="card-body">
                        <!-- Section informations personnelles -->
                        <div class="mb-4">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-id-card"></i> Informations personnelles
                            </h5>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong><i class="fas fa-user"></i> Prénom:</strong>
                                    <p class="form-control-plaintext">{{ $user->prenom ?? 'Non renseigné' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong><i class="fas fa-user"></i> Nom:</strong>
                                    <p class="form-control-plaintext">{{ $user->nom ?? 'Non renseigné' }}</p>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong><i class="fas fa-envelope"></i> Email:</strong>
                                    <p class="form-control-plaintext">{{ $user->email }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong><i class="fas fa-phone"></i> Téléphone:</strong>
                                    <p class="form-control-plaintext">{{ $user->telephone ?? 'Non renseigné' }}</p>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong><i class="fas fa-calendar-alt"></i> Membre depuis:</strong>
                                    <p class="form-control-plaintext">
                                        {{ $user->created_at->format('d/m/Y') }}
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong><i class="fas fa-history"></i> Dernière mise à jour:</strong>
                                    <p class="form-control-plaintext">
                                        {{ $user->updated_at->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Section véhicule -->
                        <div class="mb-4">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-car"></i> Mon véhicule
                            </h5>
                            
                            @if($user->vehicule)
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle"></i>
                                    <strong>Véhicule enregistré</strong>
                                    <ul class="mb-0 mt-2">
                                        <li><strong>Plaque:</strong> {{ $user->vehicule->plaque_formatee }}</li>
                                        <li><strong>Description:</strong> {{ $user->vehicule->description_courte }}</li>
                                        <li>
                                            <strong>Photo:</strong>
                                            @if($user->vehicule->has_photo)
                                                <a href="{{ $user->vehicule->photo_url }}" target="_blank" class="ms-2">
                                                    <i class="fas fa-external-link-alt"></i> Voir
                                                </a>
                                            @else
                                                <span class="text-muted ms-2">Aucune photo</span>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <strong>Aucun véhicule enregistré</strong>
                                    <p class="mb-0 mt-2">
                                        Vous devez enregistrer un véhicule pour proposer des trajets.
                                        <a href="{{ route('vehicule.create') }}" class="alert-link">Enregistrer mon véhicule</a>
                                    </p>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Section statistiques -->
                        <div class="mb-4">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-chart-bar"></i> Mes statistiques
                            </h5>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h3 class="text-primary">
                                                {{ $user->trajets->count() }}
                                            </h3>
                                            <p class="mb-0">
                                                <i class="fas fa-route"></i> Trajets proposés
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h3 class="text-primary">
                                                {{ $user->trajets()->where('date_trajet', '>=', now())->count() }}
                                            </h3>
                                            <p class="mb-0">
                                                <i class="fas fa-calendar-check"></i> Trajets à venir
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Boutons d'action -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Retour
                            </a>
                            
                            <div>
                                <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                                    <i class="fas fa-edit"></i> Modifier le profil
                                </a>
                                <a href="{{ route('vehicule.edit') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-car"></i> Modifier le véhicule
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection