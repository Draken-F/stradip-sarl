<?php 
include 'includes/header.php'; 

// Récupération de tous les accessoires
$stmt = $pdo->query("SELECT * FROM accessoires ORDER BY categorie_acc ASC");
$accessoires = $stmt->fetchAll();
?>



<main class="bg-white min-h-screen pb-24">
    <header class="bg-slate-900 py-20 text-center text-white">
        <span class="text-amber-500 text-[0.6rem] font-black uppercase tracking-[5px] mb-4 block">Équipements & Matériaux</span>
        <h1 class="logo-font text-5xl font-bold uppercase tracking-tighter">Boutique Technique</h1>
        <p class="text-gray-400 mt-4 max-w-xl mx-auto font-light">Tout le nécessaire pour la pose de vos revêtements et l'équipement de vos chantiers.</p>
    </header>

    <div class="max-w-7xl mx-auto px-4 md:px-12 py-16">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            
            <?php foreach($accessoires as $acc): ?>
<a href="fiche_accessoire.php?id=<?= $acc['id'] ?>" class="group block bg-white border border-slate-100 hover:shadow-2xl transition-all duration-500 overflow-hidden">
    <div class="relative aspect-[5/4] overflow-hidden bg-slate-50">
        <img src="assets/img    /<?= $acc['image_url'] ?>" 
             alt="<?= $acc['nom'] ?>" 
             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
        
        <!-- <span class="absolute top-4 left-4 bg-slate-900 text-white text-[0.6rem] font-black px-2 py-1 uppercase tracking-widest">
            <?= htmlspecialchars($acc['categorie_acc']) ?>
        </span> -->
    </div>

    <div class="p-4 pt-2">
        <div class="flex justify-between items-center pt-4 border-t border-slate-50">
            <h3 class="text-lg font-bold text-slate-800 uppercase tracking-widest leading-none">
            <?= htmlspecialchars($acc['nom']) ?>
        </h3>
            <span class="ml-2 text-slate-300 group-hover:text-amber-600 transition-colors">→</span>
        </div>
    </div>
</a>
<?php endforeach; ?>

        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>