@extends('layouts.app')

@section('title', 'Tableau de bord - Covoiturage Lomé')

@section('content')
<div class="min-h-screen bg-gray-100">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- En-tête -->
            <div class="md:flex md:items-center md:justify-between mb-8">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        <i class="fas fa-tachometer-alt mr-3 text-blue-600"></i>Tableau de bord
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Bienvenue, {{ auth()->user()->prenom ?? auth()->user()->name }} ! Gérez votre activité de covoiturage.
                    </p>
                </div>
                
                <div class="mt-4 flex md:mt-0 md:ml-4 space-x-3">
                    <a href="{{ route('profile.show') }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-user-edit mr-2"></i>Mon profil
                    </a>
                    
                    @if(auth()->user()->vehicule)
                        <a href="{{ route('trajets.create') }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                            <i class="fas fa-plus-circle mr-2"></i>Nouveau trajet
                        </a>
                    @else
                        <a href="{{ route('vehicule.create') }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700">
                            <i class="fas fa-car mr-2"></i>Ajouter véhicule
                        </a>
                    @endif
                </div>
            </div>

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

            @if(session('warning'))
                <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">{{ session('warning') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Cartes de statistiques -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Trajets totaux -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-route text-blue-500 text-2xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Trajets proposés
                                    </dt>
                                    <dd class="text-lg font-medium text-gray-900">
                                        {{ auth()->user()->trajets->count() }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-3">
                        <div class="text-sm">
                            <a href="{{ route('trajets.mes') }}" class="font-medium text-blue-600 hover:text-blue-500">
                                Voir tous mes trajets
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Trajets à venir -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-calendar-check text-green-500 text-2xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Trajets à venir
                                    </dt>
                                    <dd class="text-lg font-medium text-gray-900">
                                        {{ auth()->user()->trajets()->where('date_trajet', '>=', now())->count() }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-3">
                        <div class="text-sm">
                            @if(auth()->user()->trajets()->where('date_trajet', '>=', now())->count() > 0)
                                <a href="{{ route('trajets.mes') }}" class="font-medium text-green-600 hover:text-green-500">
                                    Gérer mes trajets à venir
                                </a>
                            @else
                                <span class="text-gray-500">Aucun trajet à venir</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Véhicule -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-car {{ auth()->user()->vehicule ? 'text-green-500' : 'text-yellow-500' }} text-2xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Mon véhicule
                                    </dt>
                                    <dd class="text-lg font-medium text-gray-900">
                                        @if(auth()->user()->vehicule)
                                            {{ auth()->user()->vehicule->plaque }}
                                        @else
                                            Non enregistré
                                        @endif
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-3">
                        <div class="text-sm">
                            @if(auth()->user()->vehicule)
                                <a href="{{ route('vehicule.show') }}" class="font-medium text-blue-600 hover:text-blue-500">
                                    Voir mon véhicule
                                </a>
                            @else
                                <a href="{{ route('vehicule.create') }}" class="font-medium text-yellow-600 hover:text-yellow-500">
                                    Enregistrer mon véhicule
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Membre depuis -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-user-clock text-purple-500 text-2xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Membre depuis
                                    </dt>
                                    <dd class="text-lg font-medium text-gray-900">
                                        {{ auth()->user()->created_at->format('d/m/Y') }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-3">
                        <div class="text-sm">
                            <a href="{{ route('profile.edit') }}" class="font-medium text-purple-600 hover:text-purple-500">
                                Modifier mon profil
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">
                            <i class="fas fa-history mr-2 text-blue-600"></i>Mes trajets récents
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Les 5 derniers trajets que vous avez proposés
                        </p>
                    </div>
                    
                    <div class="px-4 py-5 sm:p-6">
                        @if(auth()->user()->trajets->count() > 0)
                            <div class="flow-root">
                                <ul class="-my-5 divide-y divide-gray-200">
                                    @foreach(auth()->user()->trajets()->latest()->take(5)->get() as $trajet)
                                        <li class="py-4">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex-shrink-0">
                                                    @if($trajet->date_trajet >= now())
                                                        <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-green-100">
                                                            <i class="fas fa-route text-green-600"></i>
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-gray-100">
                                                            <i class="fas fa-route text-gray-600"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 truncate">
                                                        {{ $trajet->ville_depart }} → {{ $trajet->ville_arrivee }}
                                                    </p>
                                                    <p class="text-sm text-gray-500">
                                                        {{ $trajet->date_trajet->format('d/m/Y H:i') }}
                                                        • {{ $trajet->places_disponibles }} place(s)
                                                    </p>
                                                </div>
                                                <div>
                                                    <a href="{{ route('trajets.show', $trajet) }}"
                                                        class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-gray-300 text-sm leading-5 font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50">
                                                        Voir
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            
                            <div class="mt-6">
                                <a href="{{ route('trajets.mes') }}"
                                    class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Voir tous mes trajets
                                    <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="fas fa-route text-gray-300 text-4xl mb-4"></i>
                                <h4 class="text-lg font-medium text-gray-900 mb-2">Aucun trajet pour le moment</h4>
                                <p class="text-sm text-gray-500 mb-6">
                                    Vous n'avez pas encore proposé de trajet.
                                </p>
                                @if(auth()->user()->vehicule)
                                    <a href="{{ route('trajets.create') }}"
                                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                                        <i class="fas fa-plus-circle mr-2"></i>Proposer un trajet
                                    </a>
                                @else
                                    <p class="text-sm text-gray-500">
                                        Vous devez d'abord enregistrer un véhicule.
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Colonne droite : Actions rapides et informations -->
                <div class="space-y-8">
                    <!-- Véhicule -->
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">
                                <i class="fas fa-car mr-2 text-blue-600"></i>Mon véhicule
                            </h3>
                        </div>
                        
                        <div class="px-4 py-5 sm:p-6">
                            @if(auth()->user()->vehicule)
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        @if(auth()->user()->vehicule->photo)
                                            <img class="h-16 w-16 rounded-full object-cover"
                                                src="{{ asset('storage/' . auth()->user()->vehicule->photo) }}"
                                                alt="Photo du véhicule">
                                        @else
                                            <span class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-blue-100">
                                                <i class="fas fa-car text-blue-600 text-xl"></i>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-sm font-medium text-gray-900">
                                            {{ auth()->user()->vehicule->plaque }}
                                        </h4>
                                        <p class="text-sm text-gray-500">
                                            {{ Str::limit(auth()->user()->vehicule->description, 50) }}
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="mt-6 grid grid-cols-2 gap-4">
                                    <a href="{{ route('vehicule.show') }}"
                                        class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        <i class="fas fa-eye mr-2"></i>Voir
                                    </a>
                                    <a href="{{ route('vehicule.edit') }}"
                                        class="inline-flex justify-center items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                        <i class="fas fa-edit mr-2"></i>Modifier
                                    </a>
                                </div>
                            @else
                                <div class="text-center py-6">
                                    <i class="fas fa-car text-yellow-300 text-4xl mb-4"></i>
                                    <h4 class="text-lg font-medium text-gray-900 mb-2">Aucun véhicule enregistré</h4>
                                    <p class="text-sm text-gray-500 mb-6">
                                        Vous devez enregistrer un véhicule pour proposer des trajets.
                                    </p>
                                    <a href="{{ route('vehicule.create') }}"
                                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700">
                                        <i class="fas fa-plus mr-2"></i>Enregistrer mon véhicule
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Actions rapides -->
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">
                                <i class="fas fa-bolt mr-2 text-blue-600"></i>Actions rapides
                            </h3>
                        </div>
                        
                        <div class="px-4 py-5 sm:p-6">
                            <div class="grid grid-cols-2 gap-4">
                                <!-- Proposer un trajet -->
                                <a href="{{ route('trajets.create') }}"
                                    class="relative group bg-white p-6 focus:outline-none border border-gray-300 rounded-lg hover:border-blue-500 hover:shadow-md transition-all duration-200 {{ !auth()->user()->vehicule ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    @if(!auth()->user()->vehicule) onclick="return false;" @endif>
                                    <span class="rounded-lg inline-flex p-3 bg-blue-50 text-blue-700 group-hover:bg-blue-100">
                                        <i class="fas fa-plus-circle h-6 w-6"></i>
                                    </span>
                                    <div class="mt-4">
                                        <h3 class="text-lg font-medium text-gray-900">
                                            Proposer un trajet
                                        </h3>
                                        <p class="mt-2 text-sm text-gray-500">
                                            Partagez vos trajets quotidiens
                                        </p>
                                    </div>
                                </a>

                                <!-- Voir tous les trajets -->
                                <a href="{{ route('trajets.index') }}"
                                    class="relative group bg-white p-6 focus:outline-none border border-gray-300 rounded-lg hover:border-green-500 hover:shadow-md transition-all duration-200">
                                    <span class="rounded-lg inline-flex p-3 bg-green-50 text-green-700 group-hover:bg-green-100">
                                        <i class="fas fa-route h-6 w-6"></i>
                                    </span>
                                    <div class="mt-4">
                                        <h3 class="text-lg font-medium text-gray-900">
                                            Trajets disponibles
                                        </h3>
                                        <p class="mt-2 text-sm text-gray-500">
                                            Consultez les trajets proposés
                                        </p>
                                    </div>
                                </a>

                                <!-- Mon profil -->
                                <a href="{{ route('profile.edit') }}"
                                    class="relative group bg-white p-6 focus:outline-none border border-gray-300 rounded-lg hover:border-purple-500 hover:shadow-md transition-all duration-200">
                                    <span class="rounded-lg inline-flex p-3 bg-purple-50 text-purple-700 group-hover:bg-purple-100">
                                        <i class="fas fa-user-edit h-6 w-6"></i>
                                    </span>
                                    <div class="mt-4">
                                        <h3 class="text-lg font-medium text-gray-900">
                                            Mon profil
                                        </h3>
                                        <p class="mt-2 text-sm text-gray-500">
                                            Modifiez vos informations
                                        </p>
                                    </div>
                                </a>

                                <!-- Mon véhicule -->
                                <a href="{{ auth()->user()->vehicule ? route('vehicule.show') : route('vehicule.create') }}"
                                    class="relative group bg-white p-6 focus:outline-none border border-gray-300 rounded-lg hover:border-yellow-500 hover:shadow-md transition-all duration-200">
                                    <span class="rounded-lg inline-flex p-3 {{ auth()->user()->vehicule ? 'bg-green-50 text-green-700 group-hover:bg-green-100' : 'bg-yellow-50 text-yellow-700 group-hover:bg-yellow-100' }}">
                                        <i class="fas fa-car h-6 w-6"></i>
                                    </span>
                                    <div class="mt-4">
                                        <h3 class="text-lg font-medium text-gray-900">
                                            Mon véhicule
                                        </h3>
                                        <p class="mt-2 text-sm text-gray-500">
                                            {{ auth()->user()->vehicule ? 'Consulter/modifier' : 'Ajouter un véhicule' }}
                                        </p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section information TP -->
            <div class="mt-8 bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-400"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Informations sur le projet</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <p><strong>Application :</strong> Covoiturage local à Lomé</p>
                            <p><strong>Objectif :</strong> Permettre aux conducteurs de proposer des trajets et aux passagers de les consulter</p>
                            <p><strong>Fonctionnalités implémentées :</strong> Authentification, gestion de profil, enregistrement de véhicule, création et consultation de trajets</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Animation pour les cartes d'actions rapides
    document.addEventListener('DOMContentLoaded', function() {
        const quickActionCards = document.querySelectorAll('.group');
        quickActionCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                const icon = this.querySelector('span');
                icon.style.transform = 'scale(1.1)';
                icon.style.transition = 'transform 0.2s ease';
            });
            
            card.addEventListener('mouseleave', function() {
                const icon = this.querySelector('span');
                icon.style.transform = 'scale(1)';
            });
        });
    });
</script>
@endpush