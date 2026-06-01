<?php include 'includes/header.php'; ?>

<section class="hero bg-[url('./assets/img/bg3.webp')] bg-no-repeat bg-center bg-cover flex items-end justify-start min-h-[90vh] w-full px-4 md:px-16 lg:px-24 pb-20 relative before:absolute before:inset-0 before:bg-gradient-to-r before:from-black/40 before:via-black/0 before:to-transparent before:z-0">
    <div class="hero-content max-w-[600px] z-10 relative text-left">
        <h1 class="logo-font text-5xl md:text-7xl text-white font-bold mb-6 leading-none ">
            L'essence de la<br>
            <span class="text-[#d97706]">matière.</span>
        </h1>
        <p class="text-white text-lg mb-10 max-w-lg leading-relaxed font-light sans-serif light/300">
            Solutions céramiques de haute performance pour l'architecture contemporaine.
        </p>
        <a href="catalogue.php" class="inline-block border-2 border-white text-white hover:bg-white hover:text-black transition-all duration-500 uppercase text-sm tracking-[3px] px-8 py-4 font-semibold">
            Explorer la collection
        </a>
    </div>
</section>

<section class="py-20 px-6 bg-[#f8fafc]">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-20">
            <h2 class="text-3xl md:text-4xl font-serif tracking-[5px] text-gray-900 leading-tight uppercase">
                Nos Domaines d'Application
            </h2>
            <div class="h-1 w-12 bg-amber-600 mx-auto mt-4 mb-4"></div>
            <p class="mt-6 text-sm text-gray-500 max-w-md mx-auto italic tracking-[1px]">
                Des solutions sur mesure pour sublimer chaque espace de vie et de travail.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

            <a href="catalogue.php?type=Sol" class="group flex flex-col">
                <div class="relative overflow-hidden rounded-sm aspect-[5/5] mb-6 shadow-md transition-shadow duration-500 group-hover:shadow-xl">
                    <img src="https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&q=80&w=1200" alt="Sols Intérieurs" class="h-full w-full object-cover" />
                    <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                </div>
                <div class="flex justify-between items-start px-1 transform transition-transform duration-500 group-hover:-translate-y-1">
                    <div>
                        <h3 class="text-xl font-serif text-gray-900 mb-1">Sols Intérieurs</h3>
                        <p class="text-[11px] tracking-widest text-gray-400 uppercase font-medium Sans-Serif">Salons, Chambres & Vie</p>
                    </div>
                    <span class="text-gray-400 group-hover:text-blue-600 transition-colors duration-300 pt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14m-7-7 7 7-7 7" />
                        </svg>
                    </span>
                </div>
            </a>

            <a href="catalogue.php?type=Mur" class="group flex flex-col">
                <div class="relative overflow-hidden rounded-sm aspect-[5/5] mb-6 shadow-md transition-shadow duration-500 group-hover:shadow-xl">
                    <img src="https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&q=80&w=1200" alt="Murs & Faïences" class="h-full w-full object-cover" />
                    <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                </div>
                <div class="flex justify-between items-start px-1 transform transition-transform duration-500 group-hover:-translate-y-1">
                    <div>
                        <h3 class="text-xl font-serif text-gray-900 mb-1">Murs & Faïences</h3>
                        <p class="text-[11px] tracking-widest text-gray-400 uppercase font-medium">Cuisines & Salles de bain</p>
                    </div>
                    <span class="text-gray-400 group-hover:text-blue-600 transition-colors duration-300 pt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14m-7-7 7 7-7 7" />
                        </svg>
                    </span>
                </div>
            </a>

            <a href="catalogue.php?piece=Outdoor" class="group flex flex-col">
                <div class="relative overflow-hidden rounded-sm aspect-[5/5] mb-6 shadow-md transition-shadow duration-500 group-hover:shadow-xl">
                    <img src="https://images.unsplash.com/photo-1563911892129-d4d754944883?auto=format&fit=crop&q=80&w=1200" alt="Extérieurs" class="h-full w-full object-cover" />
                    <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                </div>
                <div class="flex justify-between items-start px-1 transform transition-transform duration-500 group-hover:-translate-y-1">
                    <div>
                        <h3 class="text-xl font-serif text-gray-900 mb-1">Espaces Extérieurs</h3>
                        <p class="text-[11px] tracking-widest text-gray-400 uppercase font-medium">Piscines & Jardins</p>
                    </div>
                    <span class="text-gray-400 group-hover:text-blue-600 transition-colors duration-300 pt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14m-7-7 7 7-7 7" />
                        </svg>
                    </span>
                </div>
            </a>

            <a href="catalogue.php?deco=Décoratif" class="group flex flex-col">
                <div class="relative overflow-hidden rounded-sm aspect-[5/5] mb-6 shadow-md transition-shadow duration-500 group-hover:shadow-xl">
                    <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&q=80&w=1200" alt="Prestige" class="h-full w-full object-cover" />
                    <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                </div>
                <div class="flex justify-between items-start px-1 transform transition-transform duration-500 group-hover:-translate-y-1">
                    <div>
                        <h3 class="text-xl font-serif text-gray-900 mb-1">Prestige & Pro</h3>
                        <p class="text-[11px] tracking-widest text-gray-400 uppercase font-medium">Bureaux & Showrooms</p>
                    </div>
                    <span class="text-gray-400 group-hover:text-blue-600 transition-colors duration-300 pt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14m-7-7 7 7-7 7" />
                        </svg>
                    </span>
                </div>
            </a>

        </div>
    </div>
