<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Covoiturage Lomé')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @stack('styles')
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <!-- Navigation personnalisée -->
            <nav class="bg-white shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <a href="{{ url('/') }}" class="text-xl font-bold text-gray-800">
                                    <i class="fas fa-car text-blue-600 mr-2"></i>Covoiturage Lomé
                                </a>
                            </div>

                            <!-- Navigation Links (toujours visibles) -->
                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <a href="{{ url('/') }}"
                                class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-900 hover:text-blue-600">
                                    <i class="fas fa-home mr-2"></i>Accueil
                                </a>
                                <a href="{{ route('trajets.index') }}"
                                class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-900 hover:text-blue-600">
                                    <i class="fas fa-route mr-2"></i>Trajets disponibles
                                </a>
                                
                                @auth
                                    <!-- Liens pour utilisateurs connectés -->
                                    @if(auth()->user()->vehicule)
                                        <a href="{{ route('trajets.create') }}"
                                        class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-900 hover:text-blue-600">
                                            <i class="fas fa-plus-circle mr-2"></i>Proposer un trajet
                                        </a>
                                    @endif
                                    
                                    <a href="{{ route('trajets.mes') }}"
                                    class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-900 hover:text-blue-600">
                                        <i class="fas fa-history mr-2"></i>Mes trajets
                                    </a>
                                @endauth
                            </div>
                        </div>

                        <!-- Menu droite -->
                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            @auth
                                <!-- Menu déroulant utilisateur -->
                                <div class="ms-3 relative">
                                    <div class="dropdown">
                                        <button class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none">
                                            <div class="flex items-center">
                                                <i class="fas fa-user-circle text-gray-500 text-xl mr-2"></i>
                                                <span>{{ auth()->user()->prenom ?? auth()->user()->name }}</span>
                                                @if(!auth()->user()->vehicule)
                                                    <span class="ml-2 inline-flex items-center rounded-full bg-yellow-100 px-2 py-1 text-xs font-medium text-yellow-800">
                                                        <i class="fas fa-exclamation-circle mr-1"></i> Pas de véhicule
                                                    </span>
                                                @endif
                                            </div>
                                            <i class="fas fa-chevron-down ml-2"></i>
                                        </button>
                                        
                                        <!-- Menu dropdown -->
                                        <div class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden" 
                                            style="z-index: 1000;">
                                            <div class="py-1" role="menu">
                                                <a href="{{ route('dashboard') }}"
                                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                                    <i class="fas fa-tachometer-alt mr-2"></i>Tableau de bord
                                                </a>
                                                <a href="{{ route('profile.show') }}"
                                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                                    <i class="fas fa-user-edit mr-2"></i>Mon profil
                                                </a>
                                                @if(auth()->user()->vehicule)
                                                    <a href="{{ route('vehicule.show') }}"
                                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                                        <i class="fas fa-car mr-2"></i>Mon véhicule
                                                    </a>
                                                @else
                                                    <a href="{{ route('vehicule.create') }}"
                                                    class="block px-4 py-2 text-sm text-yellow-700 hover:bg-yellow-50" role="menuitem">
                                                        <i class="fas fa-car mr-2"></i>Ajouter véhicule
                                                    </a>
                                                @endif
                                                <div class="border-t border-gray-100"></div>
                                                <form method="POST" action="{{ route('logout') }}" class="block">
                                                    @csrf
                                                    <button type="submit"
                                                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" 
                                                            role="menuitem">
                                                        <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- Liens pour visiteurs non connectés -->
                                <div class="space-x-4">
                                    <a href="{{ route('login') }}"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        <i class="fas fa-sign-in-alt mr-2"></i>Connexion
                                    </a>
                                    <a href="{{ route('register') }}"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                        <i class="fas fa-user-plus mr-2"></i>Inscription
                                    </a>
                                </div>
                            @endauth
                        </div>

                        <!-- Menu mobile hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none"
                                    onclick="toggleMobileMenu()">
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Menu mobile (responsive) -->
                <div class="sm:hidden hidden" id="mobile-menu">
                    <div class="pt-2 pb-3 space-y-1">
                        <a href="{{ url('/') }}"
                        class="block pl-3 pr-4 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                            <i class="fas fa-home mr-2"></i>Accueil
                        </a>
                        <a href="{{ route('trajets.index') }}"
                        class="block pl-3 pr-4 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                            <i class="fas fa-route mr-2"></i>Trajets disponibles
                        </a>
                        
                        @auth
                            @if(auth()->user()->vehicule)
                                <a href="{{ route('trajets.create') }}"
                                class="block pl-3 pr-4 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                                    <i class="fas fa-plus-circle mr-2"></i>Proposer un trajet
                                </a>
                            @endif
                            
                            <a href="{{ route('trajets.mes') }}"
                            class="block pl-3 pr-4 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                                <i class="fas fa-history mr-2"></i>Mes trajets
                            </a>
                            
                            <div class="border-t border-gray-200 pt-4 pb-3">
                                <div class="px-4">
                                    <div class="text-base font-medium text-gray-800">{{ auth()->user()->prenom ?? auth()->user()->name }}</div>
                                    <div class="text-sm font-medium text-gray-500">{{ auth()->user()->email }}</div>
                                </div>
                                <div class="mt-3 space-y-1">
                                    <a href="{{ route('dashboard') }}"
                                    class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                                        <i class="fas fa-tachometer-alt mr-2"></i>Tableau de bord
                                    </a>
                                    <a href="{{ route('profile.show') }}"
                                    class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                                        <i class="fas fa-user-edit mr-2"></i>Mon profil
                                    </a>
                                    @if(auth()->user()->vehicule)
                                        <a href="{{ route('vehicule.show') }}"
                                        class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                                            <i class="fas fa-car mr-2"></i>Mon véhicule
                                        </a>
                                    @else
                                        <a href="{{ route('vehicule.create') }}"
                                        class="block px-4 py-2 text-base font-medium text-yellow-600 hover:text-yellow-800 hover:bg-yellow-50">
                                            <i class="fas fa-car mr-2"></i>Ajouter véhicule
                                        </a>
                                    @endif
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                                class="w-full text-left block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                                            <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="pt-4 pb-3 border-t border-gray-200">
                                <div class="space-y-1">
                                    <a href="{{ route('login') }}"
                                    class="block pl-3 pr-4 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                                        <i class="fas fa-sign-in-alt mr-2"></i>Connexion
                                    </a>
                                    <a href="{{ route('register') }}"
                                    class="block pl-3 pr-4 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                                        <i class="fas fa-user-plus mr-2"></i>Inscription
                                    </a>
                                </div>
                            </div>
                        @endauth
                    </div>
                </div>
            </nav>

            <!-- Messages flash améliorés -->
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-400 p-4">
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
            
            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif
            
            @if(session('warning'))
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
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

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="py-6">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    @yield('content')
                </div>
            </main>
        </div>
        
        @stack('scripts')
        
        <script>
            // Menu mobile
            function toggleMobileMenu() {
                const mobileMenu = document.getElementById('mobile-menu');
                mobileMenu.classList.toggle('hidden');
            }
            
            // Menu dropdown desktop
            document.addEventListener('DOMContentLoaded', function() {
                const dropdownButton = document.querySelector('.dropdown button');
                const dropdownMenu = document.querySelector('.dropdown > div:last-child');
                
                if (dropdownButton) {
                    dropdownButton.addEventListener('click', function(e) {
                        e.stopPropagation();
                        dropdownMenu.classList.toggle('hidden');
                    });
                    
                    // Fermer le dropdown en cliquant ailleurs
                    document.addEventListener('click', function(e) {
                        if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
                            dropdownMenu.classList.add('hidden');
                        }
                    });
                }
            });
            
            // Fermer automatiquement les messages après 5 secondes
            setTimeout(function() {
                const alerts = document.querySelectorAll('[role="alert"], .bg-green-50, .bg-red-50, .bg-yellow-50');
                alerts.forEach(alert => {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                });
            }, 5000);
        </script>
    </body>
</html>