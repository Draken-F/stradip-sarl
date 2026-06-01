<?php 
include 'includes/header.php'; 

$id_projet = isset($_GET['id']) ? intval($_GET['id']) : 1;

// 1. Infos globales
$stmtProjet = $pdo->prepare("SELECT * FROM realisations WHERE id = ?");
$stmtProjet->execute([$id_projet]);
$projet = $stmtProjet->fetch();

if (!$projet) { echo "<script>window.location.href='index.php';</script>"; exit; }

// 2. Sections (Pièces)
$stmtSections = $pdo->prepare("SELECT * FROM realisation_sections WHERE realisation_id = ? ORDER BY ordre_affichage ASC");
$stmtSections->execute([$id_projet]);
$sections = $stmtSections->fetchAll();
?>

<main class="bg-white min-h-screen pb-32">
    <section class="relative h-[80vh]">
        <img src="assets/img/realisations/<?= $projet['image_globale'] ?>" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 flex items-end p-12">
            <h1 class="logo-font text-6xl text-white font-bold uppercase"><?= htmlspecialchars($projet['nom']) ?></h1>
        </div>
    </section>

    <div class="space-y-48 mt-32">
        <?php foreach($sections as $index => $section): 
            // On récupère TOUTES les photos de cette pièce
            $stmtPhotos = $pdo->prepare("SELECT image_url FROM realisation_section_photos WHERE section_id = ? ORDER BY ordre ASC");
            $stmtPhotos->execute([$section['id']]);
            $gallery = $stmtPhotos->fetchAll(PDO::FETCH_COLUMN);
            
            // On ajoute aussi l'image_ambiance par défaut au début de la galerie
            array_unshift($gallery, $section['image_ambiance']);

            $isEven = ($index % 2 == 0);
        ?>

        <section class="max-w-7xl mx-auto px-4 md:px-12">
            <div class="flex flex-col <?= $isEven ? 'lg:flex-row' : 'lg:flex-row-reverse' ?> gap-16">
                
                <div class="lg:w-3/5 space-y-4">
                    <div class="aspect-[4/3] overflow-hidden bg-slate-100 shadow-xl border border-slate-100">
                        <img id="mainImage_<?= $section['id'] ?>" 
                            src="assets/img/realisations/<?= $gallery[0] ?>" 
                            class="w-full h-full object-cover transition-all duration-500">
                    </div>
                    
                    <?php if(count($gallery) > 1): ?>
                    <div class="flex gap-4 overflow-x-auto pb-2 scrollbar-hide">
                        <?php foreach($gallery as $img): ?>
                        <button onclick="changePhoto(<?= $section['id'] ?>, 'assets/img/realisations/<?= $img ?>')" 
                                class="w-24 h-24 shrink-0 border-2 border-transparent hover:border-amber-600 focus:border-amber-600 transition overflow-hidden bg-slate-100">
                            <img src="assets/img/realisations/<?= $img ?>" class="w-full h-full object-cover opacity-70 hover:opacity-100">
                        </button>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="lg:w-2/5 space-y-8">
                    <h2 class="logo-font text-4xl font-bold text-slate-900 uppercase tracking-tighter"><?= htmlspecialchars($section['titre_piece']) ?></h2>
                    <p class="text-slate-500 leading-relaxed font-light"><?= htmlspecialchars($section['description']) ?></p>
                    
                    <div class="pt-8 border-t border-slate-100 space-y-4">
                        <h4 class="text-[0.6rem] font-black uppercase tracking-widest text-amber-600">Produits posés :</h4>
                        <?php
                        $stmtProd = $pdo->prepare("SELECT p.* FROM produits p JOIN realisation_produits rp ON p.id = rp.produit_id WHERE rp.section_id = ?");
                        $stmtProd->execute([$section['id']]);
                        $produits = $stmtProd->fetchAll();
                        foreach($produits as $p): ?>
                        <a href="produit.php?id=<?= $p['id'] ?>" class="flex items-center group bg-slate-50 p-3 hover:bg-white transition-all shadow-sm">
                            <img src="assets/img/<?= $p['image_url'] ?>" class="w-12 h-12 object-cover">
                            <div class="ml-4">
                                <p class="text-xs font-bold text-slate-800 uppercase"><?= $p['nom'] ?></p>
                                <p class="text-[0.6rem] text-gray-400">Voir les détails →</p>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
        <?php endforeach; ?>
    </div>
</main>

<script>
function changePhoto(sectionId, newSrc) {
    const mainImg = document.getElementById('mainImage_' + sectionId);
    mainImg.style.opacity = '0';
    setTimeout(() => {
        mainImg.src = newSrc;
        mainImg.style.opacity = '1';
    }, 300);
}
</script>

<?php include 'includes/footer.php'; ?>