</section>

<?php
// Récupération des 3 dernières réalisations
$stmtReal = $pdo->query("SELECT * FROM realisations ORDER BY date_ajout DESC LIMIT 3");
$realisations = $stmtReal->fetchAll();
?>
<section class="section px-4 md:px-16 lg:px-24 py-24 bg-blue-50 text-slate-900">
    <div class="mb-16 text-center">
        <h2 class="text-3xl md:text-4xl font-serif uppercase tracking-[5px] text-gray-900">
            Réalisations d'Exception
        </h2>
        <div class="h-1 w-12 bg-amber-600 mx-auto mt-4 mb-4"></div>
        <p class="mt-6 text-sm text-gray-500 max-w-md mx-auto italic tracking-[1px]">
            L'excellence mise en œuvre dans vos projets
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        <?php foreach ($realisations as $r): ?>
            <a href="projet_detail.php?id=<?= $r['id'] ?>" class="group relative rounded-lg overflow-hidden bg-slate-200 aspect-[5/5] cursor-pointer block">

                <img src="assets/img/realisations/<?= $r['image_globale'] ?>"
                    alt="<?= htmlspecialchars($r['nom']) ?>"
                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">

                <div class="absolute inset-0 bg-slate-900/80 flex flex-col justify-end p-8 opacity-0 group-hover:opacity-100 transition-all duration-500 translate-y-4 group-hover:translate-y-0">
                    <span class="text-amber-500 text-[0.6rem] font-bold uppercase tracking-[3px] mb-2">Projet</span>

                    <h4 class="text-white text-xl font-bold mb-2">
                        <?= htmlspecialchars($r['nom']) ?> — <?= htmlspecialchars($r['ville']) ?>
                    </h4>

                    <p class="text-gray-300 text-sm font-light">
                        Découvrir l'étude de cas
                    </p>

                    <div class="w-8 h-[1px] bg-amber-500 mt-4 transition-all duration-500 group-hover:w-full"></div>
                </div>
            </a>
        <?php endforeach; ?>

        <?php if (empty($realisations)): ?>
            <p class="col-span-full text-center text-gray-400 italic">Aucune réalisation n'est encore enregistrée.</p>
        <?php endif; ?>

    </div>

    <div class="mt-16 text-center">
        <a href="projet.php" class="inline-block border-2 border-slate-900 text-slate-900 px-12 py-4 hover:bg-slate-900 hover:text-white transition-all duration-300 uppercase text-xs font-bold tracking-[3px]">
            Voir tous nos projets
        </a>
    </div>
</section>

