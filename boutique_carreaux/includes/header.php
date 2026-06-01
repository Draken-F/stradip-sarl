<?php include_once 'db.php'; ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NOUPA CERAMIC | Excellence en Carrelage</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@300;400;600&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .logo-font {
            font-family: 'Playfair Display', serif;
        }

        .header-transition {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900">

    <nav id="main-nav" class="header-transition fixed w-full top-0 z-50 bg-white/90 backdrop-blur-md border-b border-transparent">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-24">
            <div id="nav-container" class="header-transition flex justify-between items-center h-24">

                <div class="flex-shrink-0">
                    <a href="index.php" id="logo" class="header-transition logo-font text-3xl font-bold text-slate-800 tracking-tighter">
                        NOUPA<span class="text-amber-600">CERAMIC</span>
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-10">
                    <a href="index.php" class="relative group text-sm uppercase tracking-widest font-semibold text-slate-600 hover:text-slate-900 transition">
                        Accueil
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-amber-600 transition-all group-hover:w-full"></span>
                    </a>
                    <a href="catalogue.php" class="relative group text-sm uppercase tracking-widest font-semibold text-slate-600 hover:text-slate-900 transition">
                        Catalogue
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-amber-600 transition-all group-hover:w-full"></span>
                    </a>
                    <a href="projet.php" class="relative group text-sm uppercase tracking-widest font-semibold text-slate-600 hover:text-slate-900 transition">
                        Réalisations
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-amber-600 transition-all group-hover:w-full"></span>
                    </a>
                    <a href="accessoires.php" class="relative group text-sm uppercase tracking-widest font-semibold text-slate-600 hover:text-amber-600 transition">
                        autre-produit
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-amber-600 transition-all group-hover:w-full"></span>
                    </a>
                    <a href="#contact" class="px-6 py-2.5 bg-slate-900 text-white text-xs uppercase tracking-[2px] font-bold hover:bg-amber-600 transition-colors duration-300">
                        Contact
                    </a>
                </div>

                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="text-slate-800 focus:outline-none p-2">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path id="menu-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden bg-white border-b border-slate-100 shadow-xl">
            <div class="px-6 pt-2 pb-8 space-y-4">
                <a href="index.php" class="block text-sm uppercase tracking-widest font-bold text-slate-600 hover:text-amber-600 py-2">Accueil</a>
                <a href="catalogue.php" class="block text-sm uppercase tracking-widest font-bold text-slate-600 hover:text-amber-600 py-2">Catalogue</a>
                <a href="projets.php" class="block text-sm uppercase tracking-widest font-bold text-slate-600 hover:text-amber-600 py-2">Réalisations</a>
                <a href="boutique.php" class="block text-sm uppercase tracking-widest font-bold text-slate-600 hover:text-amber-600 py-2">Boutique Tech</a>
                <a href="#contact" class="block w-full text-center px-6 py-4 bg-slate-900 text-white text-xs uppercase tracking-[2px] font-bold">Contact</a>
            </div>
        </div>
    </nav>

    <script>
        // Logique du Scroll (Ton code existant)
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('main-nav');
            const container = document.getElementById('nav-container');
            const logo = document.getElementById('logo');

            if (window.scrollY > 50) {
                nav.classList.add('bg-white', 'shadow-lg', 'border-slate-100');
                container.classList.replace('h-24', 'h-16');
                logo.classList.replace('text-3xl', 'text-xl');
            } else {
                nav.classList.remove('bg-white', 'shadow-lg', 'border-slate-100');
                container.classList.replace('h-16', 'h-24');
                logo.classList.replace('text-xl', 'text-3xl');
            }
        });

        // NOUVEAU : Logique d'ouverture du Menu Mobile
        const btn = document.getElementById('mobile-menu-button');
        const menu = document.getElementById('mobile-menu');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });

        // Fermer le menu si on clique sur un lien (utile pour les ancres comme #contact)
        const links = menu.querySelectorAll('a');
        links.forEach(link => {
            link.addEventListener('click', () => {
                menu.classList.add('hidden');
            });
        });
    </script>

    <div class="h-24"></div>