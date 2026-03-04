<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Covoiturage Lomé</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        {{-- Logo / Titre --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                <i class="fas fa-car text-blue-600 mr-2"></i>
                Covoiturage Lomé
            </h1>
            <p class="text-gray-600">Créez votre compte</p>
        </div>

        {{-- Carte du formulaire --}}
        <div class="bg-white rounded-xl shadow-lg p-8">
            {{-- Messages d'erreur/succès --}}
            @if(session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('status') }}
                </div>
            @endif
            
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Prénom --}}
                <div class="mb-4">
                    <label for="prenom" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user mr-2 text-gray-500"></i>
                        Prénom
                    </label>
                    <input type="text"
                        id="prenom"
                        name="prenom"
                        value="{{ old('prenom') }}"
                        required
                        autofocus
                        autocomplete="given-name"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                        placeholder="Votre prénom">
                    @error('prenom')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nom --}}
                <div class="mb-4">
                    <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user mr-2 text-gray-500"></i>
                        Nom
                    </label>
                    <input type="text"
                        id="nom"
                        name="nom"
                        value="{{ old('nom') }}"
                        required
                        autocomplete="family-name"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                        placeholder="Votre nom">
                    @error('nom')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Téléphone --}}
                <div class="mb-4">
                    <label for="telephone" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-phone mr-2 text-gray-500"></i>
                        Numéro de téléphone
                    </label>
                    <input type="tel"
                        id="telephone"
                        name="telephone"
                        value="{{ old('telephone') }}"
                        required
                        autocomplete="tel"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                        placeholder="+228 XX XX XX XX">
                    @error('telephone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-2 text-gray-500"></i>
                        Adresse email
                    </label>
                    <input type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                        placeholder="votre@email.com">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Mot de passe --}}
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2 text-gray-500"></i>
                        Mot de passe
                    </label>
                    <input type="password"
                        id="password"
                        name="password"
                        required
                        autocomplete="new-password"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                        placeholder="Minimum 8 caractères">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirmation mot de passe --}}
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2 text-gray-500"></i>
                        Confirmer le mot de passe
                    </label>
                    <input type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                        placeholder="Répétez votre mot de passe">
                </div>

                {{-- Bouton d'inscription --}}
                <button type="submit"
                        class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150 mb-4">
                    <i class="fas fa-user-plus mr-2"></i>
                    S'inscrire
                </button>

                {{-- Séparateur --}}
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Déjà un compte ?</span>
                    </div>
                </div>

                {{-- Lien de connexion --}}
                <div class="text-center">
                    <a href="{{ route('login') }}"
                    class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-150">
                        <i class="fas fa-sign-in-alt mr-3"></i>
                        Se connecter
                    </a>
                </div>
            </form>
        </div>

        {{-- Retour à l'accueil --}}
        <div class="text-center mt-6">
            <a href="{{ url('/') }}" class="text-gray-600 hover:text-gray-900 text-sm">
                <i class="fas fa-arrow-left mr-2"></i>
                Retour à l'accueil
            </a>
        </div>
    </div>

    <script>
        // Animation simple pour les erreurs
        document.addEventListener('DOMContentLoaded', function() {
            const errorMessages = document.querySelectorAll('.text-red-600');
            errorMessages.forEach(error => {
                error.style.opacity = '0';
                error.style.transform = 'translateY(-10px)';
                error.style.transition = 'all 0.3s ease';
                
                setTimeout(() => {
                    error.style.opacity = '1';
                    error.style.transform = 'translateY(0)';
                }, 100);
            });
        });
    </script>
</body>
</html>