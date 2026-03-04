<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Covoiturage Local - Lomé</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <style>
            /* Styles simplifiés */
            body { 
                font-family: 'Figtree', sans-serif; 
                margin: 0; 
                padding: 0; 
                background: #f8fafc; 
                color: #334155; 
            }
            
            .container { 
                max-width: 1200px; 
                margin: 0 auto; 
                padding: 0 20px; 
            }
            
            .btn { 
                display: inline-block; 
                padding: 10px 20px; 
                border-radius: 8px; 
                font-weight: 500; 
                text-decoration: none; 
                transition: 0.2s; 
                border: none;
                cursor: pointer;
                font-size: 14px;
            }
            
            .btn-primary { 
                background: #3b82f6; 
                color: white; 
            }
            
            .btn-primary:hover { 
                background: #2563eb; 
            }
            
            .btn-secondary { 
                background: #10b981; 
                color: white; 
            }
            
            .btn-secondary:hover { 
                background: #059669; 
            }
            
            .hero { 
                background: linear-gradient(135deg, #3b82f6, #1d4ed8); 
                color: white; 
                padding: 80px 20px; 
                text-align: center; 
            }
            
            .card { 
                background: white; 
                border-radius: 12px; 
                padding: 30px; 
                box-shadow: 0 5px 15px rgba(0,0,0,0.05); 
                margin: 20px 0; 
            }
            
            .feature { 
                text-align: center; 
                margin: 30px 0; 
            }
            
            .feature-icon { 
                font-size: 40px; 
                color: #3b82f6; 
                margin-bottom: 15px; 
            }
            
            /* NAVIGATION */
            .nav { 
                display: flex; 
                justify-content: space-between; 
                align-items: center; 
                padding: 20px 0;
            }
            
            .logo { 
                font-size: 24px; 
                font-weight: bold; 
                color: #3b82f6; 
                display: flex;
                align-items: center;
                gap: 10px;
            }
            
            .footer { 
                text-align: center; 
                padding: 40px 20px; 
                color: #64748b; 
                border-top: 1px solid #e2e8f0; 
                margin-top: 60px; 
            }
            
            /* MENU DESKTOP */
            .desktop-menu {
                display: flex;
                align-items: center;
                gap: 25px;
            }
            
            .nav-links-container {
                display: flex;
                align-items: center;
                gap: 25px;
            }
            
            .main-links {
                display: flex;
                align-items: center;
                gap: 20px;
            }
            
            .user-links {
                display: flex;
                align-items: center;
                gap: 15px;
            }
            
            .nav-link {
                color: #64748b; 
                text-decoration: none; 
                font-weight: 500;
                transition: color 0.2s;
                display: flex;
                align-items: center;
                gap: 6px;
                white-space: nowrap;
            }
            
            .nav-link:hover { 
                color: #3b82f6; 
            }
            
            /* Bouton déconnexion */
            .logout-btn {
                background: none;
                border: none;
                color: #64748b;
                cursor: pointer;
                font-family: inherit;
                font-size: inherit;
                padding: 0;
                margin: 0;
                font-weight: 500;
                display: flex;
                align-items: center;
                gap: 6px;
            }
            
            .logout-btn:hover {
                color: #3b82f6;
            }
            
            /* MENU MOBILE - HAMBURGER */
            .mobile-menu-btn {
                display: none;
                background: none;
                border: none;
                color: #64748b;
                font-size: 24px;
                cursor: pointer;
                padding: 10px;
            }
            
            .mobile-menu {
                display: none;
                position: absolute;
                top: 80px;
                left: 0;
                right: 0;
                background: white;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                z-index: 1000;
                padding: 20px;
                border-top: 1px solid #e2e8f0;
            }
            
            .mobile-menu.active {
                display: block;
            }
            
            .mobile-nav-link {
                display: block;
                color: #64748b;
                text-decoration: none;
                padding: 12px 20px;
                font-weight: 500;
                transition: all 0.2s;
                border-radius: 6px;
                margin-bottom: 5px;
                display: flex;
                align-items: center;
                gap: 10px;
            }
            
            .mobile-nav-link:hover {
                background: #f1f5f9;
                color: #3b82f6;
            }
            
            .mobile-user-section {
                border-top: 1px solid #e2e8f0;
                margin-top: 15px;
                padding-top: 15px;
            }
            
            .mobile-logout-btn {
                display: block;
                width: 100%;
                text-align: left;
                background: none;
                border: none;
                color: #64748b;
                cursor: pointer;
                font-family: inherit;
                font-size: inherit;
                padding: 12px 20px;
                font-weight: 500;
                transition: all 0.2s;
                border-radius: 6px;
                margin-bottom: 5px;
                display: flex;
                align-items: center;
                gap: 10px;
            }
            
            .mobile-logout-btn:hover {
                background: #f1f5f9;
                color: #3b82f6;
            }
            
            /* Responsive */
            @media (max-width: 1024px) {
                .desktop-menu {
                    gap: 15px;
                }
                
                .nav-links-container {
                    gap: 15px;
                }
                
                .main-links, .user-links {
                    gap: 15px;
                }
            }
            
            @media (max-width: 768px) {
                .desktop-menu {
                    display: none;
                }
                
                .mobile-menu-btn {
                    display: block;
                }
            }
            
            /* Séparateur visuel */
            .nav-separator {
                width: 1px;
                height: 20px;
                background: #e2e8f0;
            }
        </style>
    </head>
    <body>
        <!-- Navigation -->
        <div class="container">
            <nav class="nav">
                <div class="logo">
                    <i class="fas fa-car"></i> Covoiturage Lomé
                </div>
                
                <!-- Menu Desktop -->
                <div class="desktop-menu">
                    <div class="nav-links-container">
                        <!-- Section des liens principaux -->
                        <div class="main-links">
                            <!-- Accueil -->
                            <a href="/" class="nav-link">
                                <i class="fas fa-home"></i> Accueil
                            </a>
                            
                            <!-- Trajets disponibles -->
                            <a href="{{ route('trajets.index') }}" class="nav-link">
                                <i class="fas fa-route"></i> Trajets disponibles
                            </a>
                            
                            <!-- Liens supplémentaires pour utilisateurs connectés -->
                            @auth
                                @if(auth()->user()->vehicule)
                                    <a href="{{ route('trajets.create') }}" class="nav-link">
                                        <i class="fas fa-plus-circle"></i> Proposer un trajet
                                    </a>
                                @endif
                                
                                <a href="{{ route('trajets.mes') }}" class="nav-link">
                                    <i class="fas fa-history"></i> Mes trajets
                                </a>
                            @endauth
                        </div>
                        
                        <!-- Séparateur -->
                        <div class="nav-separator"></div>
                        
                        <!-- Section des liens utilisateur -->
                        <div class="user-links">
                            @auth
                                <a href="{{ route('dashboard') }}" class="nav-link">
                                    <i class="fas fa-tachometer-alt"></i> Tableau de bord
                                </a>
                                
                                <a href="{{ route('profile.edit') }}" class="nav-link">
                                    <i class="fas fa-user"></i> Mon profil
                                </a>
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="logout-btn">
                                        <i class="fas fa-sign-out-alt"></i> Déconnexion
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="nav-link">
                                    <i class="fas fa-sign-in-alt"></i> Connexion
                                </a>
                                
                                <a href="{{ route('register') }}" class="btn btn-primary">
                                    <i class="fas fa-user-plus"></i> Inscription
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
                
                <!-- Bouton Hamburger Mobile -->
                <button class="mobile-menu-btn" id="mobileMenuBtn">
                    <i class="fas fa-bars"></i>
                </button>
                
                <!-- Menu Mobile -->
                <div class="mobile-menu" id="mobileMenu">
                    <!-- Accueil -->
                    <a href="/" class="mobile-nav-link">
                        <i class="fas fa-home"></i> Accueil
                    </a>
                    
                    <!-- Trajets disponibles -->
                    <a href="{{ route('trajets.index') }}" class="mobile-nav-link">
                        <i class="fas fa-route"></i> Trajets disponibles
                    </a>
                    
                    <!-- Liens supplémentaires pour utilisateurs connectés -->
                    @auth
                        @if(auth()->user()->vehicule)
                            <a href="{{ route('trajets.create') }}" class="mobile-nav-link">
                                <i class="fas fa-plus-circle"></i> Proposer un trajet
                            </a>
                        @endif
                        
                        <a href="{{ route('trajets.mes') }}" class="mobile-nav-link">
                            <i class="fas fa-history"></i> Mes trajets
                        </a>
                    @endauth
                    
                    <!-- Section utilisateur -->
                    <div class="mobile-user-section">
                        @auth
                            <a href="{{ route('dashboard') }}" class="mobile-nav-link">
                                <i class="fas fa-tachometer-alt"></i> Tableau de bord
                            </a>
                            
                            <a href="{{ route('profile.edit') }}" class="mobile-nav-link">
                                <i class="fas fa-user"></i> Mon profil
                            </a>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="mobile-logout-btn">
                                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="mobile-nav-link">
                                <i class="fas fa-sign-in-alt"></i> Connexion
                            </a>
                            
                            <a href="{{ route('register') }}" class="mobile-nav-link" style="background: #3b82f6; color: white;">
                                <i class="fas fa-user-plus"></i> Inscription
                            </a>
                        @endauth
                    </div>
                </div>
            </nav>
        </div>

        <!-- Hero Section -->
        <section class="hero">
            <div class="container">
                <h1 style="font-size: 48px; font-weight: bold; margin-bottom: 20px;">
                    Covoiturage Local à Lomé
                </h1>
                <p style="font-size: 20px; max-width: 600px; margin: 0 auto 30px; opacity: 0.9;">
                    Partagez vos trajets quotidiens, réduisez vos frais de transport et favorisez la solidarité locale.
                </p>
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary" style="font-size: 18px;">
                        <i class="fas fa-tachometer-alt mr-2"></i> Accéder au tableau de bord
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-secondary" style="font-size: 18px;">
                        <i class="fas fa-user-plus mr-2"></i> Commencer gratuitement
                    </a>
                @endauth
            </div>
        </section>

        <!-- Features -->
        <div class="container">
            <div style="padding: 60px 0;">
                <h2 style="text-align: center; font-size: 36px; font-weight: bold; margin-bottom: 40px;">
                    Une solution simple et efficace
                </h2>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
                    <div class="card">
                        <div class="feature">
                            <div class="feature-icon">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <h3>Économique</h3>
                            <p>Divisez vos frais de transport par 2, 3 ou 4 selon le nombre de passagers.</p>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="feature">
                            <div class="feature-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <h3>Communautaire</h3>
                            <p>Rencontrez des voisins qui effectuent les mêmes trajets que vous.</p>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="feature">
                            <div class="feature-icon">
                                <i class="fas fa-leaf"></i>
                            </div>
                            <h3>Écologique</h3>
                            <p>Réduisez le nombre de véhicules sur la route et votre empreinte carbone.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA -->
        <div class="container">
            <div class="card" style="background: #0f172a; color: white; text-align: center;">
                <h2 style="font-size: 32px; margin-bottom: 20px;">Prêt à économiser sur vos trajets ?</h2>
                <p style="font-size: 18px; margin-bottom: 30px; opacity: 0.9;">
                    Inscrivez-vous en 2 minutes et commencez dès aujourd'hui.
                </p>
                @auth
                    <p>Vous êtes déjà connecté ! Accédez à votre tableau de bord pour gérer vos trajets.</p>
                @else
                    <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                        <a href="{{ route('register') }}" class="btn btn-secondary" style="font-size: 16px;">
                            <i class="fas fa-user-plus mr-2"></i> S'inscrire
                        </a>
                        <a href="{{ route('login') }}" class="btn" style="background: #374151; color: white; font-size: 16px;">
                            <i class="fas fa-sign-in-alt mr-2"></i> Se connecter
                        </a>
                    </div>
                @endauth
            </div>
        </div>

        <!-- Informations TP -->
        <div class="container">
            <div class="card" style="background: #fef3c7; border-left: 4px solid #f59e0b;">
                <h3 style="color: #92400e; margin-bottom: 15px;">
                    <i class="fas fa-info-circle mr-2"></i> Informations sur le projet
                </h3>
                <p style="color: #92400e; margin-bottom: 10px;">
                    <strong>Projet :</strong> Application de covoiturage local
                </p>
                <p style="color: #92400e; margin-bottom: 10px;">
                    <strong>Objectif :</strong> Permettre aux conducteurs de proposer des trajets et aux passagers de les consulter
                </p>
                <p style="color: #92400e;">
                    <strong>Fonctionnalités :</strong> Authentification, gestion de véhicules, création de trajets, liste publique
                </p>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <div style="margin-bottom: 20px;">
                    <div class="logo" style="justify-content: center; font-size: 20px;">
                        <i class="fas fa-car"></i> Covoiturage Lomé
                    </div>
                </div>
                <p style="margin-bottom: 20px;">
                    Projet académique Laravel - Application de covoiturage local
                </p>
                <div style="color: #94a3b8; font-size: 14px;">
                    &copy; {{ date('Y') }} Covoiturage Lomé. Tous droits réservés.
                </div>
            </div>
        </footer>

        <script>
            // Gestion du menu hamburger
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const mobileMenu = document.getElementById('mobileMenu');
            
            mobileMenuBtn.addEventListener('click', function() {
                mobileMenu.classList.toggle('active');
                
                // Changer l'icône
                const icon = mobileMenuBtn.querySelector('i');
                if (mobileMenu.classList.contains('active')) {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-times');
                } else {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            });
            
            // Fermer le menu en cliquant à l'extérieur
            document.addEventListener('click', function(event) {
                if (!mobileMenu.contains(event.target) && 
                    !mobileMenuBtn.contains(event.target) && 
                    mobileMenu.classList.contains('active')) {
                    mobileMenu.classList.remove('active');
                    const icon = mobileMenuBtn.querySelector('i');
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            });
            
            // Fermer le menu après avoir cliqué sur un lien (sur mobile)
            const mobileLinks = document.querySelectorAll('.mobile-nav-link, .mobile-logout-btn');
            mobileLinks.forEach(link => {
                link.addEventListener('click', function() {
                    mobileMenu.classList.remove('active');
                    const icon = mobileMenuBtn.querySelector('i');
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                });
            });
            
            // Animation simple
            document.addEventListener('DOMContentLoaded', function() {
                const cards = document.querySelectorAll('.card');
                cards.forEach(card => {
                    card.addEventListener('mouseenter', function() {
                        this.style.transform = 'translateY(-5px)';
                        this.style.transition = 'transform 0.2s';
                    });
                    card.addEventListener('mouseleave', function() {
                        this.style.transform = 'translateY(0)';
                    });
                });
            });
        </script>
    </body>
</html>