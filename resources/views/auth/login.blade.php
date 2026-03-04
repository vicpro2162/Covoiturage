<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Covoiturage Lomé</title>
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
            <p class="text-gray-600">Connectez-vous à votre compte</p>
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

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-2 text-gray-500"></i>
                        Adresse email
                    </label>
                    <input type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                        placeholder="votre@email.com">
                </div>

                {{-- Mot de passe --}}
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2 text-gray-500"></i>
                        Mot de passe
                    </label>
                    <input type="password"
                        id="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                        placeholder="Votre mot de passe">
                </div>

                {{-- Se souvenir de moi --}}
                <div class="flex items-center mb-6">
                    <input type="checkbox"
                        id="remember"
                        name="remember"
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="remember" class="ml-2 text-sm text-gray-700">
                        Se souvenir de moi
                    </label>
                </div>

                {{-- Bouton de connexion --}}
                <button type="submit"
                        class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150 mb-4">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Se connecter
                </button>

                {{-- Lien mot de passe oublié --}}
                @if (Route::has('password.request'))
                <div class="text-center mb-6">
                    <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-800 hover:underline">
                        <i class="fas fa-key mr-1"></i>
                        Mot de passe oublié ?
                    </a>
                </div>
                @endif

                {{-- Séparateur --}}
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Pas encore de compte ?</span>
                    </div>
                </div>

                {{-- Lien d'inscription --}}
                <div class="text-center">
                    <a href="{{ route('register') }}"
                    class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-150">
                        <i class="fas fa-user-plus mr-3"></i>
                        Créer un compte
                    </a>
                </div>
            </form>
        </div>

        {{-- Retour à l'accueil --}}
        <div class="text-center mt-6">
            <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900 text-sm">
                <i class="fas fa-arrow-left mr-2"></i>
                Retour à l'accueil
            </a>
        </div>
    </div>
</body>
</html>