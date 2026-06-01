<?php
// On récupère le nom du fichier actuel pour savoir quel lien mettre en orange
$current_page = basename($_SERVER['PHP_SELF']);
?>
<aside class="w-64 bg-[#0f172a] text-white flex flex-col h-screen sticky top-0 shrink-0 shadow-2xl">
    <div class="p-8 border-b border-slate-800">
        <h1 class="logo-font text-xl tracking-widest uppercase">
            NOUPA<span class="text-amber-500">ADMIN</span>
        </h1>
        <p class="text-[0.5rem] text-slate-500 uppercase tracking-[3px] mt-1">Console de gestion</p>
    </div>

    <nav class="flex-1 px-4 py-8 space-y-2 overflow-y-auto">
        <a href="dashboard.php"
            class="block px-4 py-3 rounded-sm text-sm uppercase tracking-widest transition-all <?= $current_page == 'dashboard.php' ? 'bg-amber-600 font-bold text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' ?>">
            Dashboard
        </a>



        <a href="manage_produits.php"
            class="block px-4 py-3 rounded-sm text-sm uppercase tracking-widest transition-all <?= ($current_page == 'manage_produits.php' || $current_page == 'add_produit.php') ? 'bg-amber-600 font-bold text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' ?>">
            Carreaux
        </a>

        <a href="manage_accessoires.php"
            class="block px-4 py-3 rounded-sm text-sm uppercase tracking-widest transition-all <?= $current_page == 'manage_accessoires.php' ? 'bg-amber-600 font-bold text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' ?>">
            Accessoires
        </a>



        <a href="manage_projets.php"
            class="block px-4 py-3 rounded-sm text-sm uppercase tracking-widest transition-all <?= $current_page == 'manage_projets.php' ? 'bg-amber-600 font-bold text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' ?>">
            Réalisations
        </a>
    </nav>

    <div class="p-4 border-t border-slate-800 space-y-2">
        <a href="../index.php" target="_blank" class="block px-4 py-3 text-slate-400 hover:text-white text-[0.6rem] font-bold uppercase tracking-widest transition">
            👁️ Voir le site public
        </a>
        <a href="logout.php" class="block px-4 py-3 text-red-400 hover:bg-red-950/30 rounded-sm text-[0.6rem] font-bold uppercase tracking-widest transition">
            🚪 Déconnexion
        </a>
    </div>
</aside>