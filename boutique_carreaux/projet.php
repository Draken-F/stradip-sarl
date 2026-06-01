<?php
include 'includes/header.php';

// 1. Récupération de toutes les réalisations
// On les trie par date pour avoir les plus récentes en haut
$stmt = $pdo->query("SELECT * FROM realisations ORDER BY date_ajout DESC");
$projets = $stmt->fetchAll();
?>


<main class="min-h-screen bg-white pb-32">
    <header class="bg-slate-50 py-24 border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 md:px-12 text-center">
            <h1 class="logo-font text-5xl md:text-7xl font-bold text-slate-900 uppercase tracking-[1px]">
                Réalisations
            </h1>
            <div class="h-1 w-16 bg-amber-600 mx-auto mt-6 "></div>
        </div>
    </header>

    <section class="max-w-[1600px] mx-auto px-4 md:px-12 py-20">

        <?php if (count($projets) > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-20">
                <?php foreach ($projets as $index => $p): ?>

                    <a href="projet_detail.php?id=<?= $p['id'] ?>" class="group block relative">
                        <div class="overflow-hidden bg-slate-100 aspect-video lg:aspect-[16/9] shadow-sm group-hover:shadow-2xl transition-all duration-700">
                            <img src="assets/img/realisations/<?= $p['image_globale'] ?>"
                                alt="<?= htmlspecialchars($p['nom']) ?>"
                                class="w-full h-full object-cover transition-transform duration-[2s] group-hover:scale-110">
                        </div>

                        <div class="mt-8 flex justify-between items-start">
                            <div class="space-y-2">
                                <span class="text-[0.6rem] font-black uppercase tracking-[3px] text-amber-600">
                                    <?= htmlspecialchars($p['ville'] ?? 'Localisation') ?>
                                </span>
                                <h3 class="text-2xl font-bold text-slate-900 uppercase tracking-tight group-hover:text-amber-600 transition-colors">
                                    <?= htmlspecialchars($p['nom']) ?>
                                </h3>
                                <div class="h-[1px] w-12 bg-slate-200 group-hover:w-full transition-all duration-700"></div>
                            </div>

                            <div class="w-12 h-12 rounded-full border border-slate-200 flex items-center justify-center group-hover:bg-slate-900 group-hover:text-white transition-all duration-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="py-40 text-center border-2 border-dashed border-slate-100 rounded-3xl">
                <p class="text-gray-400 font-light italic">Nos projets sont en cours de chargement...</p>
            </div>
        <?php endif; ?>

    </section>

    <section class="max-w-7xl mx-auto px-4 md:px-12 mt-20">
        <div class="bg-slate-900 p-12 md:p-20 text-center rounded-sm relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>

            <h2 class="logo-font text-3xl md:text-5xl text-white font-bold mb-8 uppercase tracking-tighter">
                Vous avez un projet <br> <span class="text-amber-500">en tête ?</span>
            </h2>
            <a href="contact.php" class="inline-block border border-white/30 text-white px-10 py-4 text-[0.7rem] font-black uppercase tracking-[3px] hover:bg-white hover:text-slate-900 transition-all duration-500">
                Parlons-en ensemble
            </a>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>