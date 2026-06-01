<?php
// 1. Inclusion du header (qui contient la connexion PDO et le début du HTML)
include 'includes/header.php';

// --- CONFIGURATION PAGINATION ---
$items_per_page = 12;
$current_page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($current_page - 1) * $items_per_page;

// --- RÉCUPÉRATION DES FILTRES ---
$f_type  = $_GET['type'] ?? '';
$f_piece = $_GET['piece'] ?? '';
$f_cat   = $_GET['cat'] ?? '';
$f_color = $_GET['color'] ?? '';
$f_deco  = $_GET['deco'] ?? ''; // Nouveau filtre Décoration

// --- 1. COMPTER LE TOTAL ---
$count_sql = "SELECT COUNT(*) FROM produits p WHERE 1=1";
$params = [];

if ($f_type) {
    $count_sql .= " AND p.type_pose = ?";
    $params[] = $f_type;
}
if ($f_piece) {
    $count_sql .= " AND p.piece LIKE ?";
    $params[] = "%$f_piece%";
}
if ($f_cat) {
    $count_sql .= " AND p.categorie_id = ?";
    $params[] = $f_cat;
}
if ($f_color) {
    $count_sql .= " AND p.couleur = ?";
    $params[] = $f_color;
}
if ($f_deco) {
    $count_sql .= " AND p.style = ?";
    $params[] = $f_deco;
}

$stmt_count = $pdo->prepare($count_sql);
$stmt_count->execute($params);
$total_items = $stmt_count->fetchColumn();
$total_pages = ceil($total_items / $items_per_page);

// --- 2. RÉCUPÉRER LES PRODUITS ---
$sql = "SELECT p.*, c.nom_matiere FROM produits p 
        JOIN categories c ON p.categorie_id = c.id 
        WHERE 1=1";

if ($f_type) {
    $sql .= " AND p.type_pose = ?";
}
if ($f_piece) {
    $sql .= " AND p.piece LIKE ?";
}
if ($f_cat) {
    $sql .= " AND p.categorie_id = ?";
}
if ($f_color) {
    $sql .= " AND p.couleur = ?";
}
if ($f_deco) {
    $sql .= " AND p.style = ?";
}

$sql .= " ORDER BY p.date_ajout DESC LIMIT $items_per_page OFFSET $offset";

$categories = $pdo->query("SELECT * FROM categories ORDER BY nom_matiere ASC")->fetchAll();
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$produits = $stmt->fetchAll();
?>

