@extends('layouts.app')

@section('title', 'Trajets disponibles - Covoiturage Lomé')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- En-tête -->
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">
                <i class="fas fa-route text-blue-600 mr-3"></i>
                Trajets disponibles
            </h1>
            <p class="text-gray-600">
                Consultez tous les trajets de covoiturage disponibles. Inscrivez-vous pour réserver ou proposer un trajet.
            </p>
        </div>

        <!-- Bouton création (si connecté) -->
        @auth
            @if(Auth::user()->vehicule)
                <div class="mb-6 flex justify-end">
                    <a href="{{ route('trajets.create') }}" class="inline-flex items-center px-5 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition">
                        <i class="fas fa-plus mr-2" style="color:blue"></i>
                        <h6 style="color:blue">Proposer un trajet</h6>
                    </a>
                </div>
            @else
                <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <p class="text-yellow-800">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        Vous devez <a href="{{ route('vehicule.create') }}" class="text-yellow-700 underline">enregistrer un véhicule</a> 
                        avant de pouvoir proposer un trajet.
                    </p>
                </div>
            @endif
        @endauth

        <!-- Liste des trajets -->
        @if($trajets->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($trajets as $trajet)
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-all">
                    <div class="p-6">
                        
                        <!-- En-tête trajet -->
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">
                                    {{ $trajet->ville_depart }} → {{ $trajet->ville_arrivee }}
                                </h3>
                                <p class="text-gray-600 text-sm mt-1">
                                    <i class="far fa-calendar-alt mr-2"></i>
                                    {{ $trajet->date_trajet->format('d/m/Y à H:i') }}
                                </p>
                            </div>
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 font-bold rounded-full text-sm">
                                {{ $trajet->places_disponibles }} place(s)
                            </span>
                        </div>

                        <!-- Lieux de départ/arrivée -->
                        <div class="space-y-4 mb-6">
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <div class="flex items-center text-red-600 mb-1">
                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                    <span class="font-semibold">Départ : {{ $trajet->ville_depart }}</span>
                                </div>
                                <p class="text-gray-700 text-sm">{{ $trajet->lieu_depart }}</p>
                            </div>
                            
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <div class="flex items-center text-green-600 mb-1">
                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                    <span class="font-semibold">Arrivée : {{ $trajet->ville_arrivee }}</span>
                                </div>
                                <p class="text-gray-700 text-sm">{{ $trajet->lieu_arrivee }}</p>
                            </div>
                        </div>

                        <!-- Conducteur -->
                        <div class="border-t pt-4 mb-4">
                            <h4 class="font-semibold text-gray-900 mb-2">
                                <i class="fas fa-user mr-2"></i> Conducteur
                            </h4>
                            <div class="flex items-center">
                                <div class="flex-1">
                                    <p class="font-medium">
                                        {{ $trajet->user->prenom }} {{ $trajet->user->nom }}
                                    </p>
                                    <p class="text-gray-600 text-sm">
                                        <i class="fas fa-phone mr-1"></i> {{ $trajet->user->telephone }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Véhicule -->
                        @if($trajet->user->vehicule)
                        <div class="border-t pt-4">
                            <h4 class="font-semibold text-gray-900 mb-2">
                                <i class="fas fa-car mr-2"></i> Véhicule
                            </h4>
                            <div class="flex items-start space-x-3">
                                @if($trajet->user->vehicule->photo)
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('storage/' . $trajet->user->vehicule->photo) }}" alt="Véhicule" class="w-16 h-16 object-cover rounded-lg">
                                </div>
                                @endif
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">
                                        {{ $trajet->user->vehicule->plaque }}
                                    </p>
                                    <p class="text-gray-600 text-sm mt-1">
                                        {{ $trajet->user->vehicule->description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Actions -->
                        <div class="border-t pt-4 mt-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 text-sm">
                                    <i class="far fa-clock mr-1"></i>
                                    {{ $trajet->created_at->diffForHumans() }}
                                </span>
                                @auth
                                    @if(Auth::id() !== $trajet->user_id)
                                        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                                            Réserver
                                        </button>
                                    @else
                                        <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-lg text-sm">
                                            Votre trajet
                                        </span>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                                        Connectez-vous pour réserver
                                    </a>
                                @endauth
                            </div>
                        </div>

                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $trajets->links() }}
            </div>

        @else
            <!-- Aucun trajet -->
            <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                <div class="mb-6">
                    <i class="fas fa-route text-6xl text-gray-300"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Aucun trajet disponible</h3>
                <p class="text-gray-600 mb-6">
                    Soyez le premier à proposer un trajet !
                </p>
                @auth
                    @if(Auth::user()->vehicule)
                        <a href="{{ route('trajets.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700">
                            <i class="fas fa-plus mr-2"></i>
                            Proposer le premier trajet
                        </a>
                    @else
                        <a href="{{ route('vehicule.create') }}" class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700">
                            <i class="fas fa-car mr-2"></i>
                            Enregistrer mon véhicule
                        </a>
                    @endif
                @else
                    <div class="space-y-4">
                        <p class="text-gray-600">Inscrivez-vous pour proposer des trajets</p>
                        <a href="{{ route('register') }}"class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700">
                            <i class="fas fa-user-plus mr-2"></i>
                            S'inscrire maintenant
                        </a>
                    </div>
                @endauth
            </div>
        @endif

    </div>
</div>
@endsection

@push('styles')
<style>
    .trajet-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .trajet-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
</style>
@endpush