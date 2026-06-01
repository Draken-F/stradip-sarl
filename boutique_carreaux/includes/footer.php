<footer class="bg-[#0f172a] text-gray-300 pt-16 pb-8 border-t border-slate-800">
    <div class="max-w-7xl mx-auto px-4 md:px-16 lg:px-24">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">

            <div class="space-y-6">
                <a href="index.php" class="logo-font text-2xl font-bold text-white tracking-wider">
                    NOUPA<span class="text-amber-500">CERAMIC</span>
                </a>
                <p class="text-sm leading-relaxed text-gray-400 font-light">
                    Spécialiste de l'importation de carrelages et marbres de premier choix au Cameroun. L'excellence italienne et espagnole au service de vos projets.
                </p>
            </div>

            <div class="lg:ml-12">
                <h3 class="text-white font-bold uppercase tracking-[3px] text-[0.7rem] mb-6 border-b border-amber-500/30 pb-2 inline-block">Collections</h3>
                <ul class="space-y-4 text-sm font-light">
                    <li><a href="catalogue.php?cat=1" class="hover:text-amber-500 transition-colors">Marbre Royal</a></li>
                    <li><a href="catalogue.php?cat=2" class="hover:text-amber-500 transition-colors">Pierre Naturelle</a></li>
                    <li><a href="catalogue.php?type=Sol" class="hover:text-amber-500 transition-colors">Sols Intérieurs</a></li>
                    <li><a href="catalogue.php?deco=Décoratif" class="hover:text-amber-500 transition-colors">Pièces Décoratives</a></li>
                </ul>
            </div>

            <div class="lg:ml-12">
                <h3 class="text-white font-bold uppercase tracking-[3px] text-[0.7rem] mb-6 border-b border-amber-500/30 pb-2 inline-block">Entreprise</h3>
                <ul class="space-y-4 text-sm font-light">
                    <li><a href="index.php" class="hover:text-amber-500 transition-colors">Accueil</a></li>
                    <li><a href="catalogue.php" class="hover:text-amber-500 transition-colors">Notre Catalogue</a></li>
                    <li><a href="projets.php" class="hover:text-amber-500 transition-colors">Nos Réalisations</a></li>
                    <li><a href="accessoires.php" class="hover:text-amber-500 transition-colors">Autre produit</a></li>
                    <li><a href="#contact" class="hover:text-amber-500 transition-colors">Contact</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-white font-bold uppercase tracking-[3px] text-[0.7rem] mb-6 border-b border-amber-500/30 pb-2 inline-block">Nos Agences</h3>
                <div class="space-y-8 text-sm font-light">

                    <div class="space-y-2">
                        <p class="text-amber-500 font-bold text-[0.6rem] uppercase tracking-widest">Douala (Siège)</p>
                        <p class="flex items-start">
                            <span class="mr-3">📍</span> Akwa, Boulevard de la Liberté
                        </p>
                        <p class="flex items-center">
                            <span class="mr-3">📞</span> +237 6XX XXX XXX
                        </p>
                    </div>

                    <div class="space-y-2">
                        <p class="text-amber-500 font-bold text-[0.6rem] uppercase tracking-widest">Yaoundé</p>
                        <p class="flex items-start">
                            <span class="mr-3">📍</span> Bastos, Rue de la Cascade
                        </p>
                        <p class="flex items-center">
                            <span class="mr-3">📞</span> +237 6XX XXX XXX
                        </p>
                    </div>

                    <!-- <div class="pt-4 border-t border-slate-800">
                        <p class="flex items-center text-gray-400 italic">
                            <span class="mr-3">✉️</span> contact@noupaceramic.com
                        </p>
                    </div> -->
                </div>
            </div>

        </div>

        <div class="pt-8 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center text-[0.65rem] text-gray-500 uppercase tracking-widest">
            <p>&copy; <?php echo date('Y'); ?> NOUPA CERAMIC. Tous droits réservés.</p>
            <p class="mt-4 md:mt-0">Design & Développement par <span class="text-white font-bold">Ton Nom</span></p>
        </div>
    </div>
</footer>

<script>
    // Smooth scroll pour les ancres
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
</script>