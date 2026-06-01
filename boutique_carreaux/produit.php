<?php
include 'includes/header.php';

// 1. Récupération du produit
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Correction : Ajout du mot-clé JOIN
$stmt = $pdo->prepare("SELECT p.*, c.nom_matiere 
                        FROM produits p 
                        JOIN categories c ON p.categorie_id = c.id 
                        WHERE p.id = ?");
$stmt->execute([$id]);
$p = $stmt->fetch();

// Redirection si le produit n'existe pas
if (!$p) {
    header('Location: catalogue.php');
    exit;
}

// 2. Produits similaires (même catégorie)
$stmtSim = $pdo->prepare("SELECT * FROM produits WHERE categorie_id = ? AND id != ? LIMIT 4");
$stmtSim->execute([$p['categorie_id'], $id]);
$similaires = $stmtSim->fetchAll();
?>



<main class="min-h-screen bg-white pb-24">
    <div></div>
    <!-- <nav class="max-w-7xl mx-auto px-4 md:px-12 py-8 text-[0.6rem] uppercase tracking-[3px] text-gray-400">
        <a href="index.php" class="hover:text-amber-600 transition">Accueil</a>
        <span class="mx-3">/</span>
        <a href="catalogue.php" class="hover:text-amber-600 transition">Catalogue</a>
        <span class="mx-3">/</span>
        <span class="text-slate-900 font-black"><?= htmlspecialchars($p['nom']) ?></span>
    </nav> -->

    <div class="max-w-7xl mx-auto px-4 md:px-12 mt-16">
        <div class="flex flex-col lg:flex-row gap-16">

            <div class="lg:w-3/5">
                <div class="relative group overflow-hidden bg-slate-100 aspect-[8/6] border border-slate-100 shadow-2xl">
                    <img src="assets/img/<?= $p['image_url'] ?>"
                        alt="<?= htmlspecialchars($p['nom']) ?>"
                        class="w-full h-full object-cover transition-transform duration-700 hover:scale-105">

                    <div class="absolute top-6 left-6">
                        <span class="bg-white/90 backdrop-blur px-4 py-2 text-[0.6rem] font-black uppercase tracking-widest text-slate-900 border border-slate-200">
                            <?= $p['stock'] > 0 ? 'En Stock' : 'Sur Commande' ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="lg:w-2/5 space-y-10">
                <div class="space-y-4">
                    <h1 class="logo-font text-5xl font-bold text-slate-900 leading-none uppercase tracking-tighter">
                        <?= htmlspecialchars($p['nom']) ?>
                        </h3>
                        <p class="text-gray-500 font-light leading-relaxed">
                            <?= htmlspecialchars($p['description'] ?? "Une sélection exclusive offrant une esthétique intemporelle et une durabilité exceptionnelle pour tous vos projets d'architecture.") ?>
                        </p>
                </div>
                <div class="border-y border-slate-100 py-8 space-y-6">
                    <h3 class="text-[0.7rem] font-black uppercase tracking-[3px] text-slate-900">Spécifications Techniques</h3>

                    <div class="grid grid-cols-2 gap-y-6">
                        <div>
                            <p class="text-[0.6rem] text-gray-400 uppercase tracking-widest mb-1">Référence</p>
                            <p class="text-sm font-bold text-slate-800"><?= htmlspecialchars($p['reference']) ?></p>
                        </div>

                        <div>
                            <p class="text-[0.6rem] text-gray-400 uppercase tracking-widest mb-1">Dimensions</p>
                            <p class="text-sm font-bold text-slate-800"><?= htmlspecialchars($p['dimension']) ?> cm</p>
                        </div>

                        <div>
                            <p class="text-[0.6rem] text-gray-400 uppercase tracking-widest mb-1">Application</p>
                            <p class="text-sm font-bold text-slate-800"><?= htmlspecialchars($p['type_pose']) ?></p>
                        </div>

                        <div>
                            <p class="text-[0.6rem] text-gray-400 uppercase tracking-widest mb-1">Espaces</p>
                            <p class="text-sm font-bold text-slate-800"><?= htmlspecialchars($p['piece']) ?></p>
                        </div>

                        <div>
                            <p class="text-[0.6rem] text-gray-400 uppercase tracking-widest mb-1">Color</p>
                            <div class="flex items-center space-x-2">
                                <div class="w-5 h-5 rounded-full border border-slate-200 shadow-sm"
                                    style="background-color: <?= htmlspecialchars($p['couleur']) ?>;">
                                </div>
                                <p class="text-sm font-bold text-slate-800"><?= htmlspecialchars($p['couleur']) ?></p>
                            </div>
                        </div>

                        <div>
                            <p class="text-[0.6rem] text-gray-400 uppercase tracking-widest mb-1">Product effects</p>
                            <p class="text-sm font-bold text-slate-800"><?= htmlspecialchars($p['nom_matiere']) ?></p>
                        </div>
                    </div>
                </div>

                <div class="space-y-4 pt-4">
                    <a href="https://wa.me/2376XXXXXXXX?text=Bonjour, je souhaite obtenir un devis pour le modèle <?= urlencode($p['nom']) ?> (Réf: <?= $p['reference'] ?>)"
                        class="flex items-center justify-center w-full bg-slate-900 text-white py-5 px-8 text-[0.7rem] font-black uppercase tracking-[3px] hover:bg-amber-600 transition-all duration-300 group">
                        <span>Demander un devis via WhatsApp</span>
                        <svg class="w-4 h-4 ml-3 transform group-hover:translate-x-1 transition" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.417-.003 6.557-5.338 11.892-11.893 11.892-1.997-.001-3.951-.5-5.688-1.448l-6.305 1.652zm6.599-3.835l.354.21c1.425.848 3.067 1.297 4.75 1.298 5.301 0 9.613-4.313 9.615-9.613.002-2.568-1.002-4.983-2.826-6.809-1.825-1.826-4.242-2.83-6.808-2.831-5.304 0-9.615 4.313-9.618 9.614-.002 1.849.528 3.653 1.535 5.239l.233.366-1.008 3.685 3.769-.989z" />
                        </svg>
                    </a>
                    <!-- <p class="text-[0.6rem] text-center text-gray-400 uppercase tracking-widest italic">Réponse moyenne sous 30 minutes (Showroom Douala/Yaoundé)</p> -->
                </div>
            </div>
        </div>

        <?php if ($similaires): ?>
            <section class="mt-32 pt-16 border-t border-slate-100">
                <h2 class="logo-font text-3xl font-bold text-slate-900 mb-12 uppercase">Modèles Similaires</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <?php foreach ($similaires as $s): ?>
                        <a href="produit.php?id=<?= $s['id'] ?>" class="group block">
                            <div class="aspect-[4/4] overflow-hidden bg-slate-50 mb-4 border border-slate-100">
                                <img src="assets/img/<?= $s['image_url'] ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                            </div>
                            <h4 class="text-xs font-bold uppercase tracking-widest text-slate-800"><?= htmlspecialchars($s['nom']) ?></h4>
                            <p class="text-[0.6rem] text-gray-400 uppercase tracking-[2px] mt-1"><?= htmlspecialchars($s['dimension']) ?></p>
                        </a>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>