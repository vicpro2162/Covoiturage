@extends('layouts.app')

@section('title', 'Détails du trajet - Covoiturage Lomé')

@section('content')
<main class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Bouton retour -->
        <div class="mb-6">
            <a href="{{ URL::previous() }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                <i class="fas fa-arrow-left mr-2"></i> Retour
            </a>
        </div>

        <!-- Carte trajet -->
        <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden trajet-card transition-all">
            
            <!-- En-tête -->
            <div class="bg-blue-600 text-white px-6 py-4 rounded-t-xl">
                <h2 class="text-2xl font-bold flex items-center">
                    <i class="fas fa-route mr-2"></i> Détails du trajet
                </h2>
            </div>

            <div class="p-6 space-y-6">
                <!-- Départ / Arrivée -->
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex items-center text-red-600 mb-1">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            <span class="font-semibold">Départ : {{ $trajet->lieu_depart }}</span>
                        </div>
                        <p class="text-gray-700 text-sm">{{ $trajet->ville_depart }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex items-center text-green-600 mb-1">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            <span class="font-semibold">Arrivée : {{ $trajet->lieu_arrivee }}</span>
                        </div>
                        <p class="text-gray-700 text-sm">{{ $trajet->ville_arrivee }}</p>
                    </div>
                </div>

                <!-- Date et places -->
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h5 class="font-semibold mb-1 flex items-center">
                            <i class="far fa-calendar-alt mr-2"></i> Date et heure
                        </h5>
                        <p class="text-gray-700 text-sm">
                            {{ $trajet->date_trajet->format('l d F Y') }} à {{ $trajet->date_trajet->format('H:i') }}
                        </p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h5 class="font-semibold mb-1 flex items-center">
                            <i class="fas fa-chair mr-2"></i> Places disponibles
                        </h5>
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 font-bold rounded-full text-sm">
                            {{ $trajet->places_disponibles }} place(s)
                        </span>
                    </div>
                </div>

                <!-- Conducteur -->
                <div class="border-t pt-4">
                    <h4 class="font-semibold text-gray-900 mb-2 flex items-center">
                        <i class="fas fa-user mr-2"></i> Conducteur
                    </h4>
                    <div class="flex items-center space-x-4">
                        <i class="fas fa-user-circle text-blue-600 text-3xl"></i>
                        <div>
                            <p class="font-medium">{{ $trajet->user->prenom }} {{ $trajet->user->nom }}</p>
                            @if($trajet->user->telephone)
                            <p class="text-gray-600 text-sm">
                                <i class="fas fa-phone mr-1"></i> {{ $trajet->user->telephone }}
                            </p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Véhicule -->
                @if($trajet->user->vehicule)
                <div class="border-t pt-4">
                    <h4 class="font-semibold text-gray-900 mb-2 flex items-center">
                        <i class="fas fa-car mr-2"></i> Véhicule
                    </h4>
                    <div class="flex items-start space-x-4">
                        @if($trajet->user->vehicule->photo)
                        <img src="{{ asset('storage/' . $trajet->user->vehicule->photo) }}" 
                             alt="Véhicule" class="w-20 h-20 object-cover rounded-lg">
                        @endif
                        <div>
                            <p class="font-semibold text-gray-900">{{ $trajet->user->vehicule->plaque }}</p>
                            <p class="text-gray-600 text-sm mt-1">{{ $trajet->user->vehicule->description }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Date de création -->
                <p class="text-gray-400 text-sm mt-4 flex items-center">
                    <i class="far fa-clock mr-1"></i> Trajet publié le {{ $trajet->created_at->format('d/m/Y à H:i') }}
                </p>
            </div>

            <!-- Actions -->
            <div class="border-t p-4 flex justify-between">
                @auth
                    @if(auth()->id() === $trajet->user_id && $trajet->date_trajet >= now())
                    <form action="{{ route('trajets.destroy', $trajet) }}" method="POST" onsubmit="return confirm('Supprimer ce trajet ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium flex items-center">
                            <i class="fas fa-trash mr-2"></i> Supprimer
                        </button>
                    </form>
                    @endif
                @endauth
                <a href="{{ route('trajets.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium flex items-center">
                    <i class="fas fa-list mr-2"></i> Tous les trajets
                </a>
            </div>
        </div>

    </div>
</main>

<style>
    .trajet-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .trajet-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
</style>
@endsection