<section class="relative h-[40vh] w-full flex flex-col bg-[url('https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=2070')] bg-fixed bg-center bg-cover overflow-hidden">
        
        <!-- OVERLAY (Pour la lisibilité du texte) -->
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-[1px]"></div>

        <!-- CONTENU (Z-10 pour être au-dessus de l'overlay) -->
        <div class="relative z-10 flex-grow flex flex-col items-center justify-center text-center max-w-6xl mx-auto px-6 animate-fade-up">
            
            <span class="text-amber-600 text-[0.65rem] font-black uppercase tracking-[5px] mb-4 block">Collections 2026</span>
            
            <h1 class="logo-font text-5xl md:text-6xl font-bold text-white tracking-[5px] uppercase">Le Catalogue</h1>
        </div>
    </section>

<main class="max-w-[1600px] mx-auto px-4 md:px-16 lg:px-12 py-12 min-h-screen mb-24">
    <div class="flex flex-col lg:flex-row">

        <aside class="w-full lg:w-80 shrink-0 lg:border-r lg:border-slate-200 lg:pr-12 lg:mr-12 pb-12 lg:pb-0">
            <form id="filterForm" method="GET" action="catalogue.php" class="space-y-12">

                <div>
                    <h3 class="text-[0.7rem] font-black uppercase tracking-[3px] text-amber-600 mb-5">Style & Décoration</h3>
                    <div class="flex flex-col space-y-3">
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="radio" name="deco" value="" <?= $f_deco == '' ? 'checked' : '' ?> class="w-4 h-4 accent-amber-600">
                            <span class="text-sm font-medium <?= $f_deco == '' ? 'text-slate-900' : 'text-gray-500' ?> group-hover:text-slate-900 transition">Tous les styles</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="radio" name="deco" value="Standard" <?= $f_deco == 'Standard' ? 'checked' : '' ?> class="w-4 h-4 accent-amber-600">
                            <span class="text-sm font-medium <?= $f_deco == 'Standard' ? 'text-slate-900' : 'text-gray-500' ?> group-hover:text-slate-900 transition">Carreaux Standard</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="radio" name="deco" value="Décoratif" <?= $f_deco == 'Décoratif' ? 'checked' : '' ?> class="w-4 h-4 accent-amber-600">
                            <span class="text-sm font-medium <?= $f_deco == 'Décoratif' ? 'text-slate-900' : 'text-gray-500' ?> group-hover:text-slate-900 transition">Décorations & Motifs</span>
                        </label>
                    </div>
                </div>

                <div>
                    <h3 class="text-[0.7rem] font-black uppercase tracking-[3px] text-slate-900 mb-5">Application</h3>
                    <div class="flex flex-col space-y-3">
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="radio" name="type" value="" <?= $f_type == '' ? 'checked' : '' ?> class="w-4 h-4 accent-amber-600">
                            <span class="text-sm text-gray-500 group-hover:text-slate-900">Toutes les poses</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="radio" name="type" value="Sol" <?= $f_type == 'Sol' ? 'checked' : '' ?> class="w-4 h-4 accent-amber-600">
                            <span class="text-sm text-gray-500 group-hover:text-slate-900">Sol (Floor)</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="radio" name="type" value="Mur" <?= $f_type == 'Mur' ? 'checked' : '' ?> class="w-4 h-4 accent-amber-600">
                            <span class="text-sm text-gray-500 group-hover:text-slate-900">Mur (Wall)</span>
                        </label>
                    </div>
                </div>

                <div>
                    <h3 class="text-[0.7rem] font-black uppercase tracking-[3px] text-slate-900 mb-5">Espaces</h3>
                    <div class="flex flex-col space-y-3">
                        <label class="flex items-center space-x-3 cursor-pointer group border-b border-slate-50 pb-2">
                            <input type="radio" name="piece" value="" <?= $f_piece == '' ? 'checked' : '' ?> class="w-4 h-4 accent-amber-600">
                            <span class="text-xs font-bold uppercase tracking-widest <?= $f_piece == '' ? 'text-slate-900' : 'text-gray-400' ?>">Toutes les pièces</span>
                        </label>
                        <?php
                        $pieces = ['Living room', 'Bedroom', 'Bathroom', 'Dining room', 'Kitchen', 'Outdoor'];
                        foreach ($pieces as $p): ?>
                            <label class="flex items-center space-x-3 cursor-pointer group">
                                <input type="radio" name="piece" value="<?= $p ?>" <?= $f_piece == $p ? 'checked' : '' ?> class="w-4 h-4 accent-amber-600">
                                <span class="text-sm font-medium <?= $f_piece == $p ? 'text-slate-900' : 'text-gray-500' ?> group-hover:text-slate-900 transition"><?= $p ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div>
                    <h3 class="text-[0.7rem] font-black uppercase tracking-[3px] text-slate-900 mb-5">Matières</h3>
                    <div class="flex flex-col space-y-3">
                        <label class="flex items-center space-x-3 cursor-pointer group border-b border-slate-50 pb-2">
                            <input type="radio" name="cat" value="" <?= $f_cat == '' ? 'checked' : '' ?> class="w-4 h-4 accent-amber-600">
                            <span class="text-xs font-bold uppercase tracking-widest <?= $f_cat == '' ? 'text-slate-900' : 'text-gray-400' ?>">Toutes les matières</span>
                        </label>
                        <?php foreach ($categories as $cat): ?>
                            <label class="flex items-center space-x-3 cursor-pointer group">
                                <input type="radio" name="cat" value="<?= $cat['id'] ?>" <?= $f_cat == $cat['id'] ? 'checked' : '' ?> class="w-4 h-4 accent-amber-600">
                                <span class="text-sm text-gray-500 group-hover:text-slate-900"><?= $cat['nom_matiere'] ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div>
                    <h3 class="text-[0.7rem] font-black uppercase tracking-[3px] text-slate-900 mb-5">Couleurs</h3>
                    <div class="grid grid-cols-4 gap-4">
                        <?php
                        $colors = ['White' => 'bg-white border-slate-200', 'Grey' => 'bg-gray-400', 'Black' => 'bg-black', 'Beige' => 'bg-[#f5f5dc]'];
                        foreach ($colors as $name => $style): ?>
                            <label class="relative cursor-pointer group flex flex-col items-center">
                                <input type="radio" name="color" value="<?= $name ?>" <?= $f_color == $name ? 'checked' : '' ?> class="peer sr-only">
                                <div class="w-10 h-10 rounded-full <?= $style ?> border peer-checked:ring-2 peer-checked:ring-amber-600 peer-checked:ring-offset-2 transition-all shadow-sm"></div>
                                <span class="text-[0.55rem] mt-2 font-bold uppercase text-gray-400 peer-checked:text-slate-900"><?= $name ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="pt-6">
                    <a href="catalogue.php" class="flex items-center justify-center w-full py-4 border border-slate-200 text-[0.65rem] font-black uppercase tracking-[3px] text-slate-400 hover:text-red-500 transition-all">✕ Réinitialiser</a>
                </div>
            </form>
        </aside>

        <section class="flex-1" id="product-container">
            <div class="flex justify-between items-center mb-10 pb-6 border-b border-slate-100">
                <span class="text-[0.7rem] font-bold uppercase tracking-widest text-gray-400">
                    <span class="text-slate-900"><?= $total_items ?></span> Modèles trouvés
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-x-10 gap-y-16">
                <?php if (count($produits) > 0): ?>
                    <?php foreach ($produits as $p): ?>
                        <a href="produit.php?id=<?= $p['id'] ?>" class="group block bg-white border border-slate-100 hover:shadow-2xl transition-all duration-500 overflow-hidden">
                            <div class="relative aspect-[5/4] overflow-hidden bg-slate-100">
                                <img src="assets/img/<?= $p['image_url'] ?>" alt="<?= $p['nom'] ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                <?php if ($p['style'] == 'Décoratif'): ?>
                                    <span class="absolute top-4 right-4 bg-amber-600 text-white text-[0.6rem] font-black px-2 py-1 uppercase tracking-widest">Déco</span>
                                <?php endif; ?>
                            </div>

                            <div class="flex justify-between items-center bg-white">
                                <div class="p-4">
                                    <div class="relative inline-block">
                                        <h3 class="text-lg font-bold text-slate-800 uppercase tracking-widest leading-none">
                                            <?= htmlspecialchars($p['nom']) ?>
                                        </h3>

                                        <div class="absolute -bottom-2 left-0 w-0 h-[3px] bg-[#ff6b00] transition-all duration-500 ease-in-out group-hover:w-full"></div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-center w-12 h-12 bg-[#ff6b00] text-white transition-all duration-300 transform opacity-0 group-hover:opacity-100">
                                    <span>→</span>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-span-full py-32 text-center bg-slate-50 border-2 border-dashed border-slate-100 rounded-3xl">
                        <h3 class="text-xl font-bold text-slate-800 uppercase tracking-widest">Aucun résultat</h3>
                        <a href="catalogue.php" class="mt-8 inline-block text-[0.7rem] font-bold uppercase tracking-widest text-amber-600 border-b-2 border-amber-600 pb-1">Voir tout le catalogue</a>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($total_pages > 1): ?>
                <div class="mt-24 flex justify-center items-center space-x-2">
                    <?php for ($i = 1; $i <= $total_pages; $i++):
                        $p_get = $_GET;
                        $p_get['page'] = $i; ?>
                        <a href="catalogue.php?<?= http_build_query($p_get) ?>"
                            class="w-10 h-10 flex items-center justify-center text-xs font-bold border transition-all
                       <?= $i == $current_page ? 'bg-slate-900 text-white' : 'bg-white text-gray-400 border-slate-200 hover:text-amber-600' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        </section>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterForm = document.getElementById('filterForm');
        const productContainer = document.getElementById('product-container');

        // 1. Fonction Maîtresse : Charger le contenu
        function updateCatalogue(url) {
            // Effet visuel de chargement
            productContainer.classList.add('opacity-40', 'pointer-events-none');

            fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newContent = doc.getElementById('product-container').innerHTML;

                    // Mise à jour de la grille
                    productContainer.innerHTML = newContent;
                    productContainer.classList.remove('opacity-40', 'pointer-events-none');

                    // Mise à jour de l'URL pour le bouton "Précédent" du navigateur
                    window.history.pushState({}, '', url);

                    // On réactive les clics sur la nouvelle pagination
                    bindPagination();
                })
                .catch(error => {
                    console.error('Erreur AJAX:', error);
                    productContainer.classList.remove('opacity-40', 'pointer-events-none');
                });
        }

        // 2. Écouteur sur les FILTRES (Détecte chaque clic sur un bouton radio)
        filterForm.addEventListener('change', function() {
            const formData = new URLSearchParams(new FormData(filterForm)).toString();
            const url = 'catalogue.php?' + formData;
            updateCatalogue(url);
        });

        // 3. Écouteur sur la PAGINATION
        function bindPagination() {
            // On cible les liens <a> à l'intérieur du container de produits
            const links = productContainer.querySelectorAll('a');
            links.forEach(link => {
                if (link.getAttribute('href').includes('page=')) {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const url = this.getAttribute('href');
                        updateCatalogue(url);
                        // Remonte doucement au début du catalogue
                        window.scrollTo({
                            top: 300,
                            behavior: 'smooth'
                        });
                    });
                }
            });
        }

        // Initialisation au premier chargement
        bindPagination();
    });
</script>

<?php include 'includes/footer.php'; ?>