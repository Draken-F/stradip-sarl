<?php 
include 'includes/header.php'; 

// 1. Récupération de l'accessoire
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$stmt = $pdo->prepare("SELECT * FROM accessoires WHERE id = ?");
$stmt->execute([$id]);
$acc = $stmt->fetch();

// Redirection si l'accessoire n'existe pas
if (!$acc) {
    header('Location: boutique.php');
    exit;
}

// 2. Produits suggérés (même catégorie)
$stmtSim = $pdo->prepare("SELECT * FROM accessoires WHERE categorie_acc = ? AND id != ? LIMIT 4");
$stmtSim->execute([$acc['categorie_acc'], $id]);
$suggestions = $stmtSim->fetchAll();
?>

<main class="min-h-screen bg-white pb-24">
    <nav class="max-w-7xl mx-auto px-4 md:px-12 py-8 text-[0.6rem] uppercase tracking-[3px] text-gray-400">
        <a href="index.php" class="hover:text-amber-600 transition">Accueil</a>
        <span class="mx-3">/</span>
        <a href="boutique.php" class="hover:text-amber-600 transition">Boutique Technique</a>
        <span class="mx-3">/</span>
        <span class="text-slate-900 font-black"><?= htmlspecialchars($acc['nom']) ?></span>
    </nav>

    <div class="max-w-7xl mx-auto px-4 md:px-12">
        <div class="flex flex-col lg:flex-row gap-16 items-start">
            
            <div class="lg:w-1/2 w-full bg-slate-50 border border-slate-100">
                <div class="relative group overflow-hidden bg-slate-100 aspect-[8/6] border border-slate-100">
                    <img src="assets/img/<?= $acc['image_url'] ?>" 
                         alt="<?= htmlspecialchars($acc['nom']) ?>" 
                         class="w-full h-full object-cover transition-transform duration-700 hover:scale-105">
                </div>
            </div>

            <div class="lg:w-1/2 w-full space-y-10">
                <div class="space-y-4">
                    <!-- <span class="bg-amber-100 text-amber-800 text-[0.6rem] font-black px-3 py-1 uppercase tracking-widest rounded-full">
                        <?= htmlspecialchars($acc['categorie_acc']) ?>
                    </span> -->
                    <h1 class="logo-font text-4xl md:text-5xl font-bold text-slate-900 leading-tight uppercase">
                        <?= htmlspecialchars($acc['nom']) ?>
                    </h1>
                    
                    <div class="flex items-baseline space-x-4">
                        <!-- <span class="text-3xl font-black text-slate-900">
                            <?= number_format($acc['prix'], 0, ',', ' ') ?> 
                            <span class="text-sm font-normal text-gray-400">FCFA</span>
                        </span> -->
                        <!-- <?php if($acc['stock'] > 0): ?>
                            <span class="text-green-500 text-[0.6rem] font-bold uppercase tracking-widest flex items-center">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span> En Stock
                            </span>
                        <?php else: ?>
                            <span class="text-red-500 text-[0.6rem] font-bold uppercase tracking-widest">Épuisé</span>
                        <?php endif; ?> -->
                    </div>
                </div>

                <div class="prose prose-slate">
                    <h3 class="text-[0.7rem] font-black uppercase tracking-[3px] text-slate-900 mb-4 border-b pb-2">Description du produit</h3>
                    <p class="text-gray-500 font-light leading-relaxed">
                        <?= nl2br(htmlspecialchars($acc['description'])) ?>
                    </p>
                </div>

                <div class="pt-6">
                    <a href="https://wa.me/2376XXXXXXXX?text=Bonjour, je souhaite commander : <?= urlencode($acc['nom']) ?> (Prix: <?= $acc['prix'] ?> FCFA)" 
                       class="flex items-center justify-center w-full bg-slate-900 text-white py-5 px-8 text-[0.7rem] font-black uppercase tracking-[3px] hover:bg-amber-600 transition-all duration-300 group">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.417-.003 6.557-5.338 11.892-11.893 11.892-1.997-.001-3.951-.5-5.688-1.448l-6.305 1.652zm6.599-3.835l.354.21c1.425.848 3.067 1.297 4.75 1.298 5.301 0 9.613-4.313 9.615-9.613.002-2.568-1.002-4.983-2.826-6.809-1.825-1.826-4.242-2.83-6.808-2.831-5.304 0-9.615 4.313-9.618 9.614-.002 1.849.528 3.653 1.535 5.239l.233.366-1.008 3.685 3.769-.989z"/></svg>
                        Commander via WhatsApp
                    </a>
                </div>
            </div>
        </div>

        <?php if ($suggestions): ?>
        <section class="mt-32 pt-16 border-t border-slate-100">
            <h2 class="logo-font text-2xl font-bold text-slate-900 mb-12 uppercase">Vous pourriez aussi avoir besoin</h2>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 ">
                <?php foreach($suggestions as $s): ?>
                <a href="fiche_accessoire.php?id=<?= $s['id'] ?>" class="group block bg-slate-50 ">
                    <div class="aspect-square overflow-hidden bg-slate-50 mb-4 border border-slate-100 p-1">
                        <img src="assets/img/autre/<?= $s['image_url'] ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                    </div>
                    <h4 class="text-xs font-bold uppercase tracking-widest text-slate-800 p-2 pt-0"><?= htmlspecialchars($s['nom']) ?></h4>
                </a>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>