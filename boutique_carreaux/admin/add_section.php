<?php
require_once 'auth.php';
require_once '../includes/db.php';

$projet_id = intval($_GET['id']);
// On récupère le nom du projet pour l'affichage
$stmtP = $pdo->prepare("SELECT nom FROM realisations WHERE id = ?");
$stmtP->execute([$projet_id]);
$nom_projet = $stmtP->fetchColumn();

// Récupération des produits pour le multi-choix
$produits_db = $pdo->query("SELECT id, nom FROM produits ORDER BY nom ASC")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre_piece'];
    $desc = $_POST['description'];

    // 1. Image d'ambiance (Principale de la section)
    $img_ambiance = time() . "_amb_" . $_FILES['image_ambiance']['name'];
    move_uploaded_file($_FILES['image_ambiance']['tmp_name'], "../assets/img/realisations/" . $img_ambiance);

    $stmtS = $pdo->prepare("INSERT INTO realisation_sections (realisation_id, titre_piece, image_ambiance, description) VALUES (?, ?, ?, ?)");
    $stmtS->execute([$projet_id, $titre, $img_ambiance, $desc]);
    $section_id = $pdo->lastInsertId();

    // 2. Galerie de photos supplémentaires
    if (!empty($_FILES['galerie']['name'][0])) {
        foreach ($_FILES['galerie']['tmp_name'] as $key => $tmp_name) {
            $filename = time() . "_gal_" . $_FILES['galerie']['name'][$key];
            if (move_uploaded_file($tmp_name, "../assets/img/realisations/" . $filename)) {
                $pdo->prepare("INSERT INTO realisation_section_photos (section_id, image_url) VALUES (?, ?)")->execute([$section_id, $filename]);
            }
        }
    }

    // 3. Produits associés
    if (!empty($_POST['produits'])) {
        foreach ($_POST['produits'] as $p_id) {
            $pdo->prepare("INSERT INTO realisation_produits (section_id, produit_id) VALUES (?, ?)")->execute([$section_id, $p_id]);
        }
    }

    $success = "La pièce '$titre' a été ajoutée. Vous pouvez en ajouter une autre.";
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ajouter une Pièce | Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 min-h-screen flex items-start">
    <?php include 'sidebar.php'; ?>
    <main class="flex-1 p-12">
        <div class="max-w-4xl mx-auto">
            <div class="mb-8">
                <p class="text-amber-600 font-bold text-xs uppercase tracking-widest">Projet : <?= $nom_projet ?></p>
                <h2 class="text-3xl font-bold text-slate-900 uppercase tracking-tighter">Ajouter une pièce / section</h2>
            </div>

            <?php if (isset($success)) echo "<div class='bg-green-100 text-green-700 p-4 mb-6 text-xs font-bold uppercase'>$success</div>"; ?>

            <form method="POST" enctype="multipart/form-data" class="bg-white p-10 border border-slate-200 shadow-sm grid grid-cols-2 gap-8">
                <div class="col-span-2">
                    <label class="block text-[0.6rem] font-black uppercase text-slate-400 mb-2">Titre de la pièce (ex: Salon de réception)</label>
                    <input type="text" name="titre_piece" required class="w-full p-4 bg-slate-50 border border-slate-200 outline-none">
                </div>

                <div class="col-span-2">
                    <label class="block text-[0.6rem] font-black uppercase text-slate-400 mb-2">Description</label>
                    <textarea name="description" rows="3" class="w-full p-4 bg-slate-50 border border-slate-200 outline-none"></textarea>
                </div>

                <div>
                    <label class="block text-[0.6rem] font-black uppercase text-slate-400 mb-2">Photo d'ambiance (Principale)</label>
                    <input type="file" name="image_ambiance" required>
                </div>

                <div class="col-span-2 pt-6">
                    <label class="block text-[0.6rem] font-black uppercase text-slate-400 mb-4 tracking-widest">Galerie photos de la pièce</label>

                    <div id="preview-container" class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-4">
                        <div id="add-image-btn" onclick="document.getElementById('gallery-input').click()"
                            class="aspect-square border-2 border-dashed border-slate-200 flex flex-col items-center justify-center cursor-pointer hover:border-amber-500 hover:bg-amber-50 transition-all group">
                            <span class="text-3xl text-slate-300 group-hover:text-amber-600 group-hover:scale-110 transition">+</span>
                            <span class="text-[0.5rem] font-bold uppercase text-slate-400 mt-2">Ajouter</span>
                        </div>
                    </div>

                    <input type="file" id="gallery-input" name="galerie[]" multiple class="hidden" accept="image/*">
                </div>

                <div class="col-span-2 pt-4 border-t">
                    <label class="block text-[0.6rem] font-black uppercase text-slate-400 mb-4">Sélectionner les produits posés dans cette pièce :</label>
                    <div class="grid grid-cols-3 gap-4 max-h-48 overflow-y-auto p-4 bg-slate-50 border">
                        <?php foreach ($produits_db as $prod): ?>
                            <label class="flex items-center space-x-2 text-xs">
                                <input type="checkbox" name="produits[]" value="<?= $prod['id'] ?>">
                                <span><?= $prod['nom'] ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="col-span-2 flex gap-4 pt-6">
                    <button type="submit" class="flex-1 bg-amber-600 text-white py-4 text-[0.7rem] font-black uppercase tracking-[2px] hover:bg-slate-900 transition">
                        Enregistrer cette pièce
                    </button>
                    <a href="manage_projets.php" class="flex-1 bg-slate-100 text-slate-600 text-center py-4 text-[0.7rem] font-black uppercase tracking-[2px] hover:bg-slate-200 transition">
                        Terminer le projet
                    </a>
                </div>
            </form>
        </div>
    </main>

    <script>
        const galleryInput = document.getElementById('gallery-input');
        const previewContainer = document.getElementById('preview-container');
        const addButton = document.getElementById('add-image-btn');

        // On utilise DataTransfer pour accumuler les fichiers comme dans un vrai panier
        let dt = new DataTransfer();

        galleryInput.addEventListener('change', function(e) {
            const files = e.target.files;

            for (let i = 0; i < files.length; i++) {
                const file = files[i];

                // On ajoute le fichier à notre collection DataTransfer
                dt.items.add(file);

                // Création de la miniature visuelle
                const reader = new FileReader();
                reader.onload = function(event) {
                    const div = document.createElement('div');
                    div.className = "relative aspect-square bg-slate-100 border border-slate-200 group overflow-hidden shadow-sm";
                    div.innerHTML = `
                    <img src="${event.target.result}" class="w-full h-full object-cover">
                    <button type="button" class="absolute inset-0 bg-red-600/80 text-white opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-xs font-bold uppercase" onclick="removeImage(this, '${file.name}')">
                        Supprimer
                    </button>
                `;
                    // On insère avant le bouton "Plus"
                    previewContainer.insertBefore(div, addButton);
                }
                reader.readAsDataURL(file);
            }

            // On met à jour l'input réel avec notre collection accumulée
            galleryInput.files = dt.files;
        });

        function removeImage(btn, fileName) {
            // Supprimer visuellement
            btn.parentElement.remove();

            // Supprimer du DataTransfer
            const newDt = new DataTransfer();
            for (let i = 0; i < dt.files.length; i++) {
                if (dt.files[i].name !== fileName) {
                    newDt.items.add(dt.files[i]);
                }
            }
            dt = newDt;
            galleryInput.files = dt.files; // Update l'input
        }
    </script>
</body>

</html>