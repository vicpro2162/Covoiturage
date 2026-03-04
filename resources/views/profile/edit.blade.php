@extends('layouts.app')

@section('title', 'Modifier mon profil - Covoiturage Lomé')

@section('content')
<div class="min-h-screen bg-gray-100">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- En-tête -->
            <div class="md:flex md:items-center md:justify-between mb-8">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        <i class="fas fa-user-edit mr-3 text-blue-600"></i>Mon Profil
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Gérez vos informations personnelles
                    </p>
                </div>
                
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        <i class="fas fa-arrow-left mr-2"></i>Retour au tableau de bord
                    </a>
                </div>
            </div>

            <!-- Messages de statut -->
            @if (session('status') === 'profile-updated')
                <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">Profil mis à jour avec succès !</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('status') === 'password-updated')
                <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">Mot de passe mis à jour avec succès !</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Informations actuelles -->
            <div class="mb-8 bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-id-card mr-2"></i>Informations actuelles
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Nom complet</p>
                        <p class="font-medium">{{ auth()->user()->prenom }} {{ auth()->user()->nom }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-medium">{{ auth()->user()->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Téléphone</p>
                        <p class="font-medium">{{ auth()->user()->telephone ?? 'Non renseigné' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Membre depuis</p>
                        <p class="font-medium">{{ auth()->user()->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Colonne gauche : Mise à jour du profil -->
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            <i class="fas fa-user-circle mr-2"></i>Informations personnelles
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Mettez à jour vos informations de profil
                        </p>
                    </div>
                    
                    <div class="px-4 py-5 sm:p-6">
                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('patch')

                            <!-- Prénom -->
                            <div class="mb-4">
                                <label for="prenom" class="block text-sm font-medium text-gray-700">
                                    Prénom *
                                </label>
                                <input type="text"
                                        name="prenom"
                                        id="prenom"
                                        value="{{ old('prenom', auth()->user()->prenom) }}"
                                        required
                                        autocomplete="given-name"
                                        class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('prenom') border-red-300 @enderror">
                                @error('prenom')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nom -->
                            <div class="mb-4">
                                <label for="nom" class="block text-sm font-medium text-gray-700">
                                    Nom *
                                </label>
                                <input type="text"
                                        name="nom"
                                        id="nom"
                                        value="{{ old('nom', auth()->user()->nom) }}"
                                        required
                                        autocomplete="family-name"
                                        class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('nom') border-red-300 @enderror">
                                @error('nom')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Téléphone -->
                            <div class="mb-4">
                                <label for="telephone" class="block text-sm font-medium text-gray-700">
                                    Téléphone *
                                </label>
                                <input type="tel"
                                        name="telephone"
                                        id="telephone"
                                        value="{{ old('telephone', auth()->user()->telephone) }}"
                                        required
                                        placeholder="Ex: +228 90 12 34 56"
                                        class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('telephone') border-red-300 @enderror">
                                @error('telephone')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-6">
                                <label for="email" class="block text-sm font-medium text-gray-700">
                                    Adresse email *
                                </label>
                                <input type="email"
                                        name="email"
                                        id="email"
                                        value="{{ old('email', auth()->user()->email) }}"
                                        required
                                        autocomplete="email"
                                        class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('email') border-red-300 @enderror">
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                
                                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-800">
                                            Votre adresse email n'est pas vérifiée.
                                            <button form="send-verification"
                                                    class="underline text-sm text-gray-600 hover:text-gray-900">
                                                Cliquez ici pour renvoyer l'email de vérification.
                                            </button>
                                        </p>
                                        @if (session('status') === 'verification-link-sent')
                                            <p class="mt-2 text-sm font-medium text-green-600">
                                                Un nouveau lien de vérification a été envoyé à votre adresse email.
                                            </p>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <!-- Boutons -->
                            <div class="flex items-center justify-end">
                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i class="fas fa-save mr-2"></i>Enregistrer les modifications
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Colonne droite : Mise à jour du mot de passe -->
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            <i class="fas fa-lock mr-2"></i>Mot de passe
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Changez votre mot de passe
                        </p>
                    </div>
                    
                    <div class="px-4 py-5 sm:p-6">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @method('put')

                            <!-- Mot de passe actuel -->
                            <div class="mb-4">
                                <label for="current_password" class="block text-sm font-medium text-gray-700">
                                    Mot de passe actuel
                                </label>
                                <input type="password"
                                        name="current_password"
                                        id="current_password"
                                        autocomplete="current-password"
                                        class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('current_password') border-red-300 @enderror">
                                @error('current_password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nouveau mot de passe -->
                            <div class="mb-4">
                                <label for="password" class="block text-sm font-medium text-gray-700">
                                    Nouveau mot de passe
                                </label>
                                <input type="password"
                                        name="password"
                                        id="password"
                                        autocomplete="new-password"
                                        class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('password') border-red-300 @enderror">
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirmation -->
                            <div class="mb-6">
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                                    Confirmer le nouveau mot de passe
                                </label>
                                <input type="password"
                                        name="password_confirmation"
                                        id="password_confirmation"
                                        autocomplete="new-password"
                                        class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <!-- Boutons -->
                            <div class="flex items-center justify-end">
                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i class="fas fa-key mr-2"></i>Changer le mot de passe
                                </button>
                            </div>
                        </form>

                        <!-- Suppression de compte -->
                        <div class="mt-8 pt-8 border-t border-gray-200">
                            <h4 class="text-lg font-medium text-red-700 mb-4">
                                <i class="fas fa-exclamation-triangle mr-2"></i>Zone dangereuse
                            </h4>
                            <p class="text-sm text-gray-600 mb-4">
                                Une fois votre compte supprimé, toutes vos ressources et données seront définitivement effacées.
                            </p>
                            <form method="POST" action="{{ route('profile.destroy') }}">
                                @csrf
                                @method('delete')
                                
                                <div class="mb-4">
                                    <label for="password_delete" class="block text-sm font-medium text-gray-700">
                                        Mot de passe (confirmation)
                                    </label>
                                    <input type="password"
                                            name="password"
                                            id="password_delete"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                            placeholder="Votre mot de passe pour confirmer">
                                </div>
                                
                                <button type="submit"
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.')"
                                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <i class="fas fa-trash mr-2"></i>Supprimer mon compte
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations sur les données -->
            <div class="mt-8 bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-shield-alt text-blue-400"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Protection des données</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <p>Vos informations personnelles sont protégées et utilisées uniquement pour le fonctionnement du service de covoiturage.</p>
                            <p class="mt-1">Conformément à la réglementation RGPD, nous collectons : prénom, nom, téléphone, email.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Formulaire pour renvoyer la vérification d'email -->
<form id="send-verification" method="POST" action="{{ route('verification.send') }}">
    @csrf
</form>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validation en temps réel
        const emailInput = document.getElementById('email');
        const phoneInput = document.getElementById('telephone');
        
        // Validation email
        emailInput.addEventListener('blur', function() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(this.value)) {
                this.classList.add('border-red-300');
            } else {
                this.classList.remove('border-red-300');
            }
        });
        
        // Formatage téléphone
        phoneInput.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            
            if (value.length > 0) {
                value = '+228 ' + value;
                if (value.length > 8) {
                    value = value.substring(0, 8) + ' ' + value.substring(8);
                }
                if (value.length > 12) {
                    value = value.substring(0, 12) + ' ' + value.substring(12, 14);
                }
            }
            
            this.value = value;
        });
        
        // Confirmation avant suppression
        const deleteForm = document.querySelector('form[action*="profile.destroy"]');
        if (deleteForm) {
            deleteForm.addEventListener('submit', function(e) {
                const password = document.getElementById('password_delete').value;
                if (!password) {
                    e.preventDefault();
                    alert('Veuillez saisir votre mot de passe pour confirmer la suppression.');
                    return false;
                }
                
                if (!confirm('ATTENTION : Cette action supprimera définitivement votre compte, tous vos trajets et données. Continuer ?')) {
                    e.preventDefault();
                    return false;
                }
                
                return true;
            });
        }
    });
</script>
@endpush
@endsection