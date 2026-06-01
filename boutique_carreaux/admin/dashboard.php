<?php
require_once 'auth.php'; // Protection de la page
require_once '../includes/db.php';

// Récupération des statistiques rapides
$countProduits = $pdo->query("SELECT COUNT(*) FROM produits")->fetchColumn();
$countProjets = $pdo->query("SELECT COUNT(*) FROM realisations")->fetchColumn();
$countAccessoires = $pdo->query("SELECT COUNT(*) FROM accessoires")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Noupa Ceramic</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@300;400;600&display=swap');

        .logo-font {
            font-family: 'Playfair Display', serif;
        }

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen flex">

    <aside class="w-64 bg-[#0f172a] text-white hidden md:flex flex-col">
        <div class="p-8">
            <h1 class="logo-font text-xl tracking-widest uppercase">
                NOUPA<span class="text-amber-500">ADMIN</span>
            </h1>
        </div>

        <nav class="flex-1 px-4 space-y-2">
            <a href="dashboard.php" class="block px-4 py-3 bg-amber-600 rounded-sm text-sm font-bold uppercase tracking-widest">Dashboard</a>
            <a href="manage_produits.php" class="block px-4 py-3 hover:bg-slate-800 rounded-sm text-sm font-medium text-slate-400 hover:text-white transition">Carreaux</a>
            <a href="manage_projets.php" class="block px-4 py-3 hover:bg-slate-800 rounded-sm text-sm font-medium text-slate-400 hover:text-white transition">Réalisations</a>
            <a href="manage_accessoires.php" class="block px-4 py-3 hover:bg-slate-800 rounded-sm text-sm font-medium text-slate-400 hover:text-white transition">Accessoires</a>
        </nav>

        <div class="p-4 border-t border-slate-800">
            <a href="logout.php" class="block px-4 py-3 text-red-400 hover:text-red-300 text-xs font-bold uppercase tracking-widest">Déconnexion</a>
        </div>
    </aside>

    <main class="flex-1 p-8 md:p-12">
        <header class="flex justify-between items-center mb-12">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 uppercase tracking-tighter">Tableau de bord</h2>
                <p class="text-slate-500 text-sm">Bienvenue, <?= $_SESSION['admin_name'] ?>.</p>
            </div>
            <div class="text-right">
                <p class="text-xs font-black uppercase tracking-widest text-slate-400"><?= date('d F Y') ?></p>
            </div>
        </header>



        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <div class="bg-white p-8 border border-slate-200 shadow-sm rounded-sm">
                <p class="text-[0.6rem] font-black uppercase tracking-widest text-amber-600 mb-2">Catalogue Carreaux</p>
                <h3 class="text-4xl font-bold text-slate-900"><?= $countProduits ?></h3>
                <p class="text-xs text-slate-400 mt-2">Articles en ligne</p>
            </div>
            <div class="bg-white p-8 border border-slate-200 shadow-sm rounded-sm">
                <p class="text-[0.6rem] font-black uppercase tracking-widest text-amber-600 mb-2">Chantiers / Projets</p>
                <h3 class="text-4xl font-bold text-slate-900"><?= $countProjets ?></h3>
                <p class="text-xs text-slate-400 mt-2">Réalisations exposées</p>
            </div>
            <div class="bg-white p-8 border border-slate-200 shadow-sm rounded-sm">
                <p class="text-[0.6rem] font-black uppercase tracking-widest text-amber-600 mb-2">Quincaillerie</p>
                <h3 class="text-4xl font-bold text-slate-900"><?= $countAccessoires ?></h3>
                <p class="text-xs text-slate-400 mt-2">Accessoires & Consommables</p>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-sm">
            <div class="p-6 border-b border-slate-100">
                <h3 class="font-bold text-slate-800 uppercase text-sm tracking-widest">Actions Rapides</h3>
            </div>
            <div class="p-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="add_produit.php" class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-slate-200 hover:border-amber-500 hover:bg-amber-50 transition rounded-sm group">
                    <span class="text-2xl mb-2 group-hover:scale-110 transition">📦</span>
                    <span class="text-[0.6rem] font-black uppercase tracking-widest text-slate-600">Nouveau Carreau</span>
                </a>
                <a href="add_projet.php" class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-slate-200 hover:border-amber-500 hover:bg-amber-50 transition rounded-sm group">
                    <span class="text-2xl mb-2 group-hover:scale-110 transition">🏗️</span>
                    <span class="text-[0.6rem] font-black uppercase tracking-widest text-slate-600">Nouvelle Réalisation</span>
                </a>
                <a href="add_accessoire.php" class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-slate-200 hover:border-amber-500 hover:bg-amber-50 transition rounded-sm group">
                    <span class="text-2xl mb-2 group-hover:scale-110 transition">🛠️</span>
                    <span class="text-[0.6rem] font-black uppercase tracking-widest text-slate-600">Nouvel Accessoire</span>
                </a>
                <a href="../index.php" target="_blank" class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-slate-200 hover:border-slate-900 hover:bg-slate-50 transition rounded-sm group">
                    <span class="text-2xl mb-2 group-hover:scale-110 transition">👁️</span>
                    <span class="text-[0.6rem] font-black uppercase tracking-widest text-slate-600">Voir le Site</span>
                </a>
            </div>
        </div>
    </main>

</body>

</html>