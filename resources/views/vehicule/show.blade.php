@extends('layouts.app')

@section('title', 'Mon Véhicule - Covoiturage Lomé')

@section('content')
<div class="min-h-screen bg-gray-100">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- En-tête -->
            <div class="md:flex md:items-center md:justify-between mb-8">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        <i class="fas fa-car mr-3 text-blue-600"></i>Mon Véhicule
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Consultez les informations de votre véhicule enregistré
                    </p>
                </div>
                
                <div class="mt-4 flex md:mt-0 md:ml-4 space-x-3">
                    <a href="{{ route('vehicule.edit') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-edit mr-2"></i>Modifier
                    </a>
                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        <i class="fas fa-arrow-left mr-2"></i>Retour au tableau de bord
                    </a>
                </div>
            </div>

            <!-- Messages flash -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Carte principale -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Détails du véhicule
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        Informations complètes sur votre véhicule
                    </p>
                </div>
                
                <div class="px-4 py-5 sm:p-6">
                    @if($vehicule)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Colonne gauche : Photo -->
                            <div>
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Photo du véhicule</h4>
                                
                                @if($vehicule->photo)
                                    <div class="relative">
                                        <img src="{{ asset('storage/' . $vehicule->photo) }}" 
                                             alt="Photo du véhicule" 
                                             class="w-full h-auto max-h-96 object-cover rounded-lg shadow-lg">
                                        <div class="absolute bottom-4 right-4">
                                            <a href="{{ asset('storage/' . $vehicule->photo) }}" 
                                               target="_blank"
                                               class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-black bg-opacity-50 hover:bg-opacity-70">
                                                <i class="fas fa-expand mr-2"></i>Agrandir
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="border-2 border-dashed border-gray-300 rounded-lg h-64 flex items-center justify-center">
                                        <div class="text-center">
                                            <i class="fas fa-car text-gray-300 text-5xl mb-4"></i>
                                            <p class="text-sm text-gray-500">Aucune photo disponible</p>
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="mt-4 text-sm text-gray-500">
                                    <p><i class="fas fa-info-circle mr-2"></i>La photo permet aux passagers de reconnaître votre véhicule</p>
                                </div>
                            </div>
                            
                            <!-- Colonne droite : Informations -->
                            <div>
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Informations générales</h4>
                                
                                <dl class="divide-y divide-gray-200">
                                    <!-- Plaque d'immatriculation -->
                                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                        <dt class="text-sm font-medium text-gray-500 flex items-center">
                                            <i class="fas fa-id-card mr-2"></i> Plaque d'immatriculation
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                <i class="fas fa-car mr-1"></i> {{ $vehicule->plaque }}
                                            </span>
                                        </dd>
                                    </div>
                                    
                                    <!-- Description -->
                                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                        <dt class="text-sm font-medium text-gray-500 flex items-center">
                                            <i class="fas fa-align-left mr-2"></i> Description
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            <div class="bg-gray-50 p-4 rounded-lg">
                                                {{ $vehicule->description }}
                                            </div>
                                        </dd>
                                    </div>
                                    
                                    <!-- Date d'enregistrement -->
                                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                        <dt class="text-sm font-medium text-gray-500 flex items-center">
                                            <i class="far fa-calendar-alt mr-2"></i> Enregistré le
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ $vehicule->created_at->format('d/m/Y à H:i') }}
                                        </dd>
                                    </div>
                                    
                                    <!-- Dernière modification -->
                                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                        <dt class="text-sm font-medium text-gray-500 flex items-center">
                                            <i class="fas fa-history mr-2"></i> Dernière modification
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ $vehicule->updated_at->format('d/m/Y à H:i') }}
                                        </dd>
                                    </div>
                                    
                                    <!-- Statut -->
                                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                        <dt class="text-sm font-medium text-gray-500 flex items-center">
                                            <i class="fas fa-check-circle mr-2"></i> Statut
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check mr-1"></i> Véhicule validé
                                            </span>
                                            <p class="mt-1 text-xs text-gray-500">
                                                Ce véhicule peut être utilisé pour proposer des trajets
                                            </p>
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                        
                        <!-- Section trajets associés -->
                        <div class="mt-12 pt-8 border-t border-gray-200">
                            <h4 class="text-lg font-medium text-gray-900 mb-6">
                                <i class="fas fa-route mr-2"></i>Trajets proposés avec ce véhicule
                            </h4>
                            
                            @if($vehicule->user->trajets->count() > 0)
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div class="text-center">
                                            <div class="text-2xl font-bold text-blue-600">{{ $vehicule->user->trajets->count() }}</div>
                                            <div class="text-sm text-gray-600">Trajets totaux</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-2xl font-bold text-green-600">
                                                {{ $vehicule->user->trajets()->where('date_trajet', '>=', now())->count() }}
                                            </div>
                                            <div class="text-sm text-gray-600">Trajets à venir</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-2xl font-bold text-gray-600">
                                                {{ $vehicule->user->trajets()->where('date_trajet', '<', now())->count() }}
                                            </div>
                                            <div class="text-sm text-gray-600">Trajets passés</div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-6">
                                        <a href="{{ route('trajets.mes') }}" 
                                           class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                                            <i class="fas fa-list mr-2"></i>Voir tous mes trajets
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-8 bg-gray-50 rounded-lg">
                                    <i class="fas fa-route text-gray-300 text-4xl mb-4"></i>
                                    <p class="text-gray-600 mb-4">Vous n'avez pas encore proposé de trajet avec ce véhicule</p>
                                    <a href="{{ route('trajets.create') }}" 
                                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                                        <i class="fas fa-plus-circle mr-2"></i>Proposer un premier trajet
                                    </a>
                                </div>
                            @endif
                        </div>
                        
                    @else
                        <!-- Aucun véhicule -->
                        <div class="text-center py-12">
                            <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-yellow-100 mb-6">
                                <i class="fas fa-car text-yellow-500 text-3xl"></i>
                            </div>
                            <h3 class="text-2xl font-medium text-gray-900 mb-4">Aucun véhicule enregistré</h3>
                            <p class="text-gray-600 max-w-md mx-auto mb-8">
                                Vous devez enregistrer un véhicule avant de pouvoir proposer des trajets. 
                                C'est obligatoire pour garantir la sécurité et la confiance des passagers.
                            </p>
                            <a href="{{ route('vehicule.create') }}" 
                               class="inline-flex items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-yellow-600 hover:bg-yellow-700">
                                <i class="fas fa-plus-circle mr-3"></i>Enregistrer mon véhicule
                            </a>
                            <div class="mt-6">
                                <a href="{{ route('dashboard') }}" class="text-sm text-blue-600 hover:text-blue-500">
                                    <i class="fas fa-arrow-left mr-2"></i>Retour au tableau de bord
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            {{-- Ajoute ceci temporairement dans vehicule/show.blade.php --}}

            <!-- Informations importantes -->
            <div class="mt-8 bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-400"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Informations importantes</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <ul class="list-disc pl-5 space-y-1">
                                <li>Votre véhicule doit être en bon état de fonctionnement</li>
                                <li>La plaque d'immatriculation doit être visible et valide</li>
                                <li>Vous ne pouvez enregistrer qu'un seul véhicule</li>
                                <li>Le véhicule est obligatoire pour proposer des trajets</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Styles personnalisés pour la photo */
    .vehicle-photo-container {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    
    .vehicle-photo-container img {
        transition: transform 0.3s ease;
    }
    
    .vehicle-photo-container:hover img {
        transform: scale(1.02);
    }
    
    /* Style pour les badges */
    .badge-vehicle {
        font-family: 'Courier New', monospace;
        letter-spacing: 1px;
        font-weight: bold;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation pour la photo
        const vehiclePhoto = document.querySelector('img');
        if (vehiclePhoto) {
            vehiclePhoto.addEventListener('mouseenter', function() {
                this.style.cursor = 'zoom-in';
            });
        }
        
        // Confirmation avant certaines actions
        const deleteButtons = document.querySelectorAll('[data-confirm]');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                if (!confirm(this.getAttribute('data-confirm'))) {
                    e.preventDefault();
                }
            });
        });
    });
</script>
@endpush