@extends('layouts.app')

@section('title', 'Proposer un trajet - Covoiturage Lomé')

@section('content')
<div class="py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- En-tête -->
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">
                <i class="fas fa-road text-green-600 mr-3"></i>
                Proposer un nouveau trajet
            </h1>
            <p class="text-gray-600">
                Remplissez les informations de votre trajet. Les autres utilisateurs pourront le voir et réserver des places.
            </p>
        </div>

        <!-- Informations du véhicule -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-blue-900">
                    <i class="fas fa-car mr-2"></i>
                    Votre véhicule
                </h3>
                <a href="{{ route('vehicule.edit') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                    <i class="fas fa-edit mr-1"></i> Modifier
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-blue-700">Plaque d'immatriculation</p>
                    <p class="font-semibold text-blue-900">{{ Auth::user()->vehicule->plaque }}</p>
                </div>
                <div>
                    <p class="text-sm text-blue-700">Description</p>
                    <p class="font-medium text-blue-900">{{ Auth::user()->vehicule->description }}</p>
                </div>
            </div>
            
            @if(Auth::user()->vehicule->photo)
            <div class="mt-4">
                <p class="text-sm text-blue-700 mb-2">Photo du véhicule</p>
                <img src="{{ asset('storage/' . Auth::user()->vehicule->photo) }}"
                    alt="Votre véhicule"
                    class="w-48 h-32 object-cover rounded-lg shadow">
            </div>
            @endif
        </div>

        <!-- Formulaire -->
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl mb-6">
                <h4 class="font-semibold mb-2">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Veuillez corriger les erreurs suivantes :
                </h4>
                <ul class="list-disc list-inside mt-2 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('trajets.store') }}" class="space-y-8">
            @csrf

            <!-- Section Départ -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                    <div class="w-8 h-8 bg-red-100 text-red-600 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    Point de départ
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Ville de départ -->
                    <div>
                        <label for="ville_depart" class="block text-sm font-medium text-gray-700 mb-2">
                            Ville de départ <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                            id="ville_depart"
                            name="ville_depart"
                            value="{{ old('ville_depart') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                            placeholder="Ex: Lomé"
                            required>
                        <p class="text-xs text-gray-500 mt-1">Ville principale de départ</p>
                    </div>
                    
                    <!-- Lieu précis de départ -->
                    <div class="md:col-span-2">
                        <label for="lieu_depart" class="block text-sm font-medium text-gray-700 mb-2">
                            Lieu précis de départ <span class="text-red-500">*</span>
                        </label>
                        <textarea id="lieu_depart"
                                name="lieu_depart"
                                rows="2"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                                placeholder="Adresse exacte, point de rendez-vous, lieu précis..."
                                required>{{ old('lieu_depart') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Soyez précis pour faciliter le rendez-vous</p>
                    </div>
                </div>
            </div>

            <!-- Section Arrivée -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                    <div class="w-8 h-8 bg-green-100 text-green-600 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-flag-checkered"></i>
                    </div>
                    Point d'arrivée
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Ville d'arrivée -->
                    <div>
                        <label for="ville_arrivee" class="block text-sm font-medium text-gray-700 mb-2">
                            Ville d'arrivée <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                            id="ville_arrivee"
                            name="ville_arrivee"
                            value="{{ old('ville_arrivee') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                            placeholder="Ex: Kpalimé"
                            required>
                        <p class="text-xs text-gray-500 mt-1">Ville principale d'arrivée</p>
                    </div>
                    
                    <!-- Lieu précis d'arrivée -->
                    <div class="md:col-span-2">
                        <label for="lieu_arrivee" class="block text-sm font-medium text-gray-700 mb-2">
                            Lieu précis d'arrivée <span class="text-red-500">*</span>
                        </label>
                        <textarea id="lieu_arrivee"
                                name="lieu_arrivee"
                                rows="2"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                                placeholder="Adresse exacte, point d'arrivée, destination précise..."
                                required>{{ old('lieu_arrivee') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Soyez précis pour faciliter l'arrivée</p>
                    </div>
                </div>
            </div>

            <!-- Section Date et Places -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                    <div class="w-8 h-8 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mr-3">
                        <i class="far fa-calendar-alt"></i>
                    </div>
                    Informations pratiques
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Date et heure -->
                    <div>
                        <label for="date_trajet" class="block text-sm font-medium text-gray-700 mb-2">
                            Date et heure du trajet <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local"
                            id="date_trajet"
                            name="date_trajet"
                            value="{{ old('date_trajet') }}"
                            min="{{ now()->format('Y-m-d\TH:i') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150" 
                            required>
                        <p class="text-xs text-gray-500 mt-1">La date doit être dans le futur</p>
                    </div>
                    
                    <!-- Nombre de places -->
                    <div>
                        <label for="places_disponibles" class="block text-sm font-medium text-gray-700 mb-2">
                            Places disponibles <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select id="places_disponibles" 
                                    name="places_disponibles"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 appearance-none"
                                    required>
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}" {{ old('places_disponibles') == $i ? 'selected' : '' }}>
                                        {{ $i }} place{{ $i > 1 ? 's' : '' }}
                                    </option>
                                @endfor
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Nombre de passagers que vous pouvez transporter</p>
                    </div>
                </div>
            </div>

            <!-- Section récapitulative -->
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-6">
                <h4 class="font-semibold text-gray-900 mb-4">
                    <i class="fas fa-clipboard-check mr-2 text-green-600"></i>
                    Récapitulatif
                </h4>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Véhicule :</span>
                        <span class="font-medium">{{ Auth::user()->vehicule->plaque }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Conducteur :</span>
                        <span class="font-medium">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Téléphone :</span>
                        <span class="font-medium">{{ Auth::user()->telephone }}</span>
                    </div>
                </div>
            </div>

            <!-- Boutons -->
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-6">
                <div>
                    <a href="{{ route('trajets.index') }}" class="inline-flex items-center px-5 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition duration-150">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Retour aux trajets
                    </a>
                </div>
                
                <div class="flex gap-4">
                    <button type="reset" 
                            class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition duration-150">
                        <i class="fas fa-redo mr-2"></i>
                        Réinitialiser
                    </button>
                    
                    <button type="submit"
                            class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium transition duration-150 shadow-md hover:shadow-lg">
                        <i class="fas fa-paper-plane mr-2" style="color:blue"></i>
                        <h6 style="color:blue">Proposer ce trajet</h6>
                    </button>
                </div>
            </div>
            
            <div class="text-center pt-6 border-t border-gray-200">
                <p class="text-sm text-gray-500">
                    <i class="fas fa-info-circle mr-2"></i>
                    Votre trajet sera visible par tous les utilisateurs. Vous pourrez le modifier ou le supprimer à tout moment.
                </p>
            </div>
        </form>

    </div>
</div>
@endsection

@push('styles')
<style>
    /* Style pour le sélecteur de date/heure */
    input[type="datetime-local"] {
        color-scheme: light;
    }
    
    /* Animation pour les sections */
    .section-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .section-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    }
    
    /* Style pour les icônes de validation */
    .required-star {
        color: #ef4444;
        font-weight: bold;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mettre à jour la date/heure minimale
        const dateInput = document.getElementById('date_trajet');
        const now = new Date();
        const localDateTime = now.toISOString().slice(0, 16);
        
        // Si pas de valeur, mettre maintenant + 1 heure
        if (!dateInput.value) {
            now.setHours(now.getHours() + 1);
            dateInput.value = now.toISOString().slice(0, 16);
        }
        
        // Validation en temps réel
        const form = document.querySelector('form');
        const villeDepart = document.getElementById('ville_depart');
        const villeArrivee = document.getElementById('ville_arrivee');
        
        // Vérifier que départ et arrivée sont différents
        form.addEventListener('submit', function(e) {
            if (villeDepart.value.toLowerCase() === villeArrivee.value.toLowerCase()) {
                e.preventDefault();
                alert('La ville de départ et la ville d\'arrivée doivent être différentes.');
                villeDepart.focus();
                return false;
            }
            
            // Vérifier la date
            const selectedDate = new Date(dateInput.value);
            if (selectedDate <= new Date()) {
                e.preventDefault();
                alert('La date et heure du trajet doivent être dans le futur.');
                dateInput.focus();
                return false;
            }
            
            return true;
        });
        
        // Afficher un aperçu du trajet
        function updatePreview() {
            const depart = villeDepart.value || '[Ville départ]';
            const arrivee = villeArrivee.value || '[Ville arrivée]';
            const date = dateInput.value ? new Date(dateInput.value).toLocaleString('fr-FR') : '[Date]';
            const places = document.getElementById('places_disponibles').value || '1';
            
            console.log(`Trajet: ${depart} → ${arrivee} | ${date} | ${places} place(s)`);
        }
        
        // Écouter les changements
        [villeDepart, villeArrivee, dateInput].forEach(input => {
            input.addEventListener('change', updatePreview);
        });
    });
</script>
@endpush