<section id="contact" class="px-4 md:px-16 lg:px-24 py-24 bg-slate-50 text-slate-900">

    <div class="mb-20 text-center">
        <h2 class="text-3xl md:text-4xl uppercase text-gray-900 font-serif tracking-[8px] leading-tight">Contact & Accès</h2>
        <div class="h-1 w-16 bg-amber-600 mx-auto mt-6 mb-4"></div>
        <p class="mt-6 text-sm text-gray-500 max-w-md mx-auto italic tracking-[1px]">L'excellence céramique à votre portée</p>
    </div>

    <div class="max-w-[1600px] mx-auto grid grid-cols-1 lg:grid-cols-12 gap-16">

        <aside class="lg:col-span-4 space-y-8">
            <div class="bg-white p-10 rounded-2xl border border-slate-200 shadow-sm sticky top-28">
                <h3 class="text-[0.65rem] font-black uppercase tracking-[4px] text-amber-600 mb-10 border-b border-slate-50 pb-4">Service Client Central</h3>

                <div class="space-y-6 mb-12">
                    <p class="text-[0.6rem] font-black uppercase tracking-[2px] text-slate-400">Agence de Douala</p>
                    <div class="space-y-4">
                        <a href="tel:+2376XXXXXXXX" class="flex items-center group">
                            <div class="w-10 h-10 bg-slate-50 rounded-full flex items-center justify-center border border-slate-100 group-hover:border-amber-500 transition-all">
                                <svg class="w-4 h-4 text-slate-600 group-hover:text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <span class="ml-4 text-sm font-bold text-slate-800 tracking-tight group-hover:text-amber-600 transition-colors">+237 6XX XXX XXX</span>
                        </a>
                        <a href="https://wa.me/2376XXXXXXXX" class="flex items-center group">
                            <div class="w-10 h-10 bg-green-50 rounded-full flex items-center justify-center border border-green-100 group-hover:bg-green-500 transition-all">
                                <svg class="w-5 h-5 text-green-600 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.417-.003 6.557-5.338 11.892-11.893 11.892-1.997-.001-3.951-.5-5.688-1.448l-6.305 1.652zm6.599-3.835l.354.21c1.425.848 3.067 1.297 4.75 1.298 5.301 0 9.613-4.313 9.615-9.613.002-2.568-1.002-4.983-2.826-6.809-1.825-1.826-4.242-2.83-6.808-2.831-5.304 0-9.615 4.313-9.618 9.614-.002 1.849.528 3.653 1.535 5.239l.233.366-1.008 3.685 3.769-.989z" />
                                </svg>
                            </div>
                            <span class="ml-4 text-sm font-bold text-slate-800 tracking-tight group-hover:text-green-600 transition-colors">WhatsApp Douala</span>
                        </a>
                    </div>
                </div>

                <div class="space-y-6 mb-5">
                    <p class="text-[0.6rem] font-black uppercase tracking-[2px] text-slate-400">Agence de Yaoundé</p>
                    <div class="space-y-4">
                        <a href="tel:+2376XXXXXXXX" class="flex items-center group">
                            <div class="w-10 h-10 bg-slate-50 rounded-full flex items-center justify-center border border-slate-100 group-hover:border-amber-500 transition-all">
                                <svg class="w-4 h-4 text-slate-600 group-hover:text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <span class="ml-4 text-sm font-bold text-slate-800 tracking-tight group-hover:text-amber-600 transition-colors">+237 6XX XXX XXX</span>
                        </a>
                        <a href="https://wa.me/2376XXXXXXXX" class="flex items-center group">
                            <div class="w-10 h-10 bg-green-50 rounded-full flex items-center justify-center border border-green-100 group-hover:bg-green-500 transition-all">
                                <svg class="w-5 h-5 text-green-600 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.417-.003 6.557-5.338 11.892-11.893 11.892-1.997-.001-3.951-.5-5.688-1.448l-6.305 1.652zm6.599-3.835l.354.21c1.425.848 3.067 1.297 4.75 1.298 5.301 0 9.613-4.313 9.615-9.613.002-2.568-1.002-4.983-2.826-6.809-1.825-1.826-4.242-2.83-6.808-2.831-5.304 0-9.615 4.313-9.618 9.614-.002 1.849.528 3.653 1.535 5.239l.233.366-1.008 3.685 3.769-.989z" />
                                </svg>
                            </div>
                            <span class="ml-4 text-sm font-bold text-slate-800 tracking-tight group-hover:text-green-600 transition-colors">WhatsApp Yaoundé</span>
                        </a>
                    </div>
                </div>

                <div class="pt-8 border-t border-slate-100">
                    <p class="text-[0.6rem] font-black uppercase tracking-[2px] text-gray-400 mb-4 tracking-widest text-center">Horaires Showrooms</p>
                    <div class="flex gap-4 text-xs text-slate-700 mb-2 font-medium uppercase tracking-tighter">
                        <span>Lun - Ven</span>
                        <span class="text-slate-900 font-bold">08h00 - 18h00</span>
                    </div>
                    <div class="flex gap-7 text-xs text-slate-700 font-medium uppercase tracking-tighter">
                        <span>Samedi</span>
                        <span class="text-slate-900 font-bold">08h00 - 13h00</span>
                    </div>
                </div>
            </div>
        </aside>

        <div class="lg:col-span-8 space-y-16">

            <div class="space-y-8">
                <div class="flex items-center">
                    <span class="text-2xl mr-4">🏙️</span>
                    <h3 class="text-2xl font-bold uppercase tracking-[4px] text-slate-900 font-serif">Douala</h3>
                    <div class="ml-6 flex-grow h-[1px] bg-slate-200"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-white p-8 border border-slate-200 rounded-xl hover:border-amber-400 hover:shadow-2xl transition-all group duration-500">
                        <div class="flex justify-between items-start mb-6">
                            <span class="px-3 py-1 bg-amber-50 text-amber-700 text-[0.55rem] font-black uppercase tracking-widest rounded-full">Showroom</span>
                            <svg class="w-5 h-5 text-amber-500 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-slate-900 mb-3 text-xl uppercase tracking-tighter">Akwa - Liberté</h4>
                        <p class="text-sm text-gray-500 leading-relaxed font-light">Boulevard de la Liberté, face à l'Hôtel de l'Air. Exposition complète de nos collections exclusives.</p>
                    </div>

                    <div class="bg-slate-100/50 p-8 border border-slate-200 rounded-xl hover:bg-white hover:shadow-xl transition-all duration-500">
                        <span class="px-3 py-1 bg-blue-50 text-blue-700 text-[0.55rem] font-black uppercase tracking-widest rounded-full mb-6 inline-block">Dépôt</span>
                        <h4 class="font-bold text-slate-900 mb-3 text-xl uppercase tracking-tighter">Bonabéri</h4>
                        <p class="text-sm text-gray-400 leading-relaxed font-light">Ancienne route, 200m après le pont. Centre logistique pour enlèvements de grandes quantités.</p>
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                <div class="flex items-center">
                    <span class="text-2xl mr-4">🏛️</span>
                    <h3 class="text-2xl font-bold uppercase tracking-[4px] text-slate-900 font-serif">Yaoundé</h3>
                    <div class="ml-6 flex-grow h-[1px] bg-slate-200"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-white p-8 border border-slate-200 rounded-xl hover:border-amber-400 hover:shadow-2xl transition-all group duration-500">
                        <div class="flex justify-between items-start mb-6">
                            <span class="px-3 py-1 bg-amber-50 text-amber-700 text-[0.55rem] font-black uppercase tracking-widest rounded-full">Showroom Boutique</span>
                            <svg class="w-5 h-5 text-amber-500 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-slate-900 mb-3 text-xl uppercase tracking-tighter">Bastos - Cascade</h4>
                        <p class="text-sm text-gray-500 leading-relaxed font-light">Rue de la Cascade, Ambassade de Chine. Spécialisé dans le Marbre & formats Prestige.</p>
                    </div>

                    <div class="bg-slate-100/50 p-8 border border-slate-200 rounded-xl hover:bg-white hover:shadow-xl transition-all duration-500">
                        <span class="px-3 py-1 bg-blue-50 text-blue-700 text-[0.55rem] font-black uppercase tracking-widest rounded-full mb-6 inline-block">Dépôt</span>
                        <h4 class="font-bold text-slate-900 mb-3 text-xl uppercase tracking-tighter">Mvan</h4>
                        <p class="text-sm text-gray-400 leading-relaxed font-light">Entrée Sud de la ville, face à la gare routière. Hub de distribution pour la région Centre.